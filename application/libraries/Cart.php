<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 23/04/2015
 * Time: 14:10
 */
Class CI_Cart
{

    var $CI = NULL;

    public $cache_path;

    public $cache_file;

    //cache_time in minutes
    public $cache_time = 30;

    public $cache;

    protected $primary_table;

    protected $foreign_table;

    protected $foreign_key;

    protected $error;

    protected $item_storage;

    protected $item_key;

    public $primary_data;

    public $add_item;

    public $update_item;

    public $delete_item;

    public $list_item;

    public $result_array_item;

    public $field_updateable = array('qty');

    function __construct($params = array())
    {
        $this->CI =& get_instance();
        $this->load = $this->CI->load;
        $this->db = $this->CI->db;

        $this->setParams($params);

        if (!$this->initCacheData())
            return false;

        if (!is_null($this->error))
            return false;
    }

    private function setParams($params)
    {
        !isset($this->cache_path) ?
            $this->cache_path = $params['cache_path'] :
            $this->error['param'][] = 'cache path not set';
        !isset($this->cache_file) ?
            $this->cache_file = $params['cache_file'] :
            $this->error['param'][] = 'cache filename not set';
        !isset($this->primary_table) ?
            $this->primary_table = $params['primary_table'] :
            $this->error['param'][] = 'primary table not set';
        !isset($this->foreign_table) ?
            $this->foreign_table = $params['foreign_table'] :
            $this->error['param'][] = 'foreign table not set';
    }

    public function primary_data($field, $value = NULL)
    {
        if (!is_array($field)) {
            $this->cache['value'][$field] = $value;
        } else {
            foreach ($field as $key => $value) {
                $this->cache['value'][$key] = $value;
            }
        }

        $this->appendCache($this->cache);

        return $this;
    }

    public function add_item($index, $value = array())
    {
        if (isset($this->cache['detail']['value'][$index])) {
            $this->cache['detail']['value'][$index]['qty'] += $value['qty'];
        } else {
            $this->cache['detail']['value'][$index] = $value;
        }

        $this->appendCache($this->cache);
        return $this;
    }

    public function update_item($index, $value = array(), $all_field_updateable = true)
    {
        if (isset($this->cache['detail']['value'][$index])) {
            if ($all_field_updateable) {
                foreach ($this->field_updateable as $v) {
                    $this->cache['detail']['value'][$index][$v] = $value[$v];
                }
            } else {
                $this->delete_item($index);
                $this->add_item($index, $value);
                return $this;
            }
        } else {
            $this->cache['detail']['value'][$index] = $value;
        }

        $this->appendCache($this->cache);
        return $this;
    }

    public function save()
    {
        if ($id = $this->insertToDB($this->cache)) {
            $this->deleteCache();
            return $id;
        } else {
            return false;
        }
    }

    public function delete_item($index)
    {

        if (isset($this->cache['detail']['value'][$index])) {
            unset($this->cache['detail']['value'][$index]);
        } else {
            $this->error['param'][] = 'item deleted not found';
        }

        $this->appendCache($this->cache);
        return $this;
    }

    public function count_item()
    {
        return count($this->cache['detail']['value']);
    }

    public function list_item($data = array(), $key)
    {

        $this->item_storage = $data;

        $this->item_key = $key;

        return $this;
    }

    public function result_array_item($recursive = true)
    {
        $result = null;
        if (!$this->item_storage)
            $this->error['param'][] = 'items_storage no set';
        if (!$this->item_key)
            $this->error['param'][] = 'item key no set';
        if ($recursive) {
            if ($this->cache['detail']['value']) {
                foreach ($this->cache['detail']['value'] as $key => $value) {
                    foreach ($this->item_storage as $index => $row) {
                        if ($key == $row[$this->item_key])
                            $result[] = array_merge($this->cache['detail']['value'] [$key], $this->item_storage[$index]);
                    }
                }
            } else {
                $this->error['param'][] = 'items record not set';
            }
        } else {
            foreach ($this->item_storage as $row) {
                if (empty($this->cache['detail']['value'] [$row[$this->item_key]])) {
                    $result[] = $row;

                } else {
                    $result[] = array_merge($this->cache['detail']['value'] [$row[$this->item_key]], $row);
                }
            }
        }

        return $result;

    }

    private function initCacheData()
    {
        if ($cache = $this->getQueryCache(
            $this->cache_path,
            $this->cache_file,
            $this->cache_time
        )
        ) {
            $this->cache = json_decode($cache, TRUE);
            return true;
        } else {
            return $this->initCache();
        }
    }

    private function initCache()
    {
        $this->initForeignKey();
        if (!$this->foreign_key) {
            $this->error['db'][] = 'foreign key not set in your database';
            return false;
        }
        $data = array(
            'table' => $this->primary_table,
            'value' => null,
            'detail' => array(
                'table' => $this->foreign_table,
                'foreign_key' => $this->foreign_key,
                'value' => null
            )
        );
        $this->appendCache($data);
        $this->cache = $data;
        return true;
    }

    protected function initForeignKey()
    {
        $row = $this->db->select("REFERENCED_COLUMN_NAME", false)
            ->from("INFORMATION_SCHEMA.KEY_COLUMN_USAGE", false)
            ->where("TABLE_NAME", $this->foreign_table)
            ->where("REFERENCED_TABLE_NAME", $this->primary_table)
            ->get()->row();

        if (!empty($row->REFERENCED_COLUMN_NAME)) {
            $this->foreign_key = $row->REFERENCED_COLUMN_NAME;
        } else {
            return false;
        }

    }

    /**
     * @param mixed $cache_time
     */
    public function setCacheTime($cache_time)
    {
        $this->cache_time = $cache_time;
    }

    public function getError($index = null, $prefix = "<p>", $suffix = "</p>")
    {
        $error = "";
        foreach ($this->error as $key => $value) {
            $error .= $prefix == "" ? "" : $prefix;
            $error .= $value;
            $error .= $suffix == "" ? "" : $suffix;
        }
        return $error;

    }

    /**
     * @return mixed
     */
    public function array_cache()
    {
        return $this->cache;
    }

    /**
     * @param array $field_updateable
     */
    public function field_updateable($field_updateable)
    {
        $this->field_updateable = $field_updateable;
    }

    public function primary_data_exists()
    {
        return is_null($this->cache['value']) ? false : true;
    }

    public function cache_exists()
    {
        $file = APPPATH . 'cache/' . $this->cache_path . '/' . $this->cache_file;
        if (file_exists($file)) {
            return true;
        } else {
            return false;
        }
    }


    protected function appendCache($data = array())
    {
        $this->cacheQuery($this->cache_path, $this->cache_file, json_encode($data));
    }

    protected function getQueryCache($dirName, $fileName = 'default', $cacheTime = null)
    {
        $cacheTime = $cacheTime * 60;
        $file = APPPATH . 'cache/' . $dirName . '/' . $fileName;
        if ($cacheTime == null && file_exists($file)) {
            return file_get_contents($file);
        } else {
            if (!file_exists($file) || time() - filemtime($file) >= $cacheTime) {
                return FALSE;
            } else {
                return file_get_contents($file);
            }
        }
    }

    protected function cacheQuery($dirName, $fileName = 'default', $data = '')
    {
        $path = APPPATH . 'cache/' . $dirName . '/';
        $file = $path . $fileName;

        if (!file_exists($path)) {
            @mkdir($path);
        }

        $fh = @fopen($file, 'w');

        if ($fh) {
            fputs($fh, $data);
            fclose($fh);
        }
    }

    public function deleteCache()
    {
        $file = APPPATH . 'cache/' . $this->cache_path . '/' . $this->cache_file;

        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function delete_record()
    {
        $this->deleteCache();
    }

    private function insertToDB($data = array())
    {
        $this->db->trans_start();
        $this->insertByField($data['table'], $data['value']);

        $reference_key = $this->db->insert_id();

        $data_detail = $this->parsingReferenceKey(
            $data['detail']['table'],
            $data['detail']['foreign_key'],
            $reference_key,
            $data['detail']['value']
        );

        $this->db->insert_batch($data['detail']['table'], $data_detail);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->error['db'][] = 'error db transaction';
            return false;
        } else {
            $this->db->trans_commit();
            return $reference_key;
        }
    }

    private function insertByField($table, $data_array = array())
    {
        if (is_array($data_array)) {
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field) {
                if (array_key_exists($field, $data_array)) {
                    if ($data_array[$field] != null || $data_array[$field] != "")
                        $this->db->set($field, $data_array[$field]);
                }
            }
            $this->db->insert($table);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }
    }

    /**
     * @param $reference_key
     * @param array $data
     * @return array
     */

    public function parsingReferenceKey($table, $reference_field, $reference_key, $data = array())
    {
        if (is_array($data)) {
            $result = array();
            $fields = $this->db->list_fields($table);
            foreach ($data as $index => $rows) {
                $data_row = array();
                foreach ($fields as $field_row) {
                    if (array_key_exists($field_row, $rows)) {
                        if ($rows[$field_row] == "") {
                            $data_row[$field_row] = null;
                        } else {
                            $data_row[$field_row] = $rows[$field_row];
                        }

                    }
                }
                $data_row[$reference_field] = $reference_key;
                $result[] = $data_row;

            }
            return $result;
        }
    }


}
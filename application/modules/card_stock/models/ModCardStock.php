<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 16/04/2015
 * Time: 16:43
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModCardStock extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function stocking($id_po,$id_staff,$data = array()){
        $this->db->trans_start();
        $this->db->insert('card_stock', array('id_staff'=>$id_staff,
            'id_po'=>$id_po));

        $reference_key = $this->db->insert_id();

        $data_detail = $this->parsingReferenceKey(
            'purchase_order_detail',
            'id_card_stock',
            $reference_key,
            $data
        );

        $this->db->update_batch('purchase_order_detail', $data_detail, 'id_po_detail');
        $this->db->update('purchase_order', array('status_stocking'=>true), "id_po = ".$id_po);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $reference_key;
        }


    }


    private function parsingReferenceKey($table, $reference_field, $reference_key, $data = array())
    {
        if (is_array($data)) {
            $result = array();
            $fields = $this->db->list_fields($table);
            foreach ($data as $rows) {
                $data_row = array();
                foreach ($fields as $field_row) {
                    if (array_key_exists($field_row, $rows)) {
                        $data_row[$field_row] = $rows[$field_row];
                    }
                }
                $data_row[$reference_field] = $reference_key;
                $result[] = $data_row;

            }
            return $result;
        }
    }

}
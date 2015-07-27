<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 17/04/2015
 * Time: 19:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModProduct extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->db->from('product');
        $this->db->join('product_unit', 'product_unit.id_product_unit = product.id_product_unit');
        $this->db->join('product_category', 'product_category.id_product_category = product.id_product_category');
        $result = $this->db->get();
        $rows = $result->result_array();
        return $rows;
    }

    public function getProductOnly()
    {
        $result = $this->db->get('product');
        $rows = $result->result_array();
        return $rows;
    }

    public function getProductOnlyForDropdown($id = null)
    {
        $this->db
            ->select('p.*, pu.*')
            ->from('product p')
            ->join('product pr', 'pr.parent = p.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
            ->where('pr.parent is null');
        if(!is_null($id)){
            $this->db->where('p.id_product !=',$id);
        }
        $result = $this->db->get();
        $data = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[$row['id_product']] = $row['name'] . '( ' . $row['unit'] . ' / ' . $row['value'] . " )";
            }
        } else {
            $data = array('' => '');
        }

        return $data;
    }

    public function getCategoryOnly()
    {
        $this->db->where('parent is NULL');
        $result = $this->db->get('product_category');
        $rows = $result->result_array();
        return $rows;
    }
    
    public function getCategoryProductOnly()
    {
        $this->db->where('parent is NOT NULL');
        $result = $this->db->get('product_category');
        $rows = $result->result_array();
        return $rows;
    }

    public function getCategoryName($id_product_category)
    {
        $this->db->where('id_product_category', $id_product_category);
        $result = $this->db->get('product_category');
        if ($result->num_rows() > 0) {
            $row = $result->row();

            return $row->category;
        }
        return '';
    }

    public function getCategoryParentName($id_product_category)
    {
        $this->db->where('id_product_category', $id_product_category);
        $result = $this->db->get('product_category');
        if ($result->num_rows() > 0) {
            $row = $result->row();

            return $this->getCategoryName($row->parent);
        }
        return '';
    }

    public function getProduct($id_product)
    {
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_unit', 'product_unit.id_product_unit = product.id_product_unit');
        $this->db->join('product_category', 'product_category.id_product_category = product.id_product_category');
        $this->db->where('product.id_product', $id_product);
        $this->db->order_by('product.name ASC');
        $result = $this->db->get();
        return $result->row();
    }

    public function checkStock($id_product, $qty)
    {
        $row = $this->db->get_where('product', array('id_product' => $id_product))->row();
        if ($row->stock < $qty) {
            return false;
        } else {
            return true;
        }
    }

    public function checkPrefixCode($prefix_code, $selected_table)
    {
        $rows = $this->db->get_where($selected_table, array('prefix_code' => $prefix_code))->num_rows();
        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUnitOnly()
    {
        $result = $this->db->get('product_unit');
        $rows = $result->result_array();
        return $rows;
    }

    public function getUnitValue($id_product_unit)
    {
        $this->db->where('id_product_unit', $id_product_unit);
        $result = $this->db->get('product_unit');
        if ($result->num_rows() > 0) {
            $row = $result->row();

            return $row->value;
        }
        return '';
    }

}
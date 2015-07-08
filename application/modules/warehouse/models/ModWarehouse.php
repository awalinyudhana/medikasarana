<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModWarehouse extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductStock($id_product)
    {
        $row = $this->db->get_where('product', array('id_product' => $id_product))->row();
        if ($row->stock > 0) {
            return $row->stock;
        } else {
            return '0';
        }
    }


    public function getProductOnlyForDropdown($id_product = null)
    {
        $this->db
            ->select('p.*, pu.*')
            ->from('product p')
            ->join('warehouse_rack_detail r', 'r.id_product = p.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit');
//            ->where('r.id_product is null');

        if (!empty($id_product))
            $this->db->where('p.id_product', $id_product);
//        $this->db->or_where('p.id_product', $id_product);

        $result = $this->db->get();
        $data = array();
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $data[$row['id_product']] = $row['name'] . ' ( ' . $row['unit'] . ' / ' . $row['value'] . " )";
            }
        } else {
            $data = array('' => '');
        }

        return $data;
    }

    public function getProductUnitData($id_product)
    {
        $productRow = $this->db->get_where('product', array('id_product' => $id_product))->row();
        if (!empty($productRow->id_product_unit)) {
            $query = $this->db->get_where('product_unit', array('id_product_unit' => $productRow->id_product_unit));
            if ($query->num_rows() > 0) {
               $row = $query->row(); 
               return $row;
            }
        } else {
            return false;
        } 
    }
    public function getNameRackParent($id){
        $this->db
            ->select('r.*')
            ->from('warehouse_rack w')
            ->join('warehouse_rack r', 'r.id_rack = w.parent','left')
            ->where('w.id_rack', $id);
        $result = $this->db->get()->row();
        return $result->name;
    }

}
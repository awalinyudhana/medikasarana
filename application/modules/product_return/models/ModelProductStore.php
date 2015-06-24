<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/1/2015
 * Time: 1:10 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelProductStore extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id_store){
        $this->db->select("*, ps.stock as store_stock");
        $this->db->from('product_store ps');
        $this->db->join('product p','p.id_product = ps.id_product');
        $this->db->join('product_unit pu','pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc','pc.id_product_category = p.id_product_category','left');
        $this->db->where('id_store',$id_store);
        $result = $this->db->get();
        $rows = $result->result_array();
        return $rows;
    }


    public function checkStock($id_product_store, $qty)
    {
        $row = $this->db->get_where('product_store', array('id_product_store' => $id_product_store))->row();
        if ($row->stock < $qty) {
            return false;
        } else {
            return true;
        }
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 11:20
 */
class ModelConversion extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    public function getListProduct(){
        return $this->db
            ->select('p.*, pu.*, pc.*')
            ->from('product p')
            ->join('product pf','pf.parent = p.id_product')
            ->join('product_unit pu','pu.id_product_unit = p.id_product_unit','left')
            ->join('product_category pc','pc.id_product_category = p.id_product_category','left')
            ->get()->result_array();
    }
    public function getProduct($id_product){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_unit','product_unit.id_product_unit = product.id_product_unit','left');
        $this->db->join('product_category','product_category.id_product_category = product.id_product_category','left');
        $this->db->where('product.parent',$id_product);
        $result = $this->db->get();
        return $result->row();
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 11:20
 */
class ModelPurchaseOrder extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
    public function getDataPOD($id_po)
    {
        $this->db->from('purchase_order_detail pod');
        $this->db->join('product p', 'p.id_product = pod.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        $this->db->where('pod.id_purchase_order', $id_po);
        return $this->db->get()->result_array();
    }
}
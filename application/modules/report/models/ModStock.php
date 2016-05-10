<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 7/30/2015
 * Time: 10:58 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModStock extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function get($id_store)
    {
        $this->db->select('*, IF(ps.stock is null, 0, ps.stock) as stock_retail, p.stock as stock_warehouse', false);
        $this->db->from('product_store ps');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'right');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_store'=>$id_store]);
        return $this->db->get()->result();
    }
}
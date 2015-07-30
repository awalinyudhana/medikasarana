<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 7/30/2015
 * Time: 10:58 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModProduct extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function get($id_store)
    {
        $this->db->select('*, ps.stock as stock_retail');
        $this->db->from('product_store ps');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_store'=>$id_store]);
        return $this->db->get()->result_array();
    }
}
class ModStore extends grocery_CRUD_model {

    private  $query_str = '';
    function __construct() {
        parent::__construct();
    }

    function get_list() {
        $query=$this->db->query($this->query_str);

        $results_array=$query->result();
        return $results_array;
    }

    public function set_query_str($query_str) {
        $this->query_str = $query_str;
    }
}
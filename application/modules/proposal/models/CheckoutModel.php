<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/2/2015
 * Time: 2:17 PM
 */
class CheckoutModel extends grocery_CRUD_Model  {

    private  $result;
    function __construct() {
        parent::__construct();
    }

    function get_list() {
//        $query=$this->db->query($this->query_str);
//
//        $results_array=$query->result();
        return $this->result;
    }

//    public function set_query_str($query_str)
//    {
//        $this->query_str = $query_str;
//    }

    public function getDataProposalDetail($id_proposal)
    {
        $this->result = $this->db
            ->select('*')
            ->from('proposal_detail pro')
            ->join('product p', 'p.id_product = pro.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_proposal' => $id_proposal])
            ->get()->result();
    }
}
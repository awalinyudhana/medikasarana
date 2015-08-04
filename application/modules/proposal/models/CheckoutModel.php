<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/2/2015
 * Time: 2:17 PM
 */
class CheckoutModel extends CI_Model  {

    function __construct() {
        parent::__construct();
    }

    public function getDataProposalDetail($id_proposal)
    {
        return $this->db
            ->select('*')
            ->from('proposal_detail pro')
            ->join('product p', 'p.id_product = pro.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_proposal' => $id_proposal])
            ->get()->result();
    }
}
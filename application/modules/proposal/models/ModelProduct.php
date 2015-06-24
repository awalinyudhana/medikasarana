<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 17/04/2015
 * Time: 19:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelProduct extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id_customer, $type){
        if($last_proposal = $this->getLastProposal($id_customer,$type)){
            return $this->getPriceLastProposal($last_proposal->id_proposal);
        }else{
            return $this->getPriceProduct();
        }
    }
    private function getLastProposal($id_customer, $type){
        return $this->db
            ->from("proposal")
            ->where("id_customer", $id_customer)
            ->where("status", 1)
            ->where("type", $type)
            ->limit(1)
            ->order_by("date_created DESC")
            ->get()
            ->row();
    }

    private function getPriceLastProposal($id_proposal){
        return $this->db
            ->query("SELECT p.id_product, p.barcode, p.name, p.brand, p.size, p.stock, pu.* , pc.*
, IF(pr.price IS NULL, p.sell_price, pr.price) AS sell_price
FROM
`product` p
LEFT JOIN (SELECT `price`, `id_product` FROM `proposal_detail` WHERE id_proposal = $id_proposal) pr USING (id_product)
LEFT JOIN `product_unit` pu USING (`id_product_unit`)
LEFT JOIN `product_category` pc USING (`id_product_category`)")
//            ->select('product.* ,product_unit.* ,product_category.* ,
//            IF(proposal_detail.price IS NULL, product.sell_price, proposal_detail.price) as sell_price'
//                ,false)
//            ->from('proposal_detail')
//            ->join('product', ' product.id_product = proposal_detail.id_product','right')
//            ->join('product_unit','product_unit.id_product_unit = product.id_product_unit', 'left')
//            ->join('product_category','product_category.id_product_category = product.id_product_category','left')
//            ->where('proposal_detail.id_proposal',$id_proposal)
//            ->or_where('proposal_detail.id_proposal',null)
            ->result_array();
    }

    private function getPriceProduct(){
        return $this->db
            ->select('*')
            ->from('product')
            ->join('product_unit','product_unit.id_product_unit = product.id_product_unit', 'left')
            ->join('product_category','product_category.id_product_category = product.id_product_category', 'left')
            ->get()
            ->result_array();
    }

    public function getProduct($id_product){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->join('product_unit','product_unit.id_product_unit = product.id_product_unit', 'left');
        $this->db->join('product_category','product_category.id_product_category = product.id_product_category', 'left');
        $this->db->where('product.id_product',$id_product);
        $this->db->order_by('product.name ASC');
        $result = $this->db->get();
        return $result->row();
    }

}
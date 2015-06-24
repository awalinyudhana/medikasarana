<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 17/04/2015
 * Time: 19:42
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelProposal extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataProposal($id_proposal)
    {
        return $this->db
            ->select("*, staff.name as staff_name, customer.name as customer_name")
            ->from("proposal")
            ->join('staff', 'staff.id_staff = proposal.id_staff')
            ->join('customer', 'customer.id_customer = proposal.id_customer')
            ->where("id_proposal", $id_proposal)
            ->get()
            ->row();
    }

    public function getDataProposalActive($id_proposal)
    {
        return $this->db
            ->from("proposal")
            ->where("id_proposal", $id_proposal)
            ->where("status", 1)
            ->get()
            ->row();
    }

    public function getListProposal($status = array())
    {
        $this->db
            ->select("*, staff.name as staff_name, customer.name as customer_name")
            ->from("proposal")
            ->join('staff', 'staff.id_staff = proposal.id_staff')
            ->join('customer', 'customer.id_customer = proposal.id_customer');
        if($status != null){
            $this->db->where_in("status", $status);
        }
        return $this->db->get()
            ->result();
    }

    public function getDataProposalDetail($id_proposal)
    {
        return $this->db->from('proposal_detail pro')
            ->join('product p', 'p.id_product = pro.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_proposal' => $id_proposal])
            ->get()->result_array();
    }

}
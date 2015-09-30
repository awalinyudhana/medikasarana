<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 13/05/2015
 * Time: 12:24
 */
class ModelJoin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListSO($id_customer)
    {
        return $this->db
            ->select("*, staff.name as staff_name, customer.name as customer_name")
            ->from("sales_order")
            // ->join('proposal', 'proposal.id_proposal = sales_order.id_proposal', 'left')
            ->join('staff', 'staff.id_staff = sales_order.id_staff')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where("sales_order.id_customer", $id_customer)
            ->where("sales_order.status_extract", 1)
            ->where("sales_order.active", 1)
            ->where("sales_order.paid", "0")
            ->order_by("sales_order.id_proposal")
            // ->where("proposal.type !=", 2)
            ->get()
            ->result();
    }


    public function getDataSODetail($id)
    {
        return $this->db->from('sales_order_detail pro')
            ->join('product p', 'p.id_product = pro.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where_in('id_sales_order',$id)
            ->get()->result_array();
    }

    public function checkAvailabeJoin($id)
    {
        $this->db->distinct()
            ->select('status_ppn')
            ->where_in('id_sales_order',$id);

        $query = $this->db->get('sales_order');

        if($query->num_rows() == 1){
            return true;
        }else {
            return false;
        }
    }

    public function checkAvailabeProposalJoin($id)
    {
        $this->db->distinct()
            ->select('id_proposal')
            ->where_in('id_sales_order',$id);

        $query = $this->db->get('sales_order');

        if($query->num_rows() == 1){
            return true;
        }else {
            return false;
        }
    }

    public function getDiscountPrice($id){
        return $this->db->select_sum('discount_price')
            ->where_in('id_sales_order',$id)
            ->get('sales_order')->row();
    }

    public function getDueDate($id){
        return $this->db->select_max('due_date')
            ->where_in('id_sales_order',$id)
            ->get('sales_order')->row();
    }

    public function getDataSO($id)
    {
        return $this->db
            ->select("*, staff.name as staff_name, customer.name as customer_name")
            ->from("sales_order")
            ->join('staff', 'staff.id_staff = sales_order.id_staff')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where("id_sales_order", $id)
            ->get()
            ->row();
    }
}
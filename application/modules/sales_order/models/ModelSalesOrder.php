<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 11:20
 */
class ModelSalesOrder extends CI_Model
{
    public function __construct(){
        parent::__construct();
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

    public function getDataSODetail($id)
    {
        return $this->db->from('sales_order_detail pro')
            ->join('product p', 'p.id_product = pro.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_sales_order' => $id])
            ->get()->result_array();
    }
}
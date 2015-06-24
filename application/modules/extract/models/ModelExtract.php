<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/5/2015
 * Time: 8:18 PM
 */
class ModelExtract extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataSO($id)
    {
        return $this->db
            ->select("*, staff.name as staff_name, customer.name as customer_name")
            ->from("sales_order")
            ->join('staff', 'staff.id_staff = sales_order.id_staff')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where_in("id_sales_order", $id)
            ->get()
            ->row();
    }
}
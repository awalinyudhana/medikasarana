<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/9/2015
 * Time: 12:31 PM
 */
class ModelSalesOrderReturn extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataSalesOrder($id_sales_order)
    {
        return $this->db
            ->select('*, staff.name as staff_name, customer.name as customer_name')
            ->from('sales_order')
            ->join('staff', 'staff.id_staff = sales_order.id_staff')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where('sales_order.id_sales_order', $id_sales_order)
            ->where('sales_order.active', 1)
            ->get()
            ->row();
    }

    public function getSalesOrderDetail($id_sales_order)
    {
        return $this->db
            ->from('sales_order_detail sod')
            ->join('product p', 'p.id_product = sod.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category','left')
            ->where(['id_sales_order'=>$id_sales_order])
            ->get()->result_array();
    }

    public function getSalesOrderItemStorage($id_sales_order)
    {
        return $this->db
            ->select('sod.id_sales_order_detail,  p.*, pu.*, pc.*')
            ->from('sales_order_detail sod')
            ->join('product p', 'p.id_product = sod.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category','left')
            ->where(['id_sales_order'=>$id_sales_order])
            ->get()->result_array();
    }

    public function checkStock($id_product, $qty)
    {
        $row = $this->db->get_where('product', ['id_product' => $id_product])->row();
        if ($row->stock < $qty) {
            return false;
        } else {
            return true;
        }
    }

    public function getProduct(){
        $this->db->from('product');
        $this->db->join('product_unit','product_unit.id_product_unit = product.id_product_unit','left');
        $this->db->join('product_category','product_category.id_product_category = product.id_product_category','left');
        $result = $this->db->get();
        $rows = $result->result_array();
        return $rows;
    }
    public function getSalesOrderDetailItem($id_sales_order_detail)
    {
        return $this->db
            ->from('sales_order_detail sod')
            ->join('product p', 'p.id_product = sod.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category','left')
            ->where(['id_sales_order_detail'=>$id_sales_order_detail])
            ->get()->row();
    }

    public function getDataReturn($id_return){
        return $this->db
            ->select('*, staff.name as staff_name, customer.name as customer_name')
            ->from('sales_order_return')
            ->join('sales_order','sales_order.id_sales_order = sales_order_return.id_sales_order')
            ->join('staff', 'staff.id_staff = sales_order_return.id_staff')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where('sales_order_return.id_sales_order_return', $id_return)
            ->get()
            ->row();
    }

    public function getReturnReplacedDetailItem($id_return)
    {
        $this->db->from('sales_order_return_detail ed');
        $this->db->join('sales_order_detail rd', 'rd.id_sales_order_detail = ed.id_sales_order_detail');
        $this->db->join('product p', 'p.id_product = rd.id_product');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        $this->db->where(['id_sales_order_return'=>$id_return]);
        return $this->db->get()->result_array();
    }

    public function getReturnReplacerDetailItem($id_return)
    {
        $this->db->from('sales_order_return_detail ed');
        $this->db->join('product p', 'p.id_product = ed.id_product','left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_sales_order_return'=>$id_return]);
        return $this->db->get()->result_array();
    }

}
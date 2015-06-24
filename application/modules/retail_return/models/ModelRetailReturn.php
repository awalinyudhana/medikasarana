<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 18/05/2015
 * Time: 16:59
 */
class ModelRetailReturn extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataRetail($id_retail){
        return $this->db
            ->select('*, staff.name as staff_name, staff.name as store_name')
            ->from('retail')
            ->join('staff', 'staff.id_staff = retail.id_staff')
            ->join('store', 'store.id_store = retail.id_store')
            ->where('retail.id_retail', $id_retail)
            ->get()
            ->row();
    }
    public function getRetailItem($id_retail)
    {
        return $this->db
            ->from('retail_detail ed')
            ->join('product_store ps', 'ps.id_product_store = ed.id_product_store', 'left')
            ->join('product p', 'p.id_product = ps.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category','left')
            ->where(['id_retail'=>$id_retail])
            ->get()->result_array();
    }
    public function getRetailItemStorage($id_retail)
    {
        return $this->db
            ->select('ed.id_retail_detail,  p.*, pu.*, pc.*')
            ->from('retail_detail ed')
            ->join('product_store ps', 'ps.id_product_store = ed.id_product_store', 'left')
            ->join('product p', 'p.id_product = ps.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_retail'=>$id_retail])
            ->get()->result_array();
    }
    public function getRetailDetailItem($id_detail)
    {
        return $this->db
            ->from('retail_detail ed')
            ->join('product_store ps', 'ps.id_product_store = ed.id_product_store', 'left')
            ->join('product p', 'p.id_product = ps.id_product', 'left')
            ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left')
            ->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left')
            ->where(['id_retail_detail'=>$id_detail])
            ->get()->row();
    }
    public function getProductStore($id_store)
    {
        $this->db->select('*, ps.stock as stock_retail');
        $this->db->from('product_store ps');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        $this->db->where(['id_store'=>$id_store]);
        return $this->db->get()->result_array();
    }
    public function checkStock($id_product__store, $qty)
    {
        $row = $this->db->get_where('product_store', ['id_product_store' => $id_product__store])->row();
        if ($row->stock < $qty) {
            return false;
        } else {
            return true;
        }
    }
    public function getReturnReplacedDetailItem($id_return)
    {
        $this->db->from('retail_return_detail ed');
        $this->db->join('retail_detail rd', 'rd.id_retail_detail = ed.id_retail_detail');
        $this->db->join('product_store ps', 'ps.id_product_store = rd.id_product_store');
        $this->db->join('product p', 'p.id_product = ps.id_product');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        $this->db->where(['id_retail_return'=>$id_return]);
        return $this->db->get()->result_array();
    }
    public function getReturnReplacerDetailItem($id_return)
    {
        $this->db->from('retail_return_detail ed');
        $this->db->join('product_store ps', 'ps.id_product_store = ed.id_product_store','left');
        $this->db->join('product p', 'p.id_product = ps.id_product','left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_retail_return'=>$id_return]);
        return $this->db->get()->result_array();
    }

    public function getDataReturn($id_return){
        return $this->db
            ->select('*, staff.name as staff_name, store.name as store_name')
            ->from('retail_return')
            ->join('retail','retail.id_retail = retail_return.id_retail')
            ->join('staff', 'staff.id_staff = retail_return.id_staff')
            ->join('store', 'store.id_store = retail.id_store')
            ->where('retail_return.id_retail_return', $id_return)
            ->get()
            ->row();
    }
}
<?php

/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 11:20
 */
class ModRetail extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }

    public function getProductRetail($id_store)
    {
        $this->db->select('*, ps.stock as stock_retail');
        $this->db->from('product_store ps');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_store'=>$id_store]);
        return $this->db->get()->result_array();
    }

    public function getProductRetailSingle($id_store,$id_product)
    {
        $this->db->select('*, ps.stock as stock_retail');
        $this->db->from('product_store ps');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['ps.id_store'=>$id_store,'ps.id_product'=>$id_product]);
        return $this->db->get()->row();
    }

    public function getRetailDetail($id_retail)
    {
        $this->db->from('retail_detail ed');
        $this->db->join('product_store ps', 'ps.id_product_store = ed.id_product_store', 'left');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_retail'=>$id_retail]);
        return $this->db->get()->result_array();
    }

    public function getReturDetail($id_retur)
    {
        $this->db->from('retail_returns_detail ed');
        $this->db->join('product p', 'p.id_product = ed.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit','left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category','left');
        $this->db->where(['id_retail_returns'=>$id_retur]);
        return $this->db->get()->result_array();
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
    public function getDataRetur($id_retur){
        return $this->db
            ->select('*, staff.name as staff_name, staff.name as store_name')
            ->from('retail_returns')
            ->join('staff', 'staff.id_staff = retail_returns.id_staff')
            ->where('retail_returns.id_retail_returns', $id_retur)
            ->get()
            ->row();
    }

    public function getDetailItemReplaced($id_retail){
        $this->db->from('retail_detail ed');
        $this->db->join('product p', 'p.id_product = ed.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category');
        $this->db->where(['id_retail'=>$id_retail,'returns >'=>0]);
        return $this->db->get()->result_array();
    }

    public function getRetailDetailItem($id_detail)
    {
        $this->db->from('retail_detail ed');
        $this->db->join('product_store ps', 'ps.id_product_store = ed.id_product_store', 'left');
        $this->db->join('product p', 'p.id_product = ps.id_product', 'left');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category');
        $this->db->where(['id_retail_detail'=>$id_detail]);
        return $this->db->get()->row();
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
}
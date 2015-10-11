<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModReturPenjualan extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getReturPenjualan($type, $dateFrom = null, $dateTo = null)
    {
        if ($dateFrom && $dateTo) {
            $this->db->where('sor.date >=', $dateFrom)
                ->where('sor.date <=', $dateTo);
        }

        $this->db
            ->select("sor.*, st.name as staff_name, c.name as customer_name", FALSE)
            ->from('sales_order_return sor')
            ->join('staff st', 'st.id_staff = sor.id_staff')
            ->join('sales_order so', 'so.id_sales_order = sor.id_sales_order')
            ->join('customer c', 'c.id_customer = so.id_customer')
            ->join('proposal p', 'p.id_proposal = so.id_proposal')
            ->where('p.type', $type)
            ->order_by('sor.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
    public function getItems($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom && $dateTo) {
            $this->db->where('sor.date >=', $dateFrom)
                ->where('sor.date <=', $dateTo);
        }

        $this->db
            ->select("sor.*, st.name as staff_name, c.name as customer_name", FALSE)
            ->from('sales_order_return sor')
            ->join('staff st', 'st.id_staff = sor.id_staff')
            ->join('sales_order so', 'so.id_sales_order = sor.id_sales_order')
            ->join('customer c', 'c.id_customer = so.id_customer')
            // ->join('proposal p', 'p.id_proposal = so.id_proposal')
            // ->where('p.type', $type)
            ->order_by('sor.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    /* NOT USED YET */
    public function getTotalReturPenjualan()
    {
        $query = $this->db
                    ->select("SUM(grand_total) AS grand_total", FALSE)
                    ->get('retail');

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

    public function checkReturPenjualan($id_sales_order_return)
    {
        $query = $this->db
                        ->where('id_sales_order_return', $id_sales_order_return)
                        ->get('sales_order_return');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getReturnReplacedDetailItem($id_sales_order_return)
    {
        $this->db->select('*, ed.id_product as id_product_cache');
        $this->db->from('sales_order_return_detail ed');
        $this->db->join('sales_order_detail rd', 'rd.id_sales_order_detail = ed.id_sales_order_detail');
        $this->db->join('product p', 'p.id_product = rd.id_product');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        $this->db->where(['id_sales_order_return'=>$id_sales_order_return]);
        return $this->db->get()->result_array();
    }

    public function getDetailPenjualan($id_retail)
    {
        $query = $this->db
                        ->select("p.barcode, p.name, p.brand, pu.unit, rd.qty, rd.price, (rd.price * rd.qty) AS sub_total", FALSE)
                        ->from('retail_detail rd')
                        ->join('product_store ps', 'ps.id_product_store = rd.id_product_store')
                        ->join('product p', 'p.id_product = ps.id_product')
                        ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                        ->where('rd.id_retail', $id_retail);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getProducts()
    {
        $this->db->select('*');
        $this->db->from('product p');
        $this->db->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit', 'left');
        $this->db->join('product_category pc', 'pc.id_product_category = p.id_product_category', 'left');
        return $this->db->get()->result_array();
    }
}

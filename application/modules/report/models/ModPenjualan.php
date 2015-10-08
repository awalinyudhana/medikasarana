<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModPenjualan extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getPenjualan($type, $dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('so.date >=', $dateFrom)
                ->where('so.date <=', $dateTo);
        }

        $this->db
                ->select('so.*, p.id_proposal, c.name AS customer_name, s.name AS staff_name')
                ->from('sales_order so')
                ->join('customer c', 'c.id_customer = so.id_customer')
                ->join('staff s', 's.id_staff = so.id_staff')
                ->join('proposal p', 'p.id_proposal = so.id_proposal')
                ->where('so.active', 1)
                ->where('p.type', $type)
                ->order_by('so.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getPenjualanGraph($type, $dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom) {
            $this->db->where('so.date >=', $dateFrom)
                ->where('so.date <=', $dateTo);
        }

        $this->db
                ->select("SUM(so.grand_total) AS grand_total, MONTH(so.date) AS month, YEAR(so.date) AS year, CONCAT(YEAR(so.date), '-', LPAD(MONTH(so.date), 2, '0')) AS yyyy_mm", false)
                ->from('sales_order so')
                ->join('proposal p', 'p.id_proposal = so.id_proposal')
                ->where('so.active', 1)
                ->where('p.type', $type)
                ->group_by('YEAR(so.date), MONTH(so.date) ASC')
                ->order_by('so.date asc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($current) {
                return $query->row()->grand_total;
            }
           return $query->result();
        }
    }

    public function getPenjualanCustomerMonthly($id_customer, $type, $dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom) {
            $this->db->where('so.date >=', $dateFrom)
                ->where('so.date <=', $dateTo);
        }

        $this->db
                ->select("so.id_customer, c.name, SUM(so.grand_total) AS grand_total, MONTH(so.date) AS month, YEAR(so.date) AS year, CONCAT(YEAR(so.date), '-', LPAD(MONTH(so.date), 2, '0')) AS yyyy_mm", false)
                ->from('sales_order so')
                ->join('proposal p', 'p.id_proposal = so.id_proposal')
                ->join('customer c', 'c.id_customer = so.id_customer')
                ->where('so.active', 1)
                ->where('p.type', $type)
                ->where('so.id_customer', $id_customer)
                ->group_by('so.id_customer, YEAR(so.date), MONTH(so.date)');
                    
        $query = $this->db->get();
        return $query->result();
    }
    public function getPenjualanCustomerYear($id_customer, $type, $dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom) {
            $this->db->where('so.date >=', $dateFrom)
                ->where('so.date <=', $dateTo);
        }

        $this->db
                ->select("eso.id_customer, c.name, SUM(so.grand_total) AS grand_total, YEAR(so.date) AS year", false)
                ->from('sales_order so')
                ->join('proposal p', 'p.id_proposal = so.id_proposal')
                ->join('customer c', 'c.id_customer = so.id_customer')
                ->where('so.active', 1)
                ->where('p.type', $type)
                ->where('so.id_customer', $id_customer)
                ->group_by('so.id_customer, YEAR(so.date)');
                    
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalPenjualan($type)
    {
        $query = $this->db
                    ->select("SUM(so.grand_total) AS grand_total", FALSE)
                    ->from('sales_order so')
                    ->join('proposal p', 'p.id_proposal = so.id_proposal')
                    ->where('so.active', 1)
                    ->where('p.type', $type)
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

    public function getDetailPenjualan($id_sales_order)
    {
        $query = $this->db
                        ->select('sod.*, p.brand, p.name, pu.unit, pu.value')
                        ->from('sales_order_detail sod')
                        ->join('product p', 'p.id_product = sod.id_product')
                        ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                        ->where('sod.id_sales_order', $id_sales_order);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getCustomerName($id_sales_order)
    {
        $query = $this->db
                        ->select('cu.name')
                        ->from('customer cu')
                        ->join('sales_order so', 'so.id_customer = cu.id_customer')
                        ->where('so.id_sales_order', $id_sales_order)
                        ->get();
        if ($query->num_rows() > 0) {
            return $query->row()->name;
        }
        return 'Unknown';
    }

    public function checkSalesOrder($id_sales_order)
    {
        $query = $this->db
                        ->where('id_sales_order', $id_sales_order)
                        ->get('sales_order');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}

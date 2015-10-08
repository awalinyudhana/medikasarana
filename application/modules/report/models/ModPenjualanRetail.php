<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModPenjualanRetail extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getPenjualan($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom && $dateTo) {
            $this->db->where('date >=', $dateFrom)
                ->where('date <=', $dateTo);
        }

        $this->db
            ->select("rt.*, st.name", FALSE)
            ->from('retail rt')
            ->join('staff st', 'st.id_staff = rt.id_staff')
            ->order_by('rt.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getPenjualanGraph($dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom && $dateTo) {
            $this->db->where('date >=', $dateFrom)
                ->where('date <=', $dateTo);
        }

        $this->db
            ->select("SUM(rt.grand_total) AS grand_total, MONTH(rt.date) AS month, YEAR(rt.date) AS year, CONCAT(YEAR(rt.date), '-', LPAD(MONTH(rt.date), 2, '0')) AS yyyy_mm", FALSE)
            ->from('retail rt')
            ->group_by("YEAR(rt.date), MONTH(rt.date) ASC")
            ->order_by('rt.date asc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($current) {
                return $query->row()->grand_total;
            }
           return $query->result();
        }
    }

    public function getTotalPenjualan()
    {
        $query = $this->db
                    ->select("SUM(grand_total) AS grand_total", FALSE)
                    ->get('retail');

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

    public function checkRetail($id_retail)
    {
        $query = $this->db
                        ->where('id_retail', $id_retail)
                        ->get('retail');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
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
}

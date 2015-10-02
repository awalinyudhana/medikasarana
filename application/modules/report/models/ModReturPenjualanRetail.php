<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModReturPenjualanRetail extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getReturPenjualan($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom && $dateTo) {
            $this->db->where('date >=', $dateFrom)
                ->where('date <=', $dateTo);
        }

        $this->db
            ->select("rr.*, st.name", FALSE)
            ->from('retail_return rr')
            ->join('staff st', 'st.id_staff = rr.id_staff')
            ->order_by('rr.date desc');
                    
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

    public function checkReturRetail($id_retail_return)
    {
        $query = $this->db
                        ->where('id_retail_return', $id_retail_return)
                        ->get('retail_return');
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

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModPembelian extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getPembelianPrincipalMonthly($id_principal, $dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom) {
            $this->db->where('po.date >=', $dateFrom)
                ->where('po.date <=', $dateTo);
        }

        $this->db
                ->select("po.id_principal, p.name, SUM(po.grand_total) AS grand_total, MONTH(po.date) AS month, YEAR(po.date) AS year, CONCAT(YEAR(po.date), '-', LPAD(MONTH(po.date), 2, '0')) AS yyyy_mm", false)
                ->from('purchase_order po')
                ->join('principal p', 'p.id_principal = po.id_principal')
                ->where('p.id_principal', $id_principal)
                ->group_by('po.id_principal, YEAR(po.date), MONTH(po.date)');
                    
        $query = $this->db->get();
        return $query->result();
    }

    public function getPembelianPrincipalYear($id_principal, $dateFrom = null, $dateTo = null, $current = false)
    {
        if ($dateFrom) {
            $this->db->where('po.date >=', $dateFrom)
                ->where('po.date <=', $dateTo);
        }

        $this->db
                ->select("po.id_principal, p.name, SUM(po.grand_total) AS grand_total, YEAR(po.date) AS year", false)
                ->from('purchase_order po')
                ->join('principal p', 'p.id_principal = po.id_principal')
                ->where('p.id_principal', $id_principal)
                ->group_by('po.id_principal, YEAR(po.date)');
                    
        $query = $this->db->get();
        return $query->result();
    }


    public function getPembelian($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('po.date >=', $dateFrom)
                ->where('po.date <=', $dateTo);
        }

        $this->db
                ->select('po.*, p.name AS principal_name, s.name AS staff_name')
                ->from('purchase_order po')
                ->join('principal p', 'p.id_principal = po.id_principal')
                ->join('staff s', 's.id_staff = po.id_staff')
                ->order_by('po.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getTotalPembelian()
    {
        $query = $this->db
                    ->select("SUM(grand_total) AS grand_total", FALSE)
                    ->from('purchase_order')
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

    public function getDetailPembelian($id_purchase_order)
    {
        $query = $this->db
                        ->select('pod.*, p.*, pu.unit, pu.value')
                        ->from('purchase_order_detail pod')
                        ->join('product p', 'p.id_product = pod.id_product')
                        ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                        ->where('pod.id_purchase_order', $id_purchase_order);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getPrincipalName($id_purchase_order)
    {
        $query = $this->db
                        ->select('p.name')
                        ->from('principal p')
                        ->join('purchase_order po', 'po.id_principal = p.id_principal')
                        ->where('po.id_purchase_order', $id_purchase_order)
                        ->get();
        if ($query->num_rows() > 0) {
            return $query->row()->name;
        }
        return 'Unknown';
    }

    public function checkPurchaseOrder($id_purchase_order)
    {
        $query = $this->db
                        ->where('id_purchase_order', $id_purchase_order)
                        ->get('purchase_order');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModCredit extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('c.date >=', $dateFrom)
                ->where('c.date <=', $dateTo);
        }

        $this->db
                ->select('c.*, po.invoice_number, p.date_created AS tanggal_transaksi, p.name AS principal_name, s.name AS staff_name')
                ->from('credit c')
                ->join('purchase_order po', 'po.id_purchase_order = c.id_purchase_order')
                ->join('principal p', 'p.id_pricipal = po.id_pricipal')
                ->join('staff s', 's.id_staff = c.id_staff')
                ->order_by('c.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}
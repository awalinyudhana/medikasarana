<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModDebit extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('so.date >=', $dateFrom)
                ->where('so.date <=', $dateTo);
        }

        $this->db
                ->from('sales_order so')
                ->join('customer c', 'c.id_customer = so.id_customer')
                ->where('so.active', true);
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
    // public function getItems($dateFrom = null, $dateTo = null)
    // {
    //     if ($dateFrom) {
    //         $this->db->where('d.date >=', $dateFrom)
    //             ->where('d.date <=', $dateTo);
    //     }

    //     $this->db
    //             ->select('d.*, so.date AS tanggal_transaksi, c.name AS customer_name, s.name AS staff_name')
    //             ->from('debit d')
    //             ->join('sales_order so', 'so.id_sales_order = d.id_sales_order')
    //             ->join('customer c', 'c.id_customer = so.id_customer')
    //             ->join('staff s', 's.id_staff = d.id_staff')
    //             ->order_by('d.date desc');
                    
    //     $query = $this->db->get();
    //     if ($query->num_rows() > 0) {
    //        return $query->result();
    //     }
    // }
}
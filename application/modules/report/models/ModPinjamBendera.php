<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModPinjamBendera extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getProposalList($type = 2, $dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('p.date_created >=', $dateFrom)
                ->where('p.date_created <=', $dateTo);
        }

        $this->db
                ->select('p.*, c.name AS customer_name, s.name AS staff_name')
                ->from('proposal p')
                ->join('staff s', 's.id_staff = p.id_staff')
                ->join('customer c', 'c.id_customer = p.id_customer')
                ->where('p.type', $type)
                ->where('p.status', 1)
                ->order_by('p.date_created desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }


    public function getPenjualan($type, $id_proposal, $dateFrom = null, $dateTo = null)
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
                ->where('so.id_proposal', $id_proposal)
                ->where('p.type', $type)
                ->order_by('so.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }


    public function getTotalPenjualan($type,  $id_proposal)
    {
        $query = $this->db
                    ->select("SUM(so.grand_total) AS grand_total", FALSE)
                    ->from('sales_order so')
                    ->join('proposal p', 'p.id_proposal = so.id_proposal')
                    ->where('so.active', 1)
                	->where('so.id_proposal', $id_proposal)
                    ->where('p.type', $type)
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

}

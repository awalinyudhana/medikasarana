<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModMutasi extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null)
    {
        if ($dateFrom) {
            $this->db->where('pm.datetime >=', $dateFrom)
                ->where('pm.datetime <=', date('Y-m-d', strtotime($dateFrom. ' + 1 days')));
        }

        $this->db
                ->select('pm.*, pu.*, pc.*,p.*, p.name AS product_name, getNameMutasi(pm.referral,pm.note)
                 , pm.qty as mutasi_qty, pm.note as mutasi_note', FALSE)
                ->from('product_movement pm')
                ->join('product p', 'p.id_product = pm.id_product')
                ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                ->join('product_category pc', 'pc.id_product_category = p.id_product_category')
                ->order_by('pm.datetime desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}
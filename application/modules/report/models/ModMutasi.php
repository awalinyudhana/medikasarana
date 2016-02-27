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
                ->where('pm.datetime <=', $dateFrom);
        }

        $this->db
                ->select('pm.*, pu.*, pc.*, p.name AS product_name, pm.referral as name')
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
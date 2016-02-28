<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModMutasiStore extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null)
    {
        if ($dateFrom) {
            $this->db->where('pms.datetime >=', $dateFrom)
                ->where('pms.datetime <=', date('Y-m-d', strtotime($dateFrom. ' + 1 days')));
        }

        $this->db
                ->select('pms.*, pu.*, pc.*,p.*, p.name AS product_name, pm.qty as mutasi_qty, pm.note as mutasi_note')
                ->from('product_movement_store pms')
                ->join('product p', 'p.id_product = pms.id_product')
                ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                ->join('product_category pc', 'pc.id_product_category = p.id_product_category')
                ->order_by('pms.datetime desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}
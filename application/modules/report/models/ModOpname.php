<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModOpname extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('o.date >=', $dateFrom)
                ->where('o.date <=', $dateTo);
        }

        $this->db
                ->select('o.*, p.*, pu.*, pc.*, p.name AS product_name, p.note AS opname_note, s.name AS staff_name')
                ->from('opname o')
                ->join('staff s', 's.id_staff = o.id_staff')
                ->join('product p', 'p.id_product = o.id_product')
                ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                ->join('product_category pc', 'pc.id_product_category = p.id_product_category')
                ->order_by('o.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}
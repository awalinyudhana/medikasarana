<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModOpnameStore extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('os.date >=', $dateFrom)
                ->where('os.date <=', $dateTo);
        }

        $this->db
                ->select('os.*, p.*, pu.*, pc.*, p.name AS product_name, os.note AS opname_note, ps.stock AS product_stock, s.name AS staff_name')
                ->from('opname_store os')
                ->join('staff s', 's.id_staff = os.id_staff')
                ->join('product_store ps', 'ps.id_product_store = os.id_product_store')
                ->join('product p', 'p.id_product = ps.id_product')
                ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                ->join('product_category pc', 'pc.id_product_category = p.id_product_category')
                ->order_by('os.date desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModProduct extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null)
    {

        $this->db
        		->select('p.*, p.name as principal_name, pr.*, pr.name as product name, pc.category, pu.unit, pu.value');
                ->from('principal p')
                ->join('purchase_order po', 'po.id_principal = p.id_principal')
                ->join('purchase_order_detail pod', 'pod.id_purchase_order = po.id_purchase_order')
                ->join('product pr', 'pr.id_product = pod.id_product')
                ->join('product_category pc', 'pc.id_product_category = pr.id_product_category')
                ->join('product_unit pu', 'pu.id_product_unit = pr.id_product_unit')
                ->group_by('p.name, pod.id_product');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function priceMovementList($id_product, $id_principal){
    	$this->db
        		->select('pm.*, p.name as principal_name, pr.*, pr.name as product name, pc.category, pu.unit, pu.value');
                ->from('product_price_movement pm')
                ->join('principal p', 'p.id_principal = pm.id_principal')
                ->join('product pr', 'pr.id_product = pm.id_product')
                ->join('product_category pc', 'pc.id_product_category = pr.id_product_category')
                ->join('product_unit pu', 'pu.id_product_unit = pr.id_product_unit');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModProduct extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($id_principal = null)
    {
        $this->db
        		->select('p.*, p.name as principal_name, pr.*, pr.name as product_name, pc.category, pu.unit, pu.value, SELECT')
                ->from('principal p')
                ->join('purchase_order po', 'po.id_principal = p.id_principal')
                ->join('purchase_order_detail pod', 'pod.id_purchase_order = po.id_purchase_order')
                ->join('product pr', 'pr.id_product = pod.id_product')
                ->join('product_category pc', 'pc.id_product_category = pr.id_product_category')
                ->join('product_unit pu', 'pu.id_product_unit = pr.id_product_unit')
                ->join('(SELECT id_price_movement, buy_price, id_product FROM product_price_movement WHERE id_principal = $id_principal order by id_price_movement desc) as pm','pm.id_product = pr.id_product','left')
                ->where('p.id_principal', $id_principal)
                ->group_by('p.name, pod.id_product');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function priceMovementList($id_product, $id_principal){
    	$this->db
        		->select('pm.*, p.name as principal_name, pr.*, pr.name as product_name, pc.category, pu.unit, pu.value')
                ->from('product_price_movement pm')
                ->join('principal p', 'p.id_principal = pm.id_principal')
                ->join('product pr', 'pr.id_product = pm.id_product')
                ->join('product_category pc', 'pc.id_product_category = pr.id_product_category')
                ->join('product_unit pu', 'pu.id_product_unit = pr.id_product_unit')
                ->where('pm.id_product', $id_product)
                ->where('pm.id_principal', $id_principal);
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }
}

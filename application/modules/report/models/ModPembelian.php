<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ModPembelian extends CI_Model
{
	public function __construct()
    {
        parent::__construct();
    }

    public function getItems($dateFrom = null, $dateTo = null){
        $monthData = $this->getMonthData($dateFrom = null, $dateTo = null);

        foreach ($this->db->get('principal')->result() as $object) {
            $data['id_principal'] =  $object->id_principal;
            $data['principal_name'] =  $object->name;

            foreach ($monthData as $value) {
                $data[$value['time']] = $this->getDataBuying($object->id_principal,$value['time']);
            }
            $principal[] = $data;
        }
        return $principal;
    }
    public function getMonthData($dateFrom = null, $dateTo = null){
        if ($dateFrom) {
            $this->db->where('po.date_created >=', $dateFrom)
                ->where('po.date_created <=', $dateTo);
        }
        $this->db
                ->select('CONCAT(YEAR(date_created),'-',MONTH(date_created)) as time')
                ->from('purchase_order po')
                ->group_by('CONCAT_WS('-', MONTH( po.date_created ) , YEAR( po.date_created ))');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result_array();
        }
                    
    }

    public function getDataBuying($id_principal,$time){
        $this->db
                ->select('SUM(po.grand_total) as grand_total',false)
                ->from('purchase_order po')
                ->where('po.id_principal', $id_principal)
                ->where('CONCAT_WS( '-', MONTH( po.date_created ) , YEAR( po.date_created ))', $time)
                ->group_by('CONCAT_WS( '-', MONTH( po.date_created ) , YEAR( po.date_created )) ');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->grand_total;
        }else{
            return '0';
        }
    }

    public function getPembelian($dateFrom = null, $dateTo = null)
    {
        if ($dateFrom) {
            $this->db->where('po.date_created >=', $dateFrom)
                ->where('po.date_created <=', $dateTo);
        }

        $this->db
                ->select('po.*, p.name AS principal_name, s.name AS staff_name')
                ->from('purchase_order po')
                ->join('principal p', 'p.id_principal = po.id_principal')
                ->join('staff s', 's.id_staff = po.id_staff')
                ->order_by('po.date_created desc');
                    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getTotalPembelian()
    {
        $query = $this->db
                    ->select("SUM(grand_total) AS grand_total", FALSE)
                    ->from('purchase_order')
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->grand_total;
        }
        return 0;
    }

    public function getDetailPembelian($id_purchase_order)
    {
        $query = $this->db
                        ->select('pod.*, p.*, pu.unit, pu.value')
                        ->from('purchase_order_detail pod')
                        ->join('product p', 'p.id_product = pod.id_product')
                        ->join('product_unit pu', 'pu.id_product_unit = p.id_product_unit')
                        ->where('pod.id_purchase_order', $id_purchase_order);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           return $query->result();
        }
    }

    public function getPrincipalName($id_purchase_order)
    {
        $query = $this->db
                        ->select('p.name')
                        ->from('principal p')
                        ->join('purchase_order po', 'po.id_principal = p.id_principal')
                        ->where('po.id_purchase_order', $id_purchase_order)
                        ->get();
        if ($query->num_rows() > 0) {
            return $query->row()->name;
        }
        return 'Unknown';
    }

    public function checkPurchaseOrder($id_purchase_order)
    {
        $query = $this->db
                        ->where('id_purchase_order', $id_purchase_order)
                        ->get('purchase_order');
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}

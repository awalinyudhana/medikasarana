<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModDashboard extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->curDate = date('Y-m-d');
    }

    public function getMinimumStock()
    {
        $where = "product.`stock` < product.`minimum_stock`";
        $this->db->where($where);
        $this->db->from('product');
        return $this->db->count_all_results();
    }

    public function getExpiredProducts()
    {
        $where = "(SELECT DATEDIFF(product.`date_expired`, '$this->curDate') AS days) < 14 AND product.`date_expired` > '$this->curDate'";
        $this->db->where($where);
        $this->db->from('product');
        return $this->db->count_all_results();
    }

    public function getCreditData()
    {
        $where = "((SELECT DATEDIFF(purchase_order.`due_date`, '$this->curDate') AS days) < 14) AND (purchase_order.`due_date` > '$this->curDate') AND (purchase_order.`status_paid` = 0)";
        $this->db->where($where);
        $this->db->from('purchase_order');
        $query = $this->db->get();

        $data['count'] = 0;
        $data['sum'] = 0;

        if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
              $data['count']++;
              $data['sum'] += ($row->grand_total - $row->paid);
           }
        }
        return $data;
    }

    public function getDebitSum()
    {
        $where = "((SELECT DATEDIFF(sales_order.`due_date`, '$this->curDate') AS days) < 14) AND (sales_order.`due_date` > '$this->curDate') AND (sales_order.`status_paid` = 0)";
        $this->db->where($where);
        $this->db->from('sales_order');
        $query = $this->db->get();

        $debitSum = 0;

        if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
              $debitSum += ($row->grand_total - $row->paid);
           }
        }
        return $debitSum;
    }
}
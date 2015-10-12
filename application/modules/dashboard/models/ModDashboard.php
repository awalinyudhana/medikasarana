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
        // $where = "(SELECT DATEDIFF(product.`date_expired`, '$this->curDate') AS days) < 30 AND product.`date_expired` > '$this->curDate'";
        $where = "(SELECT DATEDIFF(product.`date_expired`, '$this->curDate') AS days) < 30 AND product.`date_expired` > '$this->curDate'";
        $this->db->where($where);
        $this->db->from('product');
        return $this->db->count_all_results();
    }

    public function getCreditData()
    {
        // $where = "((SELECT DATEDIFF(purchase_order.`due_date`, '$this->curDate') AS days) < 14) AND (purchase_order.`due_date` > '$this->curDate') AND (purchase_order.`status_paid` = 0)";
        $where = "(SELECT DATEDIFF(purchase_order.`due_date`, '$this->curDate') AS days) < 14 AND purchase_order.`status_paid` = 0";
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

    public function getCreditBGData()
    {


        $where = "(SELECT DATEDIFF(credit.date_withdrawal, '$this->curDate') AS days) < 14";
        $query = $this->db->from('credit')
            // ->join('purchase_order', 'purchase_order.id_purchase_order = credit.id_purchase_order')
            ->where('credit.payment_type', 'bg')
            ->where('credit.status', 0)
            ->where($where)
            ->get();

        $data['count'] = 0;
        $data['sum'] = 0;

        if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
              $data['count']++;
              $data['sum'] += $row->amount;
           }
        }
        return $data;
    }

    public function getDebitData()
    {
        // $where = "((SELECT DATEDIFF(sales_order.`due_date`, '$this->curDate') AS days) < 14) AND (sales_order.`due_date` > '$this->curDate') AND (sales_order.`status_paid` = 0)";
        $where = "(SELECT DATEDIFF(sales_order.`due_date`, '$this->curDate') AS days) < 14 AND sales_order.`status_paid` = 0 AND sales_order.`active` = 1";
        $this->db->where($where);
        $this->db->from('sales_order');
        $query = $this->db->get();

        $data['sum'] = 0;
        $data['count'] = 0;

        if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
              $data['count']++;
              $data['sum'] += ($row->grand_total - $row->paid);
           }
        }
        return $data;
    }

    public function getDebitBGData()
    {

        $where = "(SELECT DATEDIFF(debit.date_withdrawal, '$this->curDate') AS days) < 14";
        $query = $this->db->from('debit')
            // ->join('sales_order', 'sales_order.id_sales_order = debit.id_sales_order')
            ->where('debit.payment_type', 'bg')
            ->where('debit.status', 0)
            ->where($where)
            ->get();

        $data['sum'] = 0;
        $data['count'] = 0;

        if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
              $data['count']++;
              $data['sum'] += $row->amount;
           }
        }
        return $data;
    }

    public function getRetailData($type = null)
    {
        switch ($type) {
            case 'month':
                $curYear = date('Y');
                $where = "(DATE_FORMAT(date, '%Y-%m-%d') >= '$curYear-01-01') AND (DATE_FORMAT(date, '%Y-%m-%d') <= '$curYear-12-31')";
                break;
            default:
                $monThisWeek = date('Y-m-d', strtotime("monday this week"));
                $friThisWeek = date('Y-m-d', strtotime("friday this week"));
                $where = "(DATE_FORMAT(date, '%Y-%m-%d') >= '$monThisWeek') AND (DATE_FORMAT(date, '%Y-%m-%d') <= '$friThisWeek')";
                break;
        }

        $this->db->where($where);
        $this->db->from('retail');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
           return $query->result_array();
        }
    }

    public function getDataPenjualan()
    {
        $query = $this->db
                    ->where('active', 1)
                    ->select('date, grand_total')
                    ->from('sales_order')
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function getDataPenjualanRetail()
    {
        $query = $this->db
                    // ->where('active', 1)
                    ->select('date, grand_total')
                    ->from('retail')
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function getDataPembelian()
    {
        $query = $this->db
                    // ->where('status_paid', 1)
                    ->select('date, grand_total')
                    ->from('purchase_order')
                    ->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function upcomingCredit()
    {
        // $where = "((SELECT DATEDIFF(po.`due_date`, '$this->curDate') AS days) < 14) AND (po.`due_date` > '$this->curDate') AND (po.`status_paid` = 0)";
        $where = "(SELECT DATEDIFF(po.`due_date`, '$this->curDate') AS days) < 14 AND po.`status_paid` = 0";
        $po = $this->db
            ->from('purchase_order po')
            ->join('principal p', 'p.id_principal = po.id_principal')
            ->where($where)
            ->order_by('po.id_purchase_order  asc')
            ->get()
            ->result();
        return $po;
    }

    public function upcomingDebit()
    {
        // $where = "((SELECT DATEDIFF(so.`due_date`, '$this->curDate') AS days) < 14) AND (so.`due_date` > '$this->curDate') AND (so.`status_paid` = 0)";
        $where = "(SELECT DATEDIFF(so.`due_date`, '$this->curDate') AS days) < 14 AND so.`status_paid` = 0 AND so.active = 1";
        $so = $this->db
            ->from('sales_order so')
            ->join('customer c', 'c.id_customer = so.id_customer')
            ->where($where)
            ->order_by('so.id_sales_order  asc')
            ->get()
            ->result();

        return $so;
    }

    public function upcomingCreditBG(){
        // $where = "((SELECT DATEDIFF(credit.date_withdrawal, '$this->curDate') AS days) < 14) AND (credit.date_withdrawal > '$this->curDate')";
        $where = "(SELECT DATEDIFF(credit.date_withdrawal, '$this->curDate') AS days) < 14";
        $credit = $this->db
            ->select("credit.*, principal.name")
            ->from('credit')
            ->join('purchase_order', 'purchase_order.id_purchase_order = credit.id_purchase_order')
            ->join('principal', 'principal.id_principal = purchase_order.id_principal')
            ->where('credit.payment_type', 'bg')
            ->where('credit.status', 0)
            ->where($where)
            ->get()
            ->result();
        return $credit;
    }

    public function upcomingDebitBG(){
        // $where = "((SELECT DATEDIFF(debit.date_withdrawal, '$this->curDate') AS days) < 14) AND (debit.date_withdrawal > '$this->curDate')";
        $where = "(SELECT DATEDIFF(debit.date_withdrawal, '$this->curDate') AS days) < 14";
        $debit = $this->db
            ->select("debit.*, customer.name")
            ->from('debit')
            ->join('sales_order', 'sales_order.id_sales_order = debit.id_sales_order')
            ->join('customer', 'customer.id_customer = sales_order.id_customer')
            ->where('debit.payment_type', 'bg')
            ->where('debit.status', 0)
            ->where('sales_order.active', 1)
            ->where($where)
            ->get()
            ->result();
        return $debit;
    }
}
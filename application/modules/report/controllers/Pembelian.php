<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('purchase_order');
        $this->load->model('ModPembelian');
    }

    // public function index()
    // {
    //     if ($this->input->post('date_from') && $this->input->post('date_to')) {
    //         $data['pembelian'] = $this->ModPembelian->getItems($this->input->post('date_from'), $this->input->post('date_to'));
    //         $data['from'] = $this->input->post('date_from');
    //         $data['to'] = $this->input->post('date_to');
    //     } else {
    //         $data['pembelian'] = $this->ModPembelian->getItems();
    //     }
        
    //     var_dump($data['pembelian']);
    // }

    // public function items()
    // {
    //     if ($this->input->post('date_from') && $this->input->post('date_to')) {
    //         $data['pembelian'] = $this->ModPembelian->getPembelian($this->input->post('date_from'), $this->input->post('date_to'));
    //         $data['from'] = $this->input->post('date_from');
    //         $data['to'] = $this->input->post('date_to');
    //     } else {
    //         $data['pembelian'] = $this->ModPembelian->getPembelian();
    //     }
        
    //     $data['total_pembelian'] = $this->ModPembelian->getTotalPembelian();

    //     $this->parser->parse('pembelian-list.tpl', $data);
    // }

    // public function detail($id_purchase_order = null)
    // {
    //     if (empty($id_purchase_order) || !$this->ModPembelian->checkPurchaseOrder($id_purchase_order)) {
    //         redirect('report/pembelian/index', 'refresh');
    //     }
    //     $data['penjualan'] = $this->ModPembelian->getDetailPembelian($id_purchase_order);
    //     $data['id_purchase_order'] = $id_purchase_order;
    //     $data['principal_name'] = $this->ModPembelian->getPrincipalName($id_purchase_order);
    //     $this->parser->parse('detail-pembelian.tpl', $data);
    // }

    private function datePeriod($min_date, $max_date)
    {
        $min_date = date_create($min_date . '-01');
        $max_date = date_create($max_date . '-31');
        $i = new DateInterval('P1M');
        $period=new DatePeriod($min_date,$i,$max_date);

        foreach ($period as $d){
          $month[] = $d->format('Y-m');
        }
        
        return $month;
    }

    private function datePeriodYear($min_date, $max_date)
    {
        $min_date = date_create($min_date . '-01-01');
        $max_date = date_create($max_date . '-12-31');
        $i = new DateInterval('P1M');
        $period=new DatePeriod($min_date,$i,$max_date);

        foreach ($period as $d){
          $month[] = $d->format('Y');
        }
        
        return $month;
    }

    public function perBulan(){
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $from = substr($this->input->post('date_from'),0,7);
            $to = substr($this->input->post('date_to'),0,7);
        }else{
            $from = substr(date('Y-m-01'),0,7);
            $to = substr(date('Y-m-t'),0,7);
        }

        $sql_from = date('Y-m-01', strtotime($from));
        $sql_to = date('Y-m-t', strtotime($to));

        $date_period = $this->datePeriod($from, $to);
        $count_date_period = count($date_period);

        foreach ($this->db->get('principal')->result() as $object) {
            $data_penjualan = $this->ModPembelian->getPenjualanCustomer($object->id_customer, 0, $sql_from, $sql_to);

            $penjualan = array();
            $date_available = array();
            $detail = array();

            foreach ($data_penjualan as $row) {
                    $penjualan[$row->yyyy_mm] = $row->grand_total;
            }

            foreach ($date_period as $value) {
                if(isset($penjualan[$value])){
                    $detail[$value]  = $penjualan[$value];
                }else{
                    $detail[$value]  = 0;
                }
            }

            $data_penjualan_per_customer[] = [
                'id_customer' => $object->id_customer,
                'customer_name' => $object->name,
                'data' => $detail
            ];
        }


        $data['items'] = $data_penjualan_per_customer;
        $data['date_period'] = $date_period;
        $data['count_date_period'] = $count_date_period;
        $data['from'] = $from;
        $data['to'] = $to;

        $this->parser->parse('penjualan-pengadaan-bulan.tpl', $data);
    }

    public function pengadaanPerTahun(){
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $from = substr($this->input->post('date_from'),0,4);
            $to = substr($this->input->post('date_to'),0,4);
        }else{
            $from = substr(date('Y-m-01'),0,4);
            $to = substr(date('Y-m-t'),0,4);
        }

        $sql_from = date('Y-01-01', strtotime($from));
        $sql_to = date('Y-12-31', strtotime($to));

        $date_period = $this->datePeriodYear($from, $to);
        $count_date_period = count($date_period);

        foreach ($this->db->get('customer')->result() as $object) {
            $data_penjualan = $this->ModPembelian->getPenjualanCustomer($object->id_customer, 0, $sql_from, $sql_to);

            $penjualan = array();
            $date_available = array();
            $detail = array();

            foreach ($data_penjualan as $row) {
                    $penjualan[$row->yyyy_mm] = $row->grand_total;
            }

            foreach ($date_period as $value) {
                if(isset($penjualan[$value])){
                    $detail[$value]  = $penjualan[$value];
                }else{
                    $detail[$value]  = 0;
                }
            }

            $data_penjualan_per_customer[] = [
                'id_customer' => $object->id_customer,
                'customer_name' => $object->name,
                'data' => $detail
            ];
        }


        $data['items'] = $data_penjualan_per_customer;
        $data['date_period'] = $date_period;
        $data['count_date_period'] = $count_date_period;
        $data['from'] = $from;
        $data['to'] = $to;

        $this->parser->parse('penjualan-pengadaan-tahun.tpl', $data);
    }
}
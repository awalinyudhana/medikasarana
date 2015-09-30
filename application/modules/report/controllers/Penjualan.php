<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModPenjualan');
        $this->proposal_type = [0 => "penjualan-pengadaan", 1 => "penjualan-tender"];
        $this->status_ppn = [0 => "Non Aktif", 1 => "Aktif"];
    }

    public function index($type = 0, $title = '')
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['penjualan'] = $this->ModPenjualan->getPenjualan($type, $this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['penjualan'] = $this->ModPenjualan->getPenjualan($type);
        }
        
        $data['total_penjualan'] = $this->ModPenjualan->getTotalPenjualan($type);

        $data['title'] = $title;
        $data['type'] = $type;
        $data['array_type'] = $this->proposal_type;
        $this->parser->parse('penjualan.tpl', $data);
    }

    public function pengadaan()
    {
        $this->index(0, 'Penjualan Pengadaan Langsung');
    }

    public function tender()
    {
        $this->index(1, 'Penjualan Tender');
    }

    public function detail($id_sales_order = null)
    {
        if (empty($id_sales_order) || !$this->ModPenjualan->checkSalesOrder($id_sales_order)) {
            redirect('report/penjualan/index', 'refresh');
        }
        $data['penjualan'] = $this->ModPenjualan->getDetailPenjualan($id_sales_order);
        $data['id_sales_order'] = $id_sales_order;
        $data['customer_name'] = $this->ModPenjualan->getCustomerName($id_sales_order);
        $this->parser->parse('detail-penjualan.tpl', $data);
    }
}
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

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['pembelian'] = $this->ModPembelian->getItems($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['pembelian'] = $this->ModPembelian->getMonthData();
        }
        
        var_dump($data['pembelian']);
    }

    public function items()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['pembelian'] = $this->ModPembelian->getPembelian($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['pembelian'] = $this->ModPembelian->getPembelian();
        }
        
        $data['total_pembelian'] = $this->ModPembelian->getTotalPembelian();

        $this->parser->parse('pembelian-list.tpl', $data);
    }

    public function detail($id_purchase_order = null)
    {
        if (empty($id_purchase_order) || !$this->ModPembelian->checkPurchaseOrder($id_purchase_order)) {
            redirect('report/pembelian/index', 'refresh');
        }
        $data['penjualan'] = $this->ModPembelian->getDetailPembelian($id_purchase_order);
        $data['id_purchase_order'] = $id_purchase_order;
        $data['principal_name'] = $this->ModPembelian->getPrincipalName($id_purchase_order);
        $this->parser->parse('detail-pembelian.tpl', $data);
    }
}
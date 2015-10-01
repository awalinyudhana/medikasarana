<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenjualanRetail extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('retail');
        $this->load->model('ModPenjualanRetail');
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['penjualan'] = $this->ModPenjualanRetail->getPenjualan($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['penjualan'] = $this->ModPenjualanRetail->getPenjualan();
        }
        
        $data['total_penjualan'] = $this->ModPenjualanRetail->getTotalPenjualan();

        $this->parser->parse('penjualan-retail.tpl', $data);
    }

    public function detail($id_retail = null)
    {
        if (empty($id_retail) || !$this->ModPenjualanRetail->checkRetail($id_retail)) {
            redirect('report/penjualanretail/index', 'refresh');
        }
        $data['penjualan'] = $this->ModPenjualanRetail->getDetailPenjualan($id_retail);
        $data['id_retail'] = $id_retail;
        $this->parser->parse('detail-penjualan-retail.tpl', $data);
    }
}
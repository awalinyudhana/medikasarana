<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturPenjualanRetail extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModReturPenjualanRetail');
        $this->id_store = $this->config->item('id_store');
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['retur_penjualan'] = $this->ModReturPenjualanRetail->getReturPenjualan($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['retur_penjualan'] = $this->ModReturPenjualanRetail->getReturPenjualan();
        }
        
        $data['total_retur_penjualan'] = $this->ModReturPenjualanRetail->getTotalReturPenjualan();

        $this->parser->parse('retur-penjualan-retail.tpl', $data);
    }

    public function detail($id_retail_return = null)
    {
        if (empty($id_retail_return) || !$this->ModReturPenjualanRetail->checkReturRetail($id_retail_return)) {
            redirect('report/retur-penjualan-retail', 'refresh');
        }

        $this->load->model('retail_return/ModelRetailReturn');
        $data['items'] = $this->ModelRetailReturn->getReturnReplacedDetailItem($id_retail_return);

        $data['id_retail_return'] = $id_retail_return;
        $data['product_storage'] = $this->storageProduct();
        $this->parser->parse('detail-retur-penjualan-retail.tpl', $data);
    }

    private function storageProduct(){
        $this->load->model('retail_return/ModelRetailReturn');
        $return = array();
        $product = $this->ModelRetailReturn->getProductStore($this->id_store);
        foreach ($product as $row) {
            $return[$row['id_product_store']] = $row;
        }
        return $return;
    }
}
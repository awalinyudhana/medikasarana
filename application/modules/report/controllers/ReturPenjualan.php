<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturPenjualan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModReturPenjualan');
        $this->proposal_type = [0 => "penjualan-pengadaan", 1 => "penjualan-tender"];
        $this->id_store = $this->config->item('id_store');
    }

    public function index($type = 0, $title = '')
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['retur_penjualan'] = $this->ModReturPenjualan->getReturPenjualan($type, $this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['retur_penjualan'] = $this->ModReturPenjualan->getReturPenjualan($type);
        }
        
        // $data['total_retur_penjualan'] = $this->ModReturPenjualan->getTotalReturPenjualan();

        $data['title'] = $title;
        $data['type'] = $type;
        $data['array_type'] = $this->proposal_type;
        $this->parser->parse('retur-penjualan.tpl', $data);
    }

    public function pengadaan()
    {
        $this->index(0, 'Penjualan Pengadaan Langsung');
    }

    public function tender()
    {
        $this->index(1, 'Penjualan Tender');
    }

    public function detail($id_sales_order_return = null)
    {
        if (empty($id_sales_order_return) || !$this->ModReturPenjualan->checkReturPenjualan($id_sales_order_return)) {
            redirect('report/retur-penjualan/index', 'refresh');
        }

        $data['items'] = $this->ModReturPenjualan->getReturnReplacedDetailItem($id_sales_order_return);

        $data['id_sales_order_return'] = $id_sales_order_return;
        $data['product_storage'] = $this->storageProduct();
        // $this->parser->parse('detail-retur-penjualan.tpl', $data);
        var_dump($data['product_storage']);
    }

    private function storageProduct(){
        $return = array();
        $product = $this->ModReturPenjualan->getProducts();
        foreach ($product as $row) {
            $return[$row['id_product']] = $row;
        }
        return $return;
    }
}
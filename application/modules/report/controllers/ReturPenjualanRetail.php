<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReturPenjualanRetail extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('retail');
        $this->load->model('ModReturPenjualanRetail');
        $this->load->model('retail_return/ModelRetailReturn');
        $this->id_store = $this->config->item('id_store');
    }
    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_from');
        } else {
            $data['from'] =  date('Y-m-01');
            $data['to'] = date('Y-m-t');
        }
        $return = $this->ModReturPenjualanRetail->getReturPenjualan($data['from'], $data['to']);
        $items = array();
        if($return){
            foreach ($return as $key) {
                $items[] = [
                    'id_retail_return' =>$key->id_retail_return,
                    'id_retail' =>$key->id_retail,
                    'date' =>$key->date,
                    'name' =>$key->name,
                    'value' =>$this->ModelRetailReturn->getReturnReplacedDetailItem($key->id_retail_return)
                ];
            }
        }
        $data['product_storage'] = $this->storageProduct();
        $data['items'] = $items;
        $this->parser->parse('return/retail.tpl', $data);
    }

    // public function index()
    // {
    //     if ($this->input->post('date_from') && $this->input->post('date_to')) {
    //         $data['retur_penjualan'] = $this->ModReturPenjualanRetail->getReturPenjualan($this->input->post('date_from'), $this->input->post('date_to'));
    //         $data['from'] = $this->input->post('date_from');
    //         $data['to'] = $this->input->post('date_to');
    //     } else {
    //         $data['retur_penjualan'] = $this->ModReturPenjualanRetail->getReturPenjualan();
    //     }
        
    //     $data['total_retur_penjualan'] = $this->ModReturPenjualanRetail->getTotalReturPenjualan();

    //     $this->parser->parse('retur-penjualan-retail.tpl', $data);
    // }

    // public function detail($id_retail_return = null)
    // {
    //     if (empty($id_retail_return) || !$this->ModReturPenjualanRetail->checkReturRetail($id_retail_return)) {
    //         redirect('report/retur-penjualan-retail', 'refresh');
    //     }

    //     $this->load->model('retail_return/ModelRetailReturn');
    //     $data['items'] = $this->ModelRetailReturn->getReturnReplacedDetailItem($id_retail_return);

    //     $data['id_retail_return'] = $id_retail_return;
    //     $data['product_storage'] = $this->storageProduct();
    //     $this->parser->parse('detail-retur-penjualan-retail.tpl', $data);
    // }

    private function storageProduct(){
        $return = array();
        $product = $this->ModelRetailReturn->getProductStore($this->id_store);
        foreach ($product as $row) {
            $return[$row['id_product_store']] = $row;
        }
        return $return;
    }
}
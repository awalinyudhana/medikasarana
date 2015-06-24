<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 14:22
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class RetailReturn extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('retail');
        $this->id_staff = $this->session->userdata('uid');
        $this->id_store = $this->config->item('id_store');
        $this->load->model('ModelRetailReturn','model_return');
        $this->load->library('cart',
            array(
                'cache_path' => 'RETAIL_RETURN',
                'cache_file' => $this->id_staff.'-'.$this->id_store,
                'primary_table' => 'retail_return',
                'foreign_table' => 'retail_return_detail'
            ));
        $this->cache = $this->cart->array_cache();
    }

    public function index()
    {
        if ($this->cart->primary_data_exists()) {
            $this->listItem();
            return false;
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        if ($this->input->post('id_retail')) {
            if ($data_retail = $this->model_return->getDataRetail($this->input->post('id_retail'))) {
                $this->cart->primary_data(array(
                    'id_retail' => $this->input->post('id_retail'),
                    'id_staff' => $this->id_staff
                ));
                redirect('retail/returns/list-item');
            }
            $data['error'] = 'no nota tidak ditemukan';
        }
        $this->parser->parse("returns-form.tpl", $data);
    }

    public function listItem()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('retail/returns');
            return false;
        }
        $data['master'] = $this->model_return->getDataRetail($this->cache['value']['id_retail']);

        $data['items'] = $this->cart
            ->list_item(
                $this->model_return->getRetailItem($this->cache['value']['id_retail']),
                'id_retail_detail')
            ->result_array_item(false);

        $data['returns'] = $this->cart
            ->list_item(
                $this->model_return->getRetailItemStorage($this->cache['value']['id_retail']),
                'id_retail_detail')
            ->result_array_item();
        $this->parser->parse("returns-list.tpl", $data);
//        var_dump($data['returns']);
    }
    public function reset(){
        if(!$this->cart->delete_record())
            redirect('retail/returns');
    }

    public function returnsItem($id_detail)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('retail/returns');
            return false;
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $detailItem = $this->model_return->getRetailDetailItem($id_detail);

        if ($this->input->post()) {
            if ($this->form_validation->run('returns') == TRUE) {
                if ($this->input->post('qty_return') <= $detailItem->qty) {
                    if( $this->model_return->checkStock($this->input->post('id_product_store'),
                        $this->input->post('qty')
                    )){
                        $this->cart->update_item($id_detail,
                            array_merge(
                                ['id_retail_detail'=>$id_detail],
                                $this->input->post()
                            ),
                            false
                        );
                        redirect('retail/returns/list-item');
                    }
                    $data['error'] = 'stok tidak cukup';
                }else{
                    $data['error'] = 'Jumlah retur tidak sesuai';
                }
            }
        }

        $data['product_storage'] = $product_storage = $this->model_return->getProductStore($this->id_store);
        $data['master'] = $this->model_return->getDataRetail($this->cache['value']['id_retail']);
        $data['detail_item'] = $detailItem;
        $this->parser->parse("returns-item.tpl", $data);
    }
    public function save(){
        if (!$this->cart->primary_data_exists() || !$this->input->post()) {
            redirect('retail/returns');
            return false;
        }
        $id_return = $this->cart->save();
        $this->checkout($id_return);
    }

    public function checkout($id_return){
        if (!$data_return = $this->model_return->getDataReturn($id_return)
        ) {
            redirect('retail/returns');
        }
        $data['master'] = $data_return;
        $data['items'] = $this->model_return->getReturnReplacedDetailItem($id_return);
        $data['returns'] = $this->model_return->getReturnReplacerDetailItem($id_return);
//        var_dump($data['items']);
        $this->parser->parse("returns-checkout.tpl", $data);
    }

    public function invoice()
    {
        if ($this->input->post('id_retail_return')) {
            if (
                $this->db
                    ->where('id_retail_return',$this->input->post('id_retail_return'))
                    ->get('retail_return')->num_rows() > 0 ) {
                redirect('retail/returns/checkout/' . $this->input->post('id_retail_return'));
            }
            $this->session->set_flashdata('message', array('class' => 'error', 'msg' => 'data tidak di temukan'));
        }
        $this->parser->parse("invoice-form.tpl");
    }
}
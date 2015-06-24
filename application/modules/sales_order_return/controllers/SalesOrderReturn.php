<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/8/2015
 * Time: 5:51 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesOrderReturn extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('proposal');
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('ModelSalesOrderReturn', 'model_return');
        $this->load->library('cart',
            array(
                'cache_path' => 'SALES_ORDER_RETURN',
                'cache_file' => $this->id_staff,
                'primary_table' => 'sales_order_return',
                'foreign_table' => 'sales_order_return_detail'
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
        if ($this->input->post('id_sales_order')) {
            if ($data_id_sales_order = $this->model_return->getDataSalesOrder($this->input->post('id_sales_order'))) {
                $this->cart->primary_data(array(
                    'id_sales_order' => $this->input->post('id_sales_order'),
                    'id_staff' => $this->id_staff
                ));
                redirect('sales-order/returns/list-item');
            }
            $data['error'] = 'no nota tidak ditemukan';
        }
        $this->parser->parse("returns-form.tpl", $data);
    }


    public function listItem()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('sales-order/returns');
            return false;
        }
        $data['master'] = $this->model_return->getDataSalesOrder($this->cache['value']['id_sales_order']);

        $data['items'] = $this->cart
            ->list_item(
                $this->model_return->getSalesOrderDetail($this->cache['value']['id_sales_order']),
                'id_sales_order_detail')
            ->result_array_item(false);

        $data['returns'] = $this->cart
            ->list_item(
                $this->model_return->getSalesOrderItemStorage($this->cache['value']['id_sales_order']),
                'id_sales_order_detail')
            ->result_array_item();
        $this->parser->parse("returns-list.tpl", $data);
    }


    public function reset(){
        if(!$this->cart->delete_record())
            redirect('sales-order/returns');
    }

    public function returnsItem($id_sales_order_detail)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('sales-order/returns');
            return false;
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $detailItem = $this->model_return->getSalesOrderDetailItem($id_sales_order_detail);

        if ($this->input->post()) {
            if ($this->form_validation->run('returns') == TRUE) {
                if ($this->input->post('qty_return') <= $detailItem->qty) {
                    if( $this->model_return->checkStock($this->input->post('id_product'),
                        $this->input->post('qty')
                    )){
                        $this->cart->update_item($id_sales_order_detail,
                            array_merge(
                                ['id_sales_order_detail'=>$id_sales_order_detail],
                                $this->input->post()
                            ),
                            false
                        );
                        redirect('sales-order/returns/list-item');
                    }
                    $data['error'] =     'stok tidak cukup';
                }else{
                    $data['error'] = 'Jumlah retur tidak sesuai';
                }
            }
        }

        $data['product_storage'] = $product_storage = $this->model_return->getProduct();
        $data['master'] = $this->model_return->getDataSalesOrder($this->cache['value']['id_sales_order']);
        $data['detail_item'] = $detailItem;
        $this->parser->parse("returns-item.tpl", $data);
    }


    public function save(){
        if (!$this->cart->primary_data_exists() || !$this->input->post()) {
            redirect('sales-order/returns');
            return false;
        }
        $id_return = $this->cart->save();
        redirect('sales-order/returns/checkout/' .$id_return);
    }

    public function checkout($id_return){
        if (!$data_return = $this->model_return->getDataReturn($id_return)
        ) {
            redirect('sales-order/returns');
        }
        $data['master'] = $data_return;
        $data['items'] = $this->model_return->getReturnReplacedDetailItem($id_return);
        $data['returns'] = $this->model_return->getReturnReplacerDetailItem($id_return);
//        var_dump($data['items']);
        $this->parser->parse("returns-checkout.tpl", $data);
    }
    public function invoice()
    {
        if ($this->input->post('id_sales_order_return')) {
            if (
                $this->db
                    ->where('id_sales_order_return',$this->input->post('id_sales_order_return'))
                    ->get('sales_order_return')->num_rows() > 0 ) {
                redirect('retail/returns/checkout/' . $this->input->post('id_sales_order_return'));
            }
            $this->session->set_flashdata('message', array('class' => 'error', 'msg' => 'data tidak di temukan'));
        }
        $this->parser->parse("invoice-form.tpl");
    }
}
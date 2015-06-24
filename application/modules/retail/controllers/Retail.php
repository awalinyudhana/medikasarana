<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 14:22
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Retail extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('retail');
        $this->id_staff = $this->session->userdata('uid');
        $this->id_store = $this->config->item('id_store');
        $this->load->model('ModRetail');
        $this->load->library('cart',
            array(
                'cache_path' => 'RETAIL',
                'cache_file' => $this->id_staff,
                'primary_table' => 'retail',
                'foreign_table' => 'retail_detail'
            ));
    }

    public function index()
    {
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        $product_storage = $this->ModRetail->getProductRetail($this->id_store);
        $data['product_storage'] = $product_storage;

        if ($this->input->post()) {
            if ($this->form_validation->run('retail') == TRUE) {
                if ($this->ModRetail->checkStock($this->input->post('id_product_store'),
                    1
                )
                ) {
                    $this->cart->add_item($this->input->post('id_product_store'), [
                        'id_product_store' => $this->input->post('id_product_store'),
                        'barcode' => $this->input->post('barcode'),
                        'qty' => 1,
                        'discount_total' => $this->input->post('discount_total') ?
                            $this->input->post('discount_total') : 0
                    ]);
                    redirect('retail');
                }
                $data['error'] = "stock tidak cukup";
            }
        }
        $data['items'] = $this->cart->list_item($product_storage, 'id_product_store')->result_array_item();
        $this->parser->parse("retail.tpl", $data);
    }

    public function updateItem($id_product_store, $qty)
    {
        if ($this->ModRetail->checkStock($id_product_store,
            $qty
        )
        ) {
            if (!$this->cart->update_item($id_product_store, ['qty' => $qty]))
                $this->session->set_flashdata('error', $this->cart->getError());
        } else {
            $this->session->set_flashdata('error', "stock tidak cukup");
        }
        redirect('retail');
    }

    public function deleteItem($id_product_store)
    {
        if (!$this->cart->delete_item($id_product_store))
            $this->session->set_flashdata('error', $this->cart->getError());
        redirect('retail');

    }

    public function save()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('retail/save') == TRUE) {
                $status_ppn = $this->input->post('status_ppn') == "on" ? 1 : 0;
                $dpp = $this->input->post('total') - $this->input->post('discount_price');
                $ppn = $status_ppn == 1 ? $dpp * 0.1 : 0;
                $id_retail = $this->cart->primary_data(array(
                    'total' => $this->input->post('total'),
                    'discount_price' => $this->input->post('discount_price'),
                    'dpp' => $dpp,
                    'ppn' => $ppn,
                    'grand_total' => $dpp + $ppn,
                    'paid' => $this->input->post('bayar'),
                    'id_staff' => $this->id_staff,
                    'id_store' => $this->id_store
                ))->save();
                redirect('retail/checkout/' . $id_retail);
            }
        }
        redirect('retail');
    }

    public function checkout($id_retail)
    {
        if (!$data_retail = $this->ModRetail->getDataRetail($id_retail)
        ) {
            redirect('retail');
        }
        $data['master'] = $data_retail;
        $data['items'] = $this->ModRetail->getRetailDetail($id_retail);
        $this->parser->parse("checkout.tpl", $data);
    }

    public function invoice()
    {
        if ($this->input->post('id_retail')) {
            if (
                $this->db
                    ->where('id_retail',$this->input->post('id_retail'))
                    ->get('retail')->num_rows() > 0 ) {
                redirect('retail/checkout/' . $this->input->post('id_retail'));
            }
            $this->session->set_flashdata('message', array('class' => 'error', 'msg' => 'data tidak di temukan'));
        }
        $this->parser->parse("invoice-form.tpl");
    }
}
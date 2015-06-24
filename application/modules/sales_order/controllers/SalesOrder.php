<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 06/05/2015
 * Time: 15:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class SalesOrder extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('proposal/ModelProduct', 'model_product');
        $this->load->model('proposal/ModelProposal', 'model_proposal');
        $this->load->model('ModelSalesOrder', 'model_so');
        $this->load->library('cart',
            array(
                'cache_path' => 'SALES_ORDER',
                'cache_file' => $this->id_staff,
                'primary_table' => 'sales_order',
                'foreign_table' => 'sales_order_detail'
            ));
        $this->cache = $this->cart->array_cache();
        $this->proposal_type = [0 => "pengadaan", 1 => "tender"];
        $this->status_ppn = [0 => "non aktif", 1 => "aktif"];
    }

    public function index($id_proposal)
    {
        if (!$this->cart->primary_data_exists()) {
            $primary = $this->model_proposal->getDataProposal($id_proposal);
            $detail = $this->model_proposal->getDataProposalDetail($id_proposal);
            $data_primary = [
                'id_customer' => $primary->id_customer,
                'id_staff' => $this->id_staff,
                'id_proposal' => $primary->id_proposal,
                'status_ppn' => $primary->status_ppn,
                'type' => $primary->type
            ];
            $this->cart->primary_data($data_primary);
            foreach ($detail as $key) {
                $this->cart->add_item($key['id_product'], $key);
            }
        }
        redirect('sales-order/list');
    }

    public function search()
    {
        if ($this->cart->primary_data_exists()) {
            redirect('sales-order/list');
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        if ($this->input->post('id_proposal')) {
            if ($data_id_proposal = $this->model_proposal->getDataProposalActive($this->input->post('id_proposal'))) {

                redirect('sales-order/'.$this->input->post('id_proposal'));
            }
            $data['error'] = 'no nota tidak ditemukan';
        }
        $this->parser->parse("sales_order-form.tpl", $data);
    }

    public function invoice(){
        if ($this->input->post('id_sales_order')) {
            if (
                $this->db
                    ->where('id_sales_order',$this->input->post('id_sales_order'))
                    ->get('sales_order')->num_rows() > 0 ) {
                redirect('sales-order/checkout/' . $this->input->post('id_sales_order'));
            }
            $this->session->set_flashdata('message', array('class' => 'error', 'msg' => 'data tidak di temukan'));
        }
        $this->parser->parse("invoice-form.tpl");
    }

    public function detail()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal/list');
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $data['master'] = $this->db->get_where('customer',
            array('id_customer' => $this->cache['value']['id_customer']))->row();
        $product_storage = $this->model_product->get($this->cache['value']['id_customer'],
            $this->cache['value']['type']);
        $data['cache'] = $this->cache;
        $data['items'] = $this->cart->list_item($product_storage, 'id_product')->result_array_item();
        $data['proposal_type'] = $this->proposal_type[$this->cache['value']['type']];
        $data['status_ppn'] = $this->status_ppn[$this->cache['value']['status_ppn']];
        $data['product_storage'] = $product_storage;
        $this->parser->parse("sales_order.tpl", $data);
    }

    public function reset()
    {
        $this->cart->delete_record();
        redirect('proposal/list');
    }

    public function save()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('sales_order/save') == TRUE) {
                $status_ppn = $this->cache['value']['status_ppn'] == 1 ?
                    1 : $this->input->post('status_ppn') == "on" ? 1 : 0;
                $dpp = $this->input->post('total') - $this->input->post('discount_price');
                $ppn = $status_ppn == 1 ? $dpp * 0.1 : 0;

                if ($id_so = $this->cart->primary_data(array(
                    'total' => $this->input->post('total'),
                    'discount_price' => $this->input->post('discount_price'),
//                    'status_ppn' => 1,
                    'status_ppn' => $this->cache['value']['status_ppn'] == 1 ? 1 : $status_ppn,
                    'due_date' => $this->input->post('due_date'),
                    'ppn' => $ppn,
                    'dpp' => $dpp,
                    'grand_total' => $dpp + $ppn
                ))->save()
                ) {
                    $this->db
                        ->where(['id_proposal' => $this->cache['value']['id_proposal']])
                        ->update('proposal', [
                            'status' => 2
                        ]);
                    redirect('sales-order/checkout/' . $id_so);
                }
                $this->session->set_flashdata('error', "transaction error");
            }
        }
        $this->detail();
    }


    public function updateItem($id_product, $qty)
    {
        if (!$this->cart->update_item($id_product, ['qty' => $qty]))
            $this->session->set_flashdata('error', $this->cart->getError());
        redirect('sales-order/list');
    }

    public function checkout($id)
    {

        if (!$master = $this->model_so->getDataSO($id)
        ) {
            redirect('proposal/list');
        }
        $data['master'] = $master;
//        $data['proposal_type'] = $this->proposal_type[$master->type];
        $data['status_ppn'] = $this->status_ppn[$master->status_ppn];
        $data['items'] = $this->model_so->getDataSODetail($id);
        $this->parser->parse("sales_order_checkout.tpl", $data);
    }

    public function deleteDetail($id_product)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal/list');
            return false;
        }
        if (!$this->cart->delete_item($id_product))
            $this->session->set_flashdata('error', $this->cart->getError());
        redirect('sales-order/list');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 04/05/2015
 * Time: 14:14
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposal extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('proposal');
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('ModelProduct', 'model_product');
        $this->load->model('ModelProposal', 'model_proposal');
        $this->load->library('cart',
            array(
                'cache_path' => 'PROPOSAL',
                'cache_file' => $this->id_staff,
                'primary_table' => 'proposal',
                'foreign_table' => 'proposal_detail'
            ));

        $this->proposal_type = [0 => "pengadaan", 1 => "tender", 2 => "pinjam bendera"];
        $this->status_ppn = [0 => "non aktif", 1 => "aktif"];
        $this->cache = $this->cart->array_cache();
    }


    public function index()
    {
        if ($this->cart->primary_data_exists()) {
            $this->insertDetail();
            return false;
        }

        if ($this->input->post()) {
            if ($this->form_validation->run('proposal') == TRUE) {
                $this->cart->primary_data(
                    [
                        'id_customer' => $this->input->post('id_customer'),
                        'id_staff' => $this->id_staff,
                        'type' => $this->input->post('type'),
                        'status_ppn' => $this->input->post('status_ppn'),
                        'status' => $this->input->post('type') == 0 ? "1" : "0"
                    ]
                );
                redirect('proposal/detail');
            }
        }

        $customers = ['' => ''];

        foreach ($this->db->get('customer')->result() as $object) {
            $customers[$object->id_customer] = $object->name;
        }
        $data['customers'] = $customers;
        $data['types'] = $this->proposal_type;
        $this->parser->parse("proposal_main.tpl", $data);
    }

    public function insertDetail()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal');
            return false;
        }

        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        if ($this->input->post()) {
            if ($this->form_validation->run('proposal/detail') == TRUE) {
                if (!$this->cache['detail']['value'][$this->input->post('id_product')]) {
                    $data_value = array(
                        'id_product' => $this->input->post('id_product'),
                        'qty' => $this->input->post('qty') != null ?
                            $this->input->post('qty') : 1,
                        'price' => $this->input->post('price'),
                        'discount' => $this->input->post('discount') == "" ? "0" : $this->input->post('discount')
                    );
                    if(!empty($this->cache['value']['id_proposal'])){
                        $data_value['id_proposal'] = $this->cache['value']['id_proposal'];
                    }

                    $this->cart->add_item($this->input->post('id_product'), $data_value);
                    redirect('proposal/detail');
                }
                $data['error'] = "Sudah ada di dalam daftar";
            }
        }


        $data['master'] = $this->db->get_where('customer',
            array('id_customer' => $this->cache['value']['id_customer']))->row();

        $product_storage = $this->model_product->get($this->cache['value']['id_customer'],
            $this->cache['value']['type']);
        $data['cache'] = $this->cache;
        $data['items'] = $this->cart->list_item($product_storage, 'id_product')->result_array_item();
        $data['proposal_type'] = $this->proposal_type[$this->cache['value']['type']];
        $data['status_ppn'] = $this->status_ppn[$this->cache['value']['status_ppn']];
        $data['product_storage'] = $product_storage;

        $this->parser->parse("proposal_detail.tpl", $data);
    }


    public function deleteDetail($id_product)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal');
            return false;
        }
        if (!$this->cart->delete_item($id_product))
            $this->session->set_flashdata('error', $this->cart->getError());
        redirect('proposal/detail');
    }

    public function detailUpdate()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal');
            return false;
        }

        if ($this->input->post()) {
            if ($this->form_validation->run('proposal/detail') == TRUE) {
                $this->cart->field_updateable(['qty', 'price', 'discount']);
                if (!$this->cart->update_item(
                    $this->input->post('id_product'),
                    [
                        'id_product' => $this->input->post('id_product'),

                        'qty' => $this->input->post('qty') != null ?
                            $this->input->post('qty') : 1,
                        'price' => $this->input->post('price'),
                        'discount' => $this->input->post('discount') == "" ? "0" : $this->input->post('discount')
                    ]
                )
                )
                    $this->session->set_flashdata('error', $this->cart->getError());
            } else {
                $this->session->set_flashdata('error', validation_errors());

            }
        }
        redirect('proposal/detail');
    }

    public function reset()
    {
        $this->cart->delete_record();
        redirect('proposal');
    }

    public function saveProposal()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('proposal');
            return false;
        }

        if(!empty($this->cache['value']['id_proposal'])){
            $this->updateProposal($this->cache['value']['id_proposal']);
            $this->cart->delete_record();
            redirect('proposal/checkout/' . $this->cache['value']['id_proposal']);
        }
        if ($this->input->post()) {
            if ($id_proposal = $this->cart->save()) {
                redirect('proposal/checkout/' . $id_proposal);
            }
            $this->session->set_flashdata('error', "Transaction error");
        }
        $this->insertDetail();
    }

    public function checkout($id)
    {
        if (!$master = $this->model_proposal->getDataProposal($id)) {
            redirect('proposal');
        }

        $this->load->model('CheckoutModel');
        $data['items'] = $this->CheckoutModel->getDataProposalDetail($id);
        $data['master'] = $master;
        $data['proposal_type'] = $this->proposal_type[$master->type];
        $data['status_ppn'] = $this->status_ppn[$master->status_ppn];
        $this->parser->parse("proposal_checkout_datatable.tpl", $data);
    }

    public function _callback_unit($value, $row)
    {
        return $row->unit . " / " . $row->value;
    }

    public function _callback_currency($value, $row)
    {
        return "Rp " . number_format($value);
    }

    public function editProposal($id_proposal)
    {
        $this->cart->delete_record();

        if ($this->cart->primary_data_exists()) {
            redirect('proposal');
            return false;
        }

        $proposal = $this->model_proposal->getDataProposal($id_proposal);
        $this->cart->primary_data(
            [
                'id_customer' => $proposal->id_customer,
                'id_staff' => $proposal->id_staff,
                'type' => $proposal->type,
                'status_ppn' => $proposal->status_ppn,
                'status' => $proposal->status,
                'id_proposal' => $id_proposal
            ]
        );
        $detail = $this->model_proposal->getDataProposalDetail($id_proposal);

        foreach ($detail as $row) {
            $data_value = array(
//                'id_detail' => $row['id_detail'],
                'id_proposal' => $row['id_proposal'],
                'id_product' => $row['id_product'],
                'qty' => $row['qty'],
                'price' => $row['price'],
                'discount' => $row['discount']
            );
            $this->cart->add_item($row['id_product'], $data_value);
        }
        redirect('proposal/detail');
    }

    public function updateProposal($id_proposal){
        $this->model_proposal->deleteDetailProposal($id_proposal);
        $data =  $this->cache['detail']['value'];
//        foreach($data as $row){
//            $value[] = $row;
//        }

        $this->model_proposal->insertDetailProposal(array_values($data));
    }

}
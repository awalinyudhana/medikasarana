<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 04/05/2015
 * Time: 14:14
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('ModelProposal', 'model_proposal');
        $this->load->library('cart',
            array(
                'cache_path' => 'SALES_ORDER',
                'cache_file' => $this->id_staff,
                'primary_table' => 'sales_order',
                'foreign_table' => 'sales_order_detail'
            ));
        $this->cache = $this->cart->array_cache();

        $this->proposal_type = [0 => "pengadaan", 1 => "tender", 2 => "pinjam bendera"];
        $this->status_ppn = [0 => "non aktif", 1 => "aktif"];
    }


    public function index($type = 'pengadaan')
    {
        if ($this->cart->primary_data_exists()) {
            redirect('sales-order/list');
        }

        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $data['array_proposal_type'] = $this->proposal_type;
        $data['array_status_ppn'] = $this->status_ppn;

        if ($type == 'pengadaan') {
            $data['items'] = $this->model_proposal->getListProposal([0, 1], 0);
        } elseif ($type == 'tender') {
            $data['items'] = $this->model_proposal->getListProposal([0, 1], 1);
        } elseif ($type == 'pinjam') {
            $data['items'] = $this->model_proposal->getListProposal([0, 1], 2);
        }

        $this->parser->parse("proposal_list.tpl", $data);
    }

    public function approve($id)
    {
        $data = $this->model_proposal->getDataProposal($id);
        if ($this->db
            ->where('id_proposal', $id)
            ->update('proposal', ['status' => 1])
        ) {
            $this->session->set_flashdata('success', "id proposal " . $id . " berhasil di update");
        }
        if($data->type == 0){
            $redirect= "proposal/list/pengadaan";
        }elseif($data->type == 1){
            $redirect= "proposal/list/tender";
        }elseif ($data->type == 2) {
            $redirect= "proposal/list/pinjam";
        }
        redirect($redirect);
    }

    public function delete($id)
    {
        $data = $this->model_proposal->getDataProposal($id);
        if ($this->db->delete('proposal', ['id_proposal' => $id])) {
            $this->session->set_flashdata('success', "id proposal " . $id . " berhasil di hapus");
        }

        if($data->type == 0){
            $redirect= "proposal/list/pengadaan";
        }elseif($data->type == 1){
            $redirect= "proposal/list/tender";
        }elseif ($data->type == 2) {
            $redirect= "proposal/list/pinjam";
        }
        redirect($redirect);
    }


    public function usang($id)
    {
        $data = $this->model_proposal->getDataProposal($id);
        if ($this->db
            ->where('id_proposal', $id)
            ->update('proposal', ['status' => 2])
        ) {
            $this->session->set_flashdata('success', "id proposal " . $id . " tidak digunakan lagi");
        }

        if($data->type == 0){
            $redirect= "proposal/list/pengadaan";
        }elseif($data->type == 1){
            $redirect= "proposal/list/tender";
        }elseif ($data->type == 2) {
            $redirect= "proposal/list/pinjam";
        }
        redirect($redirect);
    }
}
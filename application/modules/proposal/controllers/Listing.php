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

        $this->proposal_type = [0 => "pengadaan", 1 => "tender"];
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
        } else {
            $data['items'] = $this->model_proposal->getListProposal([0, 1], 1);
        }

        $this->parser->parse("proposal_list.tpl", $data);
    }

    public function approve($id)
    {
        if ($this->db
            ->where('id_proposal', $id)
            ->update('proposal', ['status' => 1])
        ) {
            $this->session->set_flashdata('success', "id proposal " . $id . " berhasil di update");
        }
        redirect('proposal/list/tender');
    }

    public function delete($id)
    {
        if ($this->db->delete('proposal', ['id_proposal' => $id])) {
            $this->session->set_flashdata('success', "id proposal " . $id . " berhasil di hapus");
        }
        redirect('proposal/list/tender');
    }


    public function usang($id)
    {
        if ($this->db
            ->where('id_proposal', $id)
            ->update('proposal', ['status' => 2])
        ) {
            $this->session->set_flashdata('success', "id proposal " . $id . " tidak digunakan lagi");
        }
        redirect('proposal/list/tender');
    }
}
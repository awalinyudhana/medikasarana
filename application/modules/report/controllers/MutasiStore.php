<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MutasiStore extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_opname_store');
        $this->load->model('ModMutasiStore');
    }

    public function index()
    {
        if ($this->input->post('date_from')) {
            $data['from'] = $this->input->post('date_from');
        } else {
            $data['from'] = date('Y-m-d');
        }

        $data['items'] = $this->ModMutasiStore->getItems($data['from']);
        $this->parser->parse('mutasi-store.tpl', $data);
    }
}
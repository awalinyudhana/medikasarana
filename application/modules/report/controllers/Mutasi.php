<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_opname');
        $this->load->model('ModMutasi');
    }

    public function index()
    {
        if ($this->input->post('date_from')) {
            $data['from'] = $this->input->post('date_from');
        } else {
            $data['from'] = date('Y-m-d');
        }

        $data['items'] = $this->ModOpname->getItems($data['from']);
        $this->parser->parse('opname.tpl', $data);
    }
}
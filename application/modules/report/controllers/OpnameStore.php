<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OpnameStore extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_opname_store');
        $this->load->model('ModOpnameStore');
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['from'] =  date('Y-m-01');
            $data['to'] = date('Y-m-t');
        }
        // if ($this->input->post('date_from') && $this->input->post('date_to')) {
        //     $data['items'] = $this->ModOpnameStore->getItems($this->input->post('date_from'), $this->input->post('date_to'));
        //     $data['from'] = $this->input->post('date_from');
        //     $data['to'] = $this->input->post('date_to');
        // } else {
        //     $data['items'] = $this->ModOpnameStore->getItems();
        // }
            $data['items'] = $this->ModOpnameStore->getItems($data['from'],$data['to']);
        $this->parser->parse('opname-store.tpl', $data);
    }
}
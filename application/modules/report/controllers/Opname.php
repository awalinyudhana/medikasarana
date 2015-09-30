<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModOpname');
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['items'] = $this->ModOpname->getItems($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['items'] = $this->ModOpname->getItems();
        }
        $this->parser->parse('opname.tpl', $data);
    }
}
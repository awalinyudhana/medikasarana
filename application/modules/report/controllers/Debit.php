<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debit extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModDebit');
        $this->status = [0 => "pending", 1 => "terbayar"];
    }

    public function index()
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['items'] = $this->ModDebit->getItems($this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['items'] = $this->ModDebit->getItems();
        }
        $data['status'] = $this->status;
        $this->parser->parse('debit.tpl', $data);
    }
}
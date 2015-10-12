<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('credit');
        $this->load->model('ModCredit');
        // $this->status = [0 => "pending", 1 => "terbayar"];
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
        //     $data['items'] = $this->ModCredit->getItems($this->input->post('date_from'), $this->input->post('date_to'));
        //     $data['from'] = $this->input->post('date_from');
        //     $data['to'] = $this->input->post('date_to');
        // } else {
        //     $data['items'] = $this->ModCredit->getItems();
        // }

        $data['items'] = $this->ModCredit->getItems($data['from'], $data['to']));
        // $data['status'] = $this->status;
        $this->parser->parse('credit.tpl', $data);
    }

}
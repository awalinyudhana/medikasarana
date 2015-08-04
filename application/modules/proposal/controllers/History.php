<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('proposal');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('history.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('proposal')
            ->columns('id_proposal', 'date_created', 'id_customer', 'id_staff', 'status_ppn', 'type')
            ->display_as('id_proposal', 'No Faktur')
            ->display_as('id_customer', 'Customer')
            ->display_as('id_staff', 'Staff')
            ->display_as('date_created', 'Tanggal Pembuatan')
            ->display_as('id_retail_return', 'No Faktur Retur')
            ->set_relation('id_customer', 'customer', 'name')
            ->set_relation('id_staff', 'staff', 'name')
            ->display_as('status_ppn', 'Status PPn')
            ->callback_column('status_ppn',array($this,'_callback_status_ppn'))
            ->callback_column('type',array($this,'_callback_type'))
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->where('status','2')
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete();

        $output = $crud->render();

        $this->render($output);
    }

    public function checkout($primary_key , $row)
    {
        return site_url('proposal/checkout/' . $primary_key);
    }

    public function _callback_status_ppn($value, $row)
    {
        if($row->status_ppn == 0){
            return "Tidak Aktif";
        }else{
            return "Aktif";
        }
    }

    public function _callback_type($value, $row)
    {
        if($row->type == 0){
            return "Pengadaan";
        }else{
            return "Tender";
        }
    }


}
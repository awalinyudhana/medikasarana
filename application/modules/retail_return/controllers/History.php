<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('purchase_order');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('history.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('retail_return')
            ->columns('id_retail_return', 'date', 'id_staff', 'id_retail')
            ->display_as('id_retail', 'No Faktur')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('id_retail_return', 'No Faktur Retur')
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete();

        $output = $crud->render();

        $this->render($output);
    }
    public function checkout($primary_key , $row)
    {
        return site_url('retail/returns/checkout/' . $primary_key);
    }
}
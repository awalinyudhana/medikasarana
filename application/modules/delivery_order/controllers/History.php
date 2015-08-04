<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('delivery_order');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('history.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('delivery_order')
            ->columns('id_delivery_order', 'date_printed', 'date_sending', 'id_staff')
            ->display_as('id_delivery_order', 'No Faktur')
            ->display_as('id_staff', 'Staff')
            ->display_as('date_printed', 'Tanggal Pembuatan')
            ->display_as('date_sending', 'Tanggal Pengiriman')
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
        return site_url('delivery-order/checkout/' . $primary_key);
    }
}
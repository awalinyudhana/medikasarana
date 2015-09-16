<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('sales_order');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('history.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('sales_order_return')
            ->columns('id_sales_order_return', 'date', 'id_staff', 'id_sales_order')
            ->display_as('id_sales_order', 'No Faktur')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('id_sales_order_return', 'No Faktur Retur')
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete()
            ->order_by('id_sales_order_return','desc');

        $output = $crud->render();

        $this->render($output);
    }
    public function checkout($primary_key , $row)
    {
        return site_url('sales-order/returns/checkout/' . $primary_key);
    }
}
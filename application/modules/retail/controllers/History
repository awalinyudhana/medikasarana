<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('retail');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('history.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('retail')
            ->columns('id_retail', 'date', 'id_staff', 'dpp', 'ppn', 'discount_price', 'grand_total', 'paid')
            ->display_as('id_retail', 'No Faktur')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('discount_price', 'Discount')
            ->display_as('grand_total', 'Grand Total')
            ->callback_column('dpp', array($this, 'currencyFormat'))
            ->callback_column('ppn', array($this, 'currencyFormat'))
            ->callback_column('discount_price', array($this, 'currencyFormat'))
            ->callback_column('grand_total', array($this, 'currencyFormat'))
            ->callback_column('paid', array($this, 'currencyFormat'))
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete();

        $output = $crud->render();

        $this->render($output);
    }
    public function currencyFormat($value, $row)
    {
        return "Rp " . number_format($value);
    }
    public function checkout($primary_key , $row)
    {
        return site_url('retail/checkout/' . $primary_key);
    }
}
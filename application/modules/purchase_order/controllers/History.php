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
        $this->parser->parse('index.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('purchase_order')
            ->columns('id_purchase_order', 'id_pricipal', 'id_staff', 'date', 'due_date', 'dpp', 'ppn', 'discount_price', 'grand_total')
            ->display_as('id_purchase_order', 'No Faktur')
            ->display_as('id_pricipal', 'Principal')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('due_date', 'Jatuh Tempo')
            ->display_as('discount_price', 'Discount')
            ->display_as('grand_total', 'Grand Total')
            ->callback_column('dpp', array($this, 'currencyFormat'))
            ->callback_column('ppn', array($this, 'currencyFormat'))
            ->callback_column('discount_price', array($this, 'currencyFormat'))
            ->callback_column('grand_total', array($this, 'currencyFormat'))
            ->set_relation('id_pricipal', 'principal', 'name')
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Attach', '', '','ui-icon-image',array($this,'attach_file'))
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

    public function attach_file($primary_key , $row)
    {
        return base_url() . "/upload/po/".$row->file;
    }
    public function checkout($primary_key , $row)
    {
        site_url('purchase-order/invoice/' . $primary_key);
    }
}
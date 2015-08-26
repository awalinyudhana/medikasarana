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

        $crud->set_table('sales_order')
            ->columns('id_sales_order', 'id_proposal', 'id_customer', 'id_staff', 'date', 'due_date', 'dpp', 'ppn', 'discount_price', 'grand_total','status_ppn','paid')
            ->display_as('id_sales_order', 'No Faktur')
            ->display_as('id_proposal', 'No Proposal')
            ->display_as('id_customer', 'Customer')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('due_date', 'Jatuh Tempo')
            ->display_as('discount_price', 'Discount')
            ->display_as('grand_total', 'Grand Total')
            ->display_as('status_ppn', 'Status PPn')
            ->callback_column('dpp', array($this, 'currencyFormat'))
            ->callback_column('ppn', array($this, 'currencyFormat'))
            ->callback_column('discount_price', array($this, 'currencyFormat'))
            ->callback_column('grand_total', array($this, 'currencyFormat'))
            ->callback_column('paid', array($this, 'currencyFormat'))
            ->callback_column('status_ppn',array($this,'_callback_status_ppn'))
            ->set_relation('id_customer', 'customer', 'name')
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->where('active','1')
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
        return site_url('sales-order/checkout/' . $primary_key);
    }

    public function _callback_status_ppn($value, $row)
    {
        if($row->status_ppn == 0){
            return "Tidak Aktif";
        }else{
            return "Aktif";
        }
    }
}
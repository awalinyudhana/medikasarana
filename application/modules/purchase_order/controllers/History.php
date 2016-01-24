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

        $crud->set_table('purchase_order')
            ->columns('id_purchase_order', 'id_principal', 'id_staff', 'status_ppn', 'date', 'due_date', 'total','dpp', 'ppn', 'discount_price', 'grand_total')
            ->display_as('id_purchase_order', 'No Faktur')
            ->display_as('status_ppn', 'Status PPn')
            ->display_as('id_principal', 'Principal')
            ->display_as('id_staff', 'Staff')
            ->display_as('date', 'Tanggal Transaksi')
            ->display_as('due_date', 'Jatuh Tempo')
            ->display_as('discount_price', 'Discount')
            ->display_as('grand_total', 'Grand Total')
            ->callback_column('status_ppn',array($this,'_callback_status_ppn'))
            ->callback_column('total', array($this, 'currencyFormat'))
            ->callback_column('dpp', array($this, 'currencyFormat'))
            ->callback_column('ppn', array($this, 'currencyFormat'))
            ->callback_column('discount_price', array($this, 'currencyFormat'))
            ->callback_column('grand_total', array($this, 'currencyFormat'))
            ->set_relation('id_principal', 'principal', 'name')
            ->set_relation('id_staff', 'staff', 'name')
            ->add_action('Detail', '', '', 'read-icon', array($this, 'checkout'))
            ->add_action('Attach', '\assets\grocery_crud\themes\flexigrid\css\images\attachment-icon.png', '','',array($this,'attach_file'))
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete()
            ->order_by('id_purchase_order','desc');

        $output = $crud->render();

        $this->render($output);
    }
    public function currencyFormat($value, $row)
    {
        return "Rp " . number_format($value);
    }

    public function attach_file($primary_key , $row)
    {
        return $row->file;
    }
    public function checkout($primary_key , $row)
    {
        return site_url('purchase-order/invoice/' . $primary_key);
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
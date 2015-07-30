<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 7/30/2015
 * Time: 10:57 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_store');
        $this->load->library('grocery_CRUD');
        $this->load->model('ModStore');
        $this->id_store = $this->config->item('id_store');
    }

    public function render($output)
    {
        $this->parser->parse('index.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();


        $crud
            ->where('id_store', $this->id_store)
            ->set_table('product_store')
            ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock')
            ->display_as('id_product_category', 'Product Category')
            ->display_as('id_product_unit', 'Product Satuan')
            ->display_as('date_expired', 'Date Expired')
            ->display_as('license', 'AKL/AKD')
            ->display_as('value', 'Nilai Satuan')
            ->callback_column('sell_price', array($this, 'currencyFormat'))
            ->set_relation('id_product_category', 'product_category', 'category')
            ->set_relation('id_product_unit', 'product_unit', '{unit} / {value}')
            ->unset_fields('weight', 'length', 'width', 'height', 'sell_price', 'stock')
            ->unset_read()
            ->unset_add()
            ->unset_edit()
            ->unset_delete();

        $output = $crud->render();

        $this->render($output);
    }
}
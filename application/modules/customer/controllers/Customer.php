<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('customer');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('index.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('customer')
            ->columns('name','alias_name1','alias_name2', 'owner', 'npwp', 'address', 'zipcode', 'city', 'state', 'country', 'plafond', 'telp1', 'telp2')
            ->display_as('npwp', 'NPWP')
            ->display_as('name', 'Nama Konsumen')
            ->display_as('alias_name1', 'Nama Faktur 1')
            ->display_as('alias_name2', 'Nama Faktur 2')
            ->display_as('address', 'Alamat')
            ->display_as('zipcode', 'Kode Pos')
            ->display_as('city', 'Kota')
            ->display_as('state', 'Provinsi')
            ->display_as('country', 'Negara')
            ->display_as('telp1', 'Telp 1')
            ->display_as('plafond', 'Plafon')
            ->callback_column('plafond', array($this, 'currencyFormat'))
            ->display_as('telp1', 'Telp 1')
            ->display_as('telp2', 'Telp 2')
            ->display_as('owner', 'Direktur')
            ->fields('name','alias_name1','alias_name2', 'owner', 'npwp', 'address', 'zipcode', 'city', 'state', 'country', 'plafond', 'telp1', 'telp2')
            ->required_fields('name', 'address', 'city', 'state', 'country', 'plafond', 'telp1')
            ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }

    public function currencyFormat($value, $row)
    {
        return "Rp " . number_format($value);
    }

} 
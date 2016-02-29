<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('store');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
         $this->parser->parse('index.tpl',$output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();
 
        $crud->set_table('store')
            ->columns('name', 'owner', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'fax', 'npwp', 'note')
            ->display_as('name', 'Nama Toko')
            ->display_as('owner', 'Nama Pemilik')
            ->display_as('address', 'Alamat')
            ->display_as('zipcode', 'Kode Pos')
            ->display_as('city', 'Kota')
            ->display_as('state', 'Provinsi')
            ->display_as('country', 'Negara')
            ->display_as('npwp', 'NPWP')
            ->display_as('note', 'Keterangan')
            ->display_as('telp1', 'Telp 1')
            ->display_as('telp2', 'Telp 2')
            ->fields('name', 'owner', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'fax', 'npwp',  'note')
            ->required_fields('name', 'owner', 'address', 'zipcode', 'city', 'state', 'country', 'telp1')
            ->unset_read()
            ->unset_add()
            ->unset_delete()
            ->callback_field('note', array($this, 'setTextarea'));
        $output = $crud->render();
        $this->render($output);
    }

    public function setTextarea($value, $row)
    {
        return "<textarea name='note' rows='2' cols='40'>$value</textarea>";
    }
} 
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
                ->columns('name', 'owner', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'fax', 'note')
                ->display_as('npwp', 'NPWP')
                ->display_as('zipcode', 'Zip Code')
                ->display_as('telp1', 'Telp 1')
                ->display_as('telp2', 'Telp 2')
                ->fields('name', 'owner', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'fax', 'note')
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
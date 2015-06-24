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
 		 $this->parser->parse('index.tpl',$output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();
 
        $crud->set_table('customer')
                ->columns('name', 'owner', 'npwp', 'address', 'zipcode', 'city', 'state', 'country', 'plafond', 'telp1', 'telp2')
                ->display_as('npwp', 'NPWP')
                ->display_as('zipcode', 'Zip Code')
                ->display_as('telp1', 'Telp 1')
                ->display_as('telp2', 'Telp 2')
                ->display_as('owner', 'Direktur')
                ->fields('name', 'owner', 'npwp', 'address', 'zipcode', 'city', 'state', 'country', 'plafond', 'telp1', 'telp2')
                ->required_fields('name', 'owner', 'npwp', 'address', 'zipcode', 'city', 'state', 'country', 'plafond', 'telp1')
                ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }
} 
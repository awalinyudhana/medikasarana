<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('principal');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
        $this->parser->parse('index.tpl', $output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('principal')
            ->columns('name', 'email', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'npwp', 'siup', 'pbf', 'pbak', 'fak')
            ->display_as('npwp', 'NPWP')
            ->display_as('zipcode', 'Zip Code')
            ->display_as('telp1', 'Telp 1')
            ->display_as('telp2', 'Telp 2')
            ->display_as('siup', 'SIUP')
            ->display_as('pbf', 'PBF')
            ->display_as('pbak', 'PBAK')
            ->display_as('fak', 'FAK')
            ->fields('name', 'email', 'address', 'zipcode', 'city', 'state', 'country', 'telp1', 'telp2', 'npwp', 'siup', 'pbf', 'pbak', 'fak')
            ->required_fields('name', 'email', 'address', 'zipcode', 'city', 'state', 'country', 'telp1')
            ->set_rules('email', 'Email', 'valid_email')
            ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }
} 
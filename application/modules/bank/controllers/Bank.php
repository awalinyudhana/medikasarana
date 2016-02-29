<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('bank');
        $this->load->library('grocery_CRUD');
    }

    public function render($output)
    {
 		$this->parser->parse('index.tpl',$output);
    }

    public function index()
    {
        $crud = new grocery_CRUD();
 
        $crud->set_table('bank_info')
                ->columns('id_principal', 'bank_name', 'bank_account', 'bank_beneficiary_name', 'bank_city', 'bank_branch')
                ->display_as('id_principal', 'Nama Prinsipal')
                ->display_as('bank_name', 'Nama Bank')
                ->display_as('bank_account', 'No Rekening')
                ->display_as('bank_beneficiary_name', 'Nama Rekening')
                ->display_as('bank_city', 'Kota')
                ->display_as('bank_branch', 'Cabang')
                ->set_relation('id_principal', 'principal', 'name')
                ->fields('id_principal', 'bank_name', 'bank_account', 'bank_beneficiary_name', 'bank_city', 'bank_branch')
                ->required_fields('id_principal', 'bank_account', 'bank_beneficiary_name')
                ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }
} 
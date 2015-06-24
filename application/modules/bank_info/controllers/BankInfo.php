<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BankInfo extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('bank_info');
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
                ->display_as('id_principal', 'Principal Name')
                ->display_as('bank_name', 'Bank Name')
                ->display_as('bank_account', 'Bank Account')
                ->display_as('bank_beneficiary_name', 'Bank Beneficiary Name')
                ->display_as('bank_city', 'Bank City')
                ->display_as('bank_branch', 'Bank Branch')
                ->set_relation('id_principal', 'principal', 'name')
                ->fields('id_principal', 'bank_name', 'bank_account', 'bank_beneficiary_name', 'bank_city', 'bank_branch')
                ->required_fields('id_principal', 'bank_name', 'bank_account', 'bank_beneficiary_name', 'bank_city', 'bank_branch')
                ->unset_read();
        $output = $crud->render();
        $this->render($output);
    }
} 
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModPrincipal extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getBankAccount($id_principal)
    {
        $row = $this->db->get_where('bank_info', array('id_principal' => $id_principal))->row();
        if ($row->bank_account > 0) {
            return $row->bank_account;
        } else {
            return '-';
        }
    }

    public function getBankBeneficiary($id_principal)
    {
        $row = $this->db->get_where('bank_info', array('id_principal' => $id_principal))->row();
        if ($row->bank_beneficiary_name > 0) {
            return $row->bank_beneficiary_name;
        } else {
            return '-';
        }
    }

    public function getBankCity($id_principal)
    {
        $row = $this->db->get_where('bank_info', array('id_principal' => $id_principal))->row();
        if ($row->bank_city > 0) {
            return $row->bank_city;
        } else {
            return '-';
        }
    }

    public function getBankBranch($id_principal)
    {
        $row = $this->db->get_where('bank_info', array('id_principal' => $id_principal))->row();
        if ($row->bank_branch > 0) {
            return $row->bank_branch;
        } else {
            return '-';
        }
    }
}
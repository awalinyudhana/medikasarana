<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModWarehouse extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductStock($id_product)
    {
        $row = $this->db->get_where('product', array('id_product' => $id_product))->row();
        if ($row->stock > 0) {
            return $row->stock;
        } else {
            return '0';
        }
    }
}
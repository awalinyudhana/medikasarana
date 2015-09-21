<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModStore extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getStoreDataById($id_store){
        $this->db->where('id_store', $id_store);
        $query = $this->db->get('store');

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
}
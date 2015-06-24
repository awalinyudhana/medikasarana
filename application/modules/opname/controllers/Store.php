<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 20/04/2015
 * Time: 15:58
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MX_Controller
{
    protected $cache = array();

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_opname_store');
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('retail/ModRetail', 'ModRetail');

        $this->id_store = $this->config->item('id_store');
    }

    public function index(){
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $data['product_storage'] = $this->ModRetail->getProductRetail($this->id_store);
        $this->parser->parse("store/opname.tpl", $data);
    }
    public function checking($id_product){
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        $data['product_storage'] = $this->ModRetail->getProductRetail($this->id_store);
        $data['product'] = $this->ModRetail->getProductRetailSingle($this->id_store,$id_product);
        $this->parser->parse("store/checking.tpl", $data);
    }

    public function save()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('opname-store/save') == TRUE) {
                $data_value = array(
                    'id_staff' => $this->id_staff,
                    'id_product_store' => $this->input->post('id_product_store'),
                    'stock_system' => $this->input->post('stock_system'),
                    'stock_difference' => $this->input->post('stock_real')-$this->input->post('stock_system'),
                    'stock_real' => $this->input->post('stock_real'),
                    'note' => $this->input->post('note')
                );

                $this->db->insert('opname_store',$data_value);
                $this->session->set_flashdata('success','Input data berhasil');

                redirect('stock-opname/store');
                return false;
            }
            $this->checking($this->input->post('id_product'));
            return false;
        }
        redirect('stock-opname/store');
    }

}
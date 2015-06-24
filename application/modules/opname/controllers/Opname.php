<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 20/04/2015
 * Time: 15:58
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends MX_Controller
{
    protected $cache = array();

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_opname');
        $this->id_staff = $this->session->userdata('uid');
        $this->load->model('product/ModProduct', 'ModProduct');
    }

    public function index(){
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $data['product_storage'] = $this->ModProduct->get();
        $this->parser->parse("opname.tpl", $data);
    }
    public function checking($id_product){
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        $data['product_storage'] = $this->ModProduct->get();
        $data['product'] = $this->ModProduct->getProduct($id_product);
        $this->parser->parse("checking.tpl", $data);
    }

    public function save()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('opname/save') == TRUE) {
                $data_value = array(
                    'id_staff' => $this->id_staff,
                    'id_product' => $this->input->post('id_product'),
                    'stock_system' => $this->input->post('stock_system'),
                    'stock_difference' => $this->input->post('stock_real')-$this->input->post('stock_system'),
                    'stock_real' => $this->input->post('stock_real'),
                    'note' => $this->input->post('note')
                );

                $this->db->insert('opname',$data_value);
                $this->session->set_flashdata('success','Input data berhasil');

                redirect('stock-opname');
                return false;
            }
            $this->checking($this->input->post('id_product'));
            return false;
        }
        redirect('stock-opname');
    }

}
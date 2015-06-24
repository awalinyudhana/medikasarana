<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 27/04/2015
 * Time: 12:57
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pricing extends MX_Controller
{
    protected $id_staff;

    protected $cache = array();

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('pricing');
        $this->load->model('product/ModProduct', 'ModProduct');

        $this->id_staff = $this->config->item('id_staff');
    }

    public function index()
    {
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $this->load->model('product/ModProduct', 'ModProduct');
        $data['product_storage'] = $this->ModProduct->get();
        $this->parser->parse("pricing.tpl", $data);
    }

    public function setPrice($id_product){
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        if($this->input->post()){
            if ($this->form_validation->run('pricing') == TRUE) {
                $this->db
                    ->where('id_product',$id_product)
                    ->update('product',['sell_price'=>$this->input->post('sell_price')]);
                $this->session->set_flashdata('success','data berhasil di update');
                redirect('pricing');
            }
            $data['error'] = 'error transaction';
        }
        $data['price_movement'] = $this->db
            ->from('product_price_movement pm')
            ->join('principal p','p.id_principal = pm.id_principal')
            ->where(['id_product' =>$id_product])
            ->get()
            ->result();
        $data['product'] = $this->ModProduct->getProduct($id_product);
        $this->parser->parse("set_price.tpl", $data);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('warehouse');
        $this->load->model('ModProduct');
    }

    public function index()
    {
        $principal = array('' => '');
        foreach ($this->db->get('principal')->result() as $object) {
            $principal[$object->id_principal] = $object->name;
        }
        $data['principals'] = $principal;
        $this->parser->parse("product.tpl", $data);
    }

    public function items()
    {
        if ($this->input->post('id_principal')) {
            $data['items'] = $this->ModProduct->getItems($this->input->post('id_principal'));
        } else {
            redirect('report/product');
        }

        $data['principal'] = $this->db->get_where('principal',
            array('id_principal' => $this->input->post('id_principal')))->row();

        $this->parser->parse('product-list.tpl', $data);
    }

    public function detail($id_product, $id_principal)
    {
        $data['items'] = $this->ModProduct->priceMovementList($id_product, $id_principal);
        $this->parser->parse('product-detail.tpl', $data);
    }
}
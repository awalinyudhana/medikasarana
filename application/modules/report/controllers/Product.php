<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModProduct');
    }

    public function index()
    {
        $data['items'] = $this->ModProduct->getItems();
        $this->parser->parse('product.tpl', $data);
    }

    public function index($id_product, $id_principal){
        $data['items'] = $this->ModProduct->priceMovementList($id_product, $id_principal);

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 22/04/2015
 * Time: 11:39
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Returns extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_return');
        $this->id_staff = $this->session->userdata('uid');
        $this->id_store = $this->config->item('id_store');
        $this->load->model('ModelProductStore', 'model_product');
        $this->load->library('cart',
            array(
                'cache_path' => 'PRODUCT_RETURN',
                'cache_file' => $this->id_staff,
                'primary_table' => 'product_return',
                'foreign_table' => 'product_return_detail'
            ));
    }

    public function index()
    {
        $data['error'] = !$this->session->flashdata('error') ? "" : $this->session->flashdata('error');

        if (!$cache = $this->cart
            ->primary_data(array(
                'id_staff' => $this->id_staff,
                'id_store' => $this->id_store
            ))
            ->array_cache()
        ) {
            $data['error'] = $this->cart->getError();
        }

        $product_storage = $this->model_product->get($this->id_store);

        $items = $this->cart->list_item($product_storage, 'id_product_store')->result_array_item();

        $data['cache'] = $cache;
        $data['items'] = $items;
        $data['product_storage'] = $product_storage;

        $this->parser->parse("return.tpl", $data);
    }

    public function add()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('product-returns') == TRUE) {

                if ($this->model_product->checkStock($this->input->post('id_product_store'),
                        $this->input->post('qty')) == TRUE
                ) {
                    $data_value = array(
                        'id_product_store' => $this->input->post('id_product_store'),
                        'qty' => $this->input->post('qty')
                    );

                    if (!$this->cart->add_item($this->input->post('id_product_store'), $data_value)) {
                        $this->session->set_flashdata('error', $this->cart->getError());
                    }

                }else{
                    $this->session->set_flashdata('error', "stok tidak cukup");
                }
            }else{
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        redirect('product-returns');
    }

    public function delete($id_product)
    {
        if (!$this->cart->delete_item($id_product)) {
            $this->session->set_flashdata('error', $this->cart->getError());
        }
        redirect('product-returns');
    }

    public function save()
    {
        if ($this->input->post()) {
            $i = 0;
            foreach ($this->input->post('id_product_store') as $val) {
                $id_product_store = $val;
                $qty = $this->input->post('qty')[$i];
                if ($this->model_product->checkStock($id_product_store, $qty) == TRUE) {

                    $data_value = array(
                        'id_product_store' => $id_product_store,
                        'qty' => $qty
                    );

                    if (!$this->cart->update_item($id_product_store, $data_value)) {
                        $this->session->set_flashdata('error', $this->cart->getError());
                        redirect('product-distribution');
                    }
                } else {
                    $this->session->set_flashdata('error', "input data error");
                    redirect('product-returns');
                }
                $i++;
            }
            if($id_distribution = $this->cart->save()){
                redirect('product-returns/checkout'.'/'.$id_distribution);
            }
            $this->session->set_flashdata('error', "transaction error");
        }
        redirect('product-returns');
    }

    public function checkout($id_return)
    {
        if (!$data_return = $this->db->select("* , staff.name as staff_name, store.name as store_name")
            ->from('product_return pr')
            ->join('staff', 'staff.id_staff = pr.id_staff')
            ->join('store','store.id_store = pr.id_store')
            ->where(array('pr.id_product_return' => $id_return))
            ->get()->row()
        ) {
            redirect('product-distribution');
        }
        $data['master'] = $data_return;
        $items = $this->db->select('*')
            ->from('product_return_detail prd')
            ->join('product_store ps','ps.id_product_store = prd.id_product_store')
            ->join('product p','p.id_product = ps.id_product')
            ->join('product_category pc','pc.id_product_category = p.id_product_category')
            ->join('product_unit pu','pu.id_product_unit = p.id_product_unit')
            ->where(array('prd.id_product_return' => $id_return))
            ->get()->result();
        $data['items'] = $items;
        $this->parser->parse("checkout.tpl", $data);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 22/04/2015
 * Time: 11:39
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribution extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('product_distribution');
        $this->id_staff = $this->session->userdata('uid');
        $this->id_store = $this->config->item('id_store');
        $this->load->model('product/ModProduct', 'ModProduct');
        $this->load->library('cart',
            array(
                'cache_path' => 'PRODUCT_DISTRIBUTION',
                'cache_file' => $this->id_staff,
                'primary_table' => 'product_distribution',
                'foreign_table' => 'product_distribution_detail'
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

        $product_storage = $this->ModProduct->get();

        $items = $this->cart->list_item($product_storage, 'id_product')->result_array_item();

        $data['cache'] = $cache;
        $data['items'] = $items;
        $data['product_storage'] = $product_storage;
//        var_dump($product_storage);

        $this->parser->parse("distribution.tpl", $data);
    }

    public function add()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('distribution') == TRUE) {

                if ($this->ModProduct->checkStock($this->input->post('id_product'),
                        $this->input->post('qty')) == TRUE
                ) {
                    $data_value = array(
                        'id_product' => $this->input->post('id_product'),
                        'qty' => $this->input->post('qty')
                    );

                    if (!$this->cart->add_item($this->input->post('id_product'), $data_value)) {
                        $this->session->set_flashdata('error', $this->cart->getError());
                    }

                }else{
                    $this->session->set_flashdata('error', "stok tidak cukup");
                }
            }else{
                $this->session->set_flashdata('error', validation_errors());
            }
        }
        redirect('product-distribution');
    }

    public function delete($id_product)
    {
        if (!$this->cart->delete_item($id_product)) {
            $this->session->set_flashdata('error', $this->cart->getError());
        }
        redirect('product-distribution');
    }

    public function save()
    {
        if ($this->input->post()) {
            $i = 0;
            foreach ($this->input->post('id_product') as $val) {
                $id_product = $val;
                $qty = $this->input->post('qty')[$i];
                if ($this->ModProduct->checkStock($id_product, $qty) == TRUE) {

                    $data_value = array(
                        'id_product' => $id_product,
                        'qty' => $qty
                    );

                    if (!$this->cart->update_item($id_product, $data_value)) {
                        $this->session->set_flashdata('error', $this->cart->getError());
                        redirect('product-distribution');
                    }
                } else {
                    $this->session->set_flashdata('error', "input data error");
                    redirect('product-distribution');
                }
                $i++;
            }
            if($id_distribution = $this->cart->save()){
                redirect('product-distribution/checkout'.'/'.$id_distribution);
            }
            $this->session->set_flashdata('error', "transaction error");
        }
        redirect('product-distribution');
    }

    public function checkout($id_distribution)
    {
        if (!$data_distribution = $this->db->select("* , staff.name as staff_name, store.name as store_name")
            ->from('product_distribution pd')
            ->join('staff', 'staff.id_staff = pd.id_staff')
            ->join('store','store.id_store = pd.id_store')
            ->where(array('pd.id_product_distribution' => $id_distribution))
            ->get()->row()
        ) {
            redirect('product-distribution');
        }
        $data['distribution'] = $data_distribution;
        $items = $this->db->select('*')
            ->from('product_distribution pd')
            ->join('product_distribution_detail pdd','pdd.id_product_distribution = pd.id_product_distribution')
            ->join('product p','p.id_product = pdd.id_product')
            ->join('product_category pc','pc.id_product_category = p.id_product_category','left')
            ->join('product_unit pu','pu.id_product_unit = p.id_product_unit','left')
            ->where(array('pd.id_product_distribution' => $id_distribution))
            ->get()->result();
        $data['items'] = $items;
        $this->parser->parse("checkout.tpl", $data);
    }

}
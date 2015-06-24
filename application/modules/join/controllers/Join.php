<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 12/05/2015
 * Time: 14:29
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Join extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('join');
        $this->id_staff = $this->session->userdata('uid');

        $this->load->library('cart',
            array(
                'cache_path' => 'JOIN',
                'cache_file' => $this->id_staff,
                'primary_table' => 'sales_order',
                'foreign_table' => 'sales_order_detail'
            ));

        $this->load->model('ModelJoin', 'model_join');
        $this->cache = $this->cart->array_cache();
    }


    public function index()
    {
        if ($this->cart->primary_data_exists()) {
            redirect('join/do');
        }
        $data['items'] = null;
        if ($this->input->post('id_customer')) {
            $data['items'] = $this->model_join->getListSO($this->input->post('id_customer'));
            $data['id_customer'] = $this->input->post('id_customer');
        }
        $customer = array('' => '');
        foreach ($this->db->get('customer')->result() as $object) {
            $customer[$object->id_customer] = $object->name;
        }
        $data['customers'] = $customer;
        $this->parser->parse("join.tpl", $data);
    }

    public function select($id_customer)
    {
        if ($this->input->post('id_sales_order')) {
            $detail = $this->model_join->getDataSODetail($this->input->post('id_sales_order'));
            $discount_price = $this->model_join->getDiscountPrice($this->input->post('id_sales_order'));
            $due_date = $this->model_join->getDueDate($this->input->post('id_sales_order'));
            $data_primary = [
                'id_customer' => $id_customer,
                'id_staff' => $this->id_staff,
                'selected' => $this->input->post('id_sales_order'),
                'discount_price' => $discount_price->discount_price,
                'due_date' => $due_date->due_date,
                'id_proposal' => null,
                'status_ppn' => 0 // set able
            ];
            $this->cart->primary_data($data_primary);
            foreach ($detail as $key) {
                $row = array_merge($key,['reference'=>$key['id_sales_order_detail']]);
                unset($row['id_sales_order_detail']);
                $this->cart->add_item($key['id_sales_order_detail'], $row);
            }
        }
        redirect('join/do');
    }

    public function listing()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('join');
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $data['master'] = $this->db->get_where('customer', ['id_customer' => $this->cache['value']['id_customer']])->row();

        $data['cache'] = $this->cache;
        $data['items'] = $this->cache['detail']['value'];
        $this->parser->parse("join_list.tpl", $data);
    }

    public function reset()
    {
        $this->cart->delete_record();
        redirect('join');
    }


    public function save()
    {
        if ($this->input->post()) {
//            if ($this->form_validation->run('sales_order/save') == TRUE) {

                $status_ppn = $this->input->post('status_ppn') == "on" ? 1 : 0;
                $dpp = $this->input->post('total') - $this->input->post('discount_price');
                $ppn = $status_ppn == 1 ? $dpp * 0.1 : 0;

                $array_selected_id = $this->cache['value']['selected'];
                if ($id_sales_order = $this->cart->primary_data(array(
                    'total' => $this->input->post('total'),
                    'discount_price' => $this->input->post('discount_price'),
                    'status_ppn' => $this->cache['value']['status_ppn'] == 1 ? 1 : $status_ppn,
//                    'due_date' => $this->input->post('due_date'),
                    'ppn' => $ppn,
                    'dpp' => $dpp,
                    'grand_total' => $dpp + $ppn
                ))->save()
                ) {
                    $this->db
                        ->where_in('id_sales_order', $array_selected_id)
                        ->update('sales_order', [
                            'active' => 0
                        ]);
//                    $this->db
//                        ->where_in('id_sales_order', $array_selected_id)
//                        ->update('delivery_order', [
//                            'id_sales_order' => $id_sales_order
//                        ]);
                    redirect('join/checkout/' . $id_sales_order);
                }
                $this->session->set_flashdata('error', "transaction error");
//            }
        }
        $this->listing();
    }


    public function checkout($id)
    {

        if (!$master = $this->model_join->getDataSO($id)
        ) {
            redirect('join');
        }
        $data['master'] = $master;
        $data['items'] = $this->model_join->getDataSODetail($id);
        $this->parser->parse("join_checkout.tpl", $data);
    }
}
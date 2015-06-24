<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 12/05/2015
 * Time: 14:29
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryOrder extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('delivery_order');
        $this->id_staff = $this->session->userdata('uid');

        $this->load->library('cart',
            array(
                'cache_path' => 'DELIVERY_ORDER',
                'cache_file' => $this->id_staff,
                'primary_table' => 'delivery_order',
                'foreign_table' => 'delivery_order_detail'
            ));

        $this->load->model('ModelDeliveryOrder', 'model_do');
        $this->load->model('sales_order/ModelSalesOrder', 'model_so');
        $this->cache = $this->cart->array_cache();
        $this->proposal_type = [0 => "pengadaan", 1 => "tender"];
        $this->status_ppn = [0 => "non aktif", 1 => "aktif"];
    }

    public function index($id)
    {
        if (!$this->cart->primary_data_exists()) {
            $detail = $this->model_do->getDataSODetail($id);
            $data_primary = [
                'id_staff' => $this->id_staff,
                'id_sales_order' => $id
            ];
            $this->cart->primary_data($data_primary);
            foreach ($detail as $key) {
                $this->cart->add_item($key['id_sales_order_detail'], $key);
            }
        }
        redirect('delivery-order/list');
    }

    public function listing()
    {
        if ($this->cart->primary_data_exists()) {
            redirect('delivery-order/list');
        }
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $data['array_proposal_type'] = $this->proposal_type;
        $data['array_status_ppn'] = $this->status_ppn;
        $data['items'] = $this->model_do->getListSO();

        $this->parser->parse("so_list.tpl", $data);
    }

    public function detail()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('delivery-order');
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $data['master'] = $this->model_so->getDataSO($this->cache['value']['id_sales_order']);

        $data['cache'] = $this->cache;
        $data['items'] = $this->cache['detail']['value'];
        $this->parser->parse("delivery_order.tpl", $data);
    }

    public function reset()
    {
        $this->cart->delete_record();
        redirect('delivery-order');
    }

    public function deleteDetail($id_sales_order)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('delivery-order');
            return false;
        }
        if (!$this->cart->delete_item($id_sales_order))
            $this->session->set_flashdata('error', $this->cart->getError());
        redirect('delivery-order/list');
    }

    public function updateItem($id_sales_order, $qty)
    {
        $available = $this->cache['detail']['value'][$id_sales_order]['qty']
            - $this->cache['detail']['value'][$id_sales_order]['delivered'];
        if($qty <= $available){
            $this->cart->field_updateable(['qty_delivered']);
            if (!$this->cart->update_item($id_sales_order, ['qty_delivered' => $qty]))
                $this->session->set_flashdata('error', $this->cart->getError());
        }else{
            $this->session->set_flashdata('error', 'Qty tidak cocok');
        }
        redirect('delivery-order/list');
    }


    public function save()
    {
        if ($this->input->post()) {
            if ($this->form_validation->run('delivery_order/save') == TRUE) {

                $id_sales_order = $this->cache['value']['id_sales_order'];
                if ($id_delivery_order = $this->cart->primary_data(array(
                    'date_sending' => $this->input->post('date_sending')
                ))->save()
                ) {
                    redirect('delivery-order/checkout/' . $id_delivery_order . '/'
                        . $id_sales_order);
                }
//                $this->db->trans_start();
//                $this->db->insert('delivery_order', [
//                    'id_staff' => $this->cache['value']['id_staff'],
//                    'date_sending' => $this->input->post('date_sending')
//                ]);
//                $id_delivery_order = $this->db->insert_id();
//                foreach ($this->cache['detail']['value'] as $key => $value) {
//                    $this->db
//                        ->where('id_sales_order_detail', $key)
//                        ->update('sales_order_detail', ['id_delivery_order' => $id_delivery_order]);
//                }
//                $this->db->trans_complete();
//
//                if ($this->db->trans_status() != FALSE) {
//                    $this->db->trans_commit();
//                    $this->cart->delete_record();
//                    redirect('delivery-order/checkout/' . $id_delivery_order . '/' . $this->cache['value']['id_sales_order']);
//                    return false;
//                }
//
//                $this->db->trans_rollback();
//                $this->error['db'][] = 'error db transaction';
            }
        }
        $this->detail();
    }


    public function checkout($id_delivery_order, $id_sales_order)
    {

        if (!$master = $this->model_so->getDataSO($id_sales_order)
        ) {
            redirect('delivery-order');
        }
        $data['do'] = $this->model_do->getDataDO($id_delivery_order);
        $data['master'] = $master;
        $data['status_ppn'] = $this->status_ppn[$master->status_ppn];
        $data['items'] = $this->model_do->getDataDODetail($id_delivery_order);
        $this->parser->parse("delivery_order_checkout.tpl", $data);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Lin
 * Date: 6/5/2015
 * Time: 12:02 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Extract extends MX_Controller
{
    protected $id_staff;

    protected $id_new_so;

    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('extract');
        $this->id_staff = $this->session->userdata('uid');

        $this->load->library('cart',
            array(
                'cache_path' => 'EXTRACT',
                'cache_file' => $this->id_staff,
                'primary_table' => 'sales_order',
                'foreign_table' => 'sales_order_detail'
            ));

        $this->load->model('join/ModelJoin', 'model_join');
        $this->load->model('ModelExtract', 'model_extract');
        $this->cache = $this->cart->array_cache();
    }


    public function index()
    {
        if ($this->cart->primary_data_exists()) {
            redirect('extract/do');
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
        $this->parser->parse("extract.tpl", $data);
    }

    public function select($id_so)
    {

        $detail = $this->model_join->getDataSODetail([$id_so]);
        $discount_price = $this->model_join->getDiscountPrice($id_so);
        $so = $this->model_join->getDataSO($id_so);
        $data_primary = [
            'id_customer' => $so->id_customer,
            'id_staff' => $this->id_staff,
            'old_so' => $id_so,
            'due_date' => $so->due_date,
            'id_proposal' => $so->id_proposal,
            'status_ppn' => $so->status_ppn, // set able
        ];
        $this->cart->primary_data($data_primary);
        foreach ($detail as $key) {
            $row = array_merge($key, ['reference' => $key['id_sales_order_detail']]);
            unset($row['id_sales_order_detail']);
            $this->cart->add_item($key['id_sales_order_detail'], $row);
        }
        redirect('extract/do');
    }

    public function listing()
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('extract');
        }
        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;

        $data['master'] = $this->db->get_where('customer', ['id_customer' => $this->cache['value']['id_customer']])->row();

        $data['cache'] = $this->cache;
        $data['items_first'] = $this->cache['detail']['value'];
        $data['items_second'] = $this->session->userdata('items_second');
        $this->parser->parse("extract_list.tpl", $data);
    }

    public function deleteDetail($id_sales_order)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('extract');
            return false;
        }
        $data = $this->session->userdata('items_second');
        $row_selected = $this->cache['detail']['value'][$id_sales_order];
        if (!$this->cart->delete_item($id_sales_order)) {
            $this->session->set_flashdata('error', $this->cart->getError());
        } else {
            $data[$id_sales_order] = $row_selected;
            $this->session->set_userdata(['items_second' => $data]);
        }
        redirect('extract/do');
    }

    public function undoDetail($id_sales_order)
    {
        if (!$this->cart->primary_data_exists()) {
            redirect('extract');
            return false;
        }
        $data = $this->session->userdata('items_second');
        if (!$this->cart->add_item($id_sales_order, $data[$id_sales_order])) {
            $this->session->set_flashdata('error', $this->cart->getError());
        } else {
            unset($data[$id_sales_order]);
            $this->session->set_userdata(['items_second' => $data]);
        }
        redirect('extract/do');
    }

    public function reset()
    {
        $this->cart->delete_record();
        $this->session->unset_userdata('items_second');
        redirect('extract');
    }

    public function save()
    {

        if (count($this->session->userdata('items_second')) > 0) {
            $data = $this->cache['value'];
            $record = $this->cache['detail']['value'];
            $id_old_so = $this->cache['value']['old_so'];

            $this->process($data, $record);
            $this->cart->delete_record();
            $this->process($data, $this->session->userdata('items_second'));
            $this->session->unset_userdata('items_second');

            $this->db
                ->where('id_sales_order', $id_old_so)
                ->update('sales_order', [
                    'active' => 0
                ]);

            redirect('extract/checkout/' . $this->id_new_so[0] .'/'.$this->id_new_so[1]);
            return false;

        }

        $this->listing();
    }

    private function process($primary, $data)
    {

        $total = 0;
        $ppn = 0;
        foreach ($data as $key => $value) {
            $this->cart->add_item($key, $value);
            $total = $total + ($value['qty'] * ($value['price'] - $value['discount']));
            $ppn = $ppn + (($value['qty'] * ($value['price'] - $value['discount'])) * 0.1);

            $data_foreign[] = [
                'id_product'=>$value['id_product'],
                'price'=>$value['price'],
                'qty'=>$value['qty'],
                'delivered'=>$value['delivered'],
                'discount'=>$value['discount'],
                'discount_price'=>$value['discount_price'],
                'sub_total'=>$value['sub_total'],
                'status'=>$value['status'],
                'reference'=>$value['reference'],
            ];
        }


        $this->db->trans_start();
        $this->db->insert('sales_order',[
            'id_customer' => $primary['id_customer'],
            'id_staff' =>$primary['id_staff'],
            'due_date' => $primary['due_date'],
            'id_proposal' => $primary['id_proposal'],
            'status_ppn' => $primary['status_ppn'],
            'total' => $total,
            'dpp' => $total,
            'ppn' => $ppn,
            'grand_total' => $total + $ppn
        ]);
        $reference_key = $this->db->insert_id();

        foreach($data_foreign as $key => $value){
            $data_foreign[$key]['id_sales_order'] = $reference_key;
        }

        $this->db->insert_batch('sales_order_detail', $data_foreign);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->error['db'][] = 'error db transaction';
            return false;
        } else {
            $this->db->trans_commit();
            $this->id_new_so[] = $reference_key;
        }
    }

    public function checkout($i,$a)
    {

        $data['master'] = $this->model_join->getDataSO($i);
        $data['master_second'] = $this->model_join->getDataSO($a);
        $data['items_first'] = $this->model_join->getDataSODetail($i);
        $data['items_second'] = $this->model_join->getDataSODetail($a);
        $this->parser->parse("extract_checkout.tpl", $data);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 16/04/2015
 * Time: 16:37
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends MX_Controller
{
    protected $id_staff;


    public function __construct()
    {
        parent::__construct();
        $this->acl->auth("purchase_order");
        $this->load->model('ModelPurchaseOrder','model_purchase_order');
    }

    public function index(){
        if ($this->input->post('id_purchase_order')) {
            if (
            $this->db
                ->where('id_purchase_order',$this->input->post('id_purchase_order'))
                ->get('purchase_order')->num_rows() > 0 ) {
                redirect('purchase-order/invoice/'.$this->input->post('id_purchase_order'));
            }
            $this->session->set_flashdata('message', array('class' => 'error', 'msg' => 'data tidak di temukan'));
        }
        $this->parser->parse("invoice-form.tpl");
    }
    public function summary($id_po){
        if(!$data_po = $this->db->get_where('purchase_order', array('id_purchase_order' => $id_po))->row()){
            redirect('purchase-order');
        }
        $data['po'] = $data_po;
        $data['principal'] = $this->db->get_where('principal', array('id_principal' => $data_po->id_principal))->row();
        $data['staff'] = $this->db->get_where('staff', array('id_staff' => $data_po->id_staff))->row();
        $data['pod'] = $this->model_purchase_order->getDataPOD($id_po);
        $this->parser->parse("invoice.tpl",$data);

    }
}
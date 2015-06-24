<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 20/04/2015
 * Time: 11:56
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class CardStock extends MX_Controller
{
    protected $id_staff;

    public function __construct()
    {
        parent::__construct();
        $this->id_staff = $this->config->item('id_staff');
    }

    public function index()
    {
        $data_po = $this->db->from('purchase_order')
            ->join('principal',
                'principal.id_principal = purchase_order.id_principal',
                'left')
            ->where('purchase_order.status_stocking', false)
            ->order_by('purchase_order.id_po ASC')
            ->get()
            ->result();

        $data['data_po'] = $data_po;
        $this->parser->parse("card_stock.tpl", $data);
    }

    public function detailCS($id_po)
    {
        $data['error'] = "";

        $this->load->model('purchase_order/ModPurchaseOrder', 'PO');
        $this->load->model('ModCardStock');
        if ($this->input->post()) {
            $i = 0;
            foreach ($this->input->post('id_po_detail') as $val) {
                $update_data[] = array(
                    'id_po_detail' => $val,
                    'qty_stock' => !empty($this->input->post('qty_stock')[$i])
                        ? $this->input->post('qty_stock')[$i] : 0,
                    'status' => $this->input->post('status')[$i] == 0
                        ? 1 : $this->input->post('status')[$i]
                );
                $i++;
            }
            if ($id_card_stock = $this->ModCardStock->stocking($id_po, $this->id_staff, $update_data)) {
                redirect('card-stock/checkout' . '/' . $id_card_stock);
                return false;
            }
            $data['error'] = "error database transaction";
        }
        $data_po = $this->db->select('*, principal.name as principal_name, staff.name as staff_name')
            ->from('purchase_order')
            ->join('principal',
                'principal.id_principal = purchase_order.id_principal',
                'left')
            ->join('staff',
                'staff.id_staff = purchase_order.id_staff',
                'left')
            ->where(array(
                'purchase_order.id_po' => $id_po,
                'purchase_order.status_stocking' => false
            ))
            ->get()
            ->row();
        if (!$data_po)
            redirect('card-stock');
        $data['po'] = $data_po;
        $data['po_detail'] = $this->PO->getDataPOD($id_po);
        $this->parser->parse("card_stock_detail.tpl", $data);
    }

    public function checkout($id_card_stock)
    {
        $this->load->model('purchase_order/ModPurchaseOrder', 'PO');
        $data_cs = $this->db->from('card_stock')
            ->join('staff',
                'staff.id_staff = card_stock.id_staff',
                'left')
            ->where(array(
                'card_stock.id_card_stock' => $id_card_stock,
            ))
            ->get()
            ->row();
        if (!$data_cs)
            redirect('card-stock');
        $data_po = $this->db->select('*, principal.name as principal_name, staff.name as staff_name')
            ->from('purchase_order')
            ->join('principal',
                'principal.id_principal = purchase_order.id_principal',
                'left')
            ->join('staff',
                'staff.id_staff = purchase_order.id_staff',
                'left')
            ->where(array(
                'purchase_order.id_po' => $data_cs->id_po,
            ))
            ->get()
            ->row();
        if (!$data_po)
            redirect('card-stock');
        $data['cs'] = $data_cs;
        $data['po'] = $data_po;
        $data['po_detail'] = $this->PO->getDataPOD($data_cs->id_po);

        $this->parser->parse("checkout.tpl", $data);


    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 21/04/2015
 * Time: 18:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Credit extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('credit');
        $this->id_staff = $this->session->userdata('uid');
    }

    public function index()
    {
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $this->db
            ->from('purchase_order po')
            ->join('principal p', 'p.id_principal = po.id_principal');
        if ($this->input->post()) {

            $this->db->where('date >=', $this->input->post('date') . '-01')
                ->where('date <', "DATE_ADD( '" . $this->input->post('date') . "-01', INTERVAL 1 MONTH)", false);

        }
        $po = $this->db
            ->where('po.status_paid', false)
            ->order_by('date_created  asc')
            ->get()
            ->result();
        $data['po'] = $po;

        $grand_total = $this->db->select_sum('grand_total')
            ->where(array('po.status_paid' => false))
            ->get('purchase_order po')
            ->row();

        $paid = $this->db->select_sum('paid')
            ->where(array('po.status_paid' => false))
            ->get('purchase_order po')
            ->row();

        $data['credit_total'] = $grand_total->grand_total - $paid->paid;

        $date_available = $this->db->select('MONTH(date) as month,YEAR(date) as year')
            ->where(array('po.status_paid' => false))
            ->group_by('month(date)')
            ->get('purchase_order po')
            ->result();

        $array_month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'Nopember', 'Desember'];

        $date = array('' => '');

        foreach ($date_available as $val) {
            $date[$val->year . '-' . str_pad($val->month, 2, "0", STR_PAD_LEFT)] = $array_month[$val->month - 1] . '-' . $val->year;
        }
        $data['date'] = $date;
        $this->parser->parse("credit.tpl", $data);
    }

    public function bill($id_purchase_order)
    {

        $data['error'] = $this->session->flashdata('error') != null ? $this->session->flashdata('error') : null;
        if ($this->input->post()) {
            if ($this->form_validation->run('credit')) {

                $scan = '';

                if (isset($_FILES['file']['size']) && ($_FILES['file']['size'] > 0)) {
                    $config['upload_path'] = './upload/credit';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '4048';
                    $config['max_width'] = '4024';
                    $config['max_height'] = '4668';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('file')) {
                        $this->session->set_flashdata('error',
                            $this->upload->display_errors(''));
                        redirect('credit/bill' . '/' . $id_purchase_order);
                    }
                    $file = $this->upload->data();
                    $scan = base_url() . "upload/credit/" . $file['file_name'];


                    $data_insert = array(
                        'id_staff' => $this->id_staff,
                        'id_purchase_order' => $id_purchase_order,
                        'payment_type' => $this->input->post('payment_type'),
                        'amount' => $this->input->post('amount'),
                        'resi_number' => $this->input->post('resi_number'),
                        'date_withdrawal' => $this->input->post('date_withdrawal') == "" ?
                            null : $this->input->post('date_withdrawal'),
                        'status' => $this->input->post('payment_type') == "bg" ? 0 : 1,
                        'file' => $scan
                    );

                    $this->db->insert('credit', $data_insert);
                    $this->session->set_flashdata('success', 'insert data berhasil');
                    redirect('credit');
                }
                $data['error'] = "masukkan bukti pembayaran";
            }
        }
        $po = $this->db->from('purchase_order po')
            ->join('principal p', 'p.id_principal = po.id_principal')
            ->where(array(
                'id_purchase_order' => $id_purchase_order
            ))
            ->get()
            ->row();

        $data['po'] = $po;
        $this->parser->parse("bill.tpl", $data);
    }

    public function update($id_credit)
    {
        $this->db
            ->where('id_credit',$id_credit)
            ->set('status',true)
            ->update('credit');
        $row = $this->db->get_where('credit',['id_credit'=>$id_credit])->row();
            redirect('credit/detail'.'/'.$row->id_purchase_order);
    }

    public function detailBayar($id_purchase_order)
    {
        $po = $this->db->from('purchase_order po')
            ->join('principal p', 'p.id_principal = po.id_principal')
            ->where(array(
                'id_purchase_order' => $id_purchase_order
            ))
            ->get()
            ->row();

        $data['po'] = $po;

        $credit = $this->db->from('credit')
            ->join('staff', 'staff.id_staff = credit.id_staff')
            ->where('id_purchase_order', $id_purchase_order)
            ->get()
            ->result();
        $data['credit'] = $credit;
        $this->parser->parse("detail.tpl", $data);

    }
}
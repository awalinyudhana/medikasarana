<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 21/04/2015
 * Time: 18:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Debit extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('debit');
        $this->id_staff = $this->session->userdata('uid');
    }

    public function index()
    {
        $data['success'] = $this->session->flashdata('success') != null ? $this->session->flashdata('success') : null;
        $this->db
            ->select('so.*, c.*')
            ->from('sales_order so')
            ->join('proposal p', 'p.id_proposal = so.id_proposal')
            ->join('customer c', 'c.id_customer = p.id_customer');
        if ($this->input->post()) {

            $this->db->where('so.date >=', $this->input->post('date') . '-01')
                ->where('so.date <', "DATE_ADD( '" . $this->input->post('date') . "-01', INTERVAL 1 MONTH)", false);

        }
        $po = $this->db
            ->where('so.status_paid', false)
            ->order_by('due_date  asc')
            ->get()
            ->result();
        $data['po'] = $po;

        $grand_total = $this->db->select_sum('grand_total')
            ->where(array('so.status_paid' => false))
            ->get('sales_order so')
            ->row();

        $paid = $this->db->select_sum('paid')
            ->where(array('so.status_paid' => false))
            ->get('sales_order so')
            ->row();

        $data['debit_total'] = $grand_total->grand_total - $paid->paid;

        $date_available = $this->db->select('MONTH(date) as month,YEAR(date) as year')
            ->where(array('so.status_paid' => false))
            ->group_by('month(date)')
            ->get('sales_order so')
            ->result();

        $array_month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'Nopember', 'Desember'];

        $date = array('' => '');

        foreach ($date_available as $val) {
            $date[$val->year . '-' . str_pad($val->month, 2, "0", STR_PAD_LEFT)] = $array_month[$val->month - 1] . '-' . $val->year;
        }
        $data['date'] = $date;
        $this->parser->parse("debit.tpl", $data);
    }

    public function bill($id_sales_order)
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
                        redirect('bill' . '/' . $id_sales_order);
                    }
                    $file = $this->upload->data();
                    $scan = base_url() . "/upload/credit" . $file['file_name'];


                }
                $data_insert = array(
                    'id_staff' => $this->id_staff,
                    'id_sales_order' => $id_sales_order,
                    'payment_type' => $this->input->post('payment_type'),
                    'amount' => $this->input->post('amount'),
                    'resi_number' => $this->input->post('resi_number'),
//                    'status' => $this->input->post('payment_type') == "bg" ? 0 : 1,
                    'file' => $scan
                );

                $this->db->insert('debit', $data_insert);

//                $this->db
//                    ->where('id_sales_order' , $id_sales_order)
//                    ->set('status_extract',0)
//                    ->update('sales_order');
                $this->session->set_flashdata('success', 'insert data berhasil');
                redirect('debit');
            }
        }
        $so = $this->db
            ->select('so.*, c.*')
            ->from('sales_order so')
            ->join('proposal p', 'p.id_proposal = so.id_proposal')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where(array(
                'id_sales_order' => $id_sales_order
            ))
            ->get()
            ->row();

        $data['so'] = $so;
        $this->parser->parse("bill.tpl", $data);
    }

    public function detailBayar($id_sales_order)
    {
        $so = $this->db
            ->select('so.*, c.*')
            ->from('sales_order so')
            ->join('proposal p', 'p.id_proposal = so.id_proposal')
            ->join('customer c', 'c.id_customer = p.id_customer')
            ->where(array(
                'id_sales_order' => $id_sales_order
            ))
            ->get()
            ->row();

        $data['so'] = $so;

        $debit = $this->db->from('debit')
            ->join('staff', 'staff.id_staff = debit.id_staff')
            ->where('id_sales_order', $id_sales_order)
            ->get()
            ->result();
        $data['debit'] = $debit;
        $this->parser->parse("detail.tpl", $data);

    }
}
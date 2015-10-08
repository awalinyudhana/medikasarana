<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->acl->auth('sales_order');
        $this->load->model('ModPenjualan');
        $this->proposal_type = [0 => "penjualan-pengadaan", 1 => "penjualan-tender"];
        $this->status_ppn = [0 => "Non Aktif", 1 => "Aktif"];
    }

    public function index($type = 0, $title = '')
    {
        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $data['penjualan'] = $this->ModPenjualan->getPenjualan($type, $this->input->post('date_from'), $this->input->post('date_to'));
            $data['from'] = $this->input->post('date_from');
            $data['to'] = $this->input->post('date_to');
        } else {
            $data['penjualan'] = $this->ModPenjualan->getPenjualan($type);
        }
        
        $data['total_penjualan'] = $this->ModPenjualan->getTotalPenjualan($type);

        $data['title'] = $title;
        $data['type'] = $type;
        $data['array_type'] = $this->proposal_type;
        $this->parser->parse('penjualan.tpl', $data);
    }

    public function pengadaan()
    {
        $this->index(0, 'Penjualan Pengadaan Langsung');
    }

    public function tender()
    {
        $this->index(1, 'Penjualan Tender');
    }

    public function detail($id_sales_order = null)
    {
        if (empty($id_sales_order) || !$this->ModPenjualan->checkSalesOrder($id_sales_order)) {
            redirect('report/penjualan/index', 'refresh');
        }
        $data['penjualan'] = $this->ModPenjualan->getDetailPenjualan($id_sales_order);
        $data['id_sales_order'] = $id_sales_order;
        $data['customer_name'] = $this->ModPenjualan->getCustomerName($id_sales_order);
        $this->parser->parse('detail-penjualan.tpl', $data);
    }

    public function graph()
    {
        $this->load->model('ModPenjualanRetail');

        $array_month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'Nopember', 'Desember'];

        if ($this->input->post('date_from') && $this->input->post('date_to')) {
            $from = substr($this->input->post('date_from'),0,7);
            $to = substr($this->input->post('date_to'),0,7);

            $data['from'] = $array_month[substr($from, -2) - 1] . ' ' . substr($from, 0, 4);
            $data['to'] = $array_month[substr($to, -2) - 1] . ' ' . substr($to, 0, 4);
            $data['form_from'] = $from;
            $data['form_to'] = $to;
            $sql_from = date('Y-m-01', strtotime($from));
            $sql_to = date('Y-m-t', strtotime($to));
            $data_penjualan_tender = $this->ModPenjualan->getPenjualanGraph(1, $sql_from, $sql_to);
            $data_penjualan_pl = $this->ModPenjualan->getPenjualanGraph(0, $sql_from, $sql_to);
            $data_penjualan_retail = $this->ModPenjualanRetail->getPenjualanGraph($sql_from, $sql_to);

            $date_period = $this->datePeriod($from, $to);
            $count_date_period = count($date_period);

            $date_string = '';
            foreach ($date_period as $key => $value) {
                $date_string .= "'" . $array_month[substr($value, -2) - 1] . ' ' . substr($value, 0, 4) . "',";
            }
            $data['daftar_bulan'] = "[" . substr($date_string, 0 , -1) . "]";

            // $groups[] = array();

            $penjualan_tender_string = '';
            if ($data_penjualan_tender) {
                foreach ($data_penjualan_tender as $v) {
                    $penjualan_tender[] = $v->grand_total;
                    $tender_date_arr[] = $v->yyyy_mm;

                    // Return Total Penjualan
                    $groups[$v->yyyy_mm]['bulan'] = $array_month[substr($v->yyyy_mm, 5, 2) - 1] . ' ' . substr($v->yyyy_mm, 0, 4);
                    $groups[$v->yyyy_mm]['total_tender'] = $v->grand_total;
                }

                foreach ($date_period as $key => $value) {
                    $inserted = array(0);
                    if (!in_array($value, $tender_date_arr)) {
                        array_splice($penjualan_tender, $key, 0, $inserted);
                    }
                }

                foreach ($penjualan_tender as $key => $value) {
                    $penjualan_tender_string .= $value . ',';
                }
            } else {
                for ($i=0; $i < $count_date_period; $i++) { 
                    $penjualan_tender_string .= 0 . ',';
                }
            }
            $data['penjualan_tender'] = "[" . substr($penjualan_tender_string, 0 , -1) . "]";

            $penjualan_pl_string = '';
            if ($data_penjualan_pl) {
                foreach ($data_penjualan_pl as $v) {
                    $penjualan_pl[] = $v->grand_total;
                    $pl_date_arr[] = $v->yyyy_mm;

                    $groups[$v->yyyy_mm]['bulan'] = $array_month[substr($v->yyyy_mm, 5, 2) - 1] . ' ' . substr($v->yyyy_mm, 0, 4);
                    $groups[$v->yyyy_mm]['total_pl'] = $v->grand_total;
                }

                foreach ($date_period as $key => $value) {
                    $inserted = array(0);
                    if (!in_array($value, $pl_date_arr)) {
                        array_splice($penjualan_pl, $key, 0, $inserted);
                    }
                }

                foreach ($penjualan_pl as $key => $value) {
                    $penjualan_pl_string .= $value . ',';
                }  
            } else {
                for ($i=0; $i < $count_date_period; $i++) { 
                    $penjualan_pl_string .= 0 . ',';
                }
            }
            $data['penjualan_pl'] = "[" . substr($penjualan_pl_string, 0 , -1) . "]";

            $penjualan_retail_string = '';
            if ($data_penjualan_retail) {
                foreach ($data_penjualan_retail as $v) {
                    $penjualan_retail[] = $v->grand_total;
                    $retail_date_arr[] = $v->yyyy_mm;

                    $groups[$v->yyyy_mm]['bulan'] = $array_month[substr($v->yyyy_mm, 5, 2) - 1] . ' ' . substr($v->yyyy_mm, 0, 4);
                    $groups[$v->yyyy_mm]['total_retail'] = $v->grand_total;
                }

                foreach ($date_period as $key => $value) {
                    $inserted = array(0);
                    if (!in_array($value, $retail_date_arr)) {
                        array_splice($penjualan_retail, $key, 0, $inserted);
                    }
                }

                foreach ($penjualan_retail as $key => $value) {
                    $penjualan_retail_string .= $value . ',';
                }
            } else {
                for ($i=0; $i < $count_date_period; $i++) { 
                    $penjualan_retail_string .= 0 . ',';
                }
            }
            $data['penjualan_retail'] = "[" . substr($penjualan_retail_string, 0 , -1) . "]";

            if (isset($groups)) {
                foreach( $groups as $m_id=>$arr ) {
                    $data_total_penjualan[] = (object) $arr;
                }
            } else {
                $data_total_penjualan[] = (object) array(
                                'bulan' => $array_month[substr($from, 5, 2) - 1] . ' ' . substr($from, 0, 4),
                                'total_retail' => 0,
                                'total_pl' => 0,
                                'total_tender' => 0
                            );
            }

        } else {
            $from = date('Y-m-01');
            $to = date('Y-m-t');
            /*$from = date('2015-09-01');
            $to = date('2015-09-31');*/
            $data['from'] = $from;
            $data['to'] = $to;
            $data['form_from'] = $from;
            $data['form_to'] = $to;
            $total_retail = $this->ModPenjualanRetail->getPenjualanGraph($from, $to, 1);
            $total_pl = $this->ModPenjualan->getPenjualanGraph(0, $from, $to, 1);
            $total_tender = $this->ModPenjualan->getPenjualanGraph(1, $from, $to, 1);
            $data['penjualan_tender'] = "[" . $total_tender . "]";
            $data['penjualan_pl'] = "[" . $total_pl . "]";
            $data['penjualan_retail'] = "[" . $total_retail . "]";
            $data['daftar_bulan'] = "['" . $array_month[substr($from, 5, 2) - 1] . ' ' . substr($from, 0, 4) . "']";

            $data_total_penjualan[] = (object) array(
                                'bulan' => $array_month[substr($from, 5, 2) - 1] . ' ' . substr($from, 0, 4),
                                'total_retail' => $total_retail,
                                'total_pl' => $total_pl,
                                'total_tender' => $total_tender 
                            );
        }

        $data['total_penjualan'] = $data_total_penjualan;
        // var_dump($data_total_penjualan);
        $this->parser->parse('graph-penjualan.tpl', $data);
    }

    private function datePeriod($min_date, $max_date)
    {
        $min_date = date_create($min_date . '-01');
        $max_date = date_create($max_date . '-31');
        $i = new DateInterval('P1M');
        $period=new DatePeriod($min_date,$i,$max_date);

        foreach ($period as $d){
          $month[] = $d->format('Y-m');
        }
        
        return $month;
    }
}
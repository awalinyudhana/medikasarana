<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->acl->auth('dashboard');
        $this->load->library('grocery_CRUD');
        $this->load->model('ModDashboard');
        $this->curDate = date('Y-m-d');
    }

    public function render($output)
    {
 		$this->parser->parse('index.tpl',$output);
    }

    public function index()
    {
        if ($this->input->post('penjualan_period')) {
            $retailData = $this->ModDashboard->getRetailData($this->input->post('penjualan_period'));
        } else {
            $retailData = $this->ModDashboard->getRetailData();
        }

        $data['minimumStock'] = $this->ModDashboard->getMinimumStock();
        $data['expiredProducts'] = $this->ModDashboard->getExpiredProducts();
        $dataCredit = $this->ModDashboard->getCreditData();
        $data['creditCount'] = $dataCredit['count'];
        $data['creditSum'] = $dataCredit['sum'];
        $data['debitSum'] = $this->ModDashboard->getDebitSum();
        $pemb[0] = array("January", 100);
        $pemb[1] = array("February", 300);
        $pemb[2] = array("March", 200);
        $data['dataPenjualan'] = json_encode($pemb);

        $dataPenjualan = $this->ModDashboard->getDataPenjualan();
        if ($dataPenjualan) {
            foreach ($dataPenjualan as $row) {
                $date = strtotime($row['date']) * 1000;
                $total = $row['grand_total'];
                $seriesPenjualan[] = "[$date, $total]";
            }
            $data['grafikPenjualan'] = "[".join($seriesPenjualan, ',')."]";
        } else {
            $data['grafikPenjualan'] = "[[0,0]]";
        }

        $dataPembelian = $this->ModDashboard->getDataPembelian();
        if ($dataPembelian) {
            foreach ($dataPembelian as $row) {
                $date = strtotime($row['date_created']) * 1000;
                $total = $row['grand_total'];
                $seriesPembelian[] = "[$date, $total]";
            }
            $data['grafikPembelian'] = "[".join($seriesPembelian, ',')."]";
        } else {
            $data['grafikPembelian'] = "[[0,0]]";
        }

        $this->parser->parse('dashboard.tpl', $data);
    }

    public function minimumStock()
    {
        $crud = new grocery_CRUD();
        $where = "stock < minimum_stock";
        $crud->where($where)
            ->set_table('product')
            ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock', 'minimum_stock')
            ->display_as('id_product_category', 'Product Category')
            ->display_as('id_product_unit', 'Product Satuan')
            ->display_as('date_expired', 'Date Expired')
            ->display_as('license', 'AKL/AKD')
            ->display_as('minimum_stock', 'Minimum Stock')
            ->display_as('value', 'Nilai Satuan')
            ->callback_column('sell_price', array($this, 'currencyFormat'))
            ->set_relation('id_product_category', 'product_category', 'category')
            ->set_relation('id_product_unit', 'product_unit', '{unit} / {value}')
            ->unset_add()
            ->unset_read()
            ->unset_edit()
            ->unset_delete();

        $extra = 'Informasi Produk Yang Melebihi Batasan Minimum Stock';
        $output = $crud->render($extra);
        
        $this->render($output);
    }

    public function expiredProducts()
    {
        $crud = new grocery_CRUD();
        
        $where = "(SELECT DATEDIFF(product.`date_expired`, '$this->curDate') AS days) < 14 AND product.`date_expired` > '$this->curDate'";
        $crud->where($where)
                ->order_by('date_expired', 'asc')
                ->set_table('product')
                ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock', 'minimum_stock')
                ->display_as('id_product_category', 'Product Category')
                ->display_as('id_product_unit', 'Product Unit')
                ->display_as('date_expired', 'Date Expired')
                ->display_as('minimum_stock', 'Minimum Stock')
                ->callback_column('sell_price', array($this, 'currencyFormat'))
                ->set_relation('id_product_category', 'product_category', 'category')
                ->set_relation('id_product_unit', 'product_unit', 'unit')
                ->set_relation('parent', 'product', '{name}')
                ->unset_fields('weight', 'length', 'width', 'height', 'sell_price', 'stock')
                ->unset_add()
                ->unset_read()
                ->unset_edit()
                ->unset_delete();
        $extra = 'Informasi Produk Yang Akan Expired';
        $output = $crud->render($extra);
        
        $this->render($output);
    }

    // public function upcomingCredit()
    // {
    //     $crud = new grocery_CRUD();

    //     $where = "((SELECT DATEDIFF(purchase_order.`due_date`, '$this->curDate') AS days) < 14) AND (purchase_order.`due_date` > '$this->curDate') AND (purchase_order.`status_paid` = 0)";
    //     $crud->where($where)
    //             ->order_by('due_date', 'asc')
    //             ->set_table('purchase_order')
    //             ->columns('id_purchase_order', 'id_principal', 'date', 'due_date', 'grand_total', 'paid', 'credit')
    //             ->display_as('id_purchase_order', 'No Faktur')
    //             ->display_as('name', 'Nama Principal')
    //             ->display_as('date', 'Tanggal Transaksi')
    //             ->display_as('due_date', 'Jatuh Tempo')
    //             ->display_as('grand_total', 'Tagihan')
    //             ->display_as('paid', 'Terbayar')
    //             ->display_as('credit', 'Hutang')
    //             ->callback_column('credit', array($this, 'getBalance'))
    //             ->callback_column('grand_total', array($this, 'currencyFormat'))
    //             ->callback_column('paid', array($this, 'currencyFormat'))
    //             ->set_relation('id_principal', 'principal', 'name')
    //             ->unset_add()
    //             ->unset_read()
    //             ->unset_edit()
    //             ->unset_delete();
    //     $extra = 'Informasi Tagihan Hutang';
    //     $output = $crud->render($extra);
        
    //     $this->render($output);
    // }

    // public function debitAlert()
    // {
    //     $crud = new grocery_CRUD();

    //     $where = "((SELECT DATEDIFF(sales_order.`due_date`, '$this->curDate') AS days) < 14) AND (sales_order.`due_date` > '$this->curDate') AND (sales_order.`status_paid` = 0)";
    //     $crud->where($where)
    //             ->order_by('due_date', 'asc')
    //             ->set_table('sales_order')
    //             ->columns('id_sales_order', 'id_customer', 'date', 'due_date', 'grand_total', 'paid', 'debit')
    //             ->display_as('id_sales_order', 'No Faktur')
    //             ->display_as('name', 'Nama Pelanggan')
    //             ->display_as('date', 'Tanggal Transaksi')
    //             ->display_as('due_date', 'Jatuh Tempo')
    //             ->display_as('grand_total', 'Tagihan')
    //             ->display_as('paid', 'Terbayar')
    //             ->display_as('debit', 'Piutang')
    //             ->callback_column('debit', array($this, 'getBalance'))
    //             ->callback_column('grand_total', array($this, 'currencyFormat'))
    //             ->callback_column('paid', array($this, 'currencyFormat'))
    //             ->set_relation('id_customer', 'customer', 'name')
    //             ->unset_add()
    //             ->unset_read()
    //             ->unset_edit()
    //             ->unset_delete();
    //     $extra = 'Informasi Tagihan Piutang';
    //     $output = $crud->render($extra);
        
    //     $this->render($output);
    // }

    // public function currencyFormat($value, $row)
    // {
    //     return "Rp " . number_format($value);
    // }

    // public function getBalance($value, $row)
    // {
    //     $grand_total = (float) str_replace(',', '', substr($row->grand_total, 3, strlen($row->grand_total)));
    //     $paid = (float) str_replace(',', '', substr($row->paid, 3, strlen($row->paid)));
    //     return "Rp " . number_format($grand_total - $paid);
    // }

    public function buying(){
        $dataPembelian = $this->ModDashboard->getDataPembelian();
        if ($dataPembelian) {
            foreach ($dataPembelian as $row) {
                $date = strtotime($row['date_created']) * 1000;
                $total = $row['grand_total'];
                $seriesPembelian[] = "[$date, $total]";
            }
            $data['grafikPembelian'] = "[".join($seriesPembelian, ',')."]";
        } else {
            $data['grafikPembelian'] = "[[0,0]]";
        }

        $this->parser->parse('buying.tpl', $data);
    }

    public function selling()
    {
        $dataPenjualan = $this->ModDashboard->getDataPenjualan();
        if ($dataPenjualan) {
            foreach ($dataPenjualan as $row) {
                $date = strtotime($row['date']) * 1000;
                $total = $row['grand_total'];
                $seriesPenjualan[] = "[$date, $total]";
            }
            $data['grafikPenjualan'] = "[".join($seriesPenjualan, ',')."]";
        } else {
            $data['grafikPenjualan'] = "[[0,0]]";
        }

        $this->parser->parse('selling.tpl', $data);
    }

    public function credit()
    {
        $data['items'] = $this->ModDashboard->upcomingCredit();
        $this->parser->parse("credit.tpl", $data);
    }

    public function debit()
    {
        $data['items'] = $this->ModDashboard->upcomingDebit();
        $this->parser->parse("debit.tpl", $data);
    }
} 
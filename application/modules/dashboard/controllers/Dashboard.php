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
        $data['minimumStockStore'] = $this->ModDashboard->getMinimumStockStore();
        $data['expiredProducts'] = $this->ModDashboard->getExpiredProducts();
        $data['expiredProductsStore'] = $this->ModDashboard->getExpiredProductsStore();
        $dataCredit = $this->ModDashboard->getCreditData();
        $dataCreditBG = $this->ModDashboard->getCreditBGData();
        $dataDebit = $this->ModDashboard->getDebitData();
        $dataDebitBG = $this->ModDashboard->getDebitBGData();


        $data['creditCount'] = $dataCredit['count'];
        $data['creditSum'] = $dataCredit['sum'];
        $data['debitCount'] = $dataDebit['count'];
        $data['debitSum'] = $dataDebit['sum'];
        $data['creditBGCount'] = $dataCreditBG['count'];
        $data['creditBGSum'] = $dataCreditBG['sum'];
        $data['debitBGCount'] = $dataDebitBG['count'];
        $data['debitBGSum'] = $dataDebitBG['sum'];

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


        $dataPenjualanRetail = $this->ModDashboard->getDataPenjualanRetail();
        if ($dataPenjualanRetail) {
            foreach ($dataPenjualanRetail as $row) {
                $date = strtotime($row['date']) * 1000;
                $total = $row['grand_total'];
                $seriesPenjualanRetail[] = "[$date, $total]";
            }
            $data['grafikPenjualanRetail'] = "[".join($seriesPenjualanRetail, ',')."]";
        } else {
            $data['grafikPenjualanRetail'] = "[[0,0]]";
        }

        $data['roles'] = $this->session->userdata('roles');
        $this->parser->parse('dashboard.tpl', $data);
    }

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
    public function sellingRetail()
    {
        $dataPenjualan = $this->ModDashboard->getDataPenjualanRetail();
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

        $this->parser->parse('selling-retail.tpl', $data);
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

    public function creditBG()
    {
        $data['items'] = $this->ModDashboard->upcomingCreditBG();
        $this->parser->parse("credit-bg.tpl", $data);
    }
    public function debitBG()
    {
        $data['items'] = $this->ModDashboard->upcomingDebitBG();
        $this->parser->parse("debit-bg.tpl", $data);
    }

    public function minimumStock()
    {
        $crud = new grocery_CRUD();
        $where = "stock < minimum_stock";
        $crud->where($where)
            ->set_table('product')
            ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock', 'minimum_stock')
            ->display_as('id_product_category', 'Kategory Produk')
            ->display_as('id_product_unit', 'Produk Satuan')
            ->display_as('date_expired', 'Produk Kadaluarsa')
            ->display_as('license', 'AKL/AKD')
            ->display_as('minimum_stock', 'Stock Minimum')
            ->display_as('value', 'Nilai Satuan')
            ->callback_column('sell_price', array($this, 'currencyFormat'))
            ->set_relation('id_product_category', 'product_category', 'category')
            ->set_relation('id_product_unit', 'product_unit', '{unit} / {value}')
            ->unset_add()
            ->unset_read()
            ->unset_edit()
            ->unset_delete();

        $extra = 'Informasi Stok Produk yang Akan Habis';
        $output = $crud->render($extra);

        $this->render($output);
    }

    public function minimumStockStore()
    {
        $data['items'] = $this->ModDashboard->getMinimumStockStoreData();
        $this->parser->parse("store-stock.tpl", $data);
    }

    public function expiredProducts()
    {
        $crud = new grocery_CRUD();
        
        $where = "(SELECT DATEDIFF(product.`date_expired`, '$this->curDate') AS days) < 30";
        $crud->where($where)
                ->order_by('date_expired', 'asc')
                ->set_table('product')
                ->columns('barcode', 'name', 'id_product_category', 'id_product_unit', 'brand', 'sell_price', 'date_expired', 'size', 'license', 'stock', 'minimum_stock')
                ->display_as('id_product_category', 'Kategory Produk')
                ->display_as('id_product_unit', 'Produk Satuan')
                ->display_as('date_expired', 'Produk Kadaluarsa')
                ->display_as('minimum_stock', 'Stock Minimum')
                ->callback_column('sell_price', array($this, 'currencyFormat'))
                ->set_relation('id_product_category', 'product_category', 'category')
                ->set_relation('id_product_unit', 'product_unit', 'unit')
                ->set_relation('parent', 'product', '{name}')
                ->unset_fields('weight', 'length', 'width', 'height', 'sell_price', 'stock')
                ->unset_add()
                ->unset_read()
                ->unset_edit()
                ->unset_delete();
        $extra = 'Informasi Produk yang Akan Kadaluarsa';
        $output = $crud->render($extra);
        
        $this->render($output);
    }

    public function expiredProductsStore()
    {
        $data['items'] = $this->ModDashboard->getExpiredProductsStoreData();
        $this->parser->parse("store-ed.tpl", $data);
    }

    public function currencyFormat($value, $row)
    {
        return "Rp " . number_format($value);
    }

} 
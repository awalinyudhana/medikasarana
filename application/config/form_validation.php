<?php
/**
 * Created by PhpStorm.
 * User: Awalin Yudhana
 * Date: 17/04/2015
 * Time: 17:01
 */
$config = array(
    'po' => array(
        array(
            'field' => 'id_principal',
            'label' => 'Principal',
            'rules' => 'required'
        ),
        array(
            'field' => 'invoice_number',
            'label' => 'Invoice Number',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'date',
            'label' => 'Order Date',
            'rules' => 'required'
        )
    ),
    'po_detail' => array(
        array(
            'field' => 'id_product',
            'label' => 'Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY Number',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'discount_total',
            'label' => 'Discount',
            'rules' => 'numeric'
        ),
    ),
    'po_save' => array(
        array(
            'field' => 'total',
            'label' => 'Total',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'discount_price',
            'label' => 'Discount',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'dpp',
            'label' => 'DPP',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'ppn',
            'label' => 'PPN',
            'rules' => 'numeric'
        ),
        array(
            'field' => 'grand_total',
            'label' => 'Grand Total',
            'rules' => 'required|numeric'
        ),
    ),
    'cs' => array(
        array(
            'field' => 'id_po',
            'label' => 'Purchase Order Number',
            'rules' => 'required|integer'
        ),
    ),
    'conversion' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY',
            'rules' => 'required|integer'
        )
    ),
    'credit' => array(
        array(
            'field' => 'amount',
            'label' => 'Jumlah Bayar',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'payment_type',
            'label' => 'Payment Type',
            'rules' => 'trim|required'
        ),
    ),
    'distribution' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY',
            'rules' => 'required|integer'
        )
    ),
    'product-returns' => array(
        array(
            'field' => 'id_product_store',
            'label' => 'ID Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY',
            'rules' => 'required|integer'
        )
    ),
    'pricing' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'sell_price',
            'label' => 'Harga Jual',
            'rules' => 'required|integer'
        )
    ),
    'retail' => array(
        array(
            'field' => 'id_product_store',
            'label' => 'Product',
            'rules' => 'required|integer'
        ),
//        array(
//            'field' => 'qty',
//            'label' => 'QTY',
//            'rules' => 'integer'
//        ),
//        array(
//            'field' => 'discount',
//            'label' => 'Diskon',
//            'rules' => 'integer'
//        )
    ),
    'retail/save' => array(
        array(
            'field' => 'bayar',
            'label' => 'Jumlah Bayar',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'discount_price',
            'label' => 'Diskon',
            'rules' => 'integer'
        )
    ),
    'retail/replace/save' => array(
        array(
            'field' => 'cashback',
            'label' => 'Diskon',
            'rules' => 'integer'
        )
    ),
    'opname/save' => array(
        array(
            'field' => 'id_product',
            'label' => 'Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_system',
            'label' => 'Stok System',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_real',
            'label' => 'Stok Fisik',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'note',
            'label' => 'Keterangan',
            'rules' => 'required|trim'
        )
    ),
    'opname-store/save' => array(
        array(
            'field' => 'id_product_store',
            'label' => 'Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_system',
            'label' => 'Stok System',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_real',
            'label' => 'Stok Fisik',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'note',
            'label' => 'Keterangan',
            'rules' => 'required|trim'
        )
    ),
    'returns' => array(
        array(
            'field' => 'qty_return',
            'label' => 'Jumlah Retur',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah Retur',
            'rules' => 'integer'
        ),
        array(
            'field' => 'id_product_store',
            'label' => 'Produk ',
            'rules' => 'integer'
        ),
        array(
            'field' => 'cashback',
            'label' => 'Produk ',
            'rules' => 'integer'
        ),
        array(
            'field' => 'note',
            'label' => 'Keterangan',
            'rules' => 'required|trim'
        )
    ),
    'proposal' => array(
        array(
            'field' => 'id_customer',
            'label' => 'Customer',
            'rules' => 'required'
        ),
        array(
            'field' => 'type',
            'label' => 'Jenis Proposal',
            'rules' => 'required'
        ),
        array(
            'field' => 'status_ppn',
            'label' => 'PPn Status',
            'rules' => 'required'
        )
    ),
    'proposal/detail' => array(
        array(
            'field' => 'id_product',
            'label' => 'Product',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY Number',
            'rules' => 'integer'
        ),
        array(
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'discount',
            'label' => 'Discount',
            'rules' => 'numeric'
        ),
    ),
    'sales_order/save' => array(
        array(
            'field' => 'due_date',
            'label' => 'Tanggal Jatuh Tempo',
            'rules' => 'required'
        )
    ),
    'delivery_order/save' => array(
        array(
            'field' => 'date_sending',
            'label' => 'Tanggal Pengiriman',
            'rules' => 'required'
        )
    ),
    'users/edit-group' => array(
        array(
            'field' => 'name_group',
            'label' => 'Nama Group',
            'rules' => 'required'
        )
    )

);
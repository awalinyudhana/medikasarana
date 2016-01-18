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
            'label' => 'Prinsipal',
            'rules' => 'required'
        ),
        array(
            'field' => 'invoice_number',
            'label' => 'No Invoice',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'date',
            'label' => 'Tanggal pembelian',
            'rules' => 'required'
        ),
        array(
            'field' => 'status_ppn',
            'label' => 'PPn status',
            'rules' => 'required'
        )
    ),
    'po_detail' => array(
        array(
            'field' => 'id_product',
            'label' => 'Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah',
            'rules' => 'required|is_natural_no_zero'
        ),
        array(
            'field' => 'price',
            'label' => 'Harga',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'discount_total',
            'label' => 'Diskon',
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
            'label' => 'Diskon',
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
            'label' => 'Grand total',
            'rules' => 'required|numeric'
        ),
    ),
    'cs' => array(
        array(
            'field' => 'id_po',
            'label' => 'No faktur pembelian',
            'rules' => 'required|integer'
        ),
    ),
    'conversion' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah',
            'rules' => 'required|is_natural_no_zero'
        )
    ),
    'credit' => array(
        array(
            'field' => 'amount',
            'label' => 'Jumlah bayar',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'payment_type',
            'label' => 'Jenis Pembayaran',
            'rules' => 'trim|required'
        ),
    ),
    'debit' => array(
        array(
            'field' => 'amount',
            'label' => 'Jumlah bayar',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'payment_type',
            'label' => 'Jenis Pembayaran',
            'rules' => 'trim|required'
        ),
    ),
    'distribution' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'QTY',
            'rules' => 'required|is_natural_no_zero'
        )
    ),
    'product-returns' => array(
        array(
            'field' => 'id_product_store',
            'label' => 'ID Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah',
            'rules' => 'required|is_natural_no_zero'
        )
    ),
    'pricing' => array(
        array(
            'field' => 'id_product',
            'label' => 'ID Produk',
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
            'label' => 'Produk',
            'rules' => 'required|integer'
        )
    ),
    'retail/save' => array(
        array(
            'field' => 'bayar',
            'label' => 'Jumlah bayar',
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
            'label' => 'Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_system',
            'label' => 'Stok tersedia',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_real',
            'label' => 'Stok fisik',
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
            'label' => 'Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_system',
            'label' => 'Stok tersedia',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'stock_real',
            'label' => 'Stok fisik',
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
            'label' => 'Jumlah retur',
            'rules' => 'required|is_natural_no_zero'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah retur',
            'rules' => 'integer|is_natural_no_zero'
        ),
        array(
            'field' => 'id_product_store',
            'label' => 'Produk',
            'rules' => 'integer'
        ),
        array(
            'field' => 'cashback',
            'label' => 'Produk',
            'rules' => 'integer'
        ),
        array(
            'field' => 'reason',
            'label' => 'Keterangan',
            'rules' => 'required|trim'
        )
    ),
    'proposal' => array(
        array(
            'field' => 'id_customer',
            'label' => 'Konsumen',
            'rules' => 'required'
        ),
        array(
            'field' => 'type',
            'label' => 'Jenis proposal',
            'rules' => 'required'
        ),
        array(
            'field' => 'status_ppn',
            'label' => 'PPn status',
            'rules' => 'required'
        )
    ),
    'proposal/detail' => array(
        array(
            'field' => 'id_product',
            'label' => 'Produk',
            'rules' => 'required|integer'
        ),
        array(
            'field' => 'qty',
            'label' => 'Jumlah',
            'rules' => 'is_natural_no_zero'
        ),
        array(
            'field' => 'price',
            'label' => 'Harga',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'discount',
            'label' => 'Diskon',
            'rules' => 'numeric'
        ),
    ),
    'sales_order/save' => array(
        array(
            'field' => 'due_date',
            'label' => 'Tanggal jatuh tmpo',
            'rules' => 'required'
        )
    ),
    'delivery_order/save' => array(
        array(
            'field' => 'date_sending',
            'label' => 'Tanggal pengiriman',
            'rules' => 'required'
        )
    ),
    'users/edit-group' => array(
        array(
            'field' => 'name_group',
            'label' => 'Nama group',
            'rules' => 'required'
        )
    ),
    'users/update-profile' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'old_password',
            'label' => 'Password Lama',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password baru',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password_confirmation',
            'label' => 'Password Confirmation',
            'rules' => 'trim|required|matches[password]'
        )
    )

);
{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Produk</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-clipboard"></i>Laporan Pembelian Barang {$principal->name} <small class="display-block">*Harga pembelian sesuai dengan harga pembelian terakhir</small>
                    </h6>
                </div>
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <!-- <th>Prinsipal</th> -->
                                <th>Nama Produk</th>
                                <!-- <th>Kategori</th> -->
		                        <th>Unit</th>
		                        <th>Nilai Satuan</th>
                                <th>Merek</th>
                                <th>Ukuran</th>
                                <th>AKL/AKD</th>
                                <th>Harga Beli</th>
		                        <th>Harga Jual</th>
                                <!-- <th>Riwayat Pembelian</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <!-- <td>{$key->principal_name}</td> -->
                                <td>{$key->product_name}</td>
                                <!-- <td>{$key->category}</td> -->
	                            <td>{$key->unit}</td>
	                            <td>{$key->value}</td>
                                <td>{$key->brand}</td>
                                <td>{$key->size}</td>
                                <td>{$key->license}</td>
                                <td class="text-right">Rp {$key->buy_price|number_format:0}</td>
                                <td class="text-right">Rp {$key->sell_price|number_format:0}</td>
                                <!-- <td>
                                    <div class="table-controls">
                                        <a href="{base_url('report/product-detail/')}/{$key->id_product}/{$key->id_principal}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Detail">
                                            <i class="icon-list"></i>
                                        </a>

                                    </div>
                                </td> -->
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-4 pull-right">
                        <div class="btn-group right-box">
                            <a href="{base_url('report/product')}"  class="btn block full-width btn-default">Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

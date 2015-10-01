{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Detail Penjualan</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> No Faktur #{$id_purchase_order}
                    </h6>
                </div>


<!-- 
            <div class="table-responsive pre-scrollable">
                <table class="table table-striped table-bordered">
 -->                    
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Merek</th>
                            <th>Satuan / Isi</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Discount</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $penjualan as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->barcode}</td>
                                <td>{$key->name}</td>
                                <td>{$key->brand}</td>
                                <td>{$key->unit} / {$key->value}</td>
                                <td>{$key->qty}</td>
                                <td class="text-right">Rp {$key->price|number_format:0}</td>
                                <td class="text-right">Rp {$key->discount_total|number_format:0}</td>
                                <td class="text-right">Rp {$key->sub_total|number_format:0}</td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+$key->sub_total}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Total Penjualan Retail:</th>
                                <td class="text-right"><h6>Rp {$total|number_format:0}</h6></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 pull-right">
                        <div class="btn-group right-box">
                            <a href="{base_url('report/pembelian')}"  class="btn block full-width btn-default">Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

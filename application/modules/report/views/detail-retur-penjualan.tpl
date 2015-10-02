{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Detail Laporan Retur Penjualan</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Detail Laporan Retur Penjualan <small class="display-block">No Retur #{$id_sales_order_return}</small>
                    </h6>
                </div>

                <div class="row">
                    <div class="col-md-4 col-md-offset-8" style="text-align: right;margin-bottom: 10px;">
                        <a class="btn btn-warning" download="detail-retur-penjualan-{$id_sales_order_return}.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatableexport', 'Detail Retur Penjualan {$id_sales_order_return}');">Export to Excel</a>
                    </div>
                </div>

                <div class="table-responsive" id="datatableexport">
                    <table class="table table-striped table-bordered">
                   <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / Isi</th>
                        <th>Jumlah</th>
                        <th>Kembali</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=no value=1}
                    {assign var=total_cashback value=0}
                    {foreach $items as $return }
                        {assign var=total_cashback value=$total_cashback+$return['cashback']}
                        <tr>
                            <td rowspan="2">{$no} </td>
                            <td>{$return['barcode']}</td>
                            <td>{$return['name']}</td>
                            <td>{$return['brand']}</td>
                            <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
                            <td>{$return['qty_return']}</td>
                            <td></td>
                            <td rowspan="2">{$return['reason']}</td>
                        </tr>

                        <tr>
                            {if $return['id_product_cache']}
                                <td>{$product_storage[$return['id_product_cache']]['barcode']}</td>
                                <td>{$product_storage[$return['id_product_cache']]['name']}</td>
                                <td>{$product_storage[$return['id_product_cache']]['brand']}</td>
                                <td>
                                    {$product_storage[$return['id_product_cache']]['unit']}
                                    ( {$product_storage[$return['id_product_cache']]['value']} )
                                    </td>
                                <td>{$return['qty']}</td>
                            {else}
                                <td colspan="5"></td>
                            {/if}
                            <td>Rp
                                {if $return['cashback']
}                                    {$return['cashback']|number_format:0}
                                {else}
                                    {0|number_format:0}
                                {/if}
                            </td>
                        </tr>
                        {assign var=no value=$no+1}
                    {/foreach}
                    </tbody>
                </table>
                </div>

                <div class="row invoice-payment">
                    <div class="col-sm-8">
                    </div>

                    <div class="col-sm-4">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right"><strong>Rp {$total_cashback|number_format:0}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 pull-right">
                        <div class="btn-group right-box">
                            <a href="#" onclick="javascript:window.history.back();"  class="btn block full-width btn-default">Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /default panel -->
{/block}
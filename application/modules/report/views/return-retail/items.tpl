{* Extend our master template *}
{extends file="../../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Retur Penjualan Retail</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i>Laporan Retur Penjualan Retail <small class="display-block">Periode {$from} - {$to}</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Tanggal Transaksi Retur :</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/retur-')}/{$array_type[$type]}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="row">
                    <div class="col-md-4 col-md-offset-8" style="text-align: right;margin-bottom: 10px;">
                        <a class="btn btn-warning" download="detail-retur-penjualan-retail-{$id_retail_return}.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatableexport', 'Detail Retur Penjualan Retail {$id_retail_return}');">Export to Excel</a>
                    </div>
                </div>

                <div class="table-responsive" id="datatableexport">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Faktur Retur</th>
                                <th>No Faktur Retail</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Customer</th>
                                <th>Nama Staff</th>
                            	<th></th>
                            	<th></th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key['id_retail_return']}</td>
                                <td>{$key['id_retail']}</td>
                                <td>{$key['date']}</td>
                                <td></td>
                                <td>{$key['name']}</td>
                            	<td></td>
                            	<td></td>
                            </tr>
                            <tr>
                            	<td rowspan="3"></td>
		                        <th>No</th>
		                        <th>Nama Produk</th>
		                        <th>Merek</th>
		                        <th>Satuan / Isi</th>
		                        <th>Jumlah</th>
		                        <th>Kembali</th>
		                        <th>Keterangan</th>
		                    </tr>
                            {assign var=val value=$val+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

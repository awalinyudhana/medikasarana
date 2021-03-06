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
                                <a href="{base_url('report/retur-penjualan-retail')}\" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="row">
                    <div class="col-md-4 col-md-offset-8" style="text-align: right;margin-bottom: 10px;">
                        <a class="btn btn-warning" download="laporan-retur-penjualan-retail-periode-{$from}-{$to}.xls" href="#" onclick="return ExcellentExport.excel(this, 'datatableexport', 'Laporan Retur Penjualan Retail Periode {$from} - {$to}');">Export to Excel</a>
                    </div>
                </div>

                <div class="table-responsive" id="datatableexport">
                    <table class="table">
                       <!--  <thead>
                            <tr>
                                <th>No</th>
                                <th></th>
                            </tr>
                        </thead> -->
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td >{$val}</td>
                                <td >Tanggal Transaksi : {$key['date']} </br>
                                No Faktur Retur : {$key['id_retail_return']}</br>
                                No Faktur Retail : {$key['id_retail']}</br>
                                Staff : {$key['name']}
                                </td>
                            </tr>
                            <tr>
                            	<td>&nbsp;</td>
                            	<td>
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
						                    {foreach $key['value'] as $return }
						                        <tr>
						                            <td rowspan="2">{$no} </td>
						                            <td>{$return['name']}</td>
						                            <td>{$return['barcode']}</td>
						                            <td>{$return['brand']}</td>
						                            <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
						                            <td>{$return['qty_return']}</td>
						                            <td></td>
						                            <td rowspan="2">{$return['reason']}</td>
						                        </tr>
						                        <tr>
						                            {if $return['id_product_cache']}
						                                <td>
						                                	{$product_storage[$return['id_product_cache']]['name']}
						                                </td>
						                                <td>
						                                	{$product_storage[$return['id_product_cache']]['barcode']}
						                                </td>
						                                <td>
						                                	{$product_storage[$return['id_product_cache']]['brand']}
					                                	</td>
						                                <td>
						                                    {$product_storage[$return['id_product_cache']]['unit']}
						                                    ( {$product_storage[$return['id_product_cache']]['value']} )
					                                    </td>
						                                <td>
						                                	{$return['qty']}
						                                </td>
						                            {else}
						                                <td colspan="5"></td>
						                            {/if}
						                            <td>Rp
						                                {if $return['cashback']}
															{$return['cashback']|number_format:0}
						                                {else}
						                                    {0|number_format:0}
						                                {/if}
						                            </td>
						                        </tr>
						                        {assign var=no value=$no+1}
						                    {/foreach}
			                            {assign var=val value=$val+1}
				                        </tbody>
	                    			</table>
                            	</td>
		                    </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

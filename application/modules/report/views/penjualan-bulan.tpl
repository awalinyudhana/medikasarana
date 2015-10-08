{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Penjualan</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Penjualan <small class="display-block">Laporan Penjualan</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Laporan Penjualan:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date-report form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date-report form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/penjualan/pengadaan/month')}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">Detail Rincian Penjualan Tiap Customer<br>Bulan {$from} - {$to}</h6>
                            </div>
                            <div class="panel-body">
                            <!-- <div class="panel-body" style="min-height:400px;"> -->
                                <!-- <div class="table-responsive" id="datatableexport">
                                    <table class="table table-striped table-bordered"> -->
                                <div class="datatable-tools">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Konsumen</th>
                                                {foreach $date_period as $period }
	                                                <th>{$period}</th>
	                                            {/foreach}
                                            </tr>
                                        </thead>
                                        <tbody>
					                        {assign var=val value=1}
					                        {foreach $items as $key }
				                            	<tr>
                                					<td>{$val}</td>
                                					<td>{$key['customer_name']}</td>

					                        			{foreach $key['data'] as $row }
                                							<td>{$row}</td>
                                            			{/foreach}
                                            	</tr>
                            					{assign var=val value=$val+1}
                                            {/foreach}
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-right">Grand Total</td>
                                                <td>Rp {$total|number_format:0}</td>
                                            </tr>
                                        </tfoot>> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /panel body -->

        </div><!-- /default panel -->

{/block}

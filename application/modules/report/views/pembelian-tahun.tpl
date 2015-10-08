{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pembelian </h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Pembelian Per Tahun <small class="display-block">Purchase Order</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Laporan Pembelian:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-year-report form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-year-report form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/pembelian/month')}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">Detail Rincian Pembelian Per Prinsipal<br>Tahun {$from} - {$to}</h6>
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
                                                <th>Nama Prinsipal</th>
                                                {foreach $date_period as $period }
	                                                <th>{$period}</th>
	                                            {/foreach}
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
               								{assign var=total value=0}
					                        {assign var=val value=1}
					                        {foreach $items as $key }
				                            	<tr>
                                					<td>{$val}</td>
                                					<td>{$key['principal_name']}</td>

                       								{assign var=sub_total value=0}
	                                                {foreach $date_period as $period }
                            							<td class="text-right">Rp {$key['data'][$period]|number_format:0}</td>
                            							{assign var=sub_total value=$sub_total+$key['data'][$period]}
		                                            {/foreach}
                        							<td class="text-right">Rp {$sub_total|number_format:0}</td>
                                            	</tr>
                            					{assign var=val value=$val+1}
                    							{assign var=total value=$total+$sub_total}
                                            {/foreach}
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="{(2+$count_date_period)}" class="text-right">Grand Total</td>
                                                <td class="text-right">Rp {$total|number_format:0}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /panel body -->

        </div><!-- /default panel -->

{/block}

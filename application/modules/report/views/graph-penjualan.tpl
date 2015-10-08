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
                                <input type="text" class="from-date-report form-control" name="date_from" placeholder="From" {if isset($from)}value="{$form_from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date-report form-control" name="date_to" placeholder="To" {if isset($to)}value="{$form_to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report')}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title"><i class="icon-calendar2"></i> Laporan Penjualan {$from} - {$to}</h6>
                            </div>
                            <div class="panel-body" style="min-height:400px;">
                                <div class="graph-standard" id="grafik_penjualan" style="height:100%; width:100%;"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(function () {
                            $('#grafik_penjualan').highcharts({

                                chart: {
                                    type: 'column'
                                },

                                title: {
                                    text: 'Laporan Penjualan<br>PT. Sarana Medika Sejahtera<br>{$from} - {$to}'
                                },

                                xAxis: {
                                    categories: {$daftar_bulan} //['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
                                },

                                yAxis: {
                                    allowDecimals: false,
                                    min: 0,
                                    title: {
                                        text: 'Jumlah (Rp)'
                                    }
                                },

                                series: [{
                                    name: 'Retail',
                                    data: {$penjualan_retail}//[5, 3, 4, 7, 2]
                                }, {
                                    name: 'PL',
                                    data: {$penjualan_pl}//[3, 4, 4, 2, 5]
                                }, {
                                    name: 'Tender',
                                    data: {$penjualan_tender}//[2, 5, 6, 2, 1]
                                }]
                            });
                        });
                    </script>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h6 class="panel-title">Detail Rincian Penjualan<br>Bulan {$from} - {$to}</h6>
                            </div>
                            <div class="panel-body" style="min-height:400px;">
                                <div class="table-responsive" id="datatableexport">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Bulan</th>
                                                <th>Retail</th>
                                                <th>Pengadaan Langsung</th>
                                                <th>Tender</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {assign var=total value=0}
                                            {foreach $total_penjualan as $row }
                                                {if isset($row->total_retail)}
                                                    {assign var=total_retail value=$row->total_retail}
                                                {else}
                                                    {assign var=total_retail value=0}
                                                {/if}
                                                {if isset($row->total_pl)}
                                                    {assign var=total_pl value=$row->total_pl}
                                                {else}
                                                    {assign var=total_pl value=0}
                                                {/if}
                                                {if isset($row->total_tender)}
                                                    {assign var=total_tender value=$row->total_tender}
                                                {else}
                                                    {assign var=total_tender value=0}
                                                {/if}
                                            <tr>
                                                <td>{$row->bulan}</td>
                                                <td>Rp {$total_retail|number_format:0}</td>
                                                <td>Rp {$total_pl|number_format:0}</td>
                                                <td>Rp {$total_tender|number_format:0}</td>
                                            </tr>
                                            {assign var=total value=$total+$total_retail+$total_pl+$total_tender}
                                            {/foreach}
                                            <tr>
                                                <td colspan="3" class="text-right">Grand Total</td>
                                                <td>Rp {$total|number_format:0}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /panel body -->

        </div><!-- /default panel -->

{/block}

{* Extend our master template *}
{extends file="../../../dashboard.tpl"}

{block name=content}
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard <small>Selamat Datang di Dashboard POS PT Sarana Medika Sejahtera</small></h3>
        </div>
    </div>

    <ul class="page-stats list-justified">
        <li class="{if $minimumStock == 0}bg-success{else}bg-danger{/if}">
            <a href="{base_url('dashboard/minimumStock')}">
                <div class="page-stats-showcase">
                    <span>Minimum Stock</span>
                    <h2>{$minimumStock}</h2>
                </div>
            </a>
        </li>
        <li class="{if $expiredProducts == 0}bg-success{else}bg-danger{/if}">
            <a href="{base_url('dashboard/expiredProducts')}">
                <div class="page-stats-showcase">
                    <span>Expired Products</span>
                    <h2>{$expiredProducts}</h2>
                </div>
            </a>
        </li>
        <li class="{if $creditCount == 0}bg-success{else}bg-danger{/if}">
            <a href="{base_url('dashboard/upcomingCredit')}">
                <div class="page-stats-showcase">
                    <span>Tagihan Hutang</span>
                    <h2>{$creditCount} | Rp {$creditSum|number_format:0}</h2>
                </div>
            </a>
        </li>
        <li class="{if $debitSum == 0}bg-success{else}bg-danger{/if}">
            <a href="{base_url('dashboard/debitAlert')}">
                <div class="page-stats-showcase">
                    <span>Tagihan Piutang</span>
                    <h2>Rp {$debitSum|number_format:0}</h2>
                </div>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Penjualan</h6>
                </div>
                <div class="panel-body" style="min-height:400px;">
                    <div class="graph-standard" id="grafik_penjualan"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Pembelian</h6>
                </div>
                <div class="panel-body" style="min-height:400px;">
                    <div class="graph-standard" id="grafik_pembelian"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var dataPenjualan = {$dataPenjualan};
        var dataPembelian = [ ["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9] ];
    </script>
    <script>
        $(function () {
            $('#grafik_penjualan').highcharts('StockChart', {
                rangeSelector : {
                    selected : 1,
                    buttons: [{
                        type: 'week',
                        count: 1,
                        text: '1w'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1m'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3m'
                    }, {
                        type: 'month',
                        count: 6,
                        text: '6m'
                    }, {
                        type: 'ytd',
                        text: 'YTD'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }, {
                        type: 'all',
                        text: 'All'
                    }]
                },

                title : {
                    text : 'Grafik Penjualan'
                },

                subtitle : {
                    text : 'PT Medika Sarana'
                },

                series : [{
                    name : 'Penjualan Rp.',
                    data : {$grafikPenjualan}
                    ,
                    tooltip: {
                        valueDecimals: 2
                    }
                }]
            });

            $('#grafik_pembelian').highcharts('StockChart', {
                rangeSelector : {
                    selected : 1,
                    buttons: [{
                        type: 'week',
                        count: 1,
                        text: '1w'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1m'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3m'
                    }, {
                        type: 'month',
                        count: 6,
                        text: '6m'
                    }, {
                        type: 'ytd',
                        text: 'YTD'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y'
                    }, {
                        type: 'all',
                        text: 'All'
                    }]
                },

                title : {
                    text : 'Grafik Pembelian'
                },

                subtitle : {
                    text : 'PT Medika Sarana'
                },

                series : [{
                    name : 'Pembelian Rp.',
                    data : {$grafikPembelian}
                    ,
                    tooltip: {
                        valueDecimals: 2
                    }
                }]
            });

        });
    </script>
{/block}

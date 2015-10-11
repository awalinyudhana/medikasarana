{* Extend our master template *}
{extends file="../../../dashboard.tpl"}

{block name=content}
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard <small>Selamat Datang di Dashboard POS PT Sarana Medika Sejahtera</small></h3>
        </div>
    </div>

    <ul class="page-stats list-justified">
        {if "product"|in_array:$roles}
            <li class="{if $minimumStock == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/product-stock')}">
                    <div class="page-stats-showcase">
                        <span>Minimum Stock</span>
                        <h2>{$minimumStock}</h2>
                    </div>
                </a>
            </li>
            <li class="{if $expiredProducts == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/product-expired')}">
                    <div class="page-stats-showcase">
                        <span>Expired Products</span>
                        <h2>{$expiredProducts}</h2>
                    </div>
                </a>
            </li>
        {/if}
        {if "credit"|in_array:$roles}
            <li class="{if $creditCount == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/credit')}">
                    <div class="page-stats-showcase">
                        <span>Tagihan Hutang</span>
                        <h2>{$creditCount} <br/> Rp {$creditSum|number_format:0}</h2>
                    </div>
                </a>
            </li>
            <li class="{if $creditBGCount == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/credit-cek')}">
                    <div class="page-stats-showcase">
                        <span>Hutang Cek BG</span>
                        <h2>{$creditBGCount} <br/> Rp {$creditBGSum|number_format:0}</h2>
                    </div>
                </a>
            </li>
        {/if}
        {if "debit"|in_array:$roles}
            <li class="{if $debitCount == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/debit')}">
                    <div class="page-stats-showcase">
                        <span>Tagihan Piutang</span>
                        <h2>{$debitCount} <br/> Rp {$debitSum|number_format:0}</h2>
                    </div>
                </a>
            </li>
            <li class="{if $debitBGCount == 0}bg-success{else}bg-danger{/if}">
                <a href="{base_url('dashboard/debit-cek')}">
                    <div class="page-stats-showcase">
                        <span>Piutang Cek BG</span>
                        <h2>{$debitBGCount} <br/> Rp {$debitBGSum|number_format:0}</h2>
                    </div>
                </a>
            </li>
        {/if}
    </ul>

    <div class="row">
        {if "purchase_order"|in_array:$roles}
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
                });
            </script>
        {/if}
        {if "sales_order"|in_array:$roles}
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
            <script>
                $(function () {

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
        {/if}
        {if "retail"|in_array:$roles}
            <script>
                $(function () {
                    $('#grafik_penjualan_retail').highcharts('StockChart', {
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
                            text : 'Grafik Penjualan Retail'
                        },

                        subtitle : {
                            text : 'PT Medika Sarana'
                        },

                        series : [{
                            name : 'Penjualan Rp.',
                            data : {$grafikPenjualanRetail}
                            ,
                            tooltip: {
                                valueDecimals: 2
                            }
                        }]
                    });

                });
            </script>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Penjualan Retail</h6>
                    </div>
                    <div class="panel-body" style="min-height:400px;">
                        <div class="graph-standard" id="grafik_penjualan_retail"></div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
    
{/block}

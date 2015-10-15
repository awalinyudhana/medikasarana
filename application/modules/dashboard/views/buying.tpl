{* Extend our master template *}
{extends file="../../../dashboard.tpl"}

{block name=content}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Pembelian</h6>
                </div>
                <div class="panel-body" style="min-height:400px;">
                    <div class="graph-standard" id="grafik_pembelian" style="height:100%; width:100%;"></div>
                </div>
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
                    text : 'PT. SARANA MEDIKA SEJAHTERA'
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

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard <small>Selamat Datang di Dashboard POS PT Sarana Medika Sejahtera</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Penjualan</h6>
                </div>
                <div class="panel-body">
                    <div class="graph-standard" id="filled_blue"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-calendar2"></i> Grafik Pembelian</h6>
                </div>
                <div class="panel-body">
                    <div class="graph-standard" id="filled_green"></div>
                </div>
            </div>
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
{/block}

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Retur Penjualan Retail</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Retur Penjualan Retail <small class="display-block">Laporan Retur Penjualan Retail</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Retur Penjualan Retail:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/retur-penjualan-retail')}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Faktur Retur</th>
                                <th>No Faktur</th>
                                <th>Tanggal Transaksi</th>
                                <th>Nama Staff</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $retur_penjualan as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_retail_return}</td>
                                <td>{$key->id_retail}</td>
                                <td>{$key->date}</td>
                                <td>{$key->name}</td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{base_url('report/retur-penjualan-retail/detail/')}/{$key->id_retail}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Detail">
                                            <i class="icon-list"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

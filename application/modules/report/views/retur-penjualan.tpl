{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Retur {$title}</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Retur {$title} <small class="display-block">Laporan Retur {$title}</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Retur {$title}:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/retur-')}{$array_type[$type]}" class="btn btn-warning">Reset</a>
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
                                <th>Nama Customer</th>
                                <th>Nama Staff</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $retur_penjualan as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_sales_order_return}</td>
                                <td>{$key->id_sales_order}</td>
                                <td>{$key->date}</td>
                                <td>{$key->customer_name}</td>
                                <td>{$key->staff_name}</td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{base_url('report/retur-penjualan/detail/')}/{$key->id_sales_order_return}"
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

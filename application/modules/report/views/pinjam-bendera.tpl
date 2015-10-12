{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pinjam Bendera</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Daftar Penjualan<small class="display-block">Daftar penjualan pinjam bendera </small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Daftar Penjualan</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/pinjam-bendera')}" class="btn btn-warning">Reset</a>
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
                                <th>No Faktur</th>
                                <th>Customer</th>
                                <!-- <th>Nama Staff</th> -->
                                <th>Tanggal Transaksi</th>
                                <<!-- th>Jatuh Tempo</th>
                                <th>Total</th>
                                <th>DPP</th>
                                <th>PPN</th>
                                <th>Discount</th> -->
                                <th>Grand Total</th>
                               <!--  <th>Paid</th>
                                <th>Detail</th> -->
                            </tr>
                        </thead>
                        <tbody>

                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_sales_order}</td>
                                <td>{$key->customer_name}</td>
                                <!-- <td>{$key->staff_name}</td> -->
                                <td>{$key->date}</td>
                                <!-- <td>{$key->due_date}</td> -->
                                <!-- <td class="text-right">Rp {$key->total|number_format:0}</td>
                                <td class="text-right">Rp {$key->dpp|number_format:0}</td>
                                <td class="text-right">Rp {$key->ppn|number_format:0}</td>
                                <td class="text-right">Rp {$key->discount_price|number_format:0}</td> -->
                                <td class="text-right">Rp {$key->grand_total|number_format:0}</td>
                                <!-- <td class="text-right">Rp {$key->paid|number_format:0}</td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{base_url('report/penjualan-detail/')}/{$key->id_sales_order}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Detail">
                                            <i class="icon-list"></i>
                                        </a>

                                    </div>
                                </td> -->
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+$key->grand_total}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <table class="table">
                            <tbody>
                            {if isset($from)}
                            <tr>
                                <th>Total Laporan Pinjam Bendera Mulai "{$from} hingga {$to}":</th>
                                <td class="text-right">Rp {$total|number_format:0}</td>
                            </tr>
                            {/if}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /panel body -->

        </div><!-- /default panel -->

{/block}

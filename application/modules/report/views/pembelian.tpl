{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pembelian</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Pembelian <small class="display-block">Laporan Pembelian</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Pembelian:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/pembelian')}" class="btn btn-warning">Reset</a>
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
                                <th>No Invoice</th>
                                <th>Principal</th>
                                <th>Nama Staff</th>
                                <th>Tanggal Transaksi</th>
                                <th>Jatuh Tempo</th>
                                <th>Total</th>
                                <th>DPP</th>
                                <th>PPN</th>
                                <th>Discount</th>
                                <th>Grand Total</th>
                                <th>Paid</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>

                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $pembelian as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->invoice_number}</td>
                                <td>{$key->principal_name}</td>
                                <td>{$key->staff_name}</td>
                                <td>{$key->date_created}</td>
                                <td>{$key->due_date}</td>
                                <td>Rp {$key->total|number_format:0}</td>
                                <td>Rp {$key->dpp|number_format:0}</td>
                                <td>Rp {$key->ppn|number_format:0}</td>
                                <td>Rp {$key->discount_price|number_format:0}</td>
                                <td>Rp {$key->grand_total|number_format:0}</td>
                                <td>Rp {$key->paid|number_format:0}</td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{base_url('report/pembelian-detail/')}/{$key->id_purchase_order}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Detail">
                                            <i class="icon-list"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+$key->grand_total}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="col-sm-8">
                    <table class="table">
                        <tbody>
                        {if isset($from)}
                        <tr>
                            <th>Total Pembelian Mulai "{$from} hingga {$to}":</th>
                            <td class="text-right">Rp {$total|number_format:0}</td>
                        </tr>
                        {/if}
                        <tr>
                            <th>Total Pembelian:</th>
                            <td class="text-right"><h6>Rp {$total_pembelian|number_format:0}</h6></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div><!-- /panel body -->

        </div><!-- /default panel -->

{/block}

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            
            <div class="panel-heading"><h6 class="panel-title">Daftar Penjualan</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Piutang <small class="display-block">Detail Penjualan</small>
                    </h6>
                </div>

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Pembayaran Piutang:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/debit')}" class="btn btn-warning">Reset</a>
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
                                <th>Tanggal Transaksi</th>
                                <th>No Faktur</th>
                                <th>Customer</th>
                                <!-- <th>No Invoice</th> -->
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Total Tagihan</th>
                                <th>Terbayar</th>
                                <th>Sisa Tagihan</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>

                        {assign var=total_tagihan value=0}
                        {assign var=total_bayar value=0}
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->date}</td>
                                <td>{$key->id_sales_order}</td>
                                <td>{$key->name}</td>
                                <!-- <td>{$key->invoice_number}</td> -->
                                <td>{$key->due_date}</td>
                                <td class="text-right">Rp {$key->grand_total|number_format:0}</td>
                                <td class="text-right">Rp {$key->paid|number_format:0}</td>
                                <td class="text-right">Rp {($key->grand_total-$key->paid)|number_format:0}</td>
                                <td>
                                    {if $key->status_paid == 0}
                                        Belum Lunas
                                    {else}
                                        Lunas
                                    {/if}
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total_tagihan value=$total_tagihan+$key->grand_total}
                            {assign var=total_bayar value=$total_bayar+$key->paid}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="col-sm-8">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>
                                Total Piutang
                                {if isset($from)} 
                                    Mulai "{$from} hingga {$to}" 
                                {/if}:
                            </th>
                            <td class="text-right">Rp {$total_tagihan|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>
                                Total Piutang yang telah terbayar
                                {if isset($from)} 
                                    Mulai "{$from} hingga {$to}" 
                                {/if}:
                            </th>
                            <td class="text-right">Rp {$total_bayar|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>
                                Sisa Piutang yang belum terbayar
                                {if isset($from)} 
                                    Mulai "{$from} hingga {$to}" 
                                {/if}:
                            </th>
                            <td class="text-right">Rp {($total_tagihan-$total_bayar)|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

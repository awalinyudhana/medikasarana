{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pembayaran Hutang</h6></div>

            <div class="panel-body">
                <!-- <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Penjualan Retail <small class="display-block">Laporan Penjualan Retail</small>
                    </h6>
                </div> -->

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Pembayaran Hutang:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="From" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="to-date form-control" name="date_to" placeholder="To" {if isset($to)}value="{$to}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/penjualan-retail')}" class="btn btn-warning">Reset</a>
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
                                <th>Principal</th>
                                <th>Tanggal Transaksi</th>
                                <th>No Invoice</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Tanggal Withdrawal</th>
                                <th>Staff</th>
                                <th>Jenis Pembayaran</th>
                                <th>No Resi</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>

                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_purchase_order}</td>
                                <td>{$key->principal_name}</td>
                                <td>{$key->tanggal_transaksi}</td>
                                <td>{$key->invoice_number}</td>
                                <td>{$key->date}</td>
                                <td>{$key->date_withdrawal}</td>
                                <td>{$key->staff_name}</td>
                                <td>{$key->payment_type}</td>
                                <td>{$key->resi_number}</td>
                                <td>{$key->amount}</td>
                                <td>{$status[$key->amount]}</td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+$key->amount}
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="col-sm-8">
                    <table class="table">
                        <tbody>
                        
                        <tr>
                            <th>
                            	Total 
                            	{if isset($from)} 
                            		Pembayaran Hutang Mulai "{$from} hingga {$to}" 
                            	{/if}:
                            </th>
                            <td class="text-right">Rp {$total|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

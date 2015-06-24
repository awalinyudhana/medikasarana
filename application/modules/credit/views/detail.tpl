{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Hutang</h6></div>

            <div class="panel-body"> 

                <div class="row invoice-header">
                    <div class="col-sm-6">
                        <h3>{$po->name}</h3>
                    <span>{$po->address} - {$po->zipcode}
                        </br>
                        {$po->city} - {$po->state}
                        </br>
                        {$po->telp1} - {$po->telp1}
                        </br>
                        {$po->email}
                    </span>
                    </div>

                    <div class="col-sm-3 pull-right">
                        <ul>
                            <li>No Faktur # <strong class="text-danger pull-right">{$po->id_purchase_order}</strong></li>
                            <li>Tanggal Nota Transaksi : <strong class="pull-right">{$po->date}</strong></li>
                            <li>Tanggal Jatuh Tempo: <strong class="pull-right">{$po->due_date}</strong></li>
                        </ul>
                    </div>
                </div>
            </div><!-- /panel body -->

            <div class="table-responsive pre-scrollable">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Tanggal Penarikan</th>
                        <th>Staff</th>
                        <th>Jumlah Bayar</th>
                        <th>Type Pembayaran</th>
                        <th>No Resi</th>
                        <th>Bukti Pembayaran</th>
                        <th>Status Pembayaran</th>
                    </tr>
                    </thead>
                    <tbody>
                    {if $credit}
                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $credit as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->date}</td>
                                <td>{$key->date_withdrawal}</td>
                                <td>{$key->name}</td>
                                <td>Rp {$key->amount|number_format:0}</td>
                                <td>{$key->payment_type}</td>
                                <td>{$key->resi_number}</td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{$key->file}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Lihat Bukti Pembayaran">
                                            <i class="icon-picassa"></i>
                                        </a>
                                        {if $key->status == "0"}
                                            <a href="{base_url('credit/paid')}/{$key->id_credit}"
                                               class="btn btn-link btn-icon btn-xs tip" title="Ubah Status">
                                                <i class="icon-coin"></i>
                                            </a>
                                        {/if}
                                    </div>
                                </td>
                                <td>
                                    {if $key->status == "1"}
                                        Terbayar
                                    {else}
                                        Belum Terbayar
                                    {/if}
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+($key->amount)}
                        {/foreach}
                    {/if}

                    </tbody>
                </table>
            </div>

            <div class="panel-body">

                <div class="col-sm-6">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Total Tagihan:</th>
                            <td class="text-right">Rp {$po->grand_total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Total Bayar:</th>
                            <td class="text-right">Rp {$po->paid|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Sisa Hutang:</th>
                            <td class="text-right"><h6>Rp {($po->grand_total - $po->paid)|number_format:0}</h6></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                {*<h6>Notes &amp; Information:</h6>*}
                {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}


            </div>


        </div><!-- /default panel -->

{/block}

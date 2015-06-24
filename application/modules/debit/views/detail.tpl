{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Piutang</h6></div>

            <div class="panel-body"> 

                <div class="row invoice-header">
                    <div class="col-sm-6">
                        <h3>{$so->name}</h3>
                    <span>{$so->address} - {$so->zipcode}
                        </br>
                        {$so->city} - {$so->state}
                        </br>
                        {$so->telp1} - {$so->telp1}
                    </span>
                    </div>

                    <div class="col-sm-3 pull-right">
                        <ul>
                            <li>No Faktur # <strong class="text-danger pull-right">{$so->id_sales_order}</strong></li>
                            <li>Tanggal Nota Transaksi : <strong class="pull-right">{$so->date}</strong></li>
                            <li>Tanggal Jatuh Tempo: <strong class="pull-right">{$so->due_date}</strong></li>
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
                        <th>Staff</th>
                        <th>Jumlah Bayar</th>
                        <th>Type Pembayaran</th>
                        <th>No Resi</th>
                        <th>Bukti Pembayaran</th>
                    </tr>
                    </thead>
                    <tbody>
                    {if $debit}
                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $debit as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->date}</td>
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
                                    </div>
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
                            <td class="text-right">Rp {$so->grand_total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Total Bayar:</th>
                            <td class="text-right">Rp {$so->paid|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Sisa Piutang:</th>
                            <td class="text-right"><h6>Rp {($so->grand_total - $so->paid)|number_format:0}</h6></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
                {*<h6>Notes &amp; Information:</h6>*}
                {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}


            </div>


        </div><!-- /default panel -->

{/block}

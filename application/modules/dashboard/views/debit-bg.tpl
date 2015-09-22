{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Informasi Daftar Piutang Cek BG</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Informasi Daftar Piutang Cek BG<small class="display-block">Daftar Cek BG belum cair</small>
                    </h6>
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
                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $items as $key }

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
                                        <a href="{base_url('debit/paid')}/{$key->id_credit}"
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

                    </tbody>
                </table>
            </div>

            <div class="panel-body">

                <div class="col-sm-6">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Total Tagihan:</th>
                            <td class="text-right">Rp {$total|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div><!-- /default panel -->

{/block}
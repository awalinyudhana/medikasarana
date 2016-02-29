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

                <div class="col-sm-4 pull-right">
                    <ul>
                        <li>No Faktur Jual# <strong class="text-danger pull-right">{$so->id_sales_order}</strong></li>
                        <li>Tanggal Faktur Jual <strong class="pull-right">{$so->date}</strong></li>
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
                    <th>Tanggal Penarikan</th>
                    <th>Staff</th>
                    <th>Jumlah Bayar</th>
                    <th>Tipe Pembayaran</th>
                    <th>No Resi</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status Pembayaran</th>
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
                                        <a href="{base_url('debit/paid')}/{$key->id_debit}"
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
            <div class="col-sm-6">

                <div class="btn-group pull-right">
                    <a href="{base_url('debit')}" class="btn btn-info button">
                        <i class="icon-box-add"></i> Daftar Piutang</a>
                    <button type="button" class="btn btn-primary" onclick="print_doc();" id="button-focus">
                        <i class="icon-print2"></i> Cetak</button>
                </div>
            </div>  
        </div>
    </div><!-- /default panel -->
{/block}
{block name=print}
    <div id="print">
        <font size="2em">
            <table border="0" width="100%">

                <tr>
                    <td width="35%" align="left" valign="top">
                        PT. SARANA MEDIKA SEJAHTERA
                        </br>
                        Ruko Armada Estate Blok A1No. 1
                        </br>
                        Jl. A. Yani Magelang
                        </br>
                        Telp. (0293) 361755,
                        </br>
                        Fax.   (0293) 366829
                        </br>
                        NPWP : 31.354.959.4-524.000
                    </td>
                    <td width="10%">
                    </td>
                    <td width="35%" align="left" valign="top">
                        Kepada Yth.
                        </br>
                        {$so->alias_name1}
                        </br>
                        {$so->alias_name2}
                        </br>
                        {$so->name}
                        </br>
                        {$so->address} - {$so->zipcode}
                        </br>
                        {$so->city} - {$so->state}
                        </br>
                        {$so->telp1} - {$so->telp2}
                        </br>
                        NPWP : {$so->npwp}
                    </td>
                    <td align="left" valign="top">
                        No Faktur Jual: #{$so->id_sales_order}
                        </br>
                        Tanggal Faktur Jual : {$so->date}
                        </br>
                        Tanggal Jatuh Tempo: {$so->due_date}
                    </td>
                </tr>
            </table>
        </font>
        </br>
        <font size="2em">
            <table border="0" width="100%">
                <thead style="border-top: 1px dashed; border-bottom: 1px dashed;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jumlah Bayar</th>
                        <th>Tipe Pembayaran</th>
                        <th>No Resi</th>
                        <th>Status Pembayaran</th>
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
                            <td>Rp {$key->amount|number_format:0}</td>
                            <td>{$key->payment_type}</td>
                            <td>{$key->resi_number}</td>
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
                    <tr>
                        <td colspan="10">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td valign="top">Total Tagihan</td>
                        <td align="right" valign="top">Rp {$so->grand_total|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">Total Bayar</td>
                        <td align="right"style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">Rp {$so->paid|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td valign="top">Sisa Piutang</td>
                        <td align="right" valign="top">Rp {($so->grand_total - $so->paid)|number_format:0}</td>
                    </tr>
                </tbody>
            </table>
        </font>
    </div>
{/block}



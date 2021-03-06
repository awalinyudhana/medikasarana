{* Extend our master template *}
{extends file="../../../master.tpl"}
{block name=content}
    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Rangkuman Transaksi</h6>

            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown">
                    <i class="icon-cog3"></i>
                    <b class="caret"></b>
                </a>
            </div>
        </div>

        <div class="panel-body">

            <div class="row invoice-header">
                <div class="col-sm-6">
                    <h3>{$master->store_name}</h3>
                    <span>{$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp2}
                    </span>
                </div>

                <div class="col-sm-3 pull-right">
                    <ul>
                        <li>No Nota Retail # <strong class="text-danger pull-right">{$master->id_retail}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Tanggal Nota Retail <strong class="pull-right">{$master->date}</strong></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $items as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['barcode']}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td style="width:100px;">{$key['unit']} ( {$key['value']} )</td>
                            <td>{$key['qty']}</td>
                            <td style="width:100px;" class="text-right">Rp {$key['price']|number_format:0}</td>
                            <td style="width:100px;" class="text-right">
                                Rp {($key['qty'] * $key['price'] - $key['discount_total'])|number_format:0}
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key['qty'] * $key['price'] - $key['discount_total'])}
                    {/foreach}
                    </tbody>
                </table>
            </div>
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-4">
                    <h6>Ringkasan :</h6>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>DPP :</th>
                            <td class="text-right">Rp {($master->dpp)|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>PPN :</th>
                            <td class="text-right">
                                Rp  {$master->ppn|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Total :</th>
                            <td class="text-right">Rp {$master->total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Diskon :</th>
                            <td class="text-right">Rp {$master->discount_price|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Grand Total:</th>
                            <td class="text-right">Rp {$master->grand_total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Bayar :</th>
                            <td class="text-right">Rp {$master->paid|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Kembali Uang :</th>
                            <td class="text-right">Rp {($master->paid-$master->grand_total)|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-group pull-right">
                        <a href="{base_url('retail')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> Order Retail Baru</a>
                        <button type="button" class="btn btn-primary" onclick="print_doc();" id="button-focus"><i
                                    class="icon-print2"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /new invoice template -->
{/block}

{block name=print}
    <div id="print">
        <font size="2em">
            <table border="0" width="100%">
                <tr>
                    <td width="40%" align="left" valign="top">
                        {$master->store_name}
                        </br>
                        {$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp2}
                        </br>
                        NPWP : {$master->npwp}
                    </td>
                    <td width="40%" align="left" valign="top">
                    </td>
                    <td>
                        #{$master->id_retail} / {$master->staff_name}
                        </br>
                        {$master->date}
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
                        <th min-width="40%">Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / Isi</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $items as $key }
                        <tr>
                            <td valign="top" align="left">{$val}</td>
                            <td valign="top" align="left">{$key['name']}</td>
                            <td valign="top" align="center">{$key['brand']}</td>
                            <td valign="top">{$key['unit']} ( {$key['value']} )</td>
                            <td valign="top" align="center">{$key['qty']}</td>
                            <td valign="top" align="right">
                                Rp {$key['price']|number_format:0}</td>
                            <td valign="top" align="right">
                                Rp {($key['qty'] * $key['price'] - $key['discount_total'])|number_format:0}
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key['qty'] * $key['price'] - $key['discount_total'])}
                    {/foreach}
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Diskon</td>
                        <td align="right" valign="top">Rp {$master->discount_price|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">Harga Jual</td>
                        <td align="right"style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">Rp {$master->grand_total|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Total</td>
                        <td align="right" valign="top">Rp {$master->grand_total|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Tunai</td>
                        <td align="right" valign="top">Rp {$master->paid|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Kembali</td>
                        <td align="right" valign="top">Rp {($master->paid-$master->grand_total)|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Anda Hemat</td>
                        <td align="right" valign="top">Rp {$master->discount_price|number_format:0}</td>
                    </tr>
                </tbody>
            </table>
            </br>
            <table border="0" width="100%">
                <tr>
                    <td width="100%" align="center" valign="top">
                        DPP : Rp {($master->dpp)|number_format:0} &nbsp;&nbsp;&nbsp; PPN : Rp {($master->ppn)|number_format:0}
                    </td>
                </tr>
                <tr>
                    <td width="100%" align="center" valign="top">
                        <span>
                            TERIMA KASIH DAN SELAMAT BELANJA KEMBALI
                        </span>
                    </td>
                </tr>
            </table>
        </font>
    </div>
{/block}

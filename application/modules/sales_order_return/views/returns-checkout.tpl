{* Extend our master template *}
{extends file="../../../master.tpl"}
{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i>Invoice Retur Order Jual</h6>

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
                    <h3>{$master->customer_name}</h3>
                    <span>{$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1}- {$master->telp2}
                    </span>
                </div>

                <div class="col-sm-3 pull-right">
                    <ul>
                        <li>No Faktur Retur# <strong class="text-danger pull-right">{$master->id_sales_order_return}</strong>
                        </li>
                        <li>No Faktur Jual# <strong class="text-danger pull-right">{$master->id_sales_order}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
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
                        <th>Qty</th>
                        <th>Cashback</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=no value=1}
                    {assign var=total_cashback value=0}
                    {foreach $items as $return }
                        {assign var=total_cashback value=$total_cashback+$return['cashback']}
                        <tr>
                            <td rowspan="2">{$no} </td>
                            <td>{$return['barcode']}</td>
                            <td>{$return['name']}</td>
                            <td>{$return['brand']}</td>
                            <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
                            <td>{$return['qty_return']}</td>
                            <td></td>
                            <td rowspan="2">{$return['reason']}</td>
                        </tr>

                        <tr>
                            {if $return['id_product_cache']}
                                <td>{$product_storage[$return['id_product_cache']]['barcode']}</td>
                                <td>{$product_storage[$return['id_product_cache']]['name']}</td>
                                <td>{$product_storage[$return['id_product_cache']]['brand']}</td>
                                <td>
                                    {$product_storage[$return['id_product_cache']]['unit']}
                                    ( {$product_storage[$return['id_product_cache']]['value']} )
                                    </td>
                                <td>{$return['qty']}</td>
                            {else}
                                <td colspan="5"></td>
                            {/if}
                            <td>Rp
                                {if $return['cashback']}
                                    {$return['cashback']|number_format:0}
                                {else}
                                    {0|number_format:0}
                                {/if}
                            </td>
                        </tr>

                        {assign var=no value=$no+1}
                    {/foreach}
                    </tbody>
                </table>
            </div>

         <!--    <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Retur</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=val value=1}
                    {foreach $items as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['barcode']}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td style="width:100px;">{$key['unit']} ( {$key['value']} )</td>
                            <td>{$key['qty']}</td>
                            <td>
                                {$key['return']}
                            </td>
                            <td style="width:130px;" class="text-right">Rp {$key['price']|number_format:0}</td>
                            <td style="width:130px;" class="text-right">Rp {$key['discount']|number_format:0}</td>
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                    {/foreach}
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Item Pengganti
                    <small class="display-block">Data item pengganti</small>
                </h6>
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
                        <th>Qty</th>
                        <th>Cashback</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=no value=1}
                    {assign var=total_cashback value=0}
                    {foreach $returns as $return }
                        <tr>
                            <td>{$no}</td>
                            <td>{$return['barcode']}</td>
                            <td>{$return['name']}</td>
                            <td>{$return['brand']}</td>
                            <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
                            <td>{$return['qty']}</td>
                            <td class="text-right">Rp
                                {if $return['cashback']}
                                    {$return['cashback']|number_format:0}
                                    {assign var=total_cashback value=$total_cashback+$return['cashback']}
                                {else}
                                    0
                                {/if}
                            </td>
                        </tr>
                        {assign var=no value=$no+1}
                    {/foreach}
                    </tbody>
                </table>
            </div> -->

            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Total:</th>
                                <td class="text-right">Rp {$total_cashback|number_format:0}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group pull-right">
                        <a href="{base_url('sales-order/search')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> New Sales Order</a>
                        <button type="button" class="btn btn-primary" onclick="print_doc();" id="button-focus">
                            <i class="icon-print2"></i> Print</button>
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
                        {$master->alias_name1}
                        </br>
                        {$master->alias_name2}
                        </br>
                        {$master->customer_name}
                        </br>
                        {$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp2}
                        </br>
                        NPWP : {$master->npwp}
                    </td>
                    <td align="left" valign="top">
                        No Faktur Retur : #{$master->id_sales_order_return} / {$master->id_sales_order}
                        </br>
                        Staff : {$master->staff_name}
                        </br>
                        Tanggal : {$master->date}
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
                    <th>Kembali</th>
                    <th>Keterangan</th>
                </tr>
                </thead>
                <tbody class="tbody-a5">
                    {assign var=no value=1}
                    {assign var=total_cashback value=0}
                    {foreach $items as $return }
                        {assign var=total_cashback value=$total_cashback+$return['cashback']}
                        <tr>
                            <td rowspan="2">{$no} </td>
                            <td>{$return['name']}</td>
                            <td>{$return['brand']}</td>
                            <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
                            <td>{$return['qty_return']}</td>
                            <td></td>
                            <td rowspan="2">{$return['reason']}</td>
                        </tr>
                        <tr>
                            {if $return['id_product_cache']}
                                <td>{$product_storage[$return['id_product_cache']]['name']}</td>
                                <td>{$product_storage[$return['id_product_cache']]['brand']}</td>
                                <td>
                                    {$product_storage[$return['id_product_cache']]['unit']}
                                    ( {$product_storage[$return['id_product_cache']]['value']} )
                                    </td>
                                <td>{$return['qty']}</td>
                            {else}
                                <td colspan="4"></td>
                            {/if}
                            <td>Rp
                                {if $return['cashback']}
                                    {$return['cashback']|number_format:0}
                                {else}
                                    {0|number_format:0}
                                {/if}
                            </td>
                        </tr>
                        {assign var=no value=$no+1}
                    {/foreach}
                </tbody>
            </table>
            </br>
            <table border="0" width="100%">
                <tr>
                    <td width="100%" align="center" valign="top">
                        Total Kembali : Rp {$total_cashback|number_format:0} 
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
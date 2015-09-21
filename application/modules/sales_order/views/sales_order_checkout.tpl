{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Order Jual Checkout</h6>

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
                        {$master->telp1} - {$master->telp2}
                        </br>
                        {$master->owner}
                    </span>
                </div>

                <div class="col-sm-3 pull-right">
                    <ul>
                        <li>No Faktur SO # <strong class="text-danger pull-right">{$master->id_sales_order}</strong></li>
                        {*<li>No Proposal # <strong class="text-danger pull-right">{$master->id_proposal}</strong></li>*}
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        <li>Jatuh Tempo : <strong class="pull-right">{$master->due_date}</strong></li>
                        <li>PPn status <strong class="text-info pull-right">{$status_ppn}</strong></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th>Ppn</th>        
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=val value=1}
                    {foreach $items as $key }
                        {assign var=ppn value=0}
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {$key['qty']}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['sub_total']|number_format:0}
                            </td>
                            {if $master->status_ppn == 1}
                                    {assign var=ppn value=($key['sub_total']*0.1)}
                            {else}    
                                    {assign var=ppn value=0}
                            {/if}

                                <td style="width:100px;" class="text-right">
                                    Rp {$ppn|number_format:0}
                                </td>
                            <td style="width:100px;" class="text-right">
                                Rp {($key['sub_total']+$ppn)|number_format:0}
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                    {/foreach}
                    </tbody>
                </table>
            </div>

            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Dpp:</th>
                            <td class="text-right">Rp {$master->dpp|number_format:0}</td>
                        </tr>
                        <!-- <tr>
                            <th>Discount:</th>
                            <td class="text-right">Rp {$master->discount_price|number_format:0}</td>
                        </tr> -->
                        <tr>
                            <th>PPn:</th>
                            <td class="text-right">Rp {$master->ppn|number_format:0}</td>
                        </tr>

                        <tr>
                            <th>Grand Total:</th>
                            <td class="text-right text-danger">
                                <h6>    <span id="sum-grand_total-text">
                                    Rp {$master->grand_total|number_format:0}
                                </h6>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-group pull-right">
                        <a href="{base_url('sales-order/search')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> New Sales Order</a>
                        <button type="button" class="btn btn-primary"><i class="icon-print2"></i> Print</button>
                    </div>
                </div>
            </div>

            <!-- <h6>Notes &amp; Information:</h6>
            This invoice contains a incomplete list of items destroyed by the Federation ship Enterprise on Startdate
            5401.6 in an unprovked attacked on a peaceful &amp; wholly scientific mission to Outpost 775.
            The Romulan people demand immediate compensation for the loss of their Warbird, Shuttle, Cloaking Device,
            and to a lesser extent thier troops. -->
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
                        <h3>{$store->name}</h3>
                    </td>
                    <td width="35%" align="left" valign="top">
                        <h3>{$master->customer_name}</h3>
                    </td>
                    <td rowspan="2" align="left" valign="top">
                        No Faktur : #{$master->id_sales_order}
                        </br>
                        Staff : {$master->staff_name}
                        </br>
                        Tanggal : {$master->date}
                        </br>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        {$store->address} - {$store->zipcode}
                        </br>
                        {$store->city} - {$store->state}
                        </br>
                        {$store->telp1} - {$store->telp2}
                        </br>
                        NPWP : {$store->npwp}
                    </td>
                    <td align="left" valign="top">
                        {$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp2}
                        </br>
                        NPWP : {$master->npwp}
                    </td>
                    <td>
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
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th>PPN</th>        
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    {assign var=val value=1}
                    {foreach $items as $key }
                        {assign var=ppn value=0}
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {$key['qty']}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['sub_total']|number_format:0}
                            </td>
                            {if $master->status_ppn == 1}
                                    {assign var=ppn value=($key['sub_total']*0.1)}
                            {else}    
                                    {assign var=ppn value=0}
                            {/if}

                                <td style="width:100px;" class="text-right">
                                    Rp {$ppn|number_format:0}
                                </td>
                            <td style="width:100px;" class="text-right">
                                Rp {($key['sub_total']+$ppn)|number_format:0}
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                    {/foreach}
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Dpp</td>
                        <td align="right" valign="top">Rp {$master->dpp|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">PPN</td>
                        <td align="right"style="border-top: 1px dashed; border-bottom: 1px dashed;" valign="top">Rp {$master->ppn|number_format:0}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td valign="top">Jumlah Total</td>
                        <td align="right" valign="top">Rp {$master->grand_total|number_format:0}</td>
                    </tr>
                </tbody>
            </table>
            </br>
            <table border="1" width="100%">
                <tr>
                    <td width="40%" height="35px" align="left" valign="top">
                        Catatan :
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="left" valign="top">
                        Disiapkan :
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="left" valign="top">
                        Diperiksa :
                    </td>
                </tr>
                <tr>
                    <td width="20%" align="left" valign="top">
                        Penerima :
                    </td>
                </tr>
            </table>
        </font>
    </div>
{/block}


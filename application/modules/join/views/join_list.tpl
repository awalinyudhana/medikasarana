{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Order Jual</h6></div>
        <div class="panel-body">
            <div class="row invoice-header">
                <div class="col-sm-4">
                    <h3>{$master->name}</h3>
                    <span>{$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp1}
                        </br>
                        NPWP : {$master->npwp}
                    </span>
                </div>

                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('join/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Ganti Dengan No Faktur Lain</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Callout -->
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$error}</p>
                </div>
            {/if}
            <!-- /callout -->
        <!-- /panel body -->


        {if $items}
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th width="100px">Qty</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th>Ppn</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=total value=0}
                    {assign var=ppn_total value=0}
                    {assign var=val value=1}
                    {foreach $items as $key }
                        {assign var=ppn value=0}
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['id_sales_order']}</td>
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

                            {if $cache['value']['status_ppn'] == 1}
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
                        {assign var=total value=$total+$key['sub_total']}
                        {assign var=ppn_total value=$ppn_total+$ppn}

                    {/foreach}
                    </tbody>
                    {assign var=total value=$total-$cache['value']['discount_price']    }
                </table>
            </div>
            <form action="{base_url('join/save')}" role="form" method="post"
                  onsubmit="return checkLimit({$total+$ppn_total},{$master->plafond});">
                <input type="hidden" name="total" value="{$total}">


                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <h6>Summary:</h6>
                            <table class="table">
                                <tbody>

                                <tr>
                                    <th>DPP:</th>
                                    <td class="text-right">Rp
                                        <span id="sum-dpp-text"><strong>{$total|number_format:0}</strong> </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="radio">
                                            PPN 10 %
                                        </label>
                                    </th>
                                    <td class="text-right">Rp <span
                                                id="sum-ppn-text">{$ppn_total|number_format:0}</span></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-danger">
                                        <h6>Rp <span
                                                    id="sum-grand_total-text">{($total+$ppn_total)|number_format:0} </span>
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right text-warning">
                                      * <i>Maksimal jumlah faktur Rp <span class="convert-currency">{$master->plafond|number_format:0}</span></i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn-group right-box">
                                <button type="submit" name="save" class="btn block full-width btn-success"><i
                                            class="icon-checkmark">
                                    </i> Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                <!-- /panel body -->
            </form>
        {/if}
        </div>
    </div>
    <!-- /default panel -->
{/block}

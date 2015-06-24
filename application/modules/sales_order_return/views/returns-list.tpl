{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-default" xmlns="http://www.w3.org/1999/html">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Data nota {$master->id_sales_order}</h6>
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
                        <li>No Faktur # <strong class="text-danger pull-right">{$master->id_sales_order}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('sales-order/returns/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Ganti No Nota</a>
                        </li>
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
                        <th>Retur</th>
                        <th>Harga</th>
                        <th>Diskon Harga</th>
                        <th>Subtotal</th>
                        <th>Action</th>
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
                                {if !empty($key['qty_return'])}
                                    {$key['return'] + $key['qty_return']}
                                {else}
                                    {$key['return']}
                                {/if}
                            </td>
                            <td style="width:130px;" class="text-right">Rp {$key['price']|number_format:0}</td>
                            <td style="width:130px;" class="text-right">Rp {$key['discount']|number_format:0}</td>
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                            </td>
                            <td>
                                <a href="{base_url('sales-order/returns/return-item/')}/{$key['id_sales_order_detail']}"
                                   class="button btn btn-info "> Retur
                                </a>
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                    {/foreach}
                    </tbody>
                </table>
            </div>
            {if $returns}
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
                        {foreach $returns as $return }
                            <tr>
                                <td>{$no}</td>
                                <td>{$return['barcode']}</td>
                                <td>{$return['name']}</td>
                                <td>{$return['brand']}</td>
                                <td style="width:100px;">{$return['unit']} ( {$return['value']} )</td>
                                <td>{$return['qty']}</td>
                                <td>Rp
                                    {if $return['cashback']}
                                        {$return['cashback']|number_format:0}
                                    {/if}
                                </td>
                            </tr>
                            {assign var=no value=$no+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <form action="{base_url('sales-order/returns/save')}" role="form" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-actions text-right">
                                    <button type="submit" name="save" value="Save" class="btn btn-success"><i
                                                class="icon-checkmark">
                                        </i> Process
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            {/if}
        </div>
    </div>
{/block}

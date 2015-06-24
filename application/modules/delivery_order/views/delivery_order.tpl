{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Delivery Order</h6></div>

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
                        <li>No Faktur <strong class="text-info">#{$master->id_sales_order}</strong></li>
                        {*<li>Jenis Proposal <strong class="text-info">{$proposal_type}</strong></li>*}
                        {*<li>PPn status # <strong class="text-info">{$status_ppn}</strong></li>*}
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('delivery-order/delete')}" class=" button btn btn-danger">
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
            <!-- /panel body -->


            {if $items}
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Merek</th>
                            <th>Satuan / isi</th>
                            <th>Jumlah Pesanan</th>
                            <th>Terkirim</th>
                            <th width="50px">Qty</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key['name']}</td>
                                <td>{$key['brand']}</td>
                                <td>{$key['unit']} / {$key['value']}</td>
                                <td>
                                    {$key['qty']}
                                </td>
                                <td>
                                    {$key['delivered']}
                                </td>
                                <td>
                                    <input type="number" id="qty-{$key['id_sales_order_detail']}"
                                           value="{$key['qty_delivered']}"
                                           class="form-control" onkeypress="qtyKeyPress({$key['id_sales_order_detail']},
                                            '{base_url('delivery-order/detail/update')}',event)">

                                </td>

                                <td style="width:90px;">

                                    <div class="table-controls">
                                        <a class="btn btn-link btn-icon btn-xs tip" title="Update Qty"
                                           onclick="updateQty({$key['id_sales_order_detail']},
                                                   '{base_url('delivery-order/detail/update')}')">
                                            <i class="icon-pencil3"></i></a>
                                        <a href="{base_url('delivery-order/detail/delete')}/{$key['id_sales_order_detail']}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Hapus Data">
                                            <i class="icon-remove3"></i></a>
                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}

                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <form action="{base_url('delivery-order/save')}" role="form" method="post"
                      onsubmit="return confirm('Process Data');">

                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Tanggal Pengiriman:</th>
                                    <td class="text-right">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12 {if form_error('date_sending')}has-warning{/if}">
                                                    {form_input('date_sending', set_value('date_sending'),
                                                    'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                                                </div>
                                            </div>
                                        </div>
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

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <script type="text/javascript">
        var data_storage = {$product_storage|@json_encode};
        var items = {$items|@json_encode};
    </script>
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
                        <li>Jenis Proposal <strong class="text-info">{$proposal_type}</strong></li>
                        <li>PPN status <strong class="text-info">{$status_ppn}</strong></li>
                        <li>Plafon <strong class="text-info">Rp {$master->plafond|number_format:0}</strong></li>
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('sales-order/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Ganti Dengan Proposal Lain</a>
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

            {if form_error('due_date')}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{form_error('due_date') }</p>
                </div>
            {/if}
            <!-- /callout -->

            {if $cache['value']['type'] == 0}
                {*<div class="row">*}
                {*<div class="col-md-4">*}
                {*<form action="{base_url('proposal/detail')}" role="form" method="post">*}
                {*<div class="form-group">*}
                {*<div class="row">*}
                {*<label class="col-sm-4 control-label">Barcode: </label>*}

                {*<div class="col-md-8">*}
                {*<input type="text" name="barcode" value="{set_value('barcode')}"*}
                {*id="input-barcode"*}
                {*class="form-control" placeholder="Type or scan barcode"*}
                {*autofocus onblur="barcodeParam(this)">*}
                {*<input type="hidden" name="id_product" value="{set_value('id_product')}"*}
                {*id="input-id_product">*}
                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*<div class="form-group">*}
                {*<div class="row">*}
                {*<label class="col-sm-4 control-label">Qty: </label>*}

                {*<div class="col-md-4 {if form_error('qty')}has-warning{/if}">*}
                {*<input type="number" name="qty" value="{set_value('qty',1)}" id="input-qty"*}
                {*class="form-control" placeholder="0">*}
                {*</div>*}
                {*</div>*}
                {*</div>*}

                {*<div class="form-group">*}
                {*<div class="row">*}
                {*<label class="col-sm-4 control-label">Harga: </label>*}

                {*<div class="col-md-7 {if form_error('price')}has-warning{/if}">*}
                {*<div class="input-group">*}
                {*<span class="input-group-addon">Rp</span>*}
                {*<input type="number" name="price" value="{set_value('price')}"*}
                {*class="form-control" placeholder="0" id="input-sell_price">*}

                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*<div class="form-group">*}
                {*<div class="row">*}
                {*<label class="col-sm-4 control-label">Diskon: </label>*}

                {*<div class="col-md-7 {if form_error('discount')}has-warning{/if}">*}
                {*<div class="input-group">*}
                {*<span class="input-group-addon">Rp</span>*}
                {*<input type="number" name="discount" value="{set_value('discount')}"*}
                {*class="form-control" placeholder="0">*}

                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*<div class="col-sm-12">*}
                {*<input type="submit" class="btn btn-block btn-success" value="Submit">*}
                {*</div>*}
                {*</form>*}
                {*</div>*}
                {*<div class="col-md-2">*}
                {*<div class="col-sm-12">*}
                {*<a data-toggle="modal" role="button" href="#default-modal"*}
                {*class="button btn btn-info center-block">Cari*}
                {*</a>*}
                {*</div>*}
                {*</div>*}
                {*<div class="col-md-6">*}
                {*<div class="row">*}
                {*<div class="col-md-6">*}
                {*<label>Nama Produk</label>*}
                {*<h6 id="text-name"></h6>*}
                {*</div>*}
                {*<div class="col-md-3">*}
                {*<label>Kategori:</label>*}
                {*<h6 id="text-category"></h6>*}
                {*</div>*}
                {*<div class="col-md-3">*}
                {*<label>Merek</label>*}
                {*<h6 id="text-brand"></h6>*}
                {*</div>*}
                {*</div>*}
                {*<div class="row">*}
                {*<div class="col-md-3">*}
                {*<label>Satuan:</label>*}
                {*<h6 id="text-unit"></h6>*}
                {*</div>*}
                {*<div class="col-md-3">*}
                {*<label>Isi Satuan:</label>*}
                {*<h6 id="text-value"></h6>*}
                {*</div>*}
                {*<div class="col-md-3">*}
                {*<label>Ukuran</label>*}
                {*<h6 id="text-size"></h6>*}
                {*</div>*}
                {*</div>*}
                {*</div>*}
                {*</div>*}
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
                        <th>Satuan / Isi</th>
                        <th>Stok Gudang</th>
                        <th width="100px">Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Diskon</th>
                        <!-- join faktur -->
                        <th>Subtotal</th>
                        <th>PPN</th>
                        <th>Total</th>
                        <th>Pilihan</th>
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
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>{$key['stock']}</td>
                            <td>
                                {if $cache['value']['type'] == 0}
                                    <input type="number" id="qty-{$key['id_product']}" value="{$key['qty']}"
                                           class="form-control" onkeypress="qtyKeyPress({$key['id_product']},
                                            '{base_url('sales-order/update')}',event)">
                                {else}
                                    {$key['qty']}
                                {/if}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                            <td style="width:100px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                            </td>
                            {if $cache['value']['status_ppn'] == 1}
                                {assign var=ppn value=$ppn+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                <td style="width:100px;" class="text-right">
                                    Rp {$ppn|number_format:0}
                                </td>
                            {else}
                                <td style="width:100px;" class="text-right">
                                    0
                                </td>
                            {/if}
                            <td style="width:100px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn)|number_format:0}
                            </td>
                            <td style="width:90px;">
                                <div class="table-controls">
                                    <a class="btn btn-link btn-icon btn-xs tip" title="Update Qty"
                                       onclick="updateQty({$key['id_product']},
                                               '{base_url('sales-order/update')}')">
                                        <i class="icon-pencil3"></i></a>
                                    <a href="{base_url('sales-order/detail/delete')}/{$key['id_product']}"
                                       class="btn btn-link btn-icon btn-xs tip" title="Hapus Data">
                                        <i class="icon-remove3"></i></a>
                                </div>
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total value=$ppn_total+$ppn}

                    {/foreach}
                    </tbody>
                </table>
            </div>
            <form action="{base_url('sales-order/save')}" role="form" method="post"
                  onsubmit="return checkLimit({$total+$ppn_total},{$master->plafond});">
                <input type="hidden" name="total" value="{$total}">
                <div class="panel-body">

                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <h6>Ringkasan :</h6>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Jatuh Tempo :</th>
                                    <td class="text-right">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12 {if form_error('due_date')}has-warning{/if}">
                                                    {form_input('due_date', set_value('due_date'),
                                                    'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <th>DPP :</th>
                                    <td class="text-right">Rp
                                        <span id="sum-dpp-text"><strong>{$total|number_format:0}</strong> </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="radio">
                                            <!-- join faktur -->
                                            {if $cache['value']['status_ppn'] == 0}
                                                <!-- <input type="checkbox" name="status_ppn" class="styled"
                                                onclick="ppnCheck()"> -->
                                            {/if}
                                            PPN :
                                        </label>
                                    </th>
                                    <td class="text-right">Rp <span
                                                id="sum-ppn-text">{$ppn_total|number_format:0}</span></td>
                                </tr>


                                <tr>
                                    <th>Total :</th>
                                    <td class="text-right text-danger">
                                        <h6>Rp <span
                                                    id="sum-grand_total-text">{($total+$ppn_total)|number_format:0} </span>
                                        </h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right text-warning">
                                      * <i>Plafon maksimal per faktur Rp {$master->plafond|number_format:0}</i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn-group right-box">
                                <button type="submit" name="save" class="btn block full-width btn-success"><i
                                            class="icon-checkmark">
                                    </i> Proses
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /panel body -->
            </form>
        {/if}
        </div>
    </div>
    <!-- /default panel -->


    <!-- Default modal -->
    <div id="default-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Daftar Product</h4>
                </div>

                <!-- New invoice template -->
                {if $product_storage}
                    <div class="panel panel-default">
                        <div class="datatable-tools">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Name</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Isi</th>
                                    <th>Merek</th>
                                    <th>Ukuran</th>
                                    <th>Stok</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $product_storage as $products }
                                    <tr>
                                        <td>{$products['barcode']}</td>
                                        <td>{$products['name']}</td>
                                        <td>{$products['category']}</td>
                                        <td>{$products['unit']}</td>
                                        <td>{$products['value']}</td>
                                        <td>{$products['brand']}</td>
                                        <td>{$products['size']}</td>
                                        <td>{$products['stock']}</td>
                                        <td>
                                            <a href="#" onclick="idParam({$products['id_product']})"
                                               class="button btn btn-info  btn-icon" data-dismiss="modal">
                                                <i class="icon-cart-add"></i>
                                            </a>

                                        </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>
                {/if}
                <!-- /new invoice template -->
            </div>
        </div>
    </div>
    <!-- /default modal -->
{/block}

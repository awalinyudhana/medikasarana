{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <script type="text/javascript" xmlns="http://www.w3.org/1999/html">
        var data_storage = {$product_storage|@json_encode};
    </script>
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Retail</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Retail
                    <small class="display-block">Informasi umum tentang proses retail</small>
                </h6>
            </div>

            <!-- Callout -->
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$error}</p>
                </div>
            {/if}
            <!-- /callout -->
            <div class="row">
                <div class="col-md-4">
                    <form action="{current_url()}" role="form" method="post">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Barcode: </label>

                                <div class="col-md-8">
                                    <input type="hidden" name="id_product_store" value="{set_value('id_product_store')}"
                                           id="input-id_product_store">
                                    <input type="text" name="barcode" value="{set_value('barcode')}" id="input-barcode"
                                           class="form-control" accesskey="submit" placeholder="Scan barcode"
                                           autofocus>
                                </div>
                            </div>
                        </div>
                        {*<div class="form-group">*}
                        {*<div class="row">*}
                        {*<label class="col-sm-4 control-label">Qty: </label>*}

                        {*<div class="col-md-4 {if form_error('qty')}has-warning{/if}">*}
                        {*<input type="number" name="qty" value="{set_value('qty')}" id="input-qty"*}
                        {*class="form-control" placeholder="0">*}
                        {*</div>*}
                        {*</div>*}
                        {*</div>*}

                        <div class="col-sm-12">
                        <input type="submit" class="btn btn-block btn-success" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="col-md-1">
                    <a data-toggle="modal" role="button" href="#default-modal"
                       class="button btn btn-info ">Cari
                    </a>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Produk</label>
                            <h6 id="text-name"></h6>
                        </div>
                        <div class="col-md-3">
                            <label>Kategori:</label>
                            <h6 id="text-category"></h6>
                        </div>
                        <div class="col-md-3">
                            <label>Merek</label>
                            <h6 id="text-brand"></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label>Satuan:</label>
                            <h6 id="text-unit"></h6>
                        </div>
                        <div class="col-md-3">
                            <label>Isi Satuan:</label>
                            <h6 id="text-value"></h6>
                        </div>
                        <div class="col-md-3">
                            <label>Ukuran</label>
                            <h6 id="text-size"></h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <h3 class="text-danger text-semibold">Harga</h3>

                    <h3 class="text-success text-semibold" id="text-sell_price"></h3>
                </div>

            </div>
            <hr>
            <!-- /panel body -->


            {if $items}
                <div class="table-responsive pre-scrollable">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Merek</th>
                            <th>Satuan / isi</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            {*<th>Diskon</th>*}
                            <th>Subtotal</th>
                            <th>Action</th>
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
                                <td>{$key['unit']} / {$key['value']}</td>
                                <td style="width:100px;">
                                    <input type="number" id="qty-{$key['id_product_store']}" value="{$key['qty']}"
                                           class="form-control" onkeypress="qtyKeyPress({$key['id_product_store']},
                                            '{base_url('retail/update')}',event)">
                                </td>
                                <td style="width:130px;" class="text-right">
                                    Rp {$key['sell_price']|number_format:0}
                                </td>
                                {*<td style="width:130px;" class="text-right">*}
                                {*Rp {$key['discount']|number_format:0}*}
                                {*</td>*}
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * $key['sell_price'] - $key['discount_total'])|number_format:0}
                                </td>
                                <td style="width:90px;">

                                    <div class="table-controls">
                                        <a class="btn btn-link btn-icon btn-xs tip" title="Update Qty"
                                           onclick="updateQty({$key['id_product_store']},
                                                   '{base_url('retail/update')}')">
                                            <i class="icon-pencil3"></i></a>
                                        <a href="{base_url('retail/delete')}/{$key['id_product_store']}"
                                           class="btn btn-link btn-icon btn-xs tip" title="Hapus Data">
                                            <i class="icon-remove3"></i></a>
                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+($key['qty'] * $key['sell_price'] - $key['discount_total'])}

                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <form action="{base_url('retail/save')}" role="form" method="post"
                      onsubmit="return confirm('Process Data');">

                    <input type="hidden" name="total" value="{$total}">
                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <h6>Total:</h6>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right">Rp
                                        <span id="sum-total-text"> {$total|number_format:0} </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Diskon:</th>
                                    <td class="text-right" style="max-width: 135px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>

                                            <input type="text" name="discount_price" value="{set_value('discount_price')}"
                                                   class="form-control currency-format" placeholder="0"
                                                   id="input-discount_price" onblur="setDpp(this.value)">

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>DPP:</th>
                                    <td class="text-right"> Rp
                                        <span id="sum-dpp-text"> {$total|number_format:0} </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="radio">
                                            <input type="checkbox" name="status_ppn" class="styled"
                                                   onclick="ppnCheck()">
                                            PPN 10 %
                                        </label>
                                    </th>
                                    <td class="text-right">Rp <span id="sum-ppn-text"></span></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-success">
                                        <h6>Rp <span id="sum-grand_total-text">{$total|number_format:0} </span></h6>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Jumlah Bayar:</th>
                                    <td class="text-right {if form_error('bayar')}has-warning{/if}"
                                        style="max-width: 135px;">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp</span>

                                            <input type="text" name="bayar" value="{set_value('bayar')}"
                                                   class="form-control currency-format" placeholder="0"
                                                   id="input-bayar" onblur="setBayar(this.value)">

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Kembali:</th>
                                    <td class="text-right text-danger">
                                        <h6>Rp <span id="sum-returns-text"> </span></h6>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn-group pull-right">
                                <button type="submit" name="save" class="btn btn-success"><i class="icon-checkmark">
                                    </i> Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            {/if}
        </div>
        <!-- /panel body -->
    </div>
    <!-- /default panel -->


    <!-- Default modal -->
    <div id="default-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Daftar Produk</h4>
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
                                    {*<th>Kategori</th>*}
                                    <th>Satuan</th>
                                    <th>Isi</th>
                                    <th>Merek</th>
                                    <th>Ukuran</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach $product_storage as $products }
                                    <tr>
                                        <td>{$products['barcode']}</td>
                                        <td>{$products['name']}</td>
                                        {*<td>{$products['category']}</td>*}
                                        <td>{$products['unit']}</td>
                                        <td>{$products['value']}</td>
                                        <td>{$products['brand']}</td>
                                        <td>{$products['size']}</td>
                                        <td>{$products['stock_retail']}</td>
                                        <td>Rp {$products['sell_price']|number_format:0}</td>
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

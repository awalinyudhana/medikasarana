{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Product Return</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Product Return
                    <small class="display-block">Informasi umum tentang Product Return</small>
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
                <div class="form-group">
                    <div class="col-sm-6">
                        <a class="btn btn-info"
                           tabindex="1" data-toggle="modal" role="button" href="#default-modal">Tambah Produk</a>
                    </div>
                </div>
            </div>
            <br>


        {if $items}
            <form action="{base_url('product-returns/save')}" role="form" method="post"
                  onsubmit="return confirm('Process Data');">
                <div class="table-responsive pre-scrollable">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Satuan</th>
                            <th>Isi</th>
                            <th>Merek</th>
                            <th>Stok</th>
                            <th>Ukuran</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>
                                    {$val}
                                </td>

                                <td>{$key['barcode']}</td>
                                <td>{$key['name']}</td>
                                <td>{$key['unit']}</td>
                                <td>{$key['value']}</td>
                                <td>{$key['brand']}</td>
                                <td>{$key['stock']}</td>
                                <td>{$key['size']}</td>
                                <td width="120px"> Rp {$key['sell_price']|number_format:0}</td>
                                <td width="90px" class="{if $key['store_stock'] < $key['qty']}has-warning{/if}">
                                    <input type="hidden" name="id_product_store[]" value="{$key['id_product_store']}">
                                    <input type="number" name="qty[]" value="{set_value('qty',$key['qty'])}"
                                           class="form-control"
                                </td>
                                <td>
                                    <div class="table-controls">
                                        <a href="{base_url('product-returns/detail/delete')}/{$key['id_product_store']}"
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
                <br>
                <div class="form-group">
                    <div class="form-actions text-right">
                        <button type="submit" name="save" value="Save" class="btn btn-success"><i
                                    class="icon-checkmark">
                            </i> Process
                        </button>
                        {*<button type="button" name="print" class="btn btn-default"><i class="icon-print2"></i> Print</button>*}
                    </div>
                </div>
            </form>
        {/if}
        </div>
    </div>
    {*<div class="panel-body">*}
    {*<h6>Notes &amp; Information:</h6>*}
    {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
    {*</div>*}


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
                                    <th>Kategory</th>
                                    <th>Satuan</th>
                                    <th>Isi</th>
                                    <th>Merek</th>
                                    <th>Stok</th>
                                    <th>Ukuran</th>
                                    <th>Harga</th>
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
                                        <td>{$products['store_stock']}</td>
                                        <td>{$products['size']}</td>
                                        <td>Rp {$products['sell_price']|number_format:0}</td>
                                        <td>
                                            <a
                                                    class="button btn btn-info  btn-icon"
                                                    onclick="javascript:$('#id-product-store').val({$products['id_product_store']});"
                                                    data-toggle="modal" role="button"
                                                    href="#qty-modal" data-dismiss="modal">
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
    <div id="qty-modal" class="modal fade" tabindex="-2" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Masukkan Jumlah</h4>
                </div>

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="col-md-12 ">

                            <form action="{base_url('product-returns/detail/add')}" role="form" method="post">

                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Qty: </label>

                                        <div class="col-sm-6 {if form_error('qty')}has-warning{/if}">
                                            <input type="hidden" name="id_product_store" id="id-product-store" value="">
                                            <input type="number" value="{set_value('qty')}"
                                                   class="form-control"
                                                   name="qty" id="qty"
                                                   placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-block btn-success" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /default modal -->
{/block}

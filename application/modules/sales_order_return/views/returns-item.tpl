{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <script type="text/javascript" xmlns="http://www.w3.org/1999/html">
        var data_storage = {$product_storage|@json_encode};
    </script>
    <!-- Default panel -->
    <div class="panel panel-default">
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
                            <a href="{base_url('sales-order/returns/list-item')}" class=" button btn btn-warning">
                                <i class="icon-eject"></i>Kembali</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Item Retur
                    <small class="display-block">Data detail item yang akan di retur</small>
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
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
                    <tr>
                        <td>{$detail_item->barcode}</td>
                        <td>{$detail_item->name}</td>
                        <td>{$detail_item->brand}</td>
                        <td>{$detail_item->unit}/{$detail_item->value}</td>
                        <td>{$detail_item->qty}</td>
                        <td>{$detail_item->return}</td>
                        <td class="text-right">Rp {$detail_item->price|number_format:0}</td>
                        <td class="text-right">Rp {$detail_item->discount|number_format:0}</td>
                        <td class="text-right">
                            Rp {($detail_item->qty * ($detail_item->price - $detail_item->discount))|number_format:0}
                        </td>
                    </tr>
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

            <!-- Callout -->
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$error}</p>
                </div>
            {/if}
            <!-- /callout -->
            <form action="{current_url()}" role="form" method="post">
                <input type="hidden" name="id_product" value="{set_value('id_product')}"
                       id="input-id_product">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Qty Retur: </label>
                                <div class="col-md-4 {if form_error('qty_return')}has-warning{/if}">
                                    <input type="number" name="qty_return" value="{set_value('qty_return')}"
                                           id="input-qty_return" class="form-control" placeholder="0" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Barcode: </label>
                                <div class="col-md-8">
                                    <input type="text" name="barcode" value="{set_value('barcode')}" id="input-barcode"
                                           class="form-control" placeholder="Type or scan barcode"
                                           onblur="barcodeParam(this)">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Qty: </label>
                                <div class="col-md-4 {if form_error('qty')}has-warning{/if}">
                                    <input type="number" name="qty" value="{set_value('qty')}" id="input-qty"
                                           class="form-control" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Kembali Uang: </label>
                                <div class="col-md-4 {if form_error('cashback')}has-warning{/if}">
                                    <input type="text" name="cashback" value="{set_value('cashback')}" id="input-cashback"
                                           class="form-control  currency-format" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Keterangan
                                    Retur: </label>
                                <div class="col-md-8  {if form_error('note')}has-warning{/if}">
                                    <textarea rows="4" cols="5" name="note" placeholder="Ket..."
                                              class="elastic form-control">{set_value('note')}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-block btn-success" value="Submit">
                        </div>
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
            </form>
        </div>
    </div>
    <!-- /panel body -->
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
                                    <th>Kategori</th>
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
                                        <td>{$products['category']}</td>
                                        <td>{$products['unit']}</td>
                                        <td>{$products['value']}</td>
                                        <td>{$products['brand']}</td>
                                        <td>{$products['size']}</td>
                                        <td>{$products['stock']}</td>
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
{/block}

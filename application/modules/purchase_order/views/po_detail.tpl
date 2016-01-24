{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <script type="text/javascript">
        var data_storage = {$product_storage|@json_encode};
    </script>
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Order Beli</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Order Beli <small class="display-block">Proses input detail order beli</small>
                </h6>
            </div>
            <div class="row invoice-header">
                <div class="col-sm-4">
                    <h3>{$principal->name}</h3>
                    <span>{$principal->address} - {$principal->zipcode}
                        </br>
                        {$principal->city} - {$principal->state}
                        </br>
                        {$principal->telp1} - {$principal->telp1}
                        </br>
                        {$principal->email}
                    </span>
                </div>

                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li>NPWP <strong>{$principal->npwp}</strong></li>
                        <li>SIUP <strong>{$principal->siup}</strong></li>
                        <li>PBF <strong>{$principal->pbf}</strong></li>
                        <li>PBAK <strong>{$principal->pbak}</strong></li>
                        <li>FAK <strong>{$principal->fak}</strong></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li>No Nota # <strong class="text-danger">{$cache['value']['invoice_number']}</strong></li>
                        <li>PPn status # <strong class="text-info">{$status_ppn}</strong></li>
                        <li>Tanggal Nota Transaksi: <strong>{$cache['value']['date']}</strong></li>
                        <li>Jatuh Tempo Pembayaran: <strong>{$cache['value']['due_date']}</strong></li>
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('purchase-order/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>New Purchase Order</a>
                        </li>
                    </ul>
                </div>
            </div>

        <!-- Callout -->
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h5>Error Message</h5>

                    <p>{$error}</p>
                </div>
            {/if}
        <!-- /callout -->

            <div class="row">
                <div class="col-md-4">
                    <form action="{base_url('purchase-order/detail')}" role="form" method="post">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Barcode: </label>

                                <div class="col-md-8">
                                    <input type="hidden" name="id_product" value="{set_value('id_product')}"
                                           id="input-id_product">
                                    <input type="text" name="barcode" value="{set_value('barcode')}" id="input-barcode"
                                           class="form-control" placeholder="Scan barcode"
                                           autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Qty: </label>

                                <div class="col-md-4 {if form_error('qty')}has-warning{/if}">
                                    <input type="number" name="qty" value="{set_value('qty')}" id="input-qty"
                                           class="form-control catcher" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Harga Beli: </label>

                                <div class="col-md-7 {if form_error('price')}has-warning{/if}">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" name="price"
                                               value="{set_value('price')}"
                                               class="form-control currency-format" placeholder="0">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Diskon: </label>

                                <div class="col-md-7 {if form_error('discount_total')}has-warning{/if}">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" name="discount_total" value="{set_value('discount_total')}"
                                               class="form-control currency-format" placeholder="0">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" name="add_item" class="btn btn-block btn-success" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <a data-toggle="modal" role="button" href="#default-modal"
                               class="button btn btn-info center-block">Cari
                            </a>
                        </div>
                    </div>
                    <br>
                    {*<div class="row">*}
                        {*<div class="col-sm-12">*}
                            {*<a role="button" href="{base_url('product/index/add')}"*}
                               {*class="button btn btn-warning center-block">Tambah Produk*}
                            {*</a>*}
                        {*</div>*}
                    {*</div>*}
                </div>
                <div class="col-md-6">
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
            </div>
        <!-- /panel body -->
         <br>

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
                            <th style="width:90px;">Qty</th>
                            <th style="width:100px;">Harga</th>
                            <th style="width:100px;">Total</th>
                            <th style="width:100px;">Diskon</th>
                            <th style="width:100px;">Total Diskon</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=total value=0}
                        {assign var=total_discount value=0}
                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key['barcode']}</td>
                                <td>{$key['name']}</td>
                                <td>{$key['brand']}</td>
                                <td>{$key['unit']} / {$key['value']}</td>
                                <td>
                                    <input type="number" id="qty-{$key['id_product']}" value="{$key['qty']}"
                                           class="form-control tip" title="enter untuk update qty"
                                           onkeypress="qtyKeyPress({$key['id_product']},
                                                   '{base_url('purchase-order/detail/update')}', event)">
                                </td>
                                <td class="text-right">
                                    Rp {$key['price']|number_format:0}
                                </td>
                                <td class="text-right">
                                    Rp {($key['qty'] * $key['price'])|number_format:0}
                                </td>
                                <td class="text-right">
                                    Rp {$key['discount_total']|number_format:0}
                                </td>
                                <td class="text-right">
                                    Rp {($key['qty'] * $key['discount_total'])|number_format:0}
                                </td>
                                <td style="width:80px;">

                                    <div class="table-controls">
                                        <a class="btn btn-link btn-icon btn-xs tip" title="Update Qty"
                                           onclick="updateQty({$key['id_product']},
                                                   '{base_url('purchase-order/detail/update')}')">
                                            <i class="icon-pencil3"></i></a>
                                        <a href="{base_url('purchase-order/detail/delete')}/{$key['id_product']}"
                                           class="btn btn-link btn-icon btn-xs tip"
                                           onclick="return confirm('Hapus Item?')" title="Hapus Item">
                                            <i class="icon-remove3"></i></a>
                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+($key['qty'] * $key['price'])}
                            {assign var=total_discount value=$total_discount+($key['qty'] * $key['discount_total'])}

                        {/foreach}
                        </tbody>
                    </table>
                </div>
                <br>
                <form action="{base_url('purchase-order/save')}" role="form" method="post" enctype="multipart/form-data"
                      onsubmit="return confirm('Process Data');">
                    <div class="row invoice-payment">
                        <div class="col-sm-4 pull-right">
                            <h6>Summary:</h6>
                            <table class="table">
                                <tbody>
                                    <th>Total:</th>
                                    <td class="text-right">
                                        <span id="sum-total-text"><strong>Rp {$total|number_format:0}</strong> </span>
                                    </td>
                                    <input type="hidden" name="total" value="{$total}">
                                </tr> 
                                <tr>
                                    <th>Diskon:</th>

                                    <td class="text-right">
                                        <span id="sum-discount_price-text">
                                            <strong>Rp {$total_discount|number_format:0}</strong> </span>
                                    </td>
                                    <input type="hidden" name="discount_price" value="{$total_discount}">
                                </tr>

                                {assign var=dpp value=0}
                                {assign var=ppn value=0}
                                {assign var=grand_total value=0}

                                {assign var=dpp value=$total-$total_discount}
				                {if $cache['value']['status_ppn'] == 1}
                                   	{assign var=ppn value=$dpp * 0.1}
                                	<tr>
                                 		<th>DPP:</th>
                                    		<td class="text-right">
                                        		<span id="sum-discount_price-text">
                                            		<strong>Rp {$dpp|number_format:0}</strong> </span>
                                    		</td>
                                    		<input type="hidden" name="dpp" value="{$dpp}">
                                	</tr>

                                	<tr>
                                   		<th>PPN:</th>
                                    		<td class="text-right">
                                        		<span id="sum-discount_price-text">
                                            <strong>Rp {$ppn|number_format:0}</strong> </span>
                                    		</td>
                                    		<input type="hidden" name="ppn" value="{$ppn}">
                                	</tr>
				                {else}
                                    <input type="hidden" name="dpp" value="{$dpp}">
                                    <input type="hidden" name="ppn" value="{$ppn}">
				                {/if}
                                <tr>
                                    {assign var=grand_total value=$total - $total_discount + $ppn}
                                    <th>Grand Total:</th>

                                    <td class="text-right">
                                        <span id="sum-discount_price-text">
                                            <strong>Rp {$grand_total|number_format:0}</strong> </span>
                                    </td>
                                    <input type="hidden" name="grand_total" value="{$grand_total}">
                                </tr>
                                <tr>
                                    <th>Bukti Pembelian:</th>
                                    <td class="text-right text-danger">
                                        <input type="file" name="file" class="styled form-control"
                                               id="report-screenshot">
                                        <span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn-group right-box">
                                <button type="submit" name="save" value="save"
                                        class="btn block full-width btn-success"><i class="icon-checkmark">
                                    </i> Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- /panel body -->
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

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <script type="text/javascript">
        var data_storage = {$product_storage|@json_encode};
        var items = {$items|@json_encode};
    </script>
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Proposal</h6></div>

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
                        <li>PPn status # <strong class="text-info">{$status_ppn}</strong></li>
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('proposal/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Buat Proposal Baru</a>
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

            <div class="row">
                <div class="col-md-4">
                    <form action="{base_url('proposal/detail')}" role="form" method="post">
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
                        {if $cache['value']['type'] == 1}
                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-4 control-label">Qty: </label>

                                    <div class="col-md-4 {if form_error('qty')}has-warning{/if}">
                                        <input type="number" name="qty" value="{set_value('qty',1)}"
                                                {*id="input-qty"*}
                                               class="form-control" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        {/if}

                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Harga: </label>

                                <div class="col-md-7 {if form_error('price')}has-warning{/if}">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" name="price" value="{set_value('price')}"
                                               class="form-control currency-format" placeholder="0" id="input-sell_price">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-sm-4 control-label">Diskon: </label>

                                <div class="col-md-7 {if form_error('discount')}has-warning{/if}">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" name="discount" value="{set_value('discount')}"
                                               class="form-control currency-format"  placeholder="0">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-block btn-success" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="col-sm-12">
                        <a data-toggle="modal" role="button" href="#default-modal"
                           class="button btn btn-info center-block">Cari
                        </a>
                    </div>
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
        </div>
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
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Diskon </th>
                        {if $cache['value']['status_ppn'] == 1}
                            <th>Subtotal</th>
                            <th>Ppn</th>
                        {/if}
                        <th>Total</th>
                        <th>Action</th>
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
                            <td>
                                {$key['qty']}
                            </td>
                            {*{/if}*}
                            <td style="width:130px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:130px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                            {if $cache['value']['status_ppn'] == 1}
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                                </td>
                                <td style="width:130px;" class="text-right">
                                    {assign var=ppn value=$ppn+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn|number_format:0}

                                </td>
                            {/if}
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn)|number_format:0}
                            </td>
                            <td style="width:90px;">

                                <div class="table-controls">
                                    <a data-toggle="modal" class="btn btn-link btn-icon btn-xs tip" title="Update Qty"
                                       href="#update-modal" onclick="updateItem({$key['id_product']})" role="button">
                                        <i class="icon-pencil3"></i></a>
                                    <a href="{base_url('proposal/detail/delete')}/{$key['id_product']}"
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
            <form action="{base_url('proposal/save')}" role="form" method="post"
                  onsubmit="return confirm('Process Data');">
                <div class="panel-body">

                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <h6>Summary:</h6>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>DPP:</th>
                                    <td class="text-right">Rp
                                        <span id="sum-total-text"><strong>{$total|number_format:0}</strong> </span>
                                    </td>
                                </tr>
                                    <tr>
                                        <th>PPn:</th>
                                        <td class="text-right">Rp
                                            <span id="sum-ppn-text"><strong> {$ppn_total|number_format:0}</strong> </span>
                                        </td>
                                    </tr>
                                <tr>
                                    <th>Grand Total:</th>
                                    <td class="text-right text-danger">
                                        <h6>Rp <span id="sum-grand_total-text">{($total+$ppn_total)|number_format:0} </span>
                                        </h6>
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
                </div>
                <!-- /panel body -->
            </form>
        {/if}

        {*<div class="panel-body">*}
        {*<h6>Notes &amp; Information:</h6>*}
        {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
        {*</div>*}
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
                                    {*<th>Kategori</th>*}
                                    <th>Satuan</th>
                                    <th>Isi</th>
                                    <th>Merek</th>
                                    <th>Ukuran</th>
                                    <th>Sell Price</th>
                                    <th>Stok</th>
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
                                        <td>Rp {$products['sell_price']|number_format:0}</td>
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
    <div id="update-modal" class="modal fade" tabindex="-2" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Update Data <span id="update-text-name"></span></h4>
                </div>

                <div class="panel panel-default">

                    <div class="panel-body">

                        <form action="{base_url('proposal/detail/update')}" role="form" method="post">

                            <input type="hidden" name="id_product" id="update-input-id_product">

                            <div class="col-md-12 ">
                                {if $cache['value']['type'] == 1}
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-4 control-label">Qty: </label>

                                            <div class="col-md-7 {if form_error('qty')}has-warning{/if}">
                                                <input type="number" value="{set_value('qty')}" class="form-control"
                                                       name="qty" id="update-input-qty"
                                                       placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                {/if}

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 control-label">Harga: </label>

                                        <div class="col-md-7 {if form_error('price')}has-warning{/if}">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp</span>
                                                <input type="text" name="price" value="{set_value('price')}"
                                                       class="form-control  currency-format" placeholder="0" id="update-input-price">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 control-label">Diskon: </label>

                                        <div class="col-md-7 {if form_error('discount')}has-warning{/if}">
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp</span>
                                                <input type="text" name="discount" value="{set_value('discount')}"
                                                       class="form-control currency-format" placeholder="0" id="update-input-discount">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-block btn-success" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/block}

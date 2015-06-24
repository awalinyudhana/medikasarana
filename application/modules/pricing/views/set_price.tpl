{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">pricing</h6></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-inner">
                        <h6 class="heading-hr">
                            <i class="icon-clipboard"></i> pricing
                            <small class="display-block">Informasi umum tentang proses pricing</small>
                        </h6>
                    </div>

                    {if $error}
                        <div class="callout callout-danger fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{$error}</p>
                        </div>
                    {/if}
                </div>

                <div class="col-md-6">
                    <div class="panel panel-default">

                        <div class="panel-heading"><h6 class="panel-title">Riwayat Harga Beli</h6></div>
                        <div class="panel-body">
                            <div class="datatable-tools">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Principal</th>
                                        <th>Harga Beli</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {foreach $price_movement as $key }
                                        <tr>
                                            <td>{$key->date}</td>
                                            <td>{$key->name}</td>
                                            <td>Rp {$key->buy_price|number_format:0}</td>

                                        </tr>
                                    {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Produk Detail:</h6>

                    <form action="{current_url()}" role="form" method="post">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Barcode:</th>
                                <td class="text-right">{$product->barcode}</td>
                            </tr>
                            <tr>
                                <th>Nama Produk:</th>
                                <td class="text-right">{$product->name}</td>
                            </tr>
                            <tr>
                                <th>Merek:</th>
                                <td class="text-right">{$product->brand}</td>
                            </tr>
                            <tr>
                                <th>Satuan / Isi:</th>
                                <td class="text-right">
                                    {$product->unit} / {$product->value}
                                </td>
                            </tr>
                            <tr>
                                <th>Stok:</th>
                                <td class="text-right">{$product->stock}</td>
                            </tr>
                            <tr>
                                <th>Harga Jual:</th>
                                <td class="text-right {if form_error('sell_price')}has-warning{/if}" width="170px;">
                                    <input type="hidden" name="id_product" value="{$product->id_product}">

                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" value="{set_value('sell_price')}"
                                               class="form-control currency-format"
                                               autofocus="autofocus" name="sell_price" id="sell-price"
                                               placeholder="0">
                                    </div>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="form-actions text-right ">
                            <div class="col-sm-4 pull-right">
                                <input type="submit" value="Update" class="btn btn-success">

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
{/block}

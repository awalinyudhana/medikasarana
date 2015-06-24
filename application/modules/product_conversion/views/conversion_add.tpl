{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    {js('form/custom.js')}
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Product Conversion</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Product Conversion
                    <small class="display-block">Informasi umum tentang Product Conversion</small>
                </h6>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h6 class="panel-title">Product Conversion</h6></div>
                    <div class="panel-body">
                        <form action="{base_url('product-conversion/save')}" role="form" method="post">
                            {if $error}
                                <div class="callout callout-danger fade in">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <p>{$error}</p>
                                </div>
                            {/if}
                            <div class="col-sm-12">
                                <h6>Konversi Dar Produk:</h6>
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
                                        <th>Qty:</th>
                                        <td class="text-right">
                                            <div class="col-sm-8 pull-right {if form_error('qty')}has-warning{/if}">
                                                <input type="number" value="{set_value('qty')}" class="form-control"
                                                       name="qty" id="qty"
                                                       onblur="inputQty(this.value,{$product->value})"
                                                       placeholder="0" autofocus>
                                            </div>
                                            <input type="hidden" name="id_product" value="{$product->id_product}">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-block btn-success" value="Submit">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">

                    <div class="panel-heading"><h6 class="panel-title">Konversi Ke Produk</h6></div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <h6>Rincian Produk:</h6>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Barcode:</th>
                                    <td class="text-right" id="result-barcode">{$product_conversion->barcode}</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk:</th>
                                    <td class="text-right" id="result-name">{$product_conversion->name}</td>
                                </tr>
                                <tr>
                                    <th>Merek:</th>
                                    <td class="text-right" id="result-brand">{$product_conversion->brand}</td>
                                </tr>
                                <tr>
                                    <th>Satuan / Isi:</th>
                                    <td class="text-right" id="result-unit">
                                        {$product_conversion->unit}/{$product_conversion->value}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stok:</th>
                                    <td class="text-right" id="result-stock">{$product_conversion->stock}</td>
                                </tr>
                                <tr>
                                    <th>Stok Tambahan:</th>
                                    <td class="text-right" id="result-qty"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
{/block}

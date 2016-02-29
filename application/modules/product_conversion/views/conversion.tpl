{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Konversi Produk</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Konversi Produk
                    <small class="display-block">Proses konversi satuan produk</small>
                </h6>
            </div>
            <!-- Callout -->

            {if $success}
                <div class="callout callout-success fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$success}</p>
                </div>
            {/if}
            {if $product_storage}
                <div class="panel panel-default">
                    <div class="datatable-tools">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama Produk</th>
                                <th>Kategori Produk</th>
                                <th>Merek</th>
                                <th>Ukuran</th>
                                <th>Satuan</th>
                                <th>Isi</th>
                                <th>Stok</th>
                                <th>Pilihan</th>
                            </tr>
                            </thead>
                            <tbody>
                            {foreach $product_storage as $products }
                                <tr>
                                    <td>{$products['barcode']}</td>
                                    <td>{$products['name']}</td>
                                    <td>{$products['category']}</td>
                                    <td>{$products['brand']}</td>
                                    <td>{$products['size']}</td>
                                    <td>{$products['unit']}</td>
                                    <td>{$products['value']}</td>
                                    <td>{$products['stock']}</td>
                                    <td>
                                        <a href="{base_url('product-conversion/add/')}/{$products['id_product']}"
                                           class="button btn btn-info " data-dismiss="modal"> Konversi
                                        </a>

                                    </td>
                                </tr>

                            {/foreach}
                            </tbody>
                        </table>
                    </div>
                </div>
            {/if}
        </div>
        <!-- /panel body -->

    </div>
{/block}

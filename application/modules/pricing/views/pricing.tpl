{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    {js('function.js')}
    {js('form/conversion.js')}
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Pricing</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Pricing
                    <small class="display-block">Informasi umum tentang proses Pricing</small>
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
                                <th>Name</th>
                                <th>Kategory</th>
                                <th>Satuan</th>
                                <th>Isi</th>
                                <th>Merek</th>
                                <th>Ukuran</th>
                                <th>Harga Jual</th>
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
                                    <td width="120px">
                                        Rp {$products['sell_price']|number_format:0}
                                    </td>
                                    <td>
                                        <a href="{base_url('pricing/setting/')}/{$products['id_product']}"
                                           class="button btn btn-info " data-dismiss="modal"> Update
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
    {*<div class="panel-body">*}
    {*<h6>Notes &amp; Information:</h6>*}
    {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
    {*</div>*}
{/block}

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Card Stock</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Card Stock <small class="display-block">Informasi umum tentang proses purchasing</small>
                </h6>
            </div>
            {if $data_po}
            <div class="panel panel-default">
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>No Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Tanggal Ajuan Stocking</th>
                            <th>Supplier / Prinsipal</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $data_po as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>#{$key->id_po}</td>
                                <td>#{$key->invoice_number}</td>
                                <td>{$key->date}</td>
                                <td>{$key->date_created}</td>
                                <td>{$key->name}</td>
                                <td>
                                    <a href="{base_url('card-stock/detail')}/{$key->id_po}"
                                       class="button btn btn-info " >
                                        <i class="icon-cart-add"></i> Pilih
                                    </a>

                                </td>
                            </tr>

                            {assign var=val value=$val+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
            {/if}
        </div><!-- /panel body -->

        <div class="panel-body">
            <h6>Notes &amp; Information:</h6>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
        </div>
    </div><!-- /default panel -->
{/block}

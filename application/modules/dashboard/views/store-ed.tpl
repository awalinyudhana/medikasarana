{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Informasi Produk yang Akan Kadaluarsa</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i>Informasi Produk yang Akan Kadaluarsa
                </h6>
            </div>
            
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Unit</th>
                        <th>Nilai Satuan</th>
                        <th>Brand</th>
                        <th>Tgl Expired</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=val value=1}
                    {foreach $items as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key->barcode}</td>
                            <td>{$key->name}</td>
                            <td>{$key->category}</td>
                            <td>{$key->unit}</td>
                            <td>{$key->value}</td>
                            <td>{$key->brand}</td>
                            <td>{$key->date_expired}</td>
                            <td>{$key->size}</td>
                            <td>{$key->stock_retail}</td>
                        </tr>
                        {assign var=val value=$val+1}
                    {/foreach}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /default panel -->

{/block}

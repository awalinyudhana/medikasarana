{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Data Produk Toko</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i>Data Produk Toko
                    <small class="display-block">Informasi umum tentang data produk toko</small>
                </h6>
            </div>
            
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Unit</th>
                        <th>Nilai Satuan</th>
                        <th>Merek</th>
                        <th>Harga Retail</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Ukuran</th>
                        <th>AKL/AKD</th>
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
                            <td>Rp {$key->sell_price|number_format:0}</td>
                            <td>{$key->date_expired}</td>
                            <td>{$key->size}</td>
                            <td>{$key->license}</td>
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

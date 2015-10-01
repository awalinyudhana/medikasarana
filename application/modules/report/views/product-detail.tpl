{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pergerakan Harga Produk</h6></div>

            <div class="panel-body">
                <!-- <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Penjualan Retail <small class="display-block">Laporan Penjualan Retail</small>
                    </h6>
                </div> -->
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Prinsipal</th>
                                <th>Tanggal</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
		                        <th>Unit</th>
		                        <th>Nilai Satuan</th>
		                        <th>Merek</th>
		                        <th>Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->principal_name}</td>
                                <td>{$key->date}</td>
                                <td>{$key->product_name}</td>
                                <td>{$key->category}</td>
	                            <td>{$key->unit}</td>
	                            <td>{$key->value}</td>
	                            <td>{$key->brand}</td>
                                <td class="text-right">Rp {$key->buy_price|number_format:0}</td>
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

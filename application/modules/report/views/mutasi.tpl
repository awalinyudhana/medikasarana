{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Mutasi Barang Gudang</h6></div>

            <div class="panel-body">
                <!-- <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Laporan Penjualan Retail <small class="display-block">Laporan Penjualan Retail</small>
                    </h6>
                </div> -->

                <form action="{current_url()}" method="post" role="form">
                    <div class="form-group">
                        <label>Tanggal Opname Gudang : </label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="from-date form-control" name="date_from" placeholder="Tanggal Mutasi" {if isset($from)}value="{$from}"{/if}>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Pilih" class="btn btn-success">
                                <a href="{base_url('report/mutasi')}" class="btn btn-warning">Reset</a>
                            </div>
                            <div class="col-md-4">
                            </div>
                        </div>
                    </div>
                </form>

                <hr>
                <div class="datatable-tools">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Type</th>
                                <th>Prinsipal / Customer</th>
                                <th>Nama Produk</th>
		                        <th>Unit</th>
		                        <th>Nilai Satuan</th>
		                        <th>Merek</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        {assign var=val value=1}
                        {foreach $items as $key }

                            <tr>
                                <td>{$val}</td>
                                <td>{$key->datetime}</td>
                                <td>{$key->type}</td>
                                <td>{$key->name}</td>
                                <td>{$key->product_name}</td>
	                            <td>{$key->unit}</td>
	                            <td>{$key->value}</td>
	                            <td>{$key->brand}</td
                                <td>{$key->qty}</td>
                                <td>{$key->mutasi_note}</td>
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}

                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /default panel -->

{/block}

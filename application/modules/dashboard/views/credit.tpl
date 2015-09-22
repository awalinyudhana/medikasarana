{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Informasi Daftar Hutang</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i> Informasi Daftar Hutang <small class="display-block">Daftar Hutang yang akan jatuh tempo</small>
                    </h6>
                </div>
            </div><!-- /panel body -->


<!-- 
            <div class="table-responsive pre-scrollable">
                <table class="table table-striped table-bordered">
 -->                    
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Nama Prinsipal</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jatuh Tempo</th>
                        <th>Tagihan</th>
                        <th>Terbayar</th>
                        <th>Hutang</th>
                        <th>Bayar</th>
                    </tr>
                    </thead>
                    <tbody>

                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $items as $key }

                        <tr>
                            <td>{$val}</td>
                            <td>{$key->id_purchase_order}</td>
                            <td>{$key->name}</td>
                            <td>{$key->date}</td>
                            <td>{$key->due_date}</td>
                            <td>Rp {$key->grand_total|number_format:0}</td>
                            <td>Rp {$key->paid|number_format:0}</td>
                            <td>Rp {($key->grand_total - $key->paid)|number_format:0}</td>
                            <td>
                                <div class="table-controls">
                                    <a href="{base_url('credit/bill/')}/{$key->id_purchase_order}"
                                       class="btn btn-link btn-icon btn-xs tip" title="Bayar">
                                        <i class="icon-coin"></i>
                                    </a>
                                    <a href="{base_url('credit/detail/')}/{$key->id_purchase_order}"
                                       class="btn btn-link btn-icon btn-xs tip" title="Detail">
                                        <i class="icon-list"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key->grand_total - $key->paid)}
                    {/foreach}

                    </tbody>
                </table>
            </div>

            <div class="panel-body">

                <div class="col-sm-6">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Total</th>
                            <td class="text-right">Rp {$total|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>


            </div>


        </div><!-- /default panel -->

{/block}

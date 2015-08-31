{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">History Hutang</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-coin"></i>History Hutang <small class="display-block">Daftar history Hutang</small>
                    </h6>
                </div>
                <hr>
            </div>
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Nama Principal</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jatuh Tempo</th>
                        <th>Tagihan</th>
                        <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>

                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $po as $key }

                        <tr>
                            <td>{$val}</td>
                            <td>{$key->id_purchase_order}</td>
                            <td>{$key->name}</td>
                            <td>{$key->date}</td>
                            <td>{$key->due_date}</td>
                            <td>Rp {$key->grand_total|number_format:0}</td>
                            <td>
                                <div class="table-controls">
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
        </div><!-- /default panel -->

{/block}

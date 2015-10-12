{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Daftar Order Kirim</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i>Daftar Order Kirim
                    <small class="display-block">Daftar nota order jual yang belum dikirim</small>
                </h6>
            </div>
            {if $success}
                <div class="callout callout-success fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$success}</p>
                </div>
            {/if}
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Proposal</th>
                        <th>No Faktur</th>
                        <th>Nama Customer</th>
                        <th>Tanggal Pembuatan</th>
                        <th>Jatuh Tempo Pengiriman</th>
                        <th>Penanngung Jawab</th>
                        {*<th>Jenis Proposal</th>*}
                        {*<th>PPn Status</th>*}
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=val value=1}
                    {foreach $items as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key->id_proposal}</td>
                            <td>{$key->id_sales_order}</td>
                            <td>{$key->customer_name}</td>
                            <td>{$key->date}</td>
                            <td>{$key->due_date}</td>
                            <td>{$key->staff_name}</td>
                            {*<td>{$array_proposal_type[$key->type]}</td>*}
                            {*<td>{$array_status_ppn[$key->status_ppn]}</td>*}
                            <td>
                                <div class="table-controls">

                                    <a href="{base_url('delivery-order/send')}/{$key->id_sales_order}"
                                       class="button btn btn-success ">
                                        Detail
                                    </a>

                                </div>
                            </td>
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

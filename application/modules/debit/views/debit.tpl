{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    {if $success}
        <div class="callout callout-success fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p>{$success}</p>
        </div>
    {/if}
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Piutang</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-coin"></i> Piutang Info
                    <small class="display-block">Informasi umum tentang proposal</small>
                </h6>
            </div>

            <form action="{current_url()}" method="post" role="form">
                <div class="form-group">
                    <label>Piutang:</label>

                    <div class="row">
                        <div class="col-md-4">
                            {form_dropdown('date',$date,set_value('date'),
                            'data-placeholder="Date" class="select-full" tabindex="1" autofocus')}
                            {if form_error('date')}
                                <span class="label label-block label-danger text-left">{form_error('date') }</span>
                            {/if}
                        </div>
                        <div class="col-md-8">
                            <input type="submit" value="Pilih" class="btn btn-success">
                        </div>
                    </div>
                </div>
            </form>

            <hr>


            <div class="table-responsive pre-scrollable">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Faktur</th>
                        <th>Nama Principal</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jatuh Tempo</th>
                        <th>Tagihan</th>
                        <th>Terbayar</th>
                        <th>Piutang</th>
                        <th>Bayar</th>
                    </tr>
                    </thead>
                    <tbody>

                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $po as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key->id_sales_order}</td>
                            <td>{$key->name}</td>
                            <td>{$key->date}</td>
                            <td>{$key->due_date}</td>
                            <td>Rp {$key->grand_total|number_format:0}</td>
                            <td>Rp {$key->paid|number_format:0}</td>
                            <td>Rp {($key->grand_total - $key->paid)|number_format:0}</td>
                            <td>
                                <div class="table-controls">
                                    <a href="{base_url('debit/bill/')}/{$key->id_sales_order}"
                                       class="btn btn-link btn-icon btn-xs tip" title="Bayar">
                                        <i class="icon-coin"></i>
                                    </a>
                                    <a href="{base_url('debit/detail/')}/{$key->id_sales_order}"
                                       class="btn btn-link btn-icon btn-xs tip icon-c" title="Detail">
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


            <div class="col-sm-6">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Total Piutang Bulan " {set_value('date')} ":</th>
                        <td class="text-right">Rp {$total|number_format:0}</td>
                    </tr>
                    <tr>
                        <th>Total Piutang:</th>
                        <td class="text-right"><h6>Rp {$debit_total|number_format:0}</h6></td>
                    </tr>
                    </tbody>
                </table>

            </div>
            {*<h6>Notes &amp; Information:</h6>*}
            {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}


        </div>


    </div>
    <!-- /default panel -->

{/block}

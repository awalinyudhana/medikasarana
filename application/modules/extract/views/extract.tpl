{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title"><i class="icon-file-zip"></i>Pisah Faktur</h6></div>
        <div class="panel-body">
            <div class="row">
                <form action="{current_url()}" role="form" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Customer :</label>

                        <div class="col-md-4 {if form_error('id_customer')}has-warning{/if}">
                            {form_dropdown('id_customer',$customers,set_value('id_customer'),
                            'data-placeholder="Customer" class="select-full" tabindex="1" autofocus')}
                            {if form_error('id_customer')}
                                <span class="label label-block label-danger text-left">{form_error('id_customer') }</span>
                            {/if}
                        </div>
                        <div class="col-sm-2">
                            <input type="submit" value="Pilih" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <!--Form-->
            {if $items}
                <div class="table-responsive pre-scrollable">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Faktur</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jumlah Tagihan</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_sales_order}</td>
                                <td>{$key->date}</td>
                                <td class="text-right">
                                    Rp {$key->grand_total|number_format:0}</td>
                                <td class="text-center">
                                    <div class="table-controls">
                                        <a href="{base_url('extract/select')}/{$key->id_sales_order}"
                                           class="button btn btn-success ">
                                            Pilih
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            {/if}
        </div>
        <!-- /panel body -->
        <!--table responsive-->
    </div>
    <!-- /default panel -->

{/block}

{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title"><i class="icon-file-zip"></i>Gabung Faktur</h6></div>
        <div class="panel-body">
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$error}</p>
                </div>
            {/if}
            <div class="row">
                <form action="{current_url()}" role="form" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Nama Konsumen :</label>

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
            <!--Form-->
            </div>

            <br>
        <!-- /panel body -->
            {if $items}
            <form action="{base_url('join/select')}/{$id_customer}" role="form" method="post" onsubmit="return confirm('Process Data');">
            <div class="datatable-tools">
                <table class="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>No Faktur</th>
                            <th>No Proposal</th>
                            <th>Status PPN</th>
                            <th>Tanggal Faktur Jual</th>
                            <th>Jumlah Tagihan</th>
                            <th>Pilihan</th>
                        </tr>
                        </thead>
                        <tbody>

                        {assign var=val value=1}
                        {foreach $items as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key->id_sales_order}</td>
                                <td>{$key->id_proposal}</td>
                                <td>{$status_ppn[$key->status_ppn]}</td>
                                <td>{$key->date}</td>
                                <td class="text-right">
                                    Rp {$key->grand_total|number_format:0}</td>
                                <td class="text-center">

                                    <input type="checkbox" name="id_sales_order[]" value="{$key->id_sales_order}" class="styled" />
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                        {/foreach}
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">

                    <div class="row invoice-payment">
                        <div class="col-sm-5 pull-right">
                            <div class="btn-group right-box">
                                <button type="submit" name="save" class="btn block full-width btn-success"><i
                                            class="icon-checkmark">
                                    </i> Gabung Faktur
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /panel body -->
                </form>
            {/if}
        <!--table responsive-->
        </div>
    </div>
    <!-- /default panel -->

{/block}

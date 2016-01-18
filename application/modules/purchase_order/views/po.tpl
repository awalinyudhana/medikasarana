{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Order Beli</h6></div>
            <form action="{current_url()}" role="form" method="post">

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-clipboard"></i> Order Beli <small class="display-block">Proses input detail order beli</small>
                    </h6>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3">Supplier / Principal:</label>

                        <div class="col-sm-4 {if form_error('id_principal')}has-warning{/if}">
                            {form_dropdown('id_principal',$principals,set_value('id_principal'),'data-placeholder="Supplier" class="select-full" tabindex="1" autofocus')}
                            {if form_error('id_principal')}
                                <span class="label label-block label-danger text-left">{form_error('id_principal') }</span>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3">No Nota Pembelian:</label>

                        <div class="col-sm-4 {if form_error('invoice_number')}has-warning{/if}">
                            {form_input('invoice_number', set_value('invoice_number'), 'class="form-control" placeholder="Invoice Number"')}
                            {if form_error('invoice_number')}
                                <span class="label label-block label-danger text-left">{form_error('invoice_number') }</span>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3">Tanggal Nota Pembelian:</label>

                        <div class="col-sm-4 {if form_error('date')}has-warning{/if}">
                            {form_input('date', set_value('date'), 'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3">Jatuh Tempo Pembayaran:</label>

                        <div class="col-sm-4 {if form_error('due_date')}has-warning{/if}">
                            {form_input('due_date', set_value('due_date'), 'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-3">PPn:</label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    {form_radio('status_ppn', '0', TRUE,'class="styled"')}
                                    Non Aktif
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    {form_radio('status_ppn', '1', FALSE,'class="styled"')}
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group ">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-block btn-success" value="Purchase Order">
                        </div>
                    </div>
                </div>
            </div><!-- /panel body -->
        </form>
    </div><!-- /default panel -->
{/block}

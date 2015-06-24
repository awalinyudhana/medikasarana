{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <form action="{current_url()}" role="form" method="post">
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Purchase Order</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-clipboard"></i> Purchase Info <small class="display-block">Informasi umum tentang proses purchasing</small>
                    </h6>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 {if form_error('id_principal')}has-warning{/if}">
                            <label>Supplier / Principal:</label>
                            {form_dropdown('id_principal',$principals,set_value('id_principal'),'data-placeholder="Supplier" class="select-full" tabindex="1" autofocus')}
                            {if form_error('id_principal')}
                                  <span class="label label-block label-danger text-left">{form_error('id_principal') }</span>
                            {/if}
                        </div>
                        <div class="col-md-6 {if form_error('invoice_number')}has-warning{/if}">
                            <label>No Nota Pembelian:</label>
                            {form_input('invoice_number', set_value('invoice_number'), 'class="form-control" placeholder="Invoice Number"')}
                            {if form_error('invoice_number')}
                                <span class="label label-block label-danger text-left">{form_error('invoice_number') }</span>
                            {/if}

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 {if form_error('date')}has-warning{/if}">
                            <label>Tanggal Nota Pembelian:</label>
                            {form_input('date', set_value('date'), 'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                        </div>
                        <div class="col-md-6 {if form_error('due_date')}has-warning{/if}">
                            <label>Jatuh Tempo Pembayaran:</label>
                            {form_input('due_date', set_value('due_date'), 'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                        </div>
                    </div>
                </div>
                <div class="form-actions ">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-block btn-success" value="Purchase Order">
                    </div>
                </div>
            </div><!-- /panel body -->
        </div><!-- /default panel -->
    </form>
{/block}

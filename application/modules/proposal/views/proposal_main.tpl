{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->

    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Create Proposal Penawaran Harga</h6></div>
        <form class="form-horizontal" method="post" role="form" action="{current_url()}">
            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-clipboard"></i> Proposal Info
                        <small class="display-block">Informasi umum tentang proses Proposal Info</small>
                    </h6>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Customer:</label>

                    <div class="col-sm-4  {if form_error('id_customer')}has-warning{/if}">
                        {form_dropdown('id_customer',
                        $customers,
                        set_value('id_customer'),
                        'data-placeholder="Customer Name" class="select-full" tabindex="1" autofocus')}
                        {if form_error('id_customer')}
                            <span class="label label-block label-danger text-left">{form_error('id_customer') }</span>
                        {/if}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3">Type:</label>

                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                {form_radio('type', '0', TRUE,'class="styled"')}
                                Pengadaan
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                {form_radio('type', '1', FALSE,'class="styled"')}
                                Tender
                            </label>
                        </div>
                    </div>
                </div>

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
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-block btn-success" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
{/block}

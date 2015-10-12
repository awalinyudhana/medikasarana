{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <form action="{base_url('report/product-list')}" role="form" method="post">
        <div class="panel panel-default">

            <div class="panel-heading"><h6 class="panel-title">Laporan Pembelian</h6></div>

            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-clipboard"></i>Laporan Pembelian Per Prinsipal <small class="display-block">Ringkasan informasi pembelian per prinsipal</small>
                    </h6>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 {if form_error('id_principal')}has-warning{/if}">
                            <label>Nama Prinsipal : </label>
                            {form_dropdown('id_principal',$principals,set_value('id_principal'),'data-placeholder="Supplier" class="select-full" tabindex="1" autofocus')}
                            {if form_error('id_principal')}
                                  <span class="label label-block label-danger text-left">{form_error('id_principal') }</span>
                            {/if}
                        </div>
                    </div>
                </div>
                <div class="form-actions ">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-block btn-success" value="Pilih">
                    </div>
                </div>
            </div><!-- /panel body -->
        </div><!-- /default panel -->
    </form>
{/block}

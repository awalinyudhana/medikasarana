{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Invoice Retur Retur</h6></div>
                <div class="panel-body">
                    {if flashdata('message')}
                        {assign var=msg value=flashdata('message')}
                        {if $msg['class']=='error'}
                            <div class="callout callout-danger fade in">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <p>{$msg['msg']}</p>
                            </div>
                        {else}
                            <div class="callout callout-success fade in">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <p>{$msg['msg']}</p>
                            </div>
                        {/if}
                    {/if}
                    <form action="{current_url()}" role="form" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Masukkan No Nota:</h6>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">No Faktur: </label>

                                        <div class="col-md-4
                                        col-lg-push-3  {if form_error('id_sales_order_return')}has-warning{/if}">
                                            <input type="text" value="{set_value('id_sales_order_return')}"
                                                   class="form-control"
                                                   autofocus="autofocus" name="id_sales_order_return" id="text-id_sales_order_return"
                                                   placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-actions">
                                            <input type="submit" class="btn btn-block btn-success" value="Submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
{/block}

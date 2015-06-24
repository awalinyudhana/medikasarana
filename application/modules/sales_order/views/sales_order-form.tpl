{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Form Sales Order</h6></div>
                <div class="panel-body">
                    {if $error}
                        <div class="callout callout-danger fade in">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{$error}</p>
                        </div>
                    {/if}
                    <form action="{current_url()}" role="form" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Masukkan No Proposal:</h6>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">No Proposal: </label>

                                        <div class="col-md-4
                                        col-lg-push-3  {if form_error('id_proposal')}has-warning{/if}">
                                            <input type="text" value="{set_value('id_proposal')}"
                                                   class="form-control"
                                                   autofocus="autofocus" name="id_proposal" id="no-nota"
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

{* Extend our master template *}
{extends file="../../../full.tpl"}

{block name=content}
    <div class="login-wrapper">
        <form action="{current_url()}" role="form" method="post">
            <div class="popup-header">
                <a href="#" class="pull-left"></a>
                <span class="text-semibold">User Recovery</span>

                <div class="btn-group pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-question4"></i></a>
                    <ul class="dropdown-menu icons-right dropdown-menu-right">\
                        <li><a href="{base_url('login')}"><i class="icon-info"></i> Login</a></li>
                        {*<li><a href="#"><i class="icon-support"></i> Contact admin</a></li>*}
                    </ul>
                </div>
            </div>
            <div class="well">
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
                <div class="form-group has-feedback">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="email" name="email">
                    <i class="icon-lock form-control-feedback"></i>
                </div>

                <div class="row form-actions">
                    <div class="col-xs-4">
                    </div>

                    <div class="col-xs-8">
                        <button type="submit" class="btn btn-warning pull-right">
                            <i class="icon-unlocked"></i> Reset Password
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
{/block}

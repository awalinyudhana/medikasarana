{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">User Update Profile</h6></div>
        <div class="panel-body">
            <form action="{current_url()}" method="post" role="form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-md-2 control-label">Username:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="{userdata('name')|lower}">
                        {f_error('username')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Password Lama:</label>
                    <div class="col-md-4">
                        <input type="password" class="form-control" name="old_password" placeholder="Password Lama">
                        {f_error('old_password')} {if isset($error)}<span class="help-block" style="color: #FF1E00;">{$error}</span>{/if}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Password Baru:</label>
                    <div class="col-md-4">
                        <input type="password" class="form-control" name="password" placeholder="Password Baru">
                        {f_error('password')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Konfirmasi Password:</label>
                    <div class="col-md-4">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Password Baru">
                        {f_error('password_confirmation')}
                    </div>
                </div>
                <div class="form-actions col-md-2 col-md-offset-4 text-right">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /panel body -->
    </div>
{/block}

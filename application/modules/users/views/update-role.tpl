{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">User Group Roles</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Update User Group Role: {$name_group}
                </h6>
            </div>

            {if $modulesList}
                <form method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6 class="panel-title"><i class="icon-pencil3"></i> Update Group
                                Role</h6></div>
                        <div class="panel-body">

                            <!-- Company General Information -->
                            <div class="block-inner">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Daftar Modul:</label>
                                            {foreach $modulesList as $module}
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="selected_modules[]" class="styled"
                                                               {if in_array($module, $userGroupRoles)}checked="checked"{/if}
                                                               value="{$module}">{$module}
                                                    </label>
                                                </div>
                                            {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions text-left">
                                <input type="submit" value="Simpan" class="btn btn-info">
                                <a href="{base_url('users/group')}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan operasi?');">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            {/if}
        </div>
        <!-- /panel body -->

    </div>
    {*<div class="panel-body">*}
    {*<h6>Notes &amp; Information:</h6>*}
    {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
    {*</div>*}
{/block}

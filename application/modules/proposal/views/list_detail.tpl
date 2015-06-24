{* Extend our master template *}
{extends file="../../../grocery.tpl"}

{block name=head}
    {foreach $output->css_files as $css_file }
        <link type="text/css" rel="stylesheet" href="{$css_file}"/>
    {/foreach}

    {foreach $output->js_files as $js_file }
        <script src="{$js_file}"></script>
    {/foreach}
{/block}
{block name=content}
    <!-- Default panel -->
    <!-- New invoice template -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Proposal Penawaran Cheockout</h6>

            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown">
                    <i class="icon-cog3"></i>
                    <b class="caret"></b>
                </a>
            </div>
        </div>

        <div class="panel-body">

            <div class="row invoice-header">
                <div class="col-sm-6">
                    <h3>{$master->customer_name}</h3>
                    <span>{$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp2}
                        </br>
                        {$master->owner}
                    </span>
                </div>

                <div class="col-sm-3 pull-right">
                    <ul>
                        <li>Jenis Proposal <strong class="text-info pull-right">{$proposal_type}</strong></li>
                        <li>No Proposal # <strong class="text-danger pull-right">{$master->id_proposal}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date_created}</strong></li>
                        <li>PPn status <strong class="text-info pull-right">{$status_ppn}</strong></li>
                    </ul>
                </div>
            </div>
            {$output->output}
        </div>

    </div>
    <!-- /new invoice template -->
    <!-- /default panel -->
{/block}

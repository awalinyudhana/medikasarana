{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

<!-- New invoice template -->
<div class="panel panel-success">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-checkmark3"></i> Product Distribution Invoice</h6>

        <div class="dropdown pull-right">
            <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown">
                <i class="icon-cog3"></i>
                <b class="caret"></b>
            </a>
            {*<ul class="dropdown-menu icons-right dropdown-menu-right">*}
            {*<li><a href="#"><i class="icon-print2"></i> Print invoice</a></li>*}
            {*<li><a href="#"><i class="icon-download"></i> Download invoice</a></li>*}
            {*<li><a href="#"><i class="icon-file-pdf"></i> View .pdf</a></li>*}
            {*<li><a href="#"><i class="icon-stack"></i> Archive</a></li>*}
            {*</ul>*}
        </div>
    </div>

    <div class="panel-body">

        <div class="row invoice-header">
            <div class="col-sm-6">
                <h3>{$distribution->store_name}</h3>
                    <span>{$distribution->address} - {$distribution->zipcode}
                        </br>
                        {$distribution->city} - {$distribution->state}
                        </br>
                        {$distribution->telp}
                        </br>
                        {$distribution->owner}
                    </span>
            </div>

            <div class="col-sm-3 pull-right">
                <ul>
                    <li>ID Distribution # <strong
                                class="text-danger pull-right">{$distribution->id_product_distribution}</strong></li>
                    <li>Staff <strong class="pull-right">{$distribution->staff_name} </strong></li>
                    <li>Date: <strong class="pull-right">{$distribution->date}</strong></li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Satuan</th>
                    <th>Isi</th>
                    <th>Merek</th>
                    <th>Ukuran</th>
                    <th>Harga</th>
                    <th>Qty</th>
                </tr>
                </thead>
                <tbody>
                {assign var=val value=1}
                {foreach $items as $key }
                    <tr>
                        <td>
                            {$val}
                        </td>
                        <td>{$key->barcode}</td>
                        <td>{$key->name}</td>
                        <td>{$key->unit}</td>
                        <td>{$key->value}</td>
                        <td>{$key->brand}</td>
                        <td>{$key->size}</td>
                        <td width="120px"> Rp {$key->sell_price|number_format:0}</td>
                        <td>{$key->qty}</td>
                    </tr>
                    {assign var=val value=$val+1}
                {/foreach}
                </tbody>
            </table>
            <br>
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <div class="btn-group pull-right">
                        <a href="{base_url('product-distribution')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> New Product Distribution</a>
                    </div>
                </div>
            </div>

            <h6>Notes &amp; Information:</h6>
            This invoice contains a incomplete list of items destroyed by the Federation ship Enterprise on Startdate
            5401.6 in an unprovked attacked on a peaceful &amp; wholly scientific mission to Outpost 775.
            The Romulan people demand immediate compensation for the loss of their Warbird, Shuttle, Cloaking Device,
            and to a lesser extent thier troops.
        </div>
    </div>
</div>
    <!-- /new invoice template -->
    {/block}

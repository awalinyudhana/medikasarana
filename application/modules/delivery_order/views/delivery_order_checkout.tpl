{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Sales Order Cheockout</h6>

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

                <div class="col-sm-3">
                    <ul>
                        <li>No Delivery Order <strong class="text-danger pull-right">#{$do->id_delivery_order}</strong>
                        </li>
                        <li>Staff Pengirim <strong class="pull-right">{$do->name} </strong></li>
                        <li>Tanggal Kirim : <strong class="pull-right">{$do->date_sending}</strong></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <ul>
                        <li>No Proposal <strong class="text-danger pull-right">#{$master->id_sales_order}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        {*<li>Jatuh Tempo : <strong class="pull-right">{$master->due_date}</strong></li>*}
                        {*<li>PPn status <strong class="text-info pull-right">{$status_ppn}</strong></li>*}
                    </ul>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody>

                    {assign var=val value=1}
                    {foreach $items as $key }
                        {assign var=ppn value=0}
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {$key['qty_delivered']}
                            </td>

                        </tr>
                        {assign var=val value=$val+1}

                    {/foreach}
                    </tbody>
                </table>
            </div>
                <br>
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <div class="btn-group pull-right">
                        <a href="{base_url('delivery-order')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> New Delivery Order</a>
                        <button type="button" class="btn btn-primary"><i class="icon-print2"></i> Print</button>
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
    <!-- /new invoice template -->
{/block}

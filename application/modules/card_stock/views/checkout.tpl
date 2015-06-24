{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Card Stock Invoice</h6>
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
                <div class="col-sm-4">
                    <h3>{$po->principal_name}</h3>
                    <span>{$po->address} - {$po->zipcode}
                        </br>
                        {$po->city} - {$po->state}
                        </br>
                        {$po->telp1} - {$po->telp1}
                        </br>
                        {$po->email}
                    </span>
                </div>

                <div class="col-sm-4">
                    <ul>
                        <li>Nama Staff Card Stock <strong class="pull-right">{$cs->name} </strong></li>
                        <li>ID Card Stock <strong class="text-danger pull-right">#{$cs->id_card_stock}</strong></li>
                        <li>Tanggal Card Stock: <strong class="pull-right">{$cs->date}</strong></li>
                    </ul>
                </div>

                <div class="col-sm-4">
                    <ul>
                        <li>Nama Staff PO  <strong class="pull-right">{$po->staff_name} </strong></li>
                        <li>No Faktur <strong class="text-danger pull-right">#{$po->id_po}</strong></li>
                        <li>No Nota <strong class="text-danger pull-right">#{$po->invoice_number}</strong></li>
                        <li>Tanggal Pembelian: <strong class="pull-right">{$po->date}</strong></li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Barcode</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Qty</th>
                    <th>Qty Stock</th>
                </tr>
                </thead>
                <tbody>
                {assign var=val value=1}
                {foreach $po_detail as $key }
                    <tr>
                        <td>{$val}</td>
                        <td>{$key['barcode']}</td>
                        <td>{$key['name']}</td>
                        <td style="width:100px;">{$key['unit']} ( {$key['value']} )</td>
                        <td>{$key['qty']}</td>
                        <td>{$key['qty_stock']}</td>
                    </tr>
                    {assign var=val value=$val+1}
                {/foreach}
                </tbody>
            </table>
        </div>
        <div class="panel-body">
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>
                <div class="col-sm-4">
                    <div class="btn-group pull-right">
                        <a href="{base_url('card-stock')}"  class="btn btn-info button"><i class="icon-box-add"></i> New Card Stock</a>
                        <button type="button" class="btn btn-primary"><i class="icon-print2"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /new invoice template -->
{/block}

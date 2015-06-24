{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    {js('function.js')}
    {js('form/po.js')}
    <div class="panel panel-default">

        <div class="panel-heading"><h6 class="panel-title">Card Stock</h6></div>

        <div class="panel-body">
            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-clipboard"></i> Card Stock <small class="display-block">Informasi umum tentang proses purchasing</small>
                </h6>
            </div>
            <div class="row invoice-header">
                <div class="col-sm-6">
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

                <div class="col-sm-6">
                    <ul class="invoice-details">
                        <li>Staff PO <strong class="text-danger">{$po->staff_name}</strong></li>
                        <li>No Faktur <strong class="text-danger">#{$po->id_po}</strong></li>
                        <li>No Nota <strong class="text-danger">#{$po->invoice_number}</strong></li>
                        <li>Tanggal Pembelian: <strong>{$po->date}</strong></li>
                        {*<li>Due Date: <strong>{$po->due_date}</strong></li>*}
                    </ul>
                </div>
            </div>

            <!-- Callout -->
            {if $error}
                <div class="callout callout-danger fade in">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{$error}</p>
                </div>
            {/if}
            <!-- /callout -->
        </div><!-- /panel body -->


        {if !empty($po_detail)}
            <form action="{current_url()}" role="form" method="post"
                  onsubmit="return confirm('Process Data');" >
                <div class="table-responsive pre-scrollable">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Nama Produk</th>
                            <th>Merek</th>
                            <th>Satuan / isi</th>
                            <th>Qty</th>
                            <th>Qty Checked</th>
                        </tr>
                        </thead>
                        <tbody>
                        {assign var=total value=0}
                        {assign var=val value=1}
                        {foreach $po_detail as $key }
                            <tr>
                                <td>{$val}</td>
                                <td>{$key['barcode']}</td>
                                <td>{$key['name']}</td>
                                <td>{$key['brand']}</td>
                                <td>{$key['unit']} / {$key['value']}</td>
                                <td>{$key['qty']}</td>
                                <td  style="width:100px;">
                                    <input name="id_po_detail[]" type="hidden" value="{$key['id_po_detail']}">
                                    {if {$key['stocking_status']} == 1}
                                        {$key['qty_stock']}
                                    {else}
                                        <input name="qty_stock[]" type="number" value="{$key['qty_stock']}" class="form-control">
                                    {/if}

                                    <input name="status[]" type="hidden" value="{$key['stocking_status']}">
                                </td>
                            </tr>
                            {assign var=val value=$val+1}
                            {assign var=total value=$total+($key['qty'] * $key['price'] - $key['discount_total'])}

                        {/foreach}
                        </tbody>
                    </table>
                </div>

                <div class="panel-body">
                    <div class="btn-group pull-right">
                        <button type="submit" name="save" class="btn btn-success">
                            <i class="icon-checkmark"></i> Process
                        </button>
                        {*<button type="button" name="print" class="btn btn-default"><i class="icon-print2"></i> Print</button>*}
                    </div>
                </div><!-- /panel body -->
            </form>
        {/if}



            {*<div class="panel-body">*}
                {*<h6>Notes &amp; Information:</h6>*}
                {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
            {*</div>*}
        </div><!-- /default panel -->
{/block}

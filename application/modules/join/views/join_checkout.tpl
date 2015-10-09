{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i> Order Jual Cheockout</h6>

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
                        <li>No Faktur Baru # <strong class="text-danger pull-right">{$master->id_sales_order}</strong></li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        <li>Jatuh Tempo : <strong class="pull-right">{$master->due_date}</strong></li>
                    </ul>
                </div>
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
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                    <th>Ppn</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>

                {assign var=total value=0}
                {assign var=ppn_total value=0}
                {assign var=val value=1}
                {foreach $items as $key }
                    {assign var=ppn value=0}
                    <tr>
                        <td>{$val}</td>
                        <td>{$key['name']}</td>
                        <td>{$key['brand']}</td>
                        <td>{$key['unit']} / {$key['value']}</td>
                        <td>
                            {$key['qty']}
                        </td>
                        {*{/if}*}
                        <td style="width:100px;" class="text-right">
                            Rp {$key['price']|number_format:0}
                        </td>
                        <td style="width:100px;" class="text-right">
                            Rp {$key['discount']|number_format:0}
                        </td>
                        <td style="width:100px;" class="text-right">
                            Rp {$key['sub_total']|number_format:0}
                        </td>
                            {if $master->status_ppn == 1}
                                {assign var=ppn value=($key['sub_total']*0.1)}
                            {else}
                                {assign var=ppn value=0}
                            {/if}
                        <td style="width:100px;" class="text-right">
                            Rp {$ppn|number_format:0}

                        </td>
                        <td style="width:130px;" class="text-right">
                            Rp {($key['sub_total']+$ppn)|number_format:0}
                        </td>
                    </tr>
                    {assign var=val value=$val+1}
                    {assign var=total value=$total+$key['sub_total']}
                    {assign var=ppn_total value=$ppn_total+ $ppn}

                {/foreach}
                </tbody>
            </table>
        </div>

        <div class="panel-body">
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Total:</th>
                            <td class="text-right">Rp {$total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>PPn:</th>
                            <td class="text-right">Rp {$ppn_total|number_format:0}</td>
                        </tr>

                        <tr>
                            <th>Grand Total:</th>
                            <td class="text-right text-danger">
                                <h6>Rp <span id="sum-grand_total-text">{($total+$ppn_total)|number_format:0} </span>
                                </h6>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-group pull-right">
                        <a href="{base_url('join')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> New Join</a>
                        <!-- <button type="button" class="btn btn-primary"><i class="icon-print2"></i> Print</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /new invoice template -->
{/block}

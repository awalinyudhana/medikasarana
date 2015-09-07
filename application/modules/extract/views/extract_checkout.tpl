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

                <div class="col-sm-3 pull-right">
                    <ul>
                        <li>No Faktur Baru # <strong class="text-danger pull-right">{$master->id_sales_order}</strong>
                        </li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        <li>Jatuh Tempo : <strong class="pull-right">{$master->due_date}</strong></li>
                    </ul>
                </div>
            </div>


            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th width="100px">Qty</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <!-- join faktur -->
                            <th>Subtotal</th>
                            <th>Ppn</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=total_first value=0}
                    {assign var=ppn_total_first value=0}
                    {assign var=val_first value=1}
                    {foreach $items_first as $key }
                        {assign var=ppn_first value=0}
                        <tr>
                            <td>{$val_first}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {$key['qty']}
                            </td>
                            <td style="width:130px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:130px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                                </td>
                                <td style="width:130px;" class="text-right">
                                    {assign var=ppn_first value=$ppn_first+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn_first|number_format:0}

                                </td>
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn_first)|number_format:0}
                            </td>
                            {*<td style="width:90px;">*}

                                {*<div class="table-controls">*}
                                    {*<a href="{base_url('extract/move')}/{$key['reference']}"*}
                                       {*class="button btn btn-success ">*}
                                        {*Pindah*}
                                    {*</a>*}
                                {*</div>*}
                            {*</td>*}
                        </tr>
                        {assign var=val_first value=$val_first+1}
                        {assign var=total_first value=$total_first+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total_first value=$ppn_total_first+$ppn_first}
                    {/foreach}
                    </tbody>
                    {assign var=total_first value=$total_first-$master->discount_price}
                </table>
            </div>
            <div class="row invoice-payment">

                <div class="col-sm-4 pull-right">
                    <h6>Summary:</h6>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>DPP:</th>
                            <td class="text-right">Rp
                                <span id="sum-dpp-text"><strong>{$total_first|number_format:0}</strong> </span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="radio">
                                    PPN 10 %
                                </label>
                            </th>
                            <td class="text-right">Rp <span
                                        id="sum-ppn-text">{$ppn_total_first|number_format:0}</span></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td class="text-right text-danger">
                                <h6>Rp <span
                                            id="sum-grand_total-text">{($total_first+$ppn_total_first)|number_format:0} </span>
                                </h6>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
                        <li>No Faktur Baru # <strong class="text-danger pull-right">{$master_second->id_sales_order}</strong>
                        </li>
                        <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                        <li>Date : <strong class="pull-right">{$master->date}</strong></li>
                        <li>Jatuh Tempo : <strong class="pull-right">{$master->due_date}</strong></li>
                    </ul>
                </div>
            </div>
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Merek</th>
                        <th>Satuan / isi</th>
                        <th width="100px">Qty</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                            <th>Subtotal</th>
                            <th>Ppn</th>
                        <th>Total</th>
                        {*<th>Action</th>*}
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=total_second value=0}
                    {assign var=ppn_total_second value=0}
                    {assign var=val_second value=1}
                    {foreach $items_second as $key }
                        {assign var=ppn_second value=0}
                        <tr>
                            <td>{$val_second}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {$key['qty']}
                            </td>
                            <td style="width:130px;" class="text-right">
                                Rp {$key['price']|number_format:0}
                            </td>
                            <td style="width:130px;" class="text-right">
                                Rp {$key['discount']|number_format:0}
                            </td>
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                                </td>
                                <td style="width:130px;" class="text-right">
                                    {assign var=ppn_second value=$ppn_second+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn_second|number_format:0}

                                </td>
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn_second)|number_format:0}
                            </td>
                            {*<td style="width:90px;">*}

                                {*<div class="table-controls">*}
                                    {*<a href="{base_url('extract/undo')}/{$key['reference']}"*}
                                       {*class="button btn btn-success ">*}
                                        {*Pindah*}
                                    {*</a>*}
                                {*</div>*}
                            {*</td>*}
                        </tr>
                        {assign var=val_second value=$val_second+1}
                        {assign var=total_second value=$total_second+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total_second value=$ppn_total_second+$ppn_second}
                    {/foreach}
                    </tbody>
                    {assign var=total_second value=$total_second-$master->discount_price}
                </table>
            </div>
            <div class="row invoice-payment">
                <div class="col-sm-4 pull-right">
                    <h6>Summary:</h6>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>DPP:</th>
                            <td class="text-right">Rp
                                <span id="sum-dpp-text"><strong>{$total_second|number_format:0}</strong> </span>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="radio">
                                    PPN 10 %
                                </label>
                            </th>
                            <td class="text-right">Rp <span
                                        id="sum-ppn-text">{$ppn_total_second|number_format:0}</span></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td class="text-right text-danger">
                                <h6>Rp <span
                                            id="sum-grand_total-text">{($total_second+$ppn_total_second)|number_format:0} </span>
                                </h6>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <div class="btn-group pull-right">
                        <a href="{base_url('extract')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> Pisah Faktur baru</a>
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

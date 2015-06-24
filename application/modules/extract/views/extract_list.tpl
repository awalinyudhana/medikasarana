{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Sales Order</h6></div>
        <div class="panel-body">
            <div class="row invoice-header">
                <div class="col-sm-4">
                    <h3>{$master->name}</h3>
                    <span>{$master->address} - {$master->zipcode}
                        </br>
                        {$master->city} - {$master->state}
                        </br>
                        {$master->telp1} - {$master->telp1}
                        </br>
                        NPWP : {$master->npwp}
                    </span>
                </div>

                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li class="invoice-status text-right list-unstyled">
                            <a href="{base_url('extract/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Ganti Dengan No Faktur Lain</a>
                        </li>
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
                        {if $cache['value']['status_ppn'] == 1}
                            <th>Subtotal</th>
                            <th>Ppn</th>
                        {/if}
                        <th>Total</th>
                        <th>Action</th>
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
                            {if $cache['value']['status_ppn'] == 1}
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                                </td>
                                <td style="width:130px;" class="text-right">
                                    {assign var=ppn_first value=$ppn_first+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn_first|number_format:0}

                                </td>
                            {/if}
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn_first)|number_format:0}
                            </td>
                            <td style="width:90px;">

                                <div class="table-controls">
                                    <a href="{base_url('extract/move')}/{$key['reference']}"
                                       class="button btn btn-success ">
                                        Pindah
                                    </a>
                                </div>
                            </td>
                        </tr>
                        {assign var=val_first value=$val_first+1}
                        {assign var=total_first value=$total_first+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total_first value=$ppn_total_first+$ppn_first}
                    {/foreach}
                    </tbody>
                    {assign var=total_first value=$total_first}
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
                    {*<div class="btn-group right-box">*}
                    {*<button type="submit" name="save" class="btn block full-width btn-success"><i*}
                    {*class="icon-checkmark">*}
                    {*</i> Checkout*}
                    {*</button>*}
                    {*</div>*}
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
                        {if $cache['value']['status_ppn'] == 1}
                            <th>Subtotal</th>
                            <th>Ppn</th>
                        {/if}
                        <th>Total</th>
                        <th>Action</th>
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
                            {if $cache['value']['status_ppn'] == 1}
                                <td style="width:130px;" class="text-right">
                                    Rp {($key['qty'] * ($key['price'] - $key['discount']))|number_format:0}
                                </td>
                                <td style="width:130px;" class="text-right">
                                    {assign var=ppn_second value=$ppn_second+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn_second|number_format:0}

                                </td>
                            {/if}
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn_second)|number_format:0}
                            </td>
                            <td style="width:90px;">

                                <div class="table-controls">
                                    <a href="{base_url('extract/undo')}/{$key['reference']}"
                                       class="button btn btn-success ">
                                        Pindah
                                    </a>
                                </div>
                            </td>
                        </tr>
                        {assign var=val_second value=$val_second+1}
                        {assign var=total_second value=$total_second+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total_second value=$ppn_total_second+$ppn_second}
                    {/foreach}
                    </tbody>
                    {assign var=total_second value=$total_second}
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
            <div class="row">
                <div class="col-md-2 pull-right text-left">
                    <a href="{base_url('extract/save')}" class="btn block full-width btn-success">
                        <i class="icon-checkmark">
                        </i> Checkout
                    </a>
                </div>
            </div>
            <!-- /panel body -->
        </div>
    </div>
    <!-- /default panel -->
{/block}

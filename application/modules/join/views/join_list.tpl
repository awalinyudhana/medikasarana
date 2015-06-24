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
                            <a href="{base_url('join/delete')}" class=" button btn btn-danger">
                                <i class="icon-eject"></i>Ganti Dengan No Faktur Lain</a>
                        </li>
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
        <!-- /panel body -->


        {if $items}
            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>No Faktur</th>
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
                        {*<th>Action</th>*}
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
                            <td>{$key['id_sales_order']}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td>{$key['unit']} / {$key['value']}</td>
                            <td>
                                {*{if $cache['value']['status_ppn'] == 0}*}
                                    {*<input type="number" id="qty-{$key['id_product']}" value="{$key['qty']}"*}
                                           {*class="form-control" onkeypress="qtyKeyPress({$key['id_product']},*}
                                            {*'{base_url('sales-order/update')}')">*}
                                {*{else}*}
                                    {$key['qty']}
                                {*{/if}*}
                            </td>
                            {*{/if}*}
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
                                    {assign var=ppn value=$ppn+($key['qty'] * ($key['price'] - $key['discount'])*0.1 )}
                                    Rp {$ppn|number_format:0}

                                </td>
                            {/if}
                            <td style="width:130px;" class="text-right">
                                Rp {($key['qty'] * ($key['price'] - $key['discount'])
                                +$ppn)|number_format:0}
                            </td>
                            {*<td style="width:90px;">*}

                                {*<div class="table-controls">*}
                                    {*<a data-toggle="modal" class="btn btn-link btn-icon btn-xs tip" title="Update Qty"*}
                                       {*href="#update-modal" onclick="updateItem({$key['id_product']})" role="button">*}
                                        {*<i class="icon-pencil3"></i></a>*}
                                    {*<a href="{base_url('sales_order/detail/delete')}/{$key['id_product']}"*}
                                       {*class="btn btn-link btn-icon btn-xs tip" title="Hapus Data">*}
                                        {*<i class="icon-remove3"></i></a>*}
                                {*</div>*}
                            {*</td>*}
                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key['qty'] * ($key['price'] - $key['discount']))}
                        {assign var=ppn_total value=$ppn_total+$ppn}

                    {/foreach}
                    </tbody>
                    {assign var=total value=$total-$cache['value']['discount_price']    }
                </table>
            </div>
            <form action="{base_url('join/save')}" role="form" method="post"
                  onsubmit="return confirm('Process Data');">
                <input type="hidden" name="total" value="{$total}">


                    <div class="row invoice-payment">

                        <div class="col-sm-4 pull-right">
                            <h6>Summary:</h6>
                            <table class="table">
                                <tbody>
                                {*<tr>*}
                                    {*<th>Jatuh Tempo:</th>*}
                                    {*<td class="text-right">*}
                                        {*<div class="form-group">*}
                                            {*<div class="row">*}
                                                {*<div class="col-md-12 {if form_error('due_date')}has-warning{/if}">*}
                                                    {*{form_input('due_date', set_value('due_date'),*}
                                                    {*'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}*}
                                                {*</div>*}
                                            {*</div>*}
                                        {*</div>*}
                                    {*</td>*}
                                {*</tr>*}

                                {*<tr>*}
                                    {*<th>Total:</th>*}
                                    {*<td class="text-right">Rp*}
                                        {*<span id="sum-total-text"> {$total|number_format:0} </span>*}
                                    {*</td>*}
                                {*</tr>*}
                                {*<tr>*}
                                    {*<th>Diskon:</th>*}
                                    {*<td class="text-right" style="max-width: 135px;">*}
                                        {*<div class="input-group">*}
                                            {*<span class="input-group-addon">Rp</span>*}

                                            {*<input type="text" name="discount_price" value="{set_value('discount_price',$cache['value']['discount_price'])}"*}
                                                   {*class="form-control currency-format" placeholder="0"*}
                                                   {*id="input-discount_price" onblur="setDpp(this.value)">*}

                                        {*</div>*}
                                    {*</td>*}
                                {*</tr>*}

                                <tr>
                                    <th>DPP:</th>
                                    <td class="text-right">Rp
                                        <span id="sum-dpp-text"><strong>{$total|number_format:0}</strong> </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <label class="radio">
                                            {if $cache['value']['status_ppn'] == 0}
                                                <input type="checkbox" name="status_ppn" class="styled"
                                                       onclick="ppnCheck()">
                                            {/if}
                                            PPN 10 %
                                        </label>
                                    </th>
                                    <td class="text-right">Rp <span
                                                id="sum-ppn-text">{$ppn_total|number_format:0}</span></td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-danger">
                                        <h6>Rp <span
                                                    id="sum-grand_total-text">{($total+$ppn_total)|number_format:0} </span>
                                        </h6>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="btn-group right-box">
                                <button type="submit" name="save" class="btn block full-width btn-success"><i
                                            class="icon-checkmark">
                                    </i> Checkout
                                </button>
                            </div>
                        </div>
                    </div>
                <!-- /panel body -->
            </form>
        {/if}
        </div>

        {*<div class="panel-body">*}
        {*<h6>Notes &amp; Information:</h6>*}
        {*Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.*}
        {*</div>*}
    </div>
    <!-- /default panel -->
{/block}

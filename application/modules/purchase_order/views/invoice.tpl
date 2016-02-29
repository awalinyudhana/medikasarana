{* Extend our master template *}
{extends file="../../../master.tpl"}
{block name=content}
    <!-- New invoice template -->
    <div class="panel panel-success">
        <div class="panel-heading">
            <h6 class="panel-title"><i class="icon-checkmark3"></i>Rangkuman Transaksi</h6>

            <div class="dropdown pull-right">
                <a href="#" class="dropdown-toggle panel-icon" data-toggle="dropdown">
                    <i class="icon-cog3"></i>
                    <b class="caret"></b>
                </a>
            </div>
        </div>

        <div class="panel-body">

            <div class="row invoice-header">
                <div class="col-sm-4">
                    <h3>{$principal->name}</h3>
                    <span>{$principal->address} - {$principal->zipcode}
                        </br>
                        {$principal->city} - {$principal->state}
                        </br>
                        {$principal->telp1} - {$principal->telp1}
                        </br>
                        {$principal->email}
                    </span>
                </div>
                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li>NPWP <strong>{$principal->npwp}</strong></li>
                        <li>SIUP <strong>{$principal->siup}</strong></li>
                        <li>PBF <strong>{$principal->pbf}</strong></li>
                        <li>PBAK <strong>{$principal->pbak}</strong></li>
                        <li>FAK <strong>{$principal->fak}</strong></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <ul class="invoice-details">
                        <li>No Faktur PO <strong class="text-danger"># {$po->id_purchase_order}</strong></li>
                        <li>No Faktur Beli <strong class="text-danger"># {$po->invoice_number}</strong></li>
                        <li>PPN status # <strong class="text-info">{$status_ppn}</strong></li>
                        <li>Staff <strong>{$staff->name} </strong></li>
                        <li>Tanggal Faktur Beli <strong>{$po->date} </strong></li>
                        <li>Jatuh Tempo Pembayaran <strong>{$po->due_date}</strong></li>
                    </ul>
                </div>
            </div>
            <br>

            <div class="datatable-tools">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Produk</th>
                        <th>Merk</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th style="width:100px;">Harga Beli</th>
                        <th style="width:100px;">Sub Total</th>
                        <th style="width:100px;">Diskon</th>
                        <th style="width:100px;">Total Diskon</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var=total value=0}
                    {assign var=val value=1}
                    {foreach $pod as $key }
                        <tr>
                            <td>{$val}</td>
                            <td>{$key['barcode']}</td>
                            <td>{$key['name']}</td>
                            <td>{$key['brand']}</td>
                            <td style="width:100px;">{$key['unit']} ( {$key['value']} )</td>
                            <td>{$key['qty']}</td>
                            <td class="text-right">Rp {$key['price']|number_format:0}</td>
                            <td class="text-right">
                                Rp {($key['qty'] * $key['price'])|number_format:0}</td>
                            <td class="text-right">Rp {$key['discount_total'] / $key['qty']|number_format:0}</td>
                            <td class="text-right">Rp {$key['discount_total']|number_format:0}</td>

                        </tr>
                        {assign var=val value=$val+1}
                        {assign var=total value=$total+($key['qty'] * $key['price'] - $key['discount_total'])}

                    {/foreach}
                    </tbody>
                </table>
            </div>

            <div class="row invoice-payment">
                <div class="col-sm-8">
                </div>

                <div class="col-sm-4">
                    <h6>Ringkasan :</h6>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Total :</th>
                            <td class="text-right">Rp {$po->total|number_format:0}</td>
                        </tr>
                        <tr>
                            <th>Diskon Total :</th>
                            <td class="text-right">Rp {$po->discount_price|number_format:0}</td>
                        </tr>
                        {if $po->status_ppn == 1}
                            <tr>
                                <th>DPP :</th>
                                <td class="text-right">Rp {$po->dpp|number_format:0}</td>
                            </tr>
                            <tr>
                                <th>PPN :</th>
                                <td class="text-right">Rp {$po->ppn|number_format:0}</td>
                            </tr>
                        {/if}
                        <tr>
                            <th>Grand Total :</th>
                            <td class="text-right">Rp {$po->grand_total|number_format:0}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="btn-group pull-right">
                        <a href="{base_url('purchase-order')}"
                           class="btn btn-info button"> <i class="icon-box-add"></i> Order Beli Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /new invoice template -->
{/block}

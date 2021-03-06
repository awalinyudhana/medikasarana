{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

<!-- New invoice template -->
<div class="panel panel-success">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-checkmark3"></i> Rangkuman Transaksi</h6>

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
                <h3>{$master->store_name}</h3>
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
                    <li>ID Distribusi # <strong
                                class="text-danger pull-right">{$master->id_product_return}</strong></li>
                    <li>Staff <strong class="pull-right">{$master->staff_name} </strong></li>
                    <li>Tanggal <strong class="pull-right">{$master->date}</strong></li>
                </ul>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Barcode</th>
                    <th>Nama Produk</th>
                    <th>Merek</th>
                    <th>Ukuran</th>
                    <th>Satuan</th>
                    <th>Isi</th>
                    <th>Jumlah</th>
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
                        <td>{$key->brand}</td>
                        <td>{$key->size}</td>
                        <td>{$key->unit}</td>
                        <td>{$key->value}</td>
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
                        <a href="{base_url('product-returns')}" class="btn btn-info button">
                            <i class="icon-box-add"></i> Distribusi Barang ke Gudang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- /new invoice template -->
    {/block}

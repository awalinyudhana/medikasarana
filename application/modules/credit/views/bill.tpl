{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}

    <!-- Default panel -->
    {if $error}
        <div class="callout callout-danger fade in">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <p>{$error}</p>
        </div>
    {/if}
    <div class="panel panel-default">
        <div class="panel-heading"><h6 class="panel-title">Pembayaran Hutang</h6></div>

        <div class="panel-body">

            <div class="block-inner">
                <h6 class="heading-hr">
                    <i class="icon-file4"></i> Info Hutang
                    <small class="display-block">Form Pembayaran Hutang</small>
                </h6>
            </div>
            <div class="col-sm-12">
                <h6>Rincian Hutang:</h6>

                <div class="table-responsive ">
                    <table class="table table-striped ">
                        <tbody>
                        <tr>
                            <th>No Faktur Beli</th>
                            <td class="text-right">{$po->id_purchase_order}</td>
                            <th>Tagihan</th>
                            <td class="text-right">Rp {$po->grand_total|number_format:0}</td>
                            <th>Tanggal Faktur Beli</th>
                            <td class="text-right text-danger">{$po->date}</td>
                        </tr>
                        <tr>
                            <th>Prinsipal</th>
                            <td class="text-right">{$po->name}</td>
                            <th>Belum Terbayar</th>
                            <td class="text-right">Rp {($po->grand_total - $po->paid)|number_format:0}</td>
                            <th>Tanggal Jatuh Tempo</th>
                            <td class="text-right text-danger">{$po->due_date}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <form class="form-horizontal" method="post" role="form" action="{current_url()}" enctype="multipart/form-data">
            <div class="panel-body">
                <div class="block-inner">
                    <h6 class="heading-hr">
                        <i class="icon-pencil4"></i> Form Pembayaran Hutang
                    </h6>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Jumlah Bayar :</label>

                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" name="amount"
                                   value="{set_value('amount',($po->grand_total - $po->paid))}"
                                   class="form-control currency-format" placeholder="0">
                        </div>
                        {if form_error('amount')}
                            <span class="label label-block label-danger text-left">{form_error('amount') }</span>
                        {/if}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Tipe Pembayaran :</label>

                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                {form_radio('payment_type', 'tunai', TRUE,'class="styled"')}
                                Tunai
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                {form_radio('payment_type', 'bg', FALSE,'class="styled"')}
                                Cek BG
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                {form_radio('payment_type', 'transfer', FALSE,'class="styled"')}
                                Transfer
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Tanggal Penarikan :</label>

                    <div class="col-sm-4 {if form_error('date_withdrawal')}has-warning{/if}">
                        {form_input('date_withdrawal', set_value('date_withdrawal'),
                        'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">No Referensi :</label>

                    <div class="col-sm-4">
                        <input type="text" name="resi_number" value="{set_value('resi_number')}"
                               class="form-control" placeholder="0">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3">Upload Bukti Pembayaran :</label>

                    <div class="col-sm-4">
                        <input type="file" name="file" class="styled">
                        <span class="help-block">Format file yang diterima .gif, .png, .jpg. Maksimal ukuran file 2Mb</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="submit" class="btn btn-block btn-success" value="Proses">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /default panel -->

    <!-- /form components -->

{/block}

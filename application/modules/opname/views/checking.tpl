{* Extend our master template *}
{extends file="../../../master.tpl"}

{block name=content}
    <!-- Default panel -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Stok Opname Gudang</h6></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Detail Produk:</h6>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>Barcode:</th>
                                    <td class="text-right">{$product->barcode}</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk:</th>
                                    <td class="text-right">{$product->name}</td>
                                </tr>
                                <tr>
                                    <th>Merek:</th>
                                    <td class="text-right">{$product->brand}</td>
                                </tr>
                                <tr>
                                    <th>Satuan / Isi:</th>
                                    <td class="text-right">
                                        {$product->unit} / {$product->value}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kadaluarsa</th>
                                    <td class="text-right">
                                        {$product->date_expired} 
                                    </td>
                                </tr>
                                <tr>
                                    <th>Stok Tersedia:</th>
                                    <td class="text-right">{$product->stock}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h6 class="panel-title">Form Opname</h6></div>
                <div class="panel-body">
                    <form action="{base_url('stock-opname/save')}" role="form" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Masukkan Data:</h6>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">Stok Fisik: </label>

                                        <div class="col-md-4
                                        col-lg-push-3  {if form_error('stock_real')}has-warning{/if}">
                                            <input type="hidden" name="id_product" value="{$product->id_product}">
                                            <input type="hidden" name="stock_system" value="{$product->stock}">

                                            <input type="number" value="{set_value('stock_real')}"
                                                   class="form-control" onblur="getDifferent(this.value);"
                                                   autofocus="autofocus" name="stock_real" id="stock-real"
                                                   placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function getDifferent(a) {
                                        var stock_system = {$product->stock};
                                        $("#different-text").html(parseInt(a) - stock_system);
                                    }
                                </script>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">Selisih: </label>

                                        <div class="col-md-4 col-lg-push-3 text-right">
                                            <span id="different-text" class="text-danger"></span> {$product->unit}
                                            / {$product->value}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">Keterangan
                                            Selisih: </label>

                                        <div class="col-md-6 col-lg-push-1 {if form_error('note')}has-warning{/if}">
                                            <textarea rows="4" cols="5" name="note" placeholder="Ket..."
                                              class="elastic form-control">{set_value('note')}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-sm-4 col-lg-push-1 control-label">Tanggal Kadaluarsa: </label>

                                        <div class="col-md-4
                                        col-lg-push-3  {if form_error('expired_date')}has-warning{/if}">
                                           {form_input('expired_date', set_value('expired_date',$product->date_expired), 'class="datepicker-trigger form-control" data-mask="9999-99-99" placeholder"YYYY-MM-dd"')}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-actions">
                                            <a href="{base_url('stock-opname')}" class="btn btn-block btn-danger">Batal</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-actions">
                                            <input type="submit" class="btn btn-block btn-success" value="Submit">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
{/block}

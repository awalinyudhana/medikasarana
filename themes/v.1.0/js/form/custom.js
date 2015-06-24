/**
 * Created by Awalin Yudhana on 27/04/2015.
 */


function getDataProductArray(id, array, key){
    var a = [];
    $.each(array, function (i, b) {
        if (b[key] == id) {
            a = b;
            return false;
        }
    });
    return a;
}

function appendItem(data){
    for (var x in data){
        if (data[x] === parseInt(data[x], 10)){
            value = parseInt(data[x]);
        }
        else{
            value = data[x];
        }

        var id_input = $('#input-'+x);
        var id_text = $('#text-'+x);
        if(id_input.length){
            id_input.val( data[x] );
        }
        if(id_text.length){
            id_text.html( data[x] );
        }

    }
}

function updateItem(param){
    var data = getDataProductArray(param, items, 'id_product');
    for (var x in data){
        if (data[x] === parseInt(data[x], 10)){
            value = parseInt(data[x]);
        }
        else{
            value = data[x];
        }

        console.log(x);
        var id_input = $('#update-input-'+x);
        var id_text = $('#update-text-'+x);
        if(id_input.length){
            id_input.val( data[x] );
        }
        if(id_text.length){
            id_text.html( data[x] );
        }

    }
}

function barcodeParam(param_objt){
    var param = param_objt.value;
    var data = getDataProductArray(param, data_storage, 'barcode');
    appendItem(data);
}

function idParam(param){
    var data = getDataProductArray(param, data_storage, 'id_product');
    appendItem(data);
}


function updateQty(a, url){
    var qty = $('#qty-'+a).val();
    if(qty <= 0 || isNaN(qty)){
        alert("Qty harus lebih dari 0");
        return false;
    }else{
        window.location.href = url+'/'+a+'/'+qty;
    }
}

function qtyKeyPress(a, url, event){
    event = event || window.event;
    if(event.keyCode == 13){
        updateQty(a, url);
        event.preventDefault();
    }
}

function setDpp(param){

    var total = parseInt(convertCurrency($('#sum-total-text').text()));
    var dpp = total - convertCurrency(param);
    $('#sum-dpp-text').html(numberFormat(dpp));
    ppnCheck();
}
function convertCurrency(currency){
    return Number(currency.replace(/[^0-9\.]+/g,""));
}

function numberFormat(number){
    return (number + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function ppnCheck(){
    var input = $('input:checkbox[name=status_ppn]');
    var dpp = parseInt(convertCurrency($('#sum-dpp-text').text()));
    var ppn = 0;


    if(input.prop( "checked" ) == true){
        ppn = 0.1 * dpp;
    }
    $('#sum-ppn-text').html(numberFormat(ppn));
    var total = dpp + ppn;
    $('#sum-grand_total-text').html(numberFormat(total));
    setBayar($('#input-bayar').val());
}

function setBayar(bayar){
    var total = parseInt(convertCurrency($('#sum-grand_total-text').text()));
    $('#sum-returns-text').html(numberFormat(convertCurrency(bayar) - total));

}
function inputQty(a,b){
    var qty_result = a * b;
    $( "#result-qty" ).html( qty_result );
    $( "#result-qty-result" ).val(qty_result);
}
function formatAsCurrency(el){
    el.value = numberFormat(convertCurrency(el.value));
}
function formatAsNumber(el){
    el.value = convertCurrency(el.value);
}

function print_doc() {
    try {
        //Try to print using jsPrintSetup Plug-In in Firefox
        //If it is not installed fall back to default printing
        jsPrintSetup.clearSilentPrint();
        //jsPrintSetup.definePaperSize(6, 6, "na_invoice", "na_invoice_5.5x8.5in", "'US Statement", 8.5 , 5.5, jsPrintSetup.kPaperSizeInches);
        jsPrintSetup.setOption('shrinkToFit', 0);
        jsPrintSetup.setOption('orientation', jsPrintSetup.kPotraitOrientation);
        jsPrintSetup.undefinePaperSize(78);
        jsPrintSetup.definePaperSize(78, 78, 'iso_a5_rotate', 'iso_a5_rotate_210x148mm', 'A5 Rotated', 210, 148, jsPrintSetup.kPaperSizeMillimeters);
        jsPrintSetup.setPaperSizeData(78);
        jsPrintSetup.setSilentPrint(true);
        /** Set silent printing */

            //Choose printer using one or more of the following functions
            //jsPrintSetup.getPrintersList...
            //jsPrintSetup.setPrinter...

            //Set Header and footer...
        jsPrintSetup.setOption('marginTop', 5);
        jsPrintSetup.setOption('marginBottom', 10);
        jsPrintSetup.setOption('marginLeft', 10);
        jsPrintSetup.setOption('marginRight', 10);
        // set page header
        jsPrintSetup.setOption('headerStrLeft', 'My custom header');
        jsPrintSetup.setOption('headerStrCenter', 'top center');
        jsPrintSetup.setOption('headerStrRight', 'top right');
        // set empty page footer
        jsPrintSetup.setOption('footerStrLeft', 'bottom left');
        jsPrintSetup.setOption('footerStrCenter', 'cottom center');
        jsPrintSetup.setOption('footerStrRight', '&PT');

        $('body')
        jsPrintSetup.print();
        jsPrintSetup.setSilentPrint(false);
        /** Set silent printing back to false */
        window.close();
    }
    catch (err) {
        alert(err);
        //Default printing if jsPrintsetup is not available
        //window.print();
        //window.close();
    }

}

$(document).ready(function(){
    $(".currency-format").bind('keyup',function(e){
        formatAsCurrency(this);
    }).bind('blur',function(e){
        formatAsNumber(this);
    });
    $('input').bind('keypress',function (e) {
        if($(this).attr('id') == "input-barcode"){
            barcodeParam(this);
        }
        if(e.keyCode == 13 && $(this).attr('type') != 'submit' && $(this).attr('accesskey') != "submit"){
            $(":input")[$(":input").index(document.activeElement)+ 1].focus();
            e.preventDefault();
        }
    })

    $("#clock").clock({"format":"24"});
});

function addItem(t){
    var a = getDataProductArray(t, data_storage, 'id_product')
    $( "#product-barcode" ).val( a['barcode'] );
    $( "#product-name-text" ).val( a['name'] );
    $( "#product-brand-text" ).val( a['brand'] );
    $( "#product-unit-text" ).val( a['unit'] );
    $( "#product-value-text" ).val( a['value'] );

    $( "#product-id" ).val( a['id_product'] );
    $( "#product-name" ).html( a['name'] );
    $( "#product-unit" ).html(a['unit']+' / '+a['value']);
    $( "#product-brand" ).html(a['brand']);
    $( "#product-category" ).html(a['category']);
    $( "#product-qty-text" ).focus();
}




function leaveTextBarcode(t){
    if(t.value != ''){
        var a = getDataProductArray(t.value, data_storage, 'barcode');
        $( "#product-id" ).val( a['id_product'] );
        $( "#product-name-text" ).val( a['name'] );
        $( "#product-brand-text" ).val( a['brand'] );
        $( "#product-unit-text" ).val( a['unit'] );
        $( "#product-value-text" ).val( a['value'] );

        $( "#product-name" ).html( a['name'] );
        $( "#product-unit" ).html(a['unit']+' / '+a['value']);
        $( "#product-brand" ).html(a['brand']);
        $( "#product-category" ).html(a['category']);
        $( "#product-qty-text" ).focus();

    }

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

function qtyKeyPress(a, url){
    if(event.keyCode == 13){
        updateQty(a, url);
        event.preventDefault();
    }
}
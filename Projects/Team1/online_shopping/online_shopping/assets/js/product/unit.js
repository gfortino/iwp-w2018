//隐藏sku
$(document).ready(function(){
    //检查是否开启sku

    hide_sku();
});


//隐藏SKU 如果没有开启
function hide_sku(){
    var sku_flag=document.getElementById("sku_flag").value; // sku_flag==0时不显示sku, sku==1时显示
    if(sku_flag==0) {
        $(".sku").hide();
    }
}
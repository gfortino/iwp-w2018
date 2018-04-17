//单位选项列表
//由于0是第一个插入的值所以已经是默认选中的了，不用加selected

$(document).ready(function(){
    add_unit_option(0,"个");
    add_unit_option(1,"包");
    add_unit_option(2,"箱");
    add_unit_option(3,"运输箱");
});

function add_unit_option(val,text){
    var option = $("<option>").val(val).text(text);
    $("#unit").append(option);
}

//隐藏SKU 如果没有开启
function hide_sku(){
    var sku_flag=document.getElementById("sku_flag").value; // sku_flag==0时不显示sku, sku==1时显示
    if(sku_flag==0) {
        $(".sku").hide();
    }
}
//该js文件用于验证创建产品-供应商价格的表单


var flag_ref=true;//用flag来验证ref号是否重复，如果重复则终止循环
//添加供应商价格表单
$(function() {//设置起订量只能填写数字
    $("#minimum_qty").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {//设置价格只能填写数字
    $("#suppliers_price").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {//设置税率只能填写数字
    $("#tva_tx_supplier").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {//设置生产周期天数只能填写数字
    $("#delivery_time_days").numericInput({ allowFloat: true, allowNegative: true });
});
//动态查看新增供应商--产品价格栏是否填写
$('#fournisseur').change(function(){
    check_supplier_products();    
});
$('#suppliers_product_ref').keyup(function(){
    check_supplier_products();
});
$('#suppliers_price').keyup(function(){
    check_supplier_products();    
});
$('#minimum_qty').keyup(function(){
    check_supplier_products();    
});

////////////////////////////////
var base_url=document.getElementById("base_url").value+"index.php/";  

function check_supplier_products(){
    var fk_soc=document.getElementById("fournisseur").value;
    if(fk_soc=='-1'||fk_soc==''){ //验证是否选择供应商
        document.getElementById("fournisseur_label").innerHTML='<font color="#8b0000">需要选择供应商</font>';
    }
    else document.getElementById("fournisseur_label").innerHTML='';

    var suppliers_product_ref=document.getElementById("suppliers_product_ref").value;
    if(suppliers_product_ref==''){ //验证是否填写ref号
        document.getElementById("suppliers_product_ref_label").innerHTML='<font color="#8b0000">需要填写ref号</font>';
    }
    else document.getElementById("suppliers_product_ref_label").innerHTML='';
    
    //验证ref号是否重复  
    $.ajax({url: base_url+"Ajax_products/check_product_fournisseur_ref/"+suppliers_product_ref, success: function(result){
        if(result==false){
            document.getElementById("suppliers_product_ref_label").innerHTML='<font color="#8b0000">ref号有重复</font>';
            flag_ref=false;
        }
        else flag_ref=true;
    }});

    var suppliers_price=document.getElementById("suppliers_price").value;
    if(suppliers_price==''){ //验证是否填写价格
        document.getElementById("suppliers_price_label").innerHTML='<font color="#8b0000">需要填写价格</font>';
    }
    else document.getElementById("suppliers_price_label").innerHTML='';

    var minimum_qty=document.getElementById("minimum_qty").value;
    if(minimum_qty==''){ //验证是否填写起订量
        document.getElementById("minimum_qty_label").innerHTML='<font color="#8b0000">需要填写起订量</font>';
    }
    else if(minimum_qty==0){
        document.getElementById("minimum_qty_label").innerHTML='<font color="#8b0000">起订量不能为0</font>';
    }
    else document.getElementById("minimum_qty_label").innerHTML='';
}
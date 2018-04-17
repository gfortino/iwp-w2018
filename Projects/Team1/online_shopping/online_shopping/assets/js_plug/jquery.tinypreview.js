function show_product_preview(fk_product){
    var e = event || window.event;//获得鼠标的位置
    setTimeout(function(){
        //alert(e.screenX);
        //return {'x':e.screenX,'y':screenY}
        posy=e.screenY-80;
        posx=e.screenX-30;
    
        fk_product=fk_product.slice(2);//删掉前面的字符，只留下rowid
        $("#preview_"+fk_product).html();
        $("#preview_"+fk_product).fadeIn(150); 
        $("#preview_"+fk_product).css("top",posy+"px");
        $("#preview_"+fk_product).css("left",posx+"px");
        //alert(fk_product);
        //$(".product_preview").fadeOut();
    }, 600);//过一秒才显示
}
function hide_product_preview(fk_product){
    fk_product=fk_product.slice(2);//删掉前面的字符，只留下rowid    
    $("#preview_"+fk_product).fadeOut(200);
}
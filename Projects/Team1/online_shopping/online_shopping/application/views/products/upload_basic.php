<?php
?>

<div class="col-md-10 col-md-offset-1">

    <h1><?php echo lang('upload_excel')?>基本格式</h1>
    <p>
        上传产品的基本信息
    </p>
    <p>
        注意：条形码类型不填写默认为EAN13<br>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        上传前请务必下载模板
    </p>
    <p>
        下载模板: <a href="<?php echo base_url('/index.php/products/download_excel_example_basic')?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"> 下载</a>
    </p>
    </br>
    <?php echo form_open_multipart('products/upload_excel_basic');?>
    <input type="file" name="userfile" size="20" />&nbsp&nbsp
    <br /><br />
    <font size="5"><b><?php echo $error;?></b></font>
    <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
        <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span> <?php echo lang('upload')?>
    </button>
    </br>
    </br>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_products')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> <?php echo lang('back_to_home')?>
    </button>
    </form>
    <?php print_r($products_array)?>
</div>
<script src="<?php echo base_url()?>assets/js_plug/sweetalert.min.js"></script>


<script>
    $( document ).ready(function() {
        var products_array = <?php echo json_encode($products_array);?>;
        for (var i = 0, len = products_array.length; i < len; i++) {
            console.log(products_array[i]);
            duplication_barcode_alert(products_array[i]['barcode'],products_array[i]['label'],products_array[i]['description'],products_array[i]['barcode_type'],products_array[i]['intrastat'],products_array[i]['price_ttc'],products_array[i]['tva_tx']);

        }
    });

    function duplication_barcode_alert(ref,label,description,barcode_type,barcode,intrastat,price_ttc,tva_tx){
        /*swal(ref+"产品条码重复! 咋办?", {
            buttons: {
                cancel: "跳过",
                改条码: true,
            },
        }).then((value) => {
            switch (value) {
            case "改条码":
                swal("原来的条码 "+ref+"在这输入条码", {
                    content: "input",
                })
                    .then((value) => {
                        $.ajax({url: "../Ajax_products/import_product/"+value+"/"+label+"/"+description+"/"+barcode_type+"/"+value+"/"+intrastat+"/"+price_ttc+"/"+tva_tx, success: function(result){
                            swal('添加成功:'+value);
                        }});
                    //swal('输入的值:'+value);
            });
                break;
            default:
                swal("成功跳过!");
            }
        });*/
        var barcode = prompt(ref+"条码重复，点击确定修改，点击取消跳过", "");
        if(barcode!=null) {
            $.ajax({
                url: "../Ajax_products/import_product/" + barcode + "/" + label + "/" + description + "/" + barcode_type + "/" + barcode + "/" + intrastat + "/" + price_ttc + "/" + tva_tx,
                success: function (result) {
                    alert('添加成功');
                }
            });
        }
    }

    /*select 插件函数*/
    function dataParserA(data, selected) {
        retval = [ { val: "-1" , text: "-" } ];

        data.forEach(function(v){
            if(selected == "-1" && v.val == 3)
                v.selected = true;
            retval.push(v);
        });

        return retval;
    }
    // 获得供应商列表 //json类型数据
    $("#fournisseur").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_fournisseur" , dataParser: dataParserA });
    $("#havoc").show()

    $("#language").tinyselect();


</script>
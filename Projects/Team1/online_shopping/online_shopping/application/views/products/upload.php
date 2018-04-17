<?php
?>

<div class="col-md-10 col-md-offset-1">

    <h1><?php echo lang('upload_excel')?></h1>
    <p>
        如果需要添加供货商，需要上传前选择
    </p>
    <p>
        注意：条形码类型不填写默认为EAN13
    </p>
    <p>
        模板: <a href="<?php echo base_url('/index.php/products/download_excel_example')?>" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"> 下载</a>
    </p>
    </br>
    <?php echo form_open_multipart('products/upload_excel');?>

    <table>
        <tr>
            <td><label><font size="3"><b><?php echo lang('fournisseur');?></b></font></label>&nbsp&nbsp</td>
        <td>
            <span id="fournisseur_td" width="15%">
            <div style="width: 80%; display: inline-block;">
                <select id="fournisseur" name="fournisseur">
                    <option value="">-</option>
                </select>
            <lable id="fournisseur_label"></lable>
            </div>
            </span>
        </td>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td><label><font size="3"><b>语言</b></font></label>&nbsp&nbsp</td>
            <td>
                <select name="language" id="language">
                    <option value="0">中文</option>
                    <option value="1">西班牙语</option>
                    <option value="2">意大利语</option>
                    <option value="3">德语</option>
                    <option value="4">英语</option>
                    <option value="5">法语</option>
                </select>
            </td>
        </tr>
    </table>
    </br>
    </br>
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
</div>

<script>
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
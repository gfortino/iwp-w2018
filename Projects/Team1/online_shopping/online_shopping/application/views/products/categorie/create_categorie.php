<div class="col-md-10 col-md-offset-1">
    <h4 align="center"><?php echo lang('add_new_product');?></h4>
    <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>

    <?php $attributes = array('class' => "form-inline");?>
    <?php echo form_open('products/create_products',$attributes); ?>
    <font color="red"><?php echo validation_errors(); ?></font>

    <table class="table table-hover table-bordered">
        <tr>
            <!--
            <td width="10%">
                <label><?php echo lang('ref');?></label>
            </td>
            <td width="17%" id="ref_td">
                <input type="input" id="ref" name="ref" class="form-control" onkeyup="check_ref(this.value)" required/>
                <label id="ref_label"></label>
            </td>
            -->

            <td width="13%">
                <label><?php echo lang('label');?> zh_CN</label>
            </td>
            <td  colspan="7">
                <input type="input" name="label" class="form-control" required/>
            </td>
        </tr>

        <tr>
            <td>
                <label><?php echo lang('description');?> zh_CN</label>
            </td>
            <td colspan="7">
                <textarea name="description" class="form-control" rows="2" cols="42"></textarea>
            </td>
        </tr>

        <tr>
            <td>
                <label><?php echo lang('barcode');?></label>
            </td>
            <td colspan="7">
                <select class="form-control" name="barcode_type">
                    <option value="6">Code 128</option>
                    <option value="2" selected>EAN13</option>
                    <option value="1">EAN8</option>
                </select>
                <input type="text" name="barcode" onkeyup="check_barcode(this.value)" class="form-control" required/>
                <label id="barcode_label"></label>
            </td>
        </tr>
        <tr>
            <td>
                <label>IntraStat</label>
            </td>
            <td colspan="7">
                <input type="text" name="intrastat" class="form-control"/>
            </td>
        </tr>
    </table>
    <!-- 供货商 -->
    <table class="table table-hover table-bordered">
        <tr>
            <td>
                <label><?php echo lang('fournisseur');?></label>
            </td>
            <td id="fournisseur_td" width="15%">
                <div style="width: 80%; display: inline-block;">
                    <select id="fournisseur" name="fournisseur">
                        <option value="">-</option>
                    </select>
                    <lable id="fournisseur_label"></lable>
                </div>
            </td>
            <td>
                <!-- 供应商产品编码-->
                <label><?php echo lang('suppliers_product_ref');?></label>
            </td>
            <td>
                <input type="input" id="suppliers_product_ref" name="suppliers_product_ref" class="form-control" />
                </br>
                <lable id="suppliers_product_ref_label"></lable>
            </td>
            <td width="15%">
                <!-- 供应商价格-->
                <label><?php echo lang('suppliers_price');?></label>
            </td>
            <td>
                <input id="suppliers_price" name="suppliers_price" class="form-control"/>
                </br>
                <label id="suppliers_price_label"></label>
            </td>

        </tr>
        <tr>
            <td>
                <label><?php echo lang('tva_tx');?>%</label>
            </td>
            <td>
                <input id="tva_tx_supplier" name="tva_tx_supplier" class="form-control"/>
                </br>
                <label id="tva_tx_label"></label>
            </td>
            <td>
                <label><?php echo lang('delivery_time_days');?></label>
            </td>
            <td>
                <input type="number" name="delivery_time_days" class="form-control"/>
            </td>
            <td>
                <!-- 起订量-->
                <label><?php echo lang('minimum_qty');?></label>
            </td>
            <td colspan="2">
                <input width="20" type="number" name="minimum_qty" id="minimum_qty" class="form-control" value="1"/>
                </br>
                <label id="minimum_qty_label"></label>
            </td>
        </tr>
        <tr>
            <td>
                <label><?php echo lang('discount')?></label>
            </td>
            <td>
                <input type="text" name="discount_supplier" class="form-control"/>
            </td>
        </tr>
    </table>

    <table class="table table-hover table-bordered">
        <tr>
            <td>
                <label><?php echo lang('price');?>(含增值税)</label>
            </td>
            <td width="10%">
                <input name="price_ttc" id="price" class="form-control" required/>
            </td>
            <td width="10%">
                <label><?php echo lang('tva_tx');?></label>
            </td>
            <td>
                <select class="form-control" name="tva_tx">
                    <option value="0">0%</option>
                    <option value="7">7%</option>
                    <option value="19" selected>19%</option>
                </select>
            </td>
            <td>
                <label><?php echo lang('cost_price');?></label>
            </td>
            <td>
                <input name="cost_price" id="cost_price" style="width: 60px" class="form-control"/>
            </td>
            <td>
                <label><?php echo lang('price_min_ttc');?></label>
            </td>
            <td>
                <input name="price_min_ttc" id="price_min_ttc" class="form-control"/>
            </td>
        </tr>
        <tr>

            <td>
                <label><?php echo lang('seuil_stock_alerte');?></label>
            </td>
            <td>
                <input name="seuil_stock_alerte" id="seuil_stock_alerte" class="form-control"/>
            </td>
            <td>
                <label><?php echo lang('desired_stock')?></label>
            </td>
            <td colspan="5">
                <input name="desired_stock" id="desired_stock" class="form-control"/>
            </td>
        </tr>

        <tr>
            <td>
                <label><?php echo lang('source_country')?></label>
            </td>
            <td colspan="7">
                <select id="source_country" name="source_country">
                </select>
            </td>
        </tr>

    </table>

    <!--多语言-->
    <!--
    <label data-toggle="collapse" data-target="#lang"><font size="3"><b><?php echo lang('multilingual_label')?></b></font><span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></label>
    </br>
    </br>
    <div id="lang" class="collapse">
        <table class="table table-hover table-bordered">
        </table>
        <table class="table table-hover table-bordered">
        </table>
        <label data-toggle="collapse" data-target="#lang_plus"><font size="2"><b>更多语言</b></font><span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></label>
        <div id="lang_plus" class="collapse">
            <table class="table table-hover table-bordered">
                <tr>
                </tr>


            </table>
        </div>
    </div>
    -->

    <!--产品自定义属性-->
    <label><font size="5"><b><?php echo lang('extra_fileds')?></b></font></label>
    </br>
    </br>
    <div id="extrafileds" >
        <table class="table table-hover table-bordered">
            <tr>
                <td><label><?php echo lang('brand')?></label></td>
                <td width="25%">
                    <select name="brand" id="brand">
                    </select>
                </td>
                <td colspan="3">
                    <input type="text" id="add_brand_label" class="form-control"/>
                    &nbsp
                    <input type="button" id="add_brand_button" value="<?php echo lang('add')?>" class='btn btn-primary btn-sm'>
                    <label id="info_brand">
                        <!--添加品牌成功或失败显示在这里-->
                        <?php echo lang('add_new_brand_here')?>
                    </label>
                </td>
                <td>
                    <button type="button" onclick="window.location.href='<?php echo base_url("/index.php/products/brands")?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> 品牌管理
                    </button>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('size')?></label></td>
                <td colspan="5">
                    <input type="text" name="size" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?></label></td>
                <td>
                    <input type="text" name="material" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?></label></td>
                <td colspan="3">
                    <input type="text" name="function" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?></label></td>
                <td>
                    <input type="text" name="color" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?></label></td>
                <td>
                    <input type="text" name="caution" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?></label></td>
                <td>
                    <input type="text" name="ingredient" class="form-control"/>
                </td>
            </tr>
        </table>
    </div>
    <!--多语言自定义属性-->
    <label data-toggle="collapse" data-target="#extra_lang"><font size="3"><b><?php echo lang('multilingual')?></b></font><span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></label>
    <div id="extra_lang" class="collapse">
        <table class="table table-hover table-bordered" id="es">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> ES</label>
                </td>
                <td  colspan="4">
                    <input type="input" name="label_es" class="form-control" />
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('description');?> ES</label>
                </td>
                <td colspan="6">
                    <textarea name="description_es" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?>ES</label></td>
                <td>
                    <input type="text" name="material_es" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?>ES</label></td>
                <td colspan="3">
                    <input type="text" name="function_es" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?>ES</label></td>
                <td>
                    <input type="text" name="color_es" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?>ES</label></td>
                <td>
                    <input type="text" name="caution_es" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?>ES</label></td>
                <td>
                    <input type="text" name="ingredient_es" class="form-control"/>
                </td>
            </tr>
        </table>
        <table id="it" class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> IT</label>
                </td>
                <td  colspan="4">
                    <input type="input" name="label_it" class="form-control" />
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('description');?> IT</label>
                </td>
                <td colspan="6">
                    <textarea name="description_it" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?>IT</label></td>
                <td>
                    <input type="text" name="material_it" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?>IT</label></td>
                <td colspan="3">
                    <input type="text" name="function_it" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?>IT</label></td>
                <td>
                    <input type="text" name="color_it" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?>IT</label></td>
                <td>
                    <input type="text" name="caution_it" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?>IT</label></td>
                <td>
                    <input type="text" name="ingredient_it" class="form-control"/>
                </td>
            </tr>
        </table>
        <table id="de" class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> DE</label>
                </td>
                <td  colspan="4">
                    <input type="input" name="label_de" class="form-control" />
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('description');?> DE</label>
                </td>
                <td colspan="6">
                    <textarea name="description_de" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?>DE</label></td>
                <td>
                    <input type="text" name="material_de" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?>DE</label></td>
                <td colspan="3">
                    <input type="text" name="function_de" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?>DE</label></td>
                <td>
                    <input type="text" name="color_de" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?>DE</label></td>
                <td>
                    <input type="text" name="caution_de" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?>DE</label></td>
                <td>
                    <input type="text" name="ingredient_de" class="form-control"/>
                </td>
            </tr>
        </table>
        <table id="en" class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> EN</label>
                </td>
                <td colspan="5">
                    <input type="input" name="label_en" class="form-control" />
                </td>
            </tr>
            <tr>
                <td>
                    <label><?php echo lang('description');?> EN</label>
                </td>
                <td colspan="5">
                    <textarea name="description_en" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?>EN</label></td>
                <td>
                    <input type="text" name="material_en" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?>EN</label></td>
                <td colspan="3">
                    <input type="text" name="function_en" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?>EN</label></td>
                <td>
                    <input type="text" name="color_en" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?>EN</label></td>
                <td>
                    <input type="text" name="caution_en" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?>EN</label></td>
                <td>
                    <input type="text" name="ingredient_en" class="form-control"/>
                </td>
            </tr>
        </table>
        <table id="fr" class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> FR</label>
                </td>
                <td colspan="5">
                    <input type="input" name="label_fr" class="form-control" />
                </td>
            </tr>
            <tr>
                <td>
                    <label><?php echo lang('description');?> FR</label>
                </td>
                <td colspan="5">
                    <textarea name="description_fr" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?>FR</label></td>
                <td>
                    <input type="text" name="material_fr" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('function')?>FR</label></td>
                <td colspan="3">
                    <input type="text" name="function_fr" class="form-control"/>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?>FR</label></td>
                <td>
                    <input type="text" name="color_fr" class="form-control"/>
                </td>
                <td width="10%"><label><?php echo lang('caution')?>FR</label></td>
                <td>
                    <input type="text" name="caution_fr" class="form-control"/>
                </td>
                <td><label><?php echo lang('ingredient')?>FR</label></td>
                <td>
                    <input type="text" name="ingredient_fr" class="form-control"/>
                </td>
            </tr>
        </table>
    </div>

    <!-- 供应商-->
    <table class="table table-hover table-bordered">
    </table>


    <table class="table table-hover table-bordered">
        <tr>
            <td width="8%">
                <?php echo lang('long');?>
            </td>
            <td width="12%">
                <input id="long" name="long" value="0" style="width: 50px" class="form-control"/>m
            </td>
            <td width="6%">
                <?php echo lang('wide');?>
            </td>
            <td width="13%">
                <input id="wide" name="wide" value="0" style="width: 50px" class="form-control"/>m
            </td>
            <td width="8%">
                <?php echo lang('hight');?>
            </td>
            <td width="12%">
                <input id="hight" name="hight" value="0" style="width: 50px" class="form-control"/>m
            </td>
            <td width="10%">
                <?php echo lang('weight');?>
            </td>
            <td>
                <input id="weight" name="weight" value="0" style="width: 50px" class="form-control"/>
                <select class="form-control " name="weight_units">
                    <option value="-3" selected>g</option>
                    <option value="0">kg</option>
                </select>
            </td>
        </tr>

    </table>

    <table class="table table-hover table-bordered">
        <tr>
            <td>
                <label><?php echo lang('categorie');?></label>
            </td>
            <td>
                <span id="categtd">
                    <select name="categ" id="categ">
                        <option value="">-</option>
                    </select>
                </span>
                </br>
                <label id="categ_label"></label>
            </td>
            <td>
                <label><?php echo lang('sub_categorie');?></label>
            </td>
            <td>
                <span id="sous_categtd">
                    <select name="sous_categ" id="sous_categ">
                        <option value="">-</option>
                    </select>
                </span>
                </br>
                <label id="sub_categ_label"></label>
            </td>
        </tr>
        <tr>
            <td width="10%">
                <label><?php echo lang('categ_selected');?></label>
            </td>
            <td colspan="3">
                <div id="sous_categ_div">
                </div>
            </td>
        </tr>
    </table>

    <table class="table table-hover table-bordered">
        <tr>
            <td>
                <label><?php echo lang('note')?></label>
            </td>
            <td>
                <textarea name="note" class="form-control" rows="2" cols="42"></textarea>
            </td>
        </tr>
    </table>

    </br>







    <div align="center">
            <a href="<?php echo base_url('/index.php/products/show_products')?>" class="btn btn-default"><?php echo lang('back_to_home');?></a>
            <input type="submit" id="submit" name="submit" class="btn btn-primary" value="<?php echo lang('create');?>"/>
    </div>
    </form>

</div>

<script src="<?php echo base_url()?>assets/js/number_only_setting.js"></script><!-- 对一些框只能输入数字的设置 -->
<script src="<?php echo base_url()?>assets/js/supplier_product.js"></script><!-- 添加供应商--产品价格的表单验证 -->
<script src="<?php echo base_url()?>assets/js/product/language_option.js"></script><!-- 用户选项，隐藏语言 -->

<script>
    //检查ref号是否重复
    /*
    var ref=false;
    function check_ref(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText==true){
                    document.getElementById("ref_label").innerHTML = "";
                    ref=true;
                    $("#submit").removeAttr("disabled");
                }
                else {
                    document.getElementById("ref_label").innerHTML = "<font color='#8b0000'><b>ref号有重复</b></font>";
                    //document.getElementById("ref_td").style=" border:1px solid #8b0000";
                    ref = false;
                    $("#submit").attr("disabled", true);
                }
            }
        };
        xmlhttp.open("GET", "../Ajax_products/check_ref/"+str, true);
        xmlhttp.send();
    }*/
    //检查条形码是否重复 check if the barcode duplate
    var base_url=document.getElementById("base_url").value+"index.php/";
    var barcode=false;
    function check_barcode(str) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText==true){
                    document.getElementById("barcode_label").innerHTML = "";
                    barcode=true;
                    $("#submit").removeAttr("disabled");
                }
                else {
                    document.getElementById("barcode_label").innerHTML = "<font color='#8b0000'><b>条形码有重复</b></font>";
                    barcode = false;
                    $("#submit").attr("disabled", true);
                }
            }
        };
        xmlhttp.open("GET", "../Ajax_products/check_barcode/"+str, true);
        xmlhttp.send();
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

    var categ_json;
    $.ajax({ type: "GET",
        url: "../Ajax_products/get_categ",
        async: false,
        success : function(json)
        {
            categ_json = json;
        }
    });

    /* 获得categ列表*/
    $("#categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_categ" , dataParser: dataParserA });
    $("#havoc").show()

    /*获得sous_categ列表*/
    /*没有选择categ的时候显示空*/
    $("#sous_categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_sous_categ/-1" , dataParser: dataParserA });
    $("#havoc").show()
    /*categ选择了之后重置表格*/
    $('#categ').on('change', function() { //获得select选则元素之后的值
        //alert( this.value );
        if(fk_parent!='') {
        $("#sous_categ").empty();
        $("#sous_categtd").find("div[class='tinyselect']").remove(); //需要把之前的去掉，注意这里是td 解释：http://m.blog.csdn.net/article/details?id=53930141
        var fk_parent=this.value

        $("#sous_categ").tinyselect({searchCaseSensitive: false, dataUrl: "../Ajax_products/get_sous_categ/" + fk_parent, dataParser: dataParserA});
        $("#havoc").show()
        }
    })

    //获得国家列表
    $("#source_country").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_list_country" , dataParser: dataParserA });
    $("#havoc").show()

    //获得品牌列表
    $("#brand").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_brand" , dataParser: dataParserA });
    $("#havoc").show()
    //添加品牌
    $("#add_brand_button").click(function(){
        var label=$("#add_brand_label").val();
        if(label!=""){
            $.ajax({
                url: "../Ajax_products/add_brand/" +label,
                success: function (result) {
                    $("#add_brand_label").val("");
                    $("#info_brand").html("添加成功");
                },
                error: function (result) {
                    $("#info_brand").html("<font color='#8b0000'>该品牌已存在</font>");
                }
            });
        }
    });

    //添加标签
    var nb_categ=0;
    var categ_array=[];
    $(document).ready(function(){
        $("#sous_categ").change(function(){
            var value=$("#sous_categ").val();
            var name=$( "#sous_categ option:selected" ).text();
            if(value!='-1') {
                if((categ_array.indexOf(name)==-1)&&name!='-') {//判断是否已经添加该标签
                    categ_array.push(name);
                    $("#sous_categ_div").append(function () {
                        nb_categ = nb_categ + 1;
                        return "<input id='categ[" + nb_categ + "]' value='" + name + "' type='button' onclick='remove_sous_categ(this.id,this.value)' class='btn btn-primary'/>&nbsp&nbsp;"
                            + "<input id='sous_categ[" + nb_categ + "]' type='hidden' name='sous_categ[" + nb_categ + "]' value='" + value + "' />";//hidden用于传值
                    });
                }
            }
        });
    });
    $(document).ready(function(){
        $("#categ").change(function(){
            var value=$("#categ").val();
            var name=$( "#categ option:selected" ).text();
            if(value!='-1') {
                if((categ_array.indexOf(name)==-1)) {//判断是否已经添加该标签
                    categ_array.push(name);
                    $("#sous_categ_div").append(function () {
                        nb_categ = nb_categ + 1;
                        return "<input id='categ[" + nb_categ + "]' value='" + name + "' type='button' onclick='remove_sous_categ(this.id,this.value)' class='btn btn-primary'/>&nbsp&nbsp;"
                            + "<input id='sous_categ[" + nb_categ + "]' type='hidden' name='sous_categ[" + nb_categ + "]' value='" + value + "' />";//hidden用于传值
                    });
                }
            }
        });
    });

    function remove_sous_categ(id,name){
        var parent=document.getElementById("sous_categ_div");
        var child=document.getElementById(id);
        var childh=document.getElementById('sous_'+id);//获得hidden标签的id
        parent.removeChild(child);//同时删除categ按钮
        parent.removeChild(childh);//同时删除hidden标签
        Array.prototype.remove = function() {//删除数组内指定元素函数
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };
        categ_array.remove(name);//删除arry中的元素
    }


    // 获得供应商列表 //json类型数据
    $("#fournisseur").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_fournisseur" , dataParser: dataParserA });
    $("#havoc").show()



</script>
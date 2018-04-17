<?php
/**
 * Created by Zherui.
 */
?>
<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>
<div class="col-md-10 col-md-offset-1">
    <h4 align="center"><?php echo lang('info_contact');?></h4>

    <?php $attributes = array('class' => "form-inline");?>
    <?php foreach ($contact as $un_contact): ?>
        <?php echo form_open('contact/edit_contact/'.$un_contact['rowid'],$attributes); ?>
        <input type="hidden" name="rowid" class="form-control" value="<?php echo $un_contact['rowid'];?>"/>
        <table class="table table-hover table-bordered">
            <tr>
                <td><?php echo lang('first_name');?></td>
                <td>
                    <input type="input" name="first_name" value="<?php echo $un_contact['firstname']?>" class="form-control" required/>
                </td>
                <td><?php echo lang('last_name');?></td>
                <td>
                    <input type="input" name="last_name" value="<?php echo $un_contact['lastname']?>" class="form-control" required/>
                </td>
                <td>
                    <?php echo lang('civility');?>
                </td>
                <td colspan="3">
                    <select name="civility" id="civility" class="form-control">
                        <option value="">-</option>
                        <option value="MME" <?php if($un_contact['civility']=="MME") echo "selected"?>><?php echo lang('madame');?></option>
                        <option value="MR" <?php if($un_contact['civility']=="MR") echo "selected"?>><?php echo lang('monsieur');?></option>
                        <option value="MLE" <?php if($un_contact['civility']=="MLE") echo "selected"?>><?php echo lang('mademoiselle');?></option>
                        <option value="MTRE" <?php if($un_contact['civility']=="MTRE") echo "selected"?>><?php echo lang('master');?></option>
                        <option value="DR"<?php if($un_contact['civility']=="DR") echo "selected"?>><?php echo lang('doctor');?></option>
                    </select>
                </td>
            </tr>
            <!--合伙人-->
            <tr>
                <td><?php echo lang('societe')?></td>
                <td colspan="7">
                    <select name="societe" id="societe" value="" class="form-control">
                        <option value="<?php echo $un_contact['societe_rowid']?>"><?php echo $un_contact['societe_nom']?></option>
                    </select>
                </td>
            </tr>

            <tr>
                <td><?php echo lang('poste');?></td>
                <td>
                    <select name="poste" id="poste">
                        <option value="<?php echo $un_contact['poste']?>"><?php echo $un_contact['poste']?></option>
                    </select>
                </td>
                <td>
                    <label><?php echo lang('address');?></label>
                </td>
                <td colspan="7">
                    <textarea name="address" class="form-control" rows="2" cols="42"><?php echo $un_contact['address']?></textarea>
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('zip');?></label>
                </td>
                <td>
                    <input type="number" name="zip" value="<?php echo $un_contact['zip']?>" class="form-control"/>
                </td>
                <td>
                    <label><?php echo lang('town');?></label>
                </td>
                <td>
                    <input type="input" name="town" value="<?php echo $un_contact['town']?>" class="form-control"/>
                </td>
                <td>
                    <label><?php echo lang('pays');?></label>
                </td>
                <td>
                    <select name="fk_pays" id="fk_pays">
                        <option value="<?php echo $un_contact['rowid_pays']?>"><?php echo $un_contact['pays']?></option>
                    </select>
                </td>
                <td>
                    <label><?php echo lang('departement');?></label>
                </td>
                <td>
                <span id="fk_departementd">
                    <select name="fk_departement" id="fk_departement">
                        <option value="<?php echo $un_contact['rowid_departement']?>"><?php echo $un_contact['departement']?></option>
                    </select>
                </span>
                </td>
            </tr>



            <tr>
                <td>
                    <label><?php echo lang('phone_mobile');?></label>
                </td>
                <td>
                    <input type="number" name="phone_mobile" value="" class="form-control" />
                </td>
                <td>
                    <label><?php echo lang('fax');?></label>
                </td>
                <td>
                    <input type="number" name="phone" value="" class="form-control"/>
                </td>
                <td>
                    <label><?php echo lang('email');?></label>
                </td>
                <td>
                    <input type="email" name="email" value="" class="form-control"/>
                </td>
                <td>
                    <label><?php echo lang('skype');?></label>
                </td>
                <td>
                    <input name="skype" value="" class="form-control"/>
                </td>
            </tr>

            <tr>
                <td><?php echo lang('note');?></td>
                <td colspan="7"><textarea name="note" class="form-control" rows="2" cols="42"></textarea></td>
            </tr>
        </table>

        <table class="table table-hover table-bordered">

            <tr>
                <td>
                    <label><?php echo lang('categorie');?></label>
                </td>
                <td>
                <span id="categtd">
                    <select name="categ" id="categ"  onchange="check_categ()">
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
                    <select id="sous_categ" onchange="check_sub_categ()">
                        <option value="">-</option>
                    </select>
                </span>
                    </br>
                    <label id="sub_categ_label"></label>
                </td>
            </tr>
            <tr>
                <td>
                    <label><?php echo lang('categ_selected') ?></label>
                </td>
                <td colspan="8">
                    <div id="sous_categ_div">
                        <?php $nb_categ=0;?>
                        <?php foreach ($categ_selected as $value): ?>
                            <input id="categ[<?php echo $nb_categ?>]" value="<?php echo $value['label'] ?>" type='button' onclick='remove_sous_categ(this.id,this.value)' class='btn btn-primary'/>
                            <input id="sous_categ[<?php echo $nb_categ?>]" type="hidden" name="sous_categ[<?php echo $nb_categ?>]" value="<?php echo $value['rowid']?>"/>
                            <?php $nb_categ=$nb_categ+1;?>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>
    <div align="right">
        <input type="submit" name="submit" class="btn btn-default"value="<?php echo lang('done');?>" />
    </div>
        <a href="<?php echo base_url('/index.php/contact/show_contacts')?>" class="btn btn-default"><?php echo lang('societe_liste');?></a>
    </form>
</div>

<script>
    //显示可选的职位列表
    /*
     var xmlhttp = new XMLHttpRequest();
     xmlhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
     document.getElementById("poste_list").innerHTML = this.responseText;
     }
     };
     xmlhttp.open("GET", "../Ajax_societe/get_poste", true);
     xmlhttp.send();
     */
    /*select 插件函数*/
    function dataParserA(data, selected) {
        retval = [ { val: "" , text: "-" } ];

        data.forEach(function(v){
            if(selected == "-1" && v.val == 3)
                v.selected = true;
            retval.push(v);
        });

        return retval;
    }
    /*选择职位*/

    $("#poste").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_poste" , dataParser: dataParserA });
    $("#havoc").show()


    /* civility 列表*/

    $("#civility").tinyselect({ showSearch: false });

    /*合伙人列表*/
    $("#societe").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_all_societes" , dataParser: dataParserA });
    $("#havoc").show()

    /* 获得国家列表 //json类型数据*/
    $("#fk_pays").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_pays" , dataParser: dataParserA });
    $("#havoc").show()
    //没有选择国家的时候departement显示空
    $("#fk_departement").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_departement/0" , dataParser: dataParserA });
    $("#havoc").show()

    /*select 插件函数 选择地区*/
    /* 获得地区列表 //json类型数据*/
    $('#fk_pays').on('change', function() { //获得select选则元素之后的值
        //alert( this.value );
        $("#fk_departement").empty();
        $("#fk_departementd").find("div[class='tinyselect']").remove(); //需要把之前的去掉，注意这里是td 解释：http://m.blog.csdn.net/article/details?id=53930141
        var fk_pays=this.value
        $("#fk_departement").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_departement/"+fk_pays , dataParser: dataParserA });
        $("#havoc").show()
    })


    /* 获得categ列表*/
    $("#categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_contact_categ" , dataParser: dataParserA });
    $("#havoc").show()

    /*获得sous_categ列表*/
    /*没有选择categ的时候显示空*/
    $("#sous_categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_sous_categ/-1" , dataParser: dataParserA });
    $("#havoc").show()
    /*categ选择了之后重置表格*/
    $('#categ').on('change', function() { //获得select选则元素之后的值
        //alert( this.value );
        if($("#categ").val()!='') {
            $("#sous_categ").empty();
            $("#sous_categtd").find("div[class='tinyselect']").remove(); //需要把之前的去掉，注意这里是td 解释：http://m.blog.csdn.net/article/details?id=53930141
            var fk_parent = this.value
            $("#sous_categ").tinyselect({
                searchCaseSensitive: false,
                dataUrl: "../../Ajax_societe/get_sous_categ/" + fk_parent,
                dataParser: dataParserA
            });
            $("#havoc").show()
        }
        else{//如果大标签选的是空，则小标签也显示空
            $("#sous_categ").empty();
            $("#sous_categtd").find("div[class='tinyselect']").remove(); //需要把之前的去掉，注意这里是td 解释：http://m.blog.csdn.net/article/details?id=53930141
            $("#sous_categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_societe/get_sous_categ/-1" , dataParser: dataParserA });
            $("#havoc").show()
        }
    })


    var nb_categ=0;
    var categ_array=[];
    $(document).ready(function(){
        $("#sous_categ").change(function(){
            var value=$("#sous_categ").val();
            var name=$( "#sous_categ option:selected" ).text();
            if(value!='') {
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
    $(document).ready(function(){
        $("#categ").change(function(){
            var value=$("#categ").val();
            var name=$( "#categ option:selected" ).text();
            if(value!='') {
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



</script>


<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>
<input type="hidden" id="base_url" value="<?php echo base_url()?>"/><!-- 用于js读取本地url -->

<div class="col-md-10 col-md-offset-1">
    <?php foreach ($products as $un_product): ?>
    <input type="hidden" id="rowid" value="<?php echo $rowid;?> "/>
    <table>
        <tr>
            <td rowspan="2" colspan="2">
                <?php show_product_photos($rowid,100)?>&nbsp
            </td>
            <td><font size="10" color="#00008b"><?php echo $un_product['ref'] ?></font></td>
        </tr>
        <tr>
            &nbsp&nbsp
            <td><font size="5"><?php echo $un_product['label'] ?></font></td>
        </tr>
    </table>
    </br>
    <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
    <table class="table table-hover table-bordered">
        <tr>
            <td width="10%"><label>Description</label></td>
            <td  colspan="3">
                <?php echo $un_product['description']?>
            </td>
        </tr>
        <tr>
            <td><label>Price</label></td>
            <td><?php echo number_format($un_product['price'],3)?></td>
        </tr>
        <tr>
            <td>
                <label>Tva_tx</label>
            </td>
            <td>
                <?php echo $un_product['tva_tx'];?>%
            </td>
        </tr>
        <tr>
            <td>
                <label>Stock</label>
            </td>
            <td>
                <?php echo $un_product['stock']?>
            </td>
        </tr>
    </table>
    <!--标签-->
    <!--<table class="table table-hover table-bordered">
        <tr>
            <td width="10%">
                <label><?php echo lang('categ_selected');?></label>
            </td>
            <td>
                <div id="sous_categ_div">
                    <?php foreach ($categ_selected as $value): ?>
                        <input value=<?php echo $value['label'] ?> type='button' class='btn btn-primary disabled'/>
                    <?php endforeach; ?>
                </div>
            </td>
        </tr>
    </table>-->

    <!--备注-->
    <table class="table table-hover table-bordered">
        <tr>
            <td width="10%">
                <label>Note</label>
            </td>
            <td>
                <?php echo $un_product['note'];?>
            </td>
        </tr>
    </table>
    </div>

    <?php endforeach; ?>


    <div align="right">
        <a  href="<?php echo base_url('/index.php/products/create_products') ?>" class="btn btn-default">Add product</a>
        <a  href="<?php echo base_url('/index.php/products/edit_product/').$rowid ?>" class="btn btn-default">Edit</a>
        <a  href="#" data-toggle="modal" data-target="#supprimerm" class="btn btn-danger <?php if(!isset($_SESSION['product_delete_permission'])) echo "disabled"?>">Delete</a>

    </div>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_products')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbspHome
    </button>
</div>

<!-- 删除确认的弹窗-->
<div class="modal fade" id="supprimerm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('delete_confirm');?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo lang('r_u_sure_to_delete');?></p>
                <a href="<?php echo base_url('/index.php/products/delete_by_rowid/'.$rowid)?>" class="btn btn-danger"value="Supprimer" name="Supprimer" ><?php echo lang('yes');?></a>
                <button type="submit" class="btn btn-primary "data-dismiss="modal" aria-label="Close" ><?php echo lang('cancel');?></button>
                </br>
            </div>
        </div>
    </div>
</div>

<script>
    //获得已选categorie列表
    var rowid;
    var label;
    $(document).ready(function(){
        var id=$("#rowid").val();
        $.ajax({url: "../../Ajax_products/get_product_categ/"+id, success: function(result){
            $json_categ=eval(result);
            $.each($json_categ, function() {
                rowid=this.rowid;//这里不是产品的rowid，是这一个价格的rowid
                label=this.label;
                $("#categorie_span").after(function(){
                    return "<h7><span class='label label-primary'>"+label+"</span></h7>&nbsp";
                });
            });
        }});
    });

    //显示竞争对手价格
    /*
    var rowid;
    var price;
    var competencia;
    $(document).ready(function(){
        var id=$("#rowid").val();
        $.ajax({url: "../../Ajax_products/get_precios_competencia_price/"+id, success: function(result){
            json_product_fournisseur=eval(result);
            $.each(json_product_fournisseur, function() {
                rowid=this.rowid;//这里不是产品的rowid，是这一个价格的rowid
                price=this.price;
                competencia=this.competencia;
                $("#precios_competencia_price").after(function(){
                    return "<tr id='tr_"+rowid+"' >"+
                        "<input type='hidden' name='"+competencia+"' value='"+rowid+"'/>"+
                        "<td>"+competencia+"</td>"+
                        "<td>"+price+"</td>"+
                        //"<td width='5%'><input type='button' id ='"+rowid+"' onclick='del_fp(this.id)' class='btn btn-danger btn-sm' value='删除'></td>"+ //不建议在显示信息界面中可以删除
                        "</tr>";
                });
            });
        }});
    });*/

    var best_buying_price;
    //显示供应商———产品价格
    var json_product_fournisseur;
    var ref_fourn;
    var fournisseur;
    var unitprice;
    var tva_tx;
    var delivery_time_days;
    var quantity;
    var discount;
    $(document).ready(function(){
        var id=$("#rowid").val();
        $.ajax({url: "../../Ajax_products/get_fournisseur_product/"+id,
            async:false,//设置成同步
            success: function(result){
            json_product_fournisseur=eval(result);
            best_buying_price=json_product_fournisseur[0]['unitprice']*(100-json_product_fournisseur[0]['discount'])/100;//最佳买价给数组第一个值
            $.each(json_product_fournisseur, function() {
                rowid=this.rowid;//这里不是产品的rowid，是这一个价格的rowid
                ref_fourn=this.ref_fourn;
                fournisseur=this.fournisseur;
                unitprice=this.unitprice;
                tva_tx=this.tva_tx;
                delivery_time_days=this.delivery_time_days;
                quantity=this.quantity;
                discount=this.discount;
                $("#fournisseur_product").after(function(){
                    return "<tr id='tr_"+rowid+"' >"+
                        "<input type='hidden' name='"+fournisseur+"' value='"+rowid+"'/>"+
                        "<td>"+fournisseur+"</td>"+
                        "<td>"+ref_fourn+"</td>"+
                        "<td>"+unitprice+"</td>"+
                        "<td>"+tva_tx+"</td>"+
                        "<td>"+delivery_time_days+"</td>"+
                        "<td>"+quantity+"</td>"+
                        "<td>"+discount+"</td>"+
                        //"<td width='5%'><input type='button' id ='"+rowid+"' onclick='del_fp(this.id)' class='btn btn-danger btn-sm' value='删除'></td>"+ //不建议在显示信息界面中可以删除
                        "</tr>";
                });
                if(best_buying_price>unitprice*(100-discount)/100){
                    best_buying_price=unitprice*(100-discount)/100;
                };
            });
        }});
        $("#best_buying_price").html(best_buying_price);
    });
    //删除供应商——产品价格
    function del_fp(id){
        $.ajax({url: "../../Ajax_products/delete_product_fournisseur_price/"+id, success: function(result){
            $("#tr_"+id).remove();
        }});
    }


    //点击需要编辑的区域后变成可编辑状态
    function click_element(id){
        var id=id.slice(3);
        var value=document.getElementById(id).innerHTML;
        $("#td_"+id).html("<input id='"+id+"' value='"+value+"' onblur='edit_element(this.id,this.value)' class='form-control'/>");
        $("#"+id).focus();
    }
    //确认编辑
    function edit_element(id,value){
        $("#td_"+id).html("<span id='"+id+"' class='element_info' onclick='click_element(this.id)'>"+value+"</span>");
        var rowid=document.getElementById('rowid').value;
        //alert("value"+rowid);
        $.ajax({
            url: "<?php echo base_url().'index.php/'?>Contact/edit_element/"+rowid+"/"+id+"/"+value,
            success: function (result) {
                //$("#"+label_id+"_label").html("设置成功");
                show_snackbar("设置成功",500);
            },
            error: function (result) {
                //$("#"+label_id+"_label").html("错误，设置失败");
                show_snackbar("错误，设置失败",2500);
            }
        });
    }
</script>
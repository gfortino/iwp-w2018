<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>
<?php foreach ($products as $un_product): ?>
<?php
      $rowid=$un_product['rowid'];
      $ref=$un_product['ref'];
      $label=$un_product['label'];
    ?>
<?php endforeach; ?>

<div class="col-md-10 col-md-offset-1">
    <input type="hidden" id="rowid" value="<?php echo $rowid;?> "/>
    <?php
    $dir="../".$_SESSION['folder']."/documents/produit/".$rowid;
    $photos=get_photo_list($dir);
    if($photos!=NULL) {
        foreach ($photos as $value) {
                ?>
            <a href="<?php echo base_url('/index.php/products/edit_photo/').$rowid?>"><img class="img-rounded" src="../../../../<?php echo $_SESSION['folder'];?>/documents/produit/<?php echo $rowid . "/" . $value; ?>"
                     img-rounded height="100"></a>
                <?php
        }
    }
    else echo"<a href=".base_url('index.php/products/edit_photo/').$rowid."><img height=\"100\" src=\"../../../assets/img/nophoto.png\"?></a>";
    ?>&nbsp
    <font size="20" color="#00008b"><?php echo $ref ?></font>
    &nbsp&nbsp&nbsp&nbsp
    <font size="20"><?php echo $label ?></font>
</br>
</br>
    <?php foreach ($products as $un_product): ?>

    <table class="table table-hover table-bordered">
        <tr>
            <td width="13%"><?php echo lang('description');?></td>
            <td  colspan="7"><?php echo $un_product['description']?></td>
        </tr>
        <tr>
            <td ><?php echo lang('barcode');?></td>
            <td  colspan="7">
                <?php if($un_product['fk_barcode_type']==6)
                          echo 'Code 128';
                      else if($un_product['fk_barcode_type']==2)
                          echo 'EAN13';
                      else if($un_product['fk_barcode_type']==1)
                          echo 'EAN8';
                    ?>&nbsp
                <?php echo $un_product['barcode']?>
            </td>
        </tr>
        <tr>
            <td><label><?php echo lang('price');?>(含增值税)</label></td>
            <td width="17%"><?php echo number_format($un_product['price_ttc'],3)?></td>
            <td width="10%">
                <label><?php echo lang('tva_tx');?></label>
            </td>
            <td width="5%">
                <?php echo $un_product['tva_tx'];?>%
            </td>
            <td width="10%"><?php echo lang('cost_price');?></td>
            <td><?php echo number_format($un_product['cost_price'],3)?></td>
            <td width="15%">
                <label><?php echo lang('price_min_ttc');?></label>
            </td>
            <td>
                <?php echo number_format($un_product['price_min_ttc'],2)?>
            </td>
        </tr>
        <tr>
            <td>
                <label><?php echo lang('seuil_stock_alerte');?></label>
            </td>
            <td>
                <?php echo $un_product['seuil_stock_alerte']?>
            </td>
            <td>
                <label><?php echo lang('desired_stock')?></label>
            </td>
            <td colspan="5">
                <?php echo $un_product['desiredstock']?>
            </td>
        </tr>
        <tr>
            <td>
                <label><?php echo lang('source_country')?></label>
            </td>
            <td colspan="7">
                <?php echo $un_product['source_country']?>
            </td>
        </tr>
    </table>

    <!--多语言-->
    <label data-toggle="collapse" data-target="#lang"><font size="5"><b>多语言</b></font><span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></label>
    </br>
    </br>
    <div id="lang" class="collapse">
        <table class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> ES</label>
                </td>
                <td  colspan="4">
                    <?php echo $un_product['label_es'];?>
                </td>
            </tr>
            <tr>
                <td>
                    <label><?php echo lang('description');?> ES</label>
                </td>
                <td colspan="6">
                    <?php echo $un_product['description_es'];?>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> IT</label>
                </td>
                <td  colspan="4">
                    <?php echo $un_product['label_it'];?>
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('description');?> IT</label>
                </td>
                <td colspan="6">
                    <?php echo $un_product['description_it'];?>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-bordered">
            <tr>
                <td width="13%">
                    <label><?php echo lang('label');?> DE</label>
                </td>
                <td  colspan="4">
                    <?php echo $un_product['label_de'];?>
                </td>
            </tr>
            <tr>
                <td>
                    <label><?php echo lang('description');?> DE</label>
                </td>
                <td colspan="6">
                    <?php echo $un_product['description_de'];?>
                </td>
            </tr>
        </table>
        <label data-toggle="collapse" data-target="#lang_plus"><font size="3"><b>更多语言</b></font><span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></label>
        <div id="lang_plus" class="collapse">
            <table class="table table-hover table-bordered">
                <tr>
                    <td width="13%">
                        <label><?php echo lang('label');?> EN</label>
                    </td>
                    <td>
                        <?php echo $un_product['label_en'];?>
                    </td>
                    <td width="13%">
                        <label><?php echo lang('label');?> FR</label>
                    </td>
                    <td>
                        <?php echo $un_product['label_fr'];?>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label><?php echo lang('description');?> EN</label>
                    </td>
                    <td>
                        <?php echo $un_product['description_en'];?>
                    </td>
                    <td>
                        <label><?php echo lang('description');?> FR</label>
                    </td>
                    <td>
                        <?php echo $un_product['description_fr'];?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!--供应商价格-->

    <table id="fournisseur_product_table" class="table table-hover table-bordered">
        <tr id="fournisseur_product">
            <td><?php echo lang('fournisseur');?></td>
            <td><?php echo lang('suppliers_product_ref');?></td>
            <td><?php echo lang('suppliers_price');?></td>
            <td width="18%"><?php echo lang('tva_tx');?></td>
            <td width="10%"><?php echo lang('delivery_time_days');?></td>
            <td colspan="2"><?php echo lang('minimum_qty');?></td>
        </tr>
    </table>


    <table class="table table-hover table-bordered">
        <tr>
            <td width="8%">
                <?php echo lang('long');?>
            </td>
            <td width="12%">
                <?php echo number_format($un_product['length'],3);?>m
            </td>
            <td width="6%">
                <?php echo lang('wide');?>
            </td>
            <td width="13%">
                <?php
                    if($un_product['length']==0)
                        echo 0;
                    else
                        echo number_format($un_product['surface']/$un_product['length'],3);?>m
            </td>
            <td width="8%">
                <?php echo lang('hight');?>
            </td>
            <td width="12%">
                <?php
                if($un_product['surface']==0)
                    echo 0;
                else
                    echo number_format($un_product['volume']/$un_product['surface'],3);?>m
            </td>
            <td width="10%">
                <?php echo lang('weight');?>
            </td>
            <td>
                <?php echo number_format($un_product['weight'],3);?>
                <?php $weight_units=$un_product['weight_units'];
                if($weight_units==0){
                    $weight_units='kg';
                }else if($weight_units==-3){
                    $weight_units='g';
                }?>
                <?php echo $weight_units; ?>
            </td>
        </tr>
    </table>


    <!--标签-->
    <table class="table table-hover table-bordered">
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
    </table>

    <!--备注-->
    <table class="table table-hover table-bordered">
        <tr>
            <td width="10%">
                <label><?php echo lang('note')?></label>
            </td>
            <td>
                <?php echo $un_product['note'];?>
            </td>
        </tr>
    </table>

    <!--产品自定义属性-->
    <label><font size="5"><b>自定义属性</b></font></label>
    </br>
    </br>
    <div id="extrafileds" >
        <table class="table table-hover table-bordered">
            <tr>
                <td width="6.4%"><label><?php echo lang('brand')?></label></td>
                <td colspan="6">
                    <?php echo $un_product['brand_label']?>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('material')?></label></td>
                <td width="25%">
                    <?php echo $un_product['material']?>
                </td>
                <td width="1.4%%"><label><?php echo lang('function')?></label></td>
                <td width="25%">
                    <?php echo $un_product['function']?>
                </td>
                <td width="8.5%"><label><?php echo lang('size')?></label></td>
                <td>
                    <?php echo $un_product['size']?>
                </td>
            </tr>
            <tr>
                <td><label><?php echo lang('color')?></label></td>
                <td>
                    <?php echo $un_product['color']?>
                </td>
                <td width="10%"><label><?php echo lang('caution')?></label></td>
                <td>
                    <?php echo $un_product['caution']?>
                </td>
                <td><label><?php echo lang('ingredient')?></label></td>
                <td>
                    <?php echo $un_product['ingredient']?>
                </td>
            </tr>
        </table>
    </div>
    </br>
    </br>


    <?php endforeach; ?>


    <div align="right">
        <a  href="<?php echo base_url('/index.php/products/create_products') ?>" class="btn btn-default"><?php echo lang('add_new_product');?></a>
        <a  href="<?php echo base_url('/index.php/products/edit_product/').$rowid ?>" class="btn btn-default"><?php echo lang('edit');?></a>
        <a  href="#" data-toggle="modal" data-target="#supprimerm" class="btn btn-danger <?php if(!isset($_SESSION['product_delete_permission'])) echo "disabled"?>"><?php echo lang('delete');?></a>

    </div>
<a href="<?php echo base_url('/index.php/products/Show_Products')?>" class="btn btn-default"><?php echo lang('home');?></a>


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
    });


    //显示供应商———产品价格
    var json_product_fournisseur;
    var ref_fourn;
    var fournisseur;
    var unitprice;
    var tva_tx;
    var delivery_time_days;
    var quantity;
    $(document).ready(function(){
        var id=$("#rowid").val();
        $.ajax({url: "../../Ajax_products/get_fournisseur_product/"+id, success: function(result){
            json_product_fournisseur=eval(result);
            $.each(json_product_fournisseur, function() {
                rowid=this.rowid;//这里不是产品的rowid，是这一个价格的rowid
                ref_fourn=this.ref_fourn;
                fournisseur=this.fournisseur;
                unitprice=this.unitprice;
                tva_tx=this.tva_tx;
                delivery_time_days=this.delivery_time_days;
                quantity=this.quantity;
                $("#fournisseur_product").after(function(){
                    return "<tr id='tr_"+rowid+"' >"+
                        "<input type='hidden' name='"+fournisseur+"' value='"+rowid+"'/>"+
                        "<td>"+fournisseur+"</td>"+
                        "<td>"+ref_fourn+"</td>"+
                        "<td>"+unitprice+"</td>"+
                        "<td>"+tva_tx+"</td>"+
                        "<td>"+delivery_time_days+"</td>"+
                        "<td>"+quantity+"</td>"+
                        //"<td width='5%'><input type='button' id ='"+rowid+"' onclick='del_fp(this.id)' class='btn btn-danger btn-sm' value='删除'></td>"+ //不建议在显示信息界面中可以删除
                        "</tr>";
                });
            });
        }});
    });
    //删除供应商——产品价格
    function del_fp(id){
        $.ajax({url: "../../Ajax_products/delete_product_fournisseur_price/"+id, success: function(result){
            $("#tr_"+id).remove();
        }});
    }
</script>
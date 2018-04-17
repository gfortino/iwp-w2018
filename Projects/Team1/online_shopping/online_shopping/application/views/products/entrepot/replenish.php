<div class="col-md-10 col-md-offset-1">
    <?php echo $this->pagination->create_links(); ?>
    <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
        <?php $attributes = array('class' => "form-inline",'id' => "product_control_form");?>
        <?php echo form_open('products/create_replenish_commande',$attributes); ?>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="select_tout">
                        <input type="checkbox" id="select_tout" name="select_tout" class="mdl-checkbox__input">
                    </label>
                </th>
                <th><font size="2"><b><?php echo lang('photo');?></b></font></th>
                <th><font size="2"><b><?php echo lang('barcode');?></b></font></th>
                <th><font size="2"><b><?php echo lang('label');?></b></font></th>
                <th><font size="2"><b>最佳库存值</b></font></th>
                <th><font size="2"><b>最小预警值</b></font></th>
                <th><font size="2"><b>实际库存</b></font></th>
                <th><font size="2"><b>已下订单</b></font></th>
                <th><font size="2"><b>要订购</b></font></th>
                <th><font size="2"><b>供应商产品编码</b></font></th>
            </tr>
            </thead>

            <?php $i=0?>
            <?php foreach ($replenish_products as $un_product): ?>
                <tr>
                    <td><input type="checkbox" id="id_<?php echo $i?>" name="product_check_box[]" value="<?php echo $un_product['rowid']?>"></td>
                    <?php $i=$i+1?>

                    <td width="6%"><?php
                        $dir="../".$_SESSION['folder']."/documents/produit/".$un_product['ref']."/thumbs";
                        $photos=get_photo_list($dir);
                        if($photos!=NULL) {?>
                                <a href="<?php echo base_url('/index.php/products/edit_photo/').$un_product['rowid']?>"><img class="img-rounded" src="../../../../<?php echo $_SESSION['dir'];?>/documents/produit/<?php echo $un_product['ref']. "/thumbs/" . $photos[0]; ?>"
                                                                                                                             img-rounded height="25"></a>
                        <?php } else echo"<a href=".base_url('index.php/products/edit_photo/').$un_product['rowid']."><img src='".base_url('assets/img/nophoto.png')."' img-rounded height=\"20\" ></a>"; ?>
                    </td>
                    <td>
                        <a align="left" href="<?php echo base_url("/index.php/products/info_products/".$un_product['rowid'])?>" ><?php echo $un_product['ref']; ?></a>
                    </td>
                    <td><?php if($un_product['label']!=null&&$un_product['label']!="") {
                            if(mb_strlen($un_product['label'],"UTF8")>8)
                                echo mb_substr($un_product['label'], 0, 8,"UTF8") . "...";//超过15个字只显示前15个字
                            else
                                echo $un_product['label'];} ?>
                    </td>
                    <td><?php echo $un_product['desiredstock']?></td>
                    <td><?php echo $un_product['seuil_stock_alerte']?></td>
                    <td><?php echo $un_product['stock']?></td>
                    <td><?php echo $un_product['total_qty_fourni']?></td>
                    <td><input name="need_to_order_<?php echo $un_product['rowid']?>" value="<?php echo ($un_product['desiredstock']-$un_product['stock']-$un_product['total_qty_fourni'])?>" class="form-control" style="width: 80px" type="number" ?></td>
                    <td>
                        <select name="fourni_product_id_<?php echo $un_product['rowid']?>">
                            <?php if($un_product['fournisseur_price']==NULL) echo "<option value='-1,-1'>此产品未设置供应商</option>"?>
                            <?php foreach ($un_product['fournisseur_price'] as $value): ?>
                                <option value="<?php echo $value['rowid']?>,<?php echo $value['fournisseur_id']?>"><?php echo $value['fournisseur'] ?>--<?php echo $value['ref_fourn']?>--<?php echo $value['quantity']?>--<?php echo $value['unitprice']?>€</option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
            <input type="hidden" id="total_product" value="<?php echo $i?>"><!-- 用于全选, 数清楚产品总数-->
        </table>
        <div align="center">
            <input type="submit" value="创建订单" class="btn btn-primary">
        </div>
        </form>

    </div>
    <?php echo $this->pagination->create_links(); ?>
</div>

<script>
    $( "#select_tout" ).click(function() {
        n=document.getElementById("total_product").value;
        for(i=0;i<n;i++){
            if(document.getElementById("select_tout").checked===true) {
                document.getElementById("id_" + i).checked = true;
            }
            else{
                document.getElementById("id_" + i).checked = false;
            }
        }
    });
</script>
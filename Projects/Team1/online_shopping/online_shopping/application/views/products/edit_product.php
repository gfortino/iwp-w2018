<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>
<input type="hidden" id="base_url" value="<?php echo base_url()?>"/><!-- 用于js读取本地url -->

<?php echo validation_errors(); ?>


<div class="col-md-10 col-md-offset-1">
    <?php $attributes = array('class' => "form-inline");?>
    <?php echo form_open('products/edit_product/'.$rowid,$attributes); ?>
    <input type="hidden" id="rowid" name="rowid" class="form-control" value="<?php echo $rowid;?>"/>

    <?php foreach ($products as $un_product): ?>
        <input type="hidden" id="rowid" value="<?php echo $rowid;?> "/>
        </br>
        <table>
            <tr>
                <td rowspan="2" colspan="2">
                    <?php show_product_photos($rowid,100)?>&nbsp
                </td>
                <!--<td><font size="10" color="#00008b"><?php echo $un_product['ref'] ?></font></td>-->
            </tr>
            <!--<tr>
                &nbsp&nbsp
                <td><font size="5"><?php echo $un_product['label'] ?></font></td>
            </tr>-->
        </table>
        </br>
    <input type="hidden" name="label" value="<?php echo $un_product['label']?>"/>
    <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
    <table class="table table-hover table-bordered">
        <tr>
            <td width="12%">
                <label>Ref</label>
            </td>
            <td>
                <input type="text" name="ref" value="<?php echo $un_product['ref']?>" class="form-control" required/>
            </td>
        </tr>
        <tr>
            <td width="12%">
                <label>Label</label>
            </td>
            <td>
                <input type="text" name="label" value="<?php echo $un_product['label']?>" class="form-control" required/>
            </td>
        </tr>
        <tr>
            <td>
                <label>Description</label>
            </td>
            <td colspan="8">
                <textarea name="description" class="form-control" rows="2" cols="42"><?php echo $un_product['description']?></textarea>
            </td>
        </tr>
        <tr>
            <td><label>Price</label></td>
            <td>
                <input type="text" name="price" value="<?php echo $un_product['price']?>" class="form-control">
            </td>
        </tr>
        <tr>
            <td>
                <label>Tva_tx</label>
            </td>
            <td>
                <select name="tva_tx" class="form-control">
                    <option value="0" <?php if($un_product['tva_tx']==0) echo "selected"?> >0%</option>
                    <option value="19" <?php if($un_product['tva_tx']==19) echo "selected"?> >19%</option>
                    <option value="21" <?php if($un_product['tva_tx']==21) echo "selected"?> >21%</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label>Stock</label>
            </td>
            <td>
                <input type="text" name="stock" value="<?php echo $un_product['stock']?>" class="form-control">
            </td>
        </tr>
    </table>
    <!--备注-->
    <table class="table table-hover table-bordered">
        <tr>
            <td width="12%">
                <label>Note</label>
            </td>
            <td>
                <textarea name="note" class="form-control" rows="4" cols="70"><?php echo $un_product['note'];?></textarea>
            </td>
        </tr>
    </table>
    </div>
    <?php endforeach; ?>


    <div align="right">
        <a  href="<?php echo base_url('/index.php/products/create_products') ?>" class="btn btn-default">Add product</a>
        <input type="submit" name="submit" class="btn btn-default"value="Done" />
        <a  href="#" data-toggle="modal" data-target="#supprimerm" class="btn btn-danger">Delete</a>

    </div>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_products')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home
    </button>
    </form>

</div>


<!-- 删除确认的弹窗-->
<div class="modal fade" id="supprimerm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">删除确认</h4>
            </div>
            <div class="modal-body">
                <p>确定要删除吗？</p>
                <a href="<?php echo base_url('/index.php/products/delete_by_rowid/'.$rowid)?>" class="btn btn-danger"value="Supprimer" name="Supprimer" >确定</a>
                <button type="submit" class="btn btn-primary "data-dismiss="modal" aria-label="Close" >取消</button>
                </br>
            </div>
        </div>
    </div>
</div>



<script>
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


    /* 获得categ列表*/
    $("#categ").tinyselect({ searchCaseSensitive: false, dataUrl: "../../Ajax_products/get_categ" , dataParser: dataParserA });
    $("#havoc").show()







</script>
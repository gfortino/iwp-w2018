<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>
    <?php $attributes = array('class' => "form-inline", "method"=>"GET");?>
    <div class="col-md-10 col-md-offset-1">
        <h4 align="center">Product</h4>
        <!--处理产品的表单，如删除-->
        <?php echo form_open('products/show_products',$attributes); ?>
            <font size="4"><label><b><?php echo lang('search');?></b></label></font>
                <input type="text" name="ref" class="form-control"  placeholder="<?php echo lang('num_ref');?>"/>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> <!--<?php echo lang('search');?>-->
                </button>
            </form>
        <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
            <!--
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="select_tout">
                                <input type="checkbox" id="select_tout" name="select_tout" class="mdl-checkbox__input">
                            </label>
                        </th>
                        <th><font size="4"><b>Photo</b></font></th>
                        <th><font size="4"><b>Ref</b></font></th>
                        <th><font size="4"><b>Label</b></font></th>
                        <th><font size="4"><b>Description</b></font></th>
                        <th><font size="4"><b>Price</b></font></th>
                        <th></th>
                    </tr>
                </thead>
            <?php $i=0?>
            <?php $attributes = array('class' => "form-inline",'id' => "product_control_form");?>
                <?php foreach ($products as $un_product): ?>
                    <tr>
                        <td><input type="checkbox" id="id_<?php echo $i?>" name="product_check_box[]" value="<?php echo $un_product['rowid']?>"></td>
                        <?php $i=$i+1?>
                        <td width="6%">
                            <?php show_product_photos($un_product['rowid'],40)?>
                        </td>
                        <td>
                            <a href="<?php echo base_url('index.php/products/info_product/').$un_product['rowid']?>"><?php echo $un_product['ref']?></a>
                        </td>
                        <td><?php if($un_product['label']!=null&&$un_product['label']!="") {
                                if(mb_strlen($un_product['label'],"UTF8")>8)
                                    echo mb_substr($un_product['label'], 0, 8,"UTF8") . "...";//超过15个字只显示前15个字
                                else
                                    echo $un_product['label'];} ?>
                        </td>
                        <td>
                            <?php if($un_product['description']!=null&&$un_product['description']!="") {
                                if(mb_strlen($un_product['description'],"UTF8")>15)
                                    echo mb_substr($un_product['description'], 0, 15,"UTF8") . "...";//超过15个字只显示前15个字
                                else
                                    echo $un_product['description'];} ?>
                        </td>
                        <td><?php echo number_format($un_product['price'],3);?></td>
                        <td>
                            <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/edit_product/').$un_product['rowid']; ?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>-->
            <div class="row">
                <?php foreach ($products as $un_product): ?>
                    <div class="col-sm-4 col-md-3">
                        <div class="thumbnail">
                            <?php show_product_photos($un_product['rowid'])?>
                            <div class="caption">
                                <h3><?php echo $un_product['label']?></h3>
                                <p>...</p>
                                <p><a href="#" class="btn btn-primary" role="button">ADD</a> <a href="#" class="btn btn-default" role="button">More info</a></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php echo $this->pagination->create_links(); ?>
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

                <button id="product_control_del_button" type="submit" form="product_control_form" <?php if(!isset($_SESSION['product_delete_permission'])) echo "disabled"?>class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                    <?php echo lang ('yes')?>
                </button>
                <button type="submit" data-dismiss="modal" aria-label="Close" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">取消</button>
                </br>
            </div>
        </div>
    </div>
</div>

<div id="preview" class="product_preview">
    <?php
    $dir="../".$_SESSION['folder']."/documents/produit/".$un_product['ref'];
    $photos=get_photo_list($dir);
    if($photos!=NULL) {
        foreach ($photos as $value):?>
            <img class="img-rounded" src="../../../../<?php echo $_SESSION['dir'];?>/documents/produit/<?php echo $un_product['ref']. "/" . $value; ?>" img-rounded height="200">
            <?php endforeach;}?>
</div>
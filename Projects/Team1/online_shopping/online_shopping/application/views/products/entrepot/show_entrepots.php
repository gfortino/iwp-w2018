<?php $attributes = array('class' => "form-inline");?>
<div class="col-md-10 col-md-offset-1">
    <h4 align="center">仓库管理</h4>
        <!--<button type="button" onclick="window.location.href='<?php echo base_url("/index.php/products/export_excel")?>'" <?php if($export_permission==false) echo "disabled"?> class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
            <span class="glyphicon glyphicon-cloud-download" aria-hidden="true"></span> <?php echo lang('export_excel');?>
        </button>-->
    &nbsp&nbsp
    <br>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/replenish')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
        <span class="foo" aria-hidden="true"></span> 补货 <!--replenish-->
    </button>


    <table class="table table-hover table-striped">

        <thead>
            <tr>
                <th><font size="4"><b>编号</b></font></th>
                <th><font size="4"><b>位置简称</b></font></th>
                <th><font size="4"><b>实际库存</b></font></th>
            </tr>
        </thead>
    <?php $i=0?>
    <?php foreach ($entrepots as $un_entrepot): ?>
        <tr>
            <td>
                <a align="left" href="<?php echo base_url("/index.php/products/info_entrepot/".$un_entrepot['rowid'])?>" ><?php echo $un_entrepot['label']; ?></a>
            </td>
            <!--<td><input type="checkbox" id="id_<?php echo $i?>" name="product_check_box[]" value="<?php echo $un_entrepot['rowid']?>"></td>-->
            <td>
                <?php if($un_entrepot['lieu']!=null&&$un_entrepot['lieu']!="") {
                            if(mb_strlen($un_entrepot['lieu'],"UTF8")>15)
                                echo mb_substr($un_entrepot['lieu'], 0, 15,"UTF8") . "...";//超过15个字只显示前15个字
                            else
                                echo $un_entrepot['lieu'];} ?>
            </td>
            <td>
                <?php echo $un_entrepot['reel']?>
            </td>
        </tr>
    <?php endforeach; ?>
    <input type="hidden" id="total_product" value="<?php echo $i?>"><!-- 用于全选, 数清楚产品总数-->
    </table>
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

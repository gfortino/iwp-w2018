<?php $attributes = array('class' => "form-inline");?>
<div class="col-md-10 col-md-offset-1">
    <h4 align="center">库存调拨信息</h4>
    <?php echo form_open('product/show_stock_mouvements',$attributes); ?>
    <!--<button type="button" onclick="window.location.href='<?php echo base_url('/index.php/facture/delay_time_ratio_commission')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        超期天数佣金比例
    </button>-->
    <!--<label><?php echo lang('search');?></label>
       <input type="input" name="ref" class="form-control"  placeholder="<?php echo lang('num_ref');?>"/>
       <input type="submit" name="search" class="btn btn-primary" value="<?php echo lang('search');?>"/>-->
    </form>

    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/info_entrepot/'.$fk_entrepot)?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>返回
    </button>

    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th><font size="4"><b><?php echo lang('date');?></b></font></th>
            <th><font size="4"><b><?php echo lang('barcode');?></b></font></th>
            <th><font size="4"><b><?php echo lang('label');?></b></font></th>
            <th><font size="4"><b>调拨标签</b></font></th>
            <!--<th><font size="4"><b>origin</b></font></th>  这个之后再弄-->
            <th><font size="4"><b>数量</b></font></th>
        </tr>
        </thead>
        <?php foreach ($stock_mouvements as $value): ?>
            <tr>
                <td><?php echo $value['tms']; ?></td>
                <td><?php echo $value['product_barcode']; ?></td>
                <td><?php echo $value['product_label']; ?></td>
                <td><?php echo $value['label']; ?></td>
                <!--<td>origin</td>-->
                <td><?php echo $value['value']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php echo $this->pagination->create_links(); ?>
</div>

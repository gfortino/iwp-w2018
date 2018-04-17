<?php
/**
 * Created by Zherui.
 * Date: 2017/9/9
 * Time: 08:33
 */?>
<?php $attributes = array('class' => "form-inline");?>
<?php echo validation_errors(); ?>
<div class="col-md-2 col-md-offset-1">
    <div class="list-group">
        <a class="list-group-item" href="<?php echo base_url('/index.php/products/export_product_list')?>"><font size="5"><b>产品列表</b></font></a>
        <a class="list-group-item" href="<?php echo base_url('/index.php/products/export_product_stock')?>"><font size="3">产品库存</font></a>
        <a href="#" class="list-group-item">Products sells</a>
    </div>
</div>
<div class="col-md-8">
    <?php echo form_open('products/export_product_list',$attributes); ?>
    <table>
        <tr>
            <td>
                <h5>创建时间</h5>
                <input type="date" name="start_time" value="<?php echo set_value('start_time'); ?>" required> - <input type="date" name="end_time" value="<?php echo set_value('end_time'); ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                <h5>隐藏信息</h5>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <input type="checkbox" name="ref" <?php if(set_value('ref')=="on") echo "checked";?> >
            </td>
            <td>
                <font size="4"><b>ref号</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="label" <?php if(set_value('label')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>产品名字</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="description" <?php if(set_value('description')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>描述</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="barcode" <?php if(set_value('barcode')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>条形码</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="price" <?php if(set_value('price')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>售价</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="cost_price" <?php if(set_value('cost_price')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>成本价</b></font>
            </td>
        </tr>
    </table>
    <br/>
    <td width="90px">
        <input type="submit" name="submit" class="btn btn-default"value="<?php echo lang('done');?>" />
    </td>
    <br>
    <br>
    <a align="left" href="<?php echo base_url('/index.php/products/download_excel')?>" class="btn btn-primary">下载</a>

    </form>
</div>


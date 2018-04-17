<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>

   <?php $attributes = array('class' => "form-inline");?>
   <div class="col-md-10 col-md-offset-1">
       <h4 align="center"><?php echo lang('show_products');?></h4>

           <?php echo form_open('products/show_products',$attributes); ?>
           <!--<a align="left" href="<?php echo base_url('/index.php/products/export_excel')?>" class="btn btn-warning"><?php echo lang('export_excel');?></a>-->
           </form>

   </div>

<div class="col-md-10 col-md-offset-1">
    <table>
        <tr>
            <td>
                <a align="left" href="<?php echo base_url('/index.php/products/export_product_list')?>"><h5>产品列表</h5></a>
            </td>
        </tr>
        <tr>
            <td>
                <a align="left" href="<?php echo base_url('/index.php/products/export_product_stock')?>"><h5>产品库存</h5></a>
            </td>
        </tr>
        <tr>
            <td>
                <a align="left" href="<?php echo base_url('/index.php/products/export_excel')?>"><h5>Products sells</h5></a>
            </td>
        </tr>
    </table>
</div>

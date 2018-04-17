<div class="col-md-10 col-md-offset-1">
    <h4 align="center"><?php echo lang('add_new_product');?></h4>
    <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>

    <?php $attributes = array('class' => "form-inline");?>
    <?php echo form_open('products/create_products',$attributes); ?>
    <font color="red"><?php echo validation_errors(); ?></font>
    <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
        <table class="table table-hover table-bordered">
            <tr>
                <td width="12%">
                    <label>Ref</label>
                </td>
                <td>
                    <input type="text" name="ref" class="form-control" required/>
                </td>
            </tr>
            <tr>
                <td width="12%">
                    <label>Label</label>
                </td>
                <td>
                    <input type="text" name="label" class="form-control" required/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Description</label>
                </td>
                <td colspan="8">
                    <textarea name="description" class="form-control" rows="2" cols="42"></textarea>
                </td>
            </tr>
            <tr>
                <td><label>Price</label></td>
                <td>
                    <input type="text" name="price" class="form-control">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Tva_tx</label>
                </td>
                <td>
                    <select name="tva_tx" class="form-control">
                        <option value="0">0%</option>
                        <option value="19" selected>19%</option>
                        <option value="21">21%</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Stock</label>
                </td>
                <td>
                    <input type="text" name="stock" value="0" class="form-control">
                </td>
            </tr>
        </table>


        <table class="table table-hover table-bordered">
            <tr>
                <td width="12%">
                    <label>Note</label>
                </td>
                <td>
                    <textarea name="note" class="form-control" rows="4" cols="70"></textarea>
                </td>
            </tr>
        </table>
    </div>
    </br>
    <div align="center">
            <a href="<?php echo base_url('/index.php/products/show_products')?>" class="btn btn-default"><?php echo lang('back_to_home');?></a>
            <input type="submit" id="submit" name="submit" class="btn btn-primary" value="<?php echo lang('create');?>"/>
    </div>
    </form>

</div>
<?php
/**
 * Created by Zherui.
 * Date: 2017/9/9
 * Time: 08:33
 */?>
<?php $attributes = array('class' => "form-inline");?>
<h5 align="center">库存转移报表</h5>
<?php echo validation_errors(); ?>
<div class="col-md-2 col-md-offset-1">
    <div class="list-group">
        <a class="list-group-item" href="<?php echo base_url('/index.php/products/export_product_list')?>"><font size="3">产品列表</font></a>
        <a class="list-group-item" href="<?php echo base_url('/index.php/products/export_product_stock')?>"><font size="5"><b>产品库存</b></font></a>
        <a href="#" class="list-group-item">Products sells</a>
    </div>
</div>

<div class="col-md-8">
    <?php echo form_open('products/export_product_stock',$attributes); ?>
    <input type="hidden" name="rowid" value="123" >
    <table>
        <tr>
            <td>
                长度
            </td>
            <td>
                <input type="number" name="duration" class="form-control" style="width: 80px" value="<?php echo set_value('duration'); ?>">
            </td>
            <td>
                区间
            </td>
            <td>
                <select name="interval">
                    <option value="0" <?php echo set_select('interval', 0, TRUE);?>>日</option>
                    <option value="1" <?php echo set_select('interval', 1, TRUE);?>>周</option>
                    <option value="2" <?php echo set_select('interval', 2, TRUE);?>>月</option>
                    <option value="3" <?php echo set_select('interval', 3, TRUE);?>>年</option>
                </select>&nbsp&nbsp
            </td>
            <td>
                结束日期: <input type="date" name="end_time" value="<?php echo set_value('end_time'); ?>" class="form-control" required>
                &nbsp&nbsp
            </td>
            <td>
                <input type="submit" name="submit" class="btn btn-default"value="<?php echo lang('done');?>" />&nbsp
            </td>
            <td>
                <a align="left" href="<?php echo base_url('/index.php/products/download_excel')?>" class="btn btn-primary">下载</a>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td rowspan="100" width="80px">
                <font size="5"><b>仓库</b></font>
            </td>
        </tr>
        <?php foreach ($entrepot as $value): ?>
        <?php
            echo '<tr>
                      <td>
                          <input type="checkbox" name="entrepot_'.$value['rowid'].'"  ';
                          if(set_value('entrepot_'.$value['rowid'])=="on") echo "checked";
                          echo '>
                      </td>
                      <td>
                          <font size="4"><b>'.$value['label'].'</b></font>
                      </td>
                  </tr>';
            ?>
        <?php endforeach; ?>
    </table>
</div>
<div class="col-md-7 col-md-offset-3">
    <table>
        <tr>
            <td rowspan="10" width="80px">
                <font size="5"><b>隐藏</b></font>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="ref" <?php if(set_value('ref')=="on") echo "checked";?>>
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
        <tr>
            <td>
                <input type="checkbox" name="stock" <?php if(set_value('stock')=="on") echo "checked";?>>
            </td>
            <td>
                <font size="4"><b>库存</b></font>
            </td>
        </tr>
    </table>
</div>
<div class="col-md-4 col-md-offset-3">
    <br>
    <table>
        <tr>
            <td rowspan="11" width="80px">
                <font size="5"><b>标签</b></font>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" id="categ_select_tout" name="categ_select_tout" <?php if(set_value('categ_select_tout')=="on") echo "checked";?> ></td>
            <td><font size="4"><b>全选</b></font></td>
        </tr>
        <?php $i=0;?>
        <?php foreach ($categ as $value): ?>
            <?php
            if($value['fk_parent']==0) {
                echo '<tr>';
                if ($i > 8) {
                    echo '<td></td>';
                }
                echo '<td>
                          <input class="categ" type="checkbox" id="categ'.$i.'" name="categ_' . $value['rowid'] . '" ';
                if(set_value('categ_'.$value['rowid'])=="on") echo "checked";
                echo  '>
                      </td>
                      <td>
                          <font size="4"><b>' . $value['label'] . '</b></font>                    
                      </td>
                      </tr>';
                $i = $i + 1;
            }
            ?>
        <?php endforeach; ?>
        <input type="hidden" id="total_categ" value="<?php echo $i?>">
    </table>
</div>
<div class="col-md-4">
    <br>
    <table id="sous_categ_tab">
        <tr>
            <td rowspan="11" width="80px">
                <font size="5"><b>小标签</b></font>
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" id="sous_categ_select_tout" name="sous_categ_select_tout" <?php if(set_value('sous_categ_select_tout')=="on") echo "checked";?>></td>
            <td><font size="4"><b>全选</b></font></td>
        </tr>
        <?php $i=0;?>
        <?php foreach ($categ as $value): ?>
            <?php
            if($value['fk_parent']!=0) {
                echo '<tr>';
                if ($i > 8) {
                    echo '<td></td>';
                }
                echo '<td>
                          <input type="checkbox" name="categ_'.$value['rowid'].'" id="sous_categ'.$i.'"';
                          if(set_value('categ_'.$value['rowid'])=="on") echo "checked";
                echo  '>
                      </td>
                      <td>
                          <font size="4"><b>' . $value['label'] . '</b></font>                    
                      </td>
                      </tr>';
                $i = $i + 1;
            }
            ?>
        <?php endforeach; ?>
        <input type="hidden" id="total_sous_categ" value="<?php echo $i?>">

    </table>
</div>
</form>


<script>
    $( "#categ_select_tout" ).click(function() {
        n=document.getElementById("total_categ").value;
        for(i=0;i<n;i++){
            if(document.getElementById("categ_select_tout").checked===true) {
                document.getElementById("categ" + i).checked = true;
            }
            else{
                document.getElementById("categ" + i).checked = false;
            }
        }
    });
    $( "#sous_categ_select_tout" ).click(function() {
        n=document.getElementById("total_sous_categ").value;
        for(i=0;i<n;i++){
            if(document.getElementById("sous_categ_select_tout").checked===true) {
                document.getElementById("sous_categ" + i).checked = true;
            }
            else{
                document.getElementById("sous_categ" + i).checked = false;
            }
        }
    });

</script>
<?php
/**
 * Created by Zherui.身经百战见得多
 * Date: 2017/6/5
 * Time: 11:02
 */
?>
<!--获得用户的rowid-->
<input type="hidden" id="rowid" value="<?php echo $rowid?>"/>
<div class="col-md-10 col-md-offset-1">
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('product');?></font></label></div>
            <a id="product_href" href="<?php echo base_url('/index.php/products/show_products')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/product.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">仓库</font></label></div>
            <a id="supplier_href" href="<?php echo base_url("/index.php/products/show_entrepots")?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/supplier.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('contact');?></font></label></div>
            <a id="supplier_href" href="<?php echo base_url('/index.php/contact/contact_main_page')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/contact.png" height="30">
            </a>
        </div>

        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('commande');?></font></label></div>
            <a href="<?php echo base_url('/index.php/commande/commande_main_page')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/commande.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">发票</font></label></div>
            <a href="<?php echo base_url('/index.php/facture/facture_main_page')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/invoice.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">现金银行</font></label></div>
            <a href="<?php echo base_url('/index.php/bank/show_bank_accounts')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/bank.png" height="30">
            </a>
        </div>

        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">POS</font></label></div>
            <a href="<?php echo base_url('/index.php/pos/show_pos_status')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/pos.ico" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">报表</font></label></div>
            <a href="<?php echo base_url('/index.php/report/report_main_page')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/report_icon.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">后台管理</font></label></div>
            <a href="<?php if($_SESSION['admin']==1){ //如果是管理员，显示后台
                echo base_url('/index.php/Background/main_page');
            }
            else{
                echo "#";
            }?>
                " class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/backend.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">设置</font></label></div>
            <a href="<?php echo base_url('/index.php/option/personal_option');?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/option_icon.png" height="30">
            </a>
        </div>
    </div>
    <div id="note_public">
        <?php $attributes = array('class' => "form-inline");?>
        <?php echo form_open('login/main_page',$attributes); ?>
        <table>
            <thead>
            <tr>
                <th>
                    <textarea name="note" rows="4" cols="50" placeholder="输入工作留言板内容" class="form-control"></textarea>
                </th>
                <th>
                    &nbsp
                    <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                        发送
                    </button>
                </th>
            </tr>
            </thead>
        </table>
        </form>
        <!-- 分页类参数要用get传参。不然点下一页的时不能保存结果-->
        <?php $attributes = array('class' => "form-inline",'method'=>"get");?>
        <?php echo form_open('login/main_page',$attributes); ?>
        <table>
            <tr>
                <td>
                    <?php echo $this->pagination->create_links(); ?>
                </td>
                <td>
                    日期
                </td>
                <td>
                    <input type="date" name="start_time" value="<?php echo set_value('start_time'); ?>" class="form-control">--<input type="date" name="end_time" value="<?php echo set_value('end_time'); ?>" class="form-control">
                </td>
                <td>
                    &nbsp
                    <select class="form-control">
                        <option value="-1">全部</option>
                    </select>
                </td>
                <td>
                    &nbsp
                    <input type="submit" class="btn btn-primary" value="筛选">
                </td>
            </tr>
        </table>
        <font size="5"><?php echo $start_time."----".$end_time;?></font>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th width="60%">工作留言板</th>
                <th>时间</th>
                <th>用户</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($note_public as $un_note): ?>
                <tr>
                    <td>
                        <?php echo $un_note['note']?>
                    </td>
                    <td>
                        <?php echo $un_note['tms']?>
                    </td>
                    <td>
                        <?php echo $un_note['lastname']?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </form>

    </div>



    <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3D1636026676699080%26id%3D1635974703370944&width=500" width="500" height="298" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
    <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fpermalink.php%3Fstory_fbid%3D1738133959827871%26id%3D100008938510268&width=500" width="500" height="236" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
</div>


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
            <div align="center"><label><font size="5">Product</font></label></div>
            <a id="product_href" href="<?php echo base_url('/index.php/products/show_products')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/product.png" height="30">
            </a>
        </div>
        <!--
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">仓库</font></label></div>
            <a id="supplier_href" href="<?php echo base_url("/index.php/products/show_entrepots")?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/supplier.png" height="30">
            </a>
        </div>-->
        <!--<div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('supplier');?></font></label></div>
            <a id="supplier_href" href="<?php echo base_url('/index.php/fournisseur/show_fournisseurs')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/supplier.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('customer');?></font></label></div>
            <a href="<?php echo base_url('/index.php/client/show_clients')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/customer.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('contact');?></font></label></div>
            <a href="<?php echo base_url('/index.php/contact/show_contacts')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/contact.png" height="30">
            </a>
        </div>-->
        <!--<div class="col-xs-4 col-md-2">
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
            <div align="center"><label><font size="5">费用</font></label></div>
            <a href="#" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/expense.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">人事管理</font></label></div>
            <a href="#" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/human_ressource.png" height="30">
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
        </div>-->
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">Orders</font></label></div>
            <a href="#" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/ecommerce_icon.png" height="30">
            </a>
        </div>
    </div>
</div>
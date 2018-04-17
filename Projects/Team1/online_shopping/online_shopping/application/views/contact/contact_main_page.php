<?php
/*created by zherui*/
?>
<h4 align="center">联系人类型</h4>
<div class="col-md-10 col-md-offset-3">
    <br /><br />
    <div></div>
    <div class="row">
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">供应商</font></label></div>
            <a id="product_href" href="<?php echo base_url('/index.php/fournisseur/show_fournisseurs')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/supplier.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">客户</font></label></div>
            <a id="developement_product_href" href="<?php echo base_url('/index.php/client/show_clients')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/customer.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5">联系人</font></label></div>
            <a id="developement_product_href" href="<?php echo base_url('/index.php/contact/show_contacts')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/contact.png" height="30">
            </a>
        </div>
    </div>
    </br>
    </br>
    <!--
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_products')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> <?php echo lang('back_to_home')?>
    </button>-->
</div>

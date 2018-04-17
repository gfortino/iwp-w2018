<?php
?>

<div class="col-md-10 col-md-offset-1">

    <h1><?php echo lang('choose_upoad_format')?></h1>

    <br /><br />

    <div class="row">
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('base_format');?></font></label></div>
            <a id="product_href" href="<?php echo base_url('/index.php/products/upload_excel_basic')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/upload_basic.png" height="30">
            </a>
        </div>
        <div class="col-xs-4 col-md-2">
            <div align="center"><label><font size="5"><?php echo lang('complex_format');?></font></label></div>
            <a id="developement_product_href" href="<?php echo base_url('/index.php/products/upload_excel')?>" class="thumbnail">
                <img src="<?php echo base_url()?>assets/img/upload.png" height="30">
            </a>
        </div>
    </div>
    </br>
    </br>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_products')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> <?php echo lang('back_to_home')?>
    </button>
</div>

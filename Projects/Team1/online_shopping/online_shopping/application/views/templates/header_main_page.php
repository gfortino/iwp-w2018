<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>GTech</title>
    <!-- jquery -->
    <script src="<?php echo base_url()?>assets/jquery-3.2.0.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/tinyselect.js"></script><!-- select插件 -->
    <script src="<?php echo base_url()?>assets/js/number_only.js"></script><!-- 只能输入数字的插件 -->
    <!-- Bootstrap -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="<?php echo base_url()?>assets/css/bootswatch_paper.min.css" rel="stylesheet">-->
    <!--Material-->
    <link href="<?php echo base_url()?>assets/css/material.min.css" rel="stylesheet">
    <!-- select插件 -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/tinyselect.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        img.pos_abs
        {
            position:absolute;
            left:1000px;
            top:2px;
            z-index:999
        }
    </style>
</head>
<body>
<!--
    <a href="<?php echo base_url('/index.php/products/Show_Products')?>"><img class="pos_abs" src="<?php echo base_url()?>assets/img/logo.png" height="50"></a>
    -->
<nav class="navbar navbar-default">
    <div class="container-fluid col-md-10 col-md-offset-1">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url('/index.php/login/main_page')?>">TEAM1</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            </ul>
            <div class="navbar-form navbar-left" role="search">
                <!--<a href="<?php echo base_url('/index.php/option/personal_option');?>"><?php echo $_SESSION['username'];?></a>-->
                <a  href="<?php echo base_url('/index.php/login/logout/');?>" class="btn btn-danger"><?php echo lang('logout');?></a>
                <!--<?php if($_SESSION['admin']==1){ //如果是管理员，显示后台
                    echo '<a href="'.base_url('/index.php/Background/show_users').'"<b>#后台</b></a>';
                }?>-->
            </div>
            <!--
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <img src="<?php echo base_url()?>assets/img/china.svg" height="30"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('/index.php/Option/lang_chinese?url='.current_url())?>"><img src="<?php echo base_url()?>assets/img/china.svg" height="30"><font size="1">&nbspCN</font></a></li>
                        <li><a href="<?php echo base_url('/index.php/Option/lang_english?url='.current_url())?>"><img src="<?php echo base_url()?>assets/img/us.svg" height="30"><font size="1">&nbspUS</font></a></li>
                        <li><a href="#"><img src="<?php echo base_url()?>assets/img/de.svg" height="30"><font size="1">&nbspDE</font></a></li>
                        <li><a href="#"><img src="<?php echo base_url()?>assets/img/es.svg" height="30"><font size="1">&nbspES</font></a></li>
                        <li><a href="#"><img src="<?php echo base_url()?>assets/img/it.svg" height="30"><font size="1">&nbspIT</font></a></li>
                    </ul>
                </li>
            </ul>-->
        </div>
    </div>
</nav>

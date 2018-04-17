<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>GTech</title>
    <!-- jquery -->
    <script src="<?php echo base_url()?>assets/jquery-3.2.0.min.js"></script>
    <!-- 只能输入数字的插件 -->
    <script src="<?php echo base_url()?>assets/js/number_only.js"></script>
    <!-- Bootstrap -->
    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--<link href="<?php echo base_url()?>assets/css/bootswatch_paper.min.css" rel="stylesheet">-->
    <!--Material-->
    <link href="<?php echo base_url()?>assets/css/material.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-red.min.css" /><!--谷歌的网站国内引用可能会出问题-->
    <script src="<?php echo base_url()?>assets/js/material.min.js"></script>
    <!-- select插件 -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/tinyselect.css">
    <script src="<?php echo base_url()?>assets/js/tinyselect.js"></script>
    <!-- select插件--chosen -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/chosen.css">
    <script src="<?php echo base_url()?>assets/js_plug/chosen.jquery.min.js"></script>
    <!-- 鼠标悬停显示页面插件 -->
    <!--<link rel="stylesheet" href="<?php echo base_url()?>assets/css/tooltipster.bundle.min.css">
    <script type="text/javascript" src="<?php echo base_url()?>assets/js_plug/tooltipster.bundle.min.js"></script>-->
    <!-- 鼠标悬停显示预览插件-->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.tinypreview.css">
    <script type="text/javascript" src="<?php echo base_url()?>assets/js_plug/jquery.tinypreview.js"></script>
    <!--
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-blue.min.css" />
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    -->

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
        body {background-color:#f1f4f4;}
        .nav_pos{
            position: fixed;
            top: 0px;
            z-index: 500;
            /*background-color: #FF6668;*/
            /*opacity: 0.68;*/
            width: 100%;
        }
        .dropdown-menu{ /*设置dropdown宽度自适应*/
            min-width: inherit;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-default nav_pos">
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

            <div class="navbar-form navbar-left">
                &nbsp&nbsp<a href="<?php echo base_url('/index.php/products/show_products')?>"><img src="<?php echo base_url()?>assets/img/product.png" height="30"></a>
                </br>
                Product
            </div>
            <div class="navbar-form navbar-left">
                &nbsp<a href="#"><img src="<?php echo base_url()?>assets/img/ecommerce_icon.png" height="30"></a>
                </br>
                Orders
            </div>


            <div class="navbar-form navbar-left" role="search">
                <a href="<?php echo base_url('/index.php/option/personal_option');?>"><?php echo $_SESSION['username'];?></a>
                <a  href="<?php echo base_url('/index.php/login/logout/');?>" class="btn btn-danger"><?php echo lang('logout');?></a>
            </div>
            <!--
            <div class="navbar-form navbar-left">
                <a href="<?php echo base_url('/index.php/Option/lang_chinese?url='.current_url())?>"><img src="<?php echo base_url()?>assets/img/china.svg" height="30"></a>
            </div>
            <div class="navbar-form navbar-left">
                <a href="<?php echo base_url('/index.php/Option/lang_english?url='.current_url())?>"><img src="<?php echo base_url()?>assets/img/gb.png" height="30"></a>
            </div>-->
            <!--<ul class="nav navbar-nav">
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
<br>
<br>
<br>
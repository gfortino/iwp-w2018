<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Food and Restorent One page Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.js@2.3/dist/instantsearch.min.css">
        <link rel="stylesheet" href="<?=base_url();?>assets/css/bootstrap.min.css">
        <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?=base_url();?>assets/css/font-awesome.min.css">
        <!--        <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">-->

         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!--For Plugins external css-->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/animate/animate.css" />
        <link rel="stylesheet" href="<?=base_url();?>assets/css/plugins.css" />

        <!--Theme custom css -->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/style.css">

        <!--Theme Responsive css-->
        <link rel="stylesheet" href="<?=base_url();?>assets/css/responsive.css" />

        <script src="<?=base_url();?>assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@2.3/dist/instantsearch.min.js"></script>
        <script src="<?=base_url();?>assets/js/app.js"></script>
        <style>
        .algolia-autocomplete {
          width: 100%;
        }
        .algolia-autocomplete .aa-input, .algolia-autocomplete .aa-hint {
          width: 100%;
        }
        .algolia-autocomplete .aa-hint {
          color: #999;
        }
        .algolia-autocomplete .aa-dropdown-menu {
          width: 100%;
          background-color: #fff;
          border: 1px solid #999;
          border-top: none;
        }
        .algolia-autocomplete .aa-dropdown-menu .aa-suggestion {
          cursor: pointer;
          padding: 5px 4px;
        }
        .algolia-autocomplete .aa-dropdown-menu .aa-suggestion.aa-cursor {
          background-color: #B2D7FF;
        }
        .algolia-autocomplete .aa-dropdown-menu .aa-suggestion em {
          font-weight: bold;
          font-style: normal;
        }
    </style>
    </head>
    <body>

        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		<!--<div class='preloader'><div class='loaded'>&nbsp;</div></div>-->
        <header id="home" class="navbar-fixed-top">
            <div class="header_top_menu clearfix">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-3 col-sm-12 text-right">
                            <div class="call_us_text">
								<a href=""><i class="fa fa-clock-o"></i> Order Foods 24/7</a>
								<a href=""><i class="fa fa-phone"></i>061 9876 5432</a>
							</div>
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <div class="head_top_social text-right">
                                <a href=""><i class="fa fa-facebook"></i></a>
                                <a href=""><i class="fa fa-google-plus"></i></a>
                                <a href=""><i class="fa fa-twitter"></i></a>
                                <a href=""><i class="fa fa-linkedin"></i></a>
                                <a href=""><i class="fa fa-pinterest-p"></i></a>
                                <a href=""><i class="fa fa-youtube"></i></a>
                                <a href=""><i class="fa fa-phone"></i></a>
                                <a href=""><i class="fa fa-camera"></i></a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="main_menu_bg">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand our_logo" href="#"><img src="<?=base_url();?>assets/images/logo.png" alt="" /></a>
                                </div>

                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                                    <ul class="nav navbar-nav navbar-right">
                                      <li><a> <input class="form-control" id="search-input" name="contacts" type="text" placeholder='Search by name' /></a></li>

                                      <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
                                      <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
                                      <script>
                                        var client = algoliasearch('9USJ7O4AOH', 'cc9c7697f1e099b20b3f353b186ff7b3');
                                        var index = client.initIndex('FOOD');
                                        autocomplete('#search-input', { hint: false }, [
                                          {
                                            source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
                                            displayKey: 'name',
                                            templates: {
                                              suggestion: function(suggestion) {
                                                return suggestion._highlightResult.name.value;
                                              }
                                            }
                                          }
                                        ]).on('autocomplete:selected', function(event, suggestion, dataset) {
                                          console.log(suggestion, dataset);
                                          alert('dataset: ' + dataset + ', ' + suggestion.name);
                                        });
                                      </script>
                                      <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
                                        <li><a><?php
                                        $user = $_SESSION['username'];
                                        echo "Welcome $user";
                                        ?></a></li>
                                      <?php endif; ?>
                                      <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true && $_SESSION['is_admin'] != false) : ?>

                                         <li><a href="<?= base_url('admin') ?>">ADMIN</a></li>


                                      <?php endif; ?>
                                      <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>

                                      <li><a href="<?= base_url('display') ?>">Product </a></li>

                                      <?php endif; ?>


                                        <li><a href="<?= base_url('home') ?>">Home</a></li>
                                        <li><a href="#abouts">Menu</a></li>
                                        <li><a href="#features">Features</a></li>
                                        <li><a href="#portfolio">Delivery</a></li>
                                        <li><a href="#ourPakeg">News</a></li>


                                        <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
                            							<li><a href="<?= base_url('logout') ?>"class="booking">Logout</a></li>
                            						<?php else : ?>
                            							<li><a href="<?= base_url('register') ?>"class="booking">Register</a></li>
                            							<li><a href="<?= base_url('login') ?>"class="booking">Login</a></li>
                            						<?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
	<main id="site-content" role="main">

		<?php if (isset($_SESSION)) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php var_dump($_SESSION); ?>
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		<?php endif; ?>

<?php
/**
 * Created by Zherui
 * Date: 2017/5/12
 * Time: 18:28
 */
?>

<div class="col-md-10 col-md-offset-1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 col-md-offset-4">
                <h1 class="text-center login-title"><?php echo lang('login');?></h1>
                <div class="account-wall">

                    </br>
                    </br>
                    <?php echo validation_errors(); ?>
                    <?php $attributes = array('class' => "form-signin");?>
                    <?php echo form_open('login/index',$attributes); ?>
                        <input name="account" type="text" class="form-control" placeholder="user" required autofocus>
                        </br>
                        <input name="password" type="password" class="form-control" placeholder="Password">
                        </br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Sign in</button>
                        <label class="checkbox pull-left">
                            <input type="checkbox" value="remember-me">
                            Remember me
                        </label>
                        <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                        <?php echo hash('md5', '123456');?>
                        <br>
                        <?php echo sha1(md5('20180112175557123456'));?>
                        <br>
                    c4db4282cf0477d2c39d2b43511b9682afb03b75
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

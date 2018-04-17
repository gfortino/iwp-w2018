<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>

   <?php $attributes = array('class' => "form-inline");?>
   <div class="col-md-10 col-md-offset-1">
        <h4 align="center"><?php echo lang('show_contact');?></h4>

        <?php echo form_open('products/show_products',$attributes); ?>
           <a align="left" href="<?php echo base_url('/index.php/contact/create_contact')?>" class="btn btn-primary"><?php echo lang('add_new_contact');?></a>
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
           &nbsp
       <!--
       <label><?php echo lang('search');?></label>
               <input type="input" name="ref" class="form-control"  placeholder="<?php echo lang('num_ref');?>"/>
               <input type="submit" name="search" class="btn btn-primary" value="<?php echo lang('search');?>"/>
           -->
        </form>
        <div class="well well-sm" style="background-color:#FFFFFF; /*height:260px;*/ border:1px  ; overflow-x:hidden; overflow-y:scroll;">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th><?php echo lang('company_name');?></th>
                        <th><?php echo lang('town'); ?></th>
                        <th><?php echo lang('phone');?></th>
                        <th></th>
                    </tr>
                </thead>

            <?php foreach ($contact as $un_contact): ?>
                <tr>
                    <td>
                        <a align="left" href="<?php echo base_url("/index.php/contact/info_contact/".$un_contact['rowid'])?>" ><?php echo $un_contact['lastname'].$un_contact['firstname']; ?></a>
                    </td>
                    <td><?php echo $un_contact['town']; ?></td>
                    <td><?php echo $un_contact['phone'];?></td>
                    <td width="8%">
                        <a  href="<?php echo base_url('/index.php/contact/edit_contact/').$un_contact['rowid']; ?>" class="btn btn-warning"><?php echo lang('edit');?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>
        </div>
        <?php echo $this->pagination->create_links(); ?>
   </div>

   </br>
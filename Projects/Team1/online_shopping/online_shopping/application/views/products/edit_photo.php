<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>

<div class="col-md-10 col-md-offset-1">
    <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
    <h4 align="center"><?php echo lang('edit_photo');?></h4>

    <font size="20" color="#00008b">ref: <?php echo $ref ?></font>
    </br>
    <span id="photo_span"></span>

    <?php
    $dir="../".$_SESSION['folder']."/documents/produit/".$ref;
    $photos=get_photo_list($dir);
    if($photos!=NULL) {
        $i=0;
        foreach ($photos as $value) {
            ?>
            <a  href="#" data-toggle="modal" data-target="#suprimer<?php echo $i?>">
            <img class="img-rounded" src="../../../../<?php echo $_SESSION['dir'];?>/documents/produit/<?php echo $ref . "/" . $value; ?>"
                 img-rounded height="200"/>
            </a>
            <?php
            $i=$i+1;
        }
    }
    else echo"<img src=\"../../../assets/img/nophoto.png\"/>";
    $dir="../".$_SESSION['dir']."/documents/produit/".$ref;
    ?>
    <input type="hidden" id="dir" value="<?php echo $dir?>">
    </br>
    </br>
    <?php if($error!=null) echo $error;?>
    <script src="<?php echo base_url()?>assets/js_plug/dropzone.js"></script><!-- 添加图片插件 -->
    <!--<script src="<?php echo base_url()?>assets/js_plug/exif.js"></script><!-- 防止iPhone图片上传翻转用 -->

    <link href="<?php echo base_url()?>assets/css/dropzone.css" rel="stylesheet">
    <?php $attributes = array('class' => "dropzone",'id'=>"dropzone");?>
    <?php echo form_open_multipart('products/do_upload_photo/'.$rowid,$attributes);?>
    <!--<input type="file" name="photo" size="20" />-->
    <div class="fallback"><!--如果浏览器不支持js，则添加一般的上传窗口-->
        <input name="photo" type="file" multiple />
    </div>
    <p class="help-block">支持上传格式: png,gif,jpg,jpeg。不超过8M</p>

    <!--<input type="submit" value="<?php echo lang('upload');?>" class="btn btn-primary"/>-->
    </form>
    <?php echo form_open_multipart('products/do_upload_photo/'.$rowid);?>
    <!--<input type="submit" value="<?php echo lang('upload');?>" class="btn btn-primary"/>-->
    </form>
    <!--
    <div class="dropz">
        <link href="<?php echo base_url()?>assets/css/dropzone.css" rel="stylesheet">
        <form action="products/do_upload_photo/<?php echo $rowid?>"
              class="dropzone"
              id="my-awesome-dropzone">
            <input type="submit" value="<?php echo lang('upload');?>" class="btn btn-primary"/>

        </form>
    </div>
    -->

    </br>
    </br>
    <a href="<?php echo base_url('/index.php/products/info_products/').$rowid ?>" class="btn btn-default"><?php echo lang('done');?></a>
    <a href="<?php echo base_url('/index.php/products/create_products') ?>" class="btn btn-default"><?php echo lang('add_new_product');?></a>
    <a href="<?php echo base_url('/index.php/products/create_products_mobi') ?>" class="btn btn-default"><?php echo lang('add_new_product');?>-MOBI</a>
</div>

<script>
    var base_url=document.getElementById("base_url").value+"index.php/";
    Dropzone.options.dropzone = {
        paramName: "photo", // The name that will be used to transfer the file
        maxFilesize: 8, // MB
        resizeWidth: 2000,
        accept: function(file, done) {
            /*if (file.name == "justinbieber.jpg") {
                done("Naha, you don't.");
            }
            else { done(); }*/
            done();
            //本来想马上显示出来，但是有问题
            /*$("#photo_span").after(function(){
                //return $("#dir").val();
                return "<img class='img-rounded' src='../../../../"+$("#dir").val()+"/"+file.name+"' >";
            });*/
        }
    };
    $("#photo_span").after(function(){
        //return $("#dir").val();
        //return "<img class='img-rounded' src='../../../../"+$("#dir").val()+'/'+file.name+"' >";
    });
</script>
<!-- 删除确认的弹窗
<?php foreach ($photos as $value) {?>
<div class="modal fade" id="suprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">删除确认</h4>
            </div>
            <div class="modal-body">
                <p>确定要删除吗？</p>
                <a href="<?php //echo base_url('/index.php/products/delete_by_ref/'.$ref)?>#" class="btn btn-danger"value="Supprimer" name="Supprimer" ><?php echo $value?></a>
                <button type="submit" class="btn btn-primary "data-dismiss="modal" aria-label="Close" >取消</button>
                </br>


            </div>
        </div>
    </div>
</div>
<?php }?>
-->
<?php
$i=0;
if ($photos!=null){
foreach ($photos as $value) {
    echo '<div class="modal fade" id="suprimer'.$i.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
    echo '<div class="modal-dialog modal-sm" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '<h4 class="modal-title" id="myModalLabel">删除确认</h4>';
    echo '</div>';
    echo '<div class="modal-body">';
    echo '<p>确定要删除吗？</p>';
    echo '<a href="'.base_url('/index.php/products/delete_photo_by_name/'.$rowid.'/'.$value).'" class="btn btn-danger"value="Supprimer" name="Supprimer" >'.lang('yes').'</a>';
    echo '&nbsp';
    echo '<button type="submit" class="btn btn-primary "data-dismiss="modal" aria-label="Close" >'.lang('cancel').'</button>';
    echo '</br>';


    echo '</div>
            </div>
        </div>
    </div>';
    $i=$i+1;
    }
}
?>
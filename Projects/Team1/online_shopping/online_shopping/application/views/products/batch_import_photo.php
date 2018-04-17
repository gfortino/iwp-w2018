<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>

    <div class="col-md-10 col-md-offset-1">
        <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
        <h4 align="center">批量导入图片</h4>
        <p>图片名称需命名为产品ref名称或条码名称</p>
        <p>如一个产品需要导入多张图片，则需要用下划线"_"把条形码分隔开</p> <!-- 或横线"-"-->
        <p>如果找不到该产品，则无法添加图片</p>

        </br>
        </br>
        <?php if($error!=null) echo $error;?>
        <script src="<?php echo base_url()?>assets/js_plug/dropzone.js"></script><!-- 添加图片插件 -->
        <!--<script src="<?php echo base_url()?>assets/js_plug/exif.js"></script><!-- 防止iPhone图片上传翻转用 -->

        <link href="<?php echo base_url()?>assets/css/dropzone.css" rel="stylesheet">
        <?php $attributes = array('class' => "dropzone",'id'=>"dropzone");?>
        <?php echo form_open_multipart('products/batch_import_photo/',$attributes);?>
        <div class="fallback"><!--如果浏览器不支持js，则添加一般的上传窗口-->
            <input name="photo" type="file" multiple />
        </div>
        <p class="help-block">支持上传格式: png,gif,jpg,jpeg。每张不超过8M</p>

        <!--<input type="submit" value="<?php echo lang('upload');?>" class="btn btn-primary"/>-->
        </form>

        </br>
        </br>
    </div>

    <script>
        //var base_url=document.getElementById("base_url").value+"index.php/";
        Dropzone.options.dropzone = {
            paramName: "photo", // The name that will be used to transfer the file
            maxFilesize: 8, // MB
            resizeWidth: 2000,
            /*renameFilename: function renameFilename(file) {
                var barcode=file.filename;
                console.log(barcode);
                var position=barcode.indexOf('.')
                barcode=barcode.substring(0,position);
                var ref;
                $.ajax({ type: "GET",
                    url: "../Ajax_products/get_ref_by_barcode/"+barcode,
                    async: false,
                    success : function(resultat)
                    {
                        //alert(resultat);
                        if(resultat==null){
                            //done("找不到该图片对应的产品"+file.name);
                            ref=barcode;
                        }
                        else{
                            ref=resultat;
                        }
                    }
                });
                return ref + file.split('.').pop();
            },*/
            accept: function(file, done) {

                var ref=file.name;
                position=ref.indexOf('.')
                ref=ref.substring(0,position);
                //alert(ref);
                position=ref.indexOf('_')
                if(position!=-1){//如果存在下划线
                    ref=ref.substring(0,position);//去掉下划线
                }
                /*position=ref.indexOf('-')
                if(position!=-1){//如果存在横线
                    ref=ref.substring(0,position);//去掉横线
                }*/
                var flag_check_ref=true;
                var flag_check_barcode=true;
                $.ajax({ type: "GET",
                    url: "../Ajax_products/check_ref/"+ref,
                    async: false,
                    success : function(resultat)
                    {
                        console.log(ref);
                        //alert(resultat);
                        if(resultat==1){
                            console.log(resultat);
                            //done("找不到该图片对应的产品"+file.name);
                            flag_check_ref=false;
                        }
                    }
                });
                $.ajax({ type: "GET",
                    url: "../Ajax_products/check_barcode/"+ref,
                    async: false,
                    success : function(resultat)
                    {
                        //alert(resultat);
                        if(resultat==1){
                            //done("找不到该图片对应的产品"+file.name);
                            flag_check_barcode=false;
                        }
                    }
                });
                console.log(flag_check_ref);
                console.log(flag_check_barcode);

                if((flag_check_ref==false)&&(flag_check_barcode==false)){
                    done("找不到该图片对应的产品"+file.name);
                }
                done();
                /*
                if (check_barcode(barcode) == false) {
                    done("Naha, you don't.");
                 }
                 else {
                    done();
                }*/

            }
        };

    </script>

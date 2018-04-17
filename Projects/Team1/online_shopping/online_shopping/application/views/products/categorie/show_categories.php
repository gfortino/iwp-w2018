 <?php $attributes = array('class' => "form-inline");?>
    <div class="col-md-10 col-md-offset-1">
       <h4 align="center">标签管理(只显示大标签)</h4>
    </div>


<div class="col-md-10 col-md-offset-1">
    <table class="table table-hover table-striped">

        <thead>
            <tr>
                <th><font size="4"><b>名称</b></font></th>
                <th><font size="4"><b>最高折扣</b></font></th>
            </tr>
        </thead>
    <?php foreach ($categories as $un_categorie): ?>
        <tr>
            <td>
                <!--<a align="left" href="<?php echo base_url("/index.php/products/info_categorie/".$un_categorie['rowid'])?>" ><?php echo $un_categorie['label']; ?></a>-->
                <?php echo $un_categorie['label']; ?>
            </td>
            <td>
                <input type="text" id="<?php echo $un_categorie['rowid']?>" onblur="set_ratio_commission(this.id,this.value)" value="<?php echo $un_categorie['limit_discount']*100?>">%
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</div>
 <div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
     <div class="mdl-snackbar__text"></div>
     <button class="mdl-snackbar__action" type="button"></button>
 </div>

 <script>
        function set_ratio_commission(rowid_categ,limit_discount){
            //alert(rowid_categ+" "+ratio_commission);
            //ajax...
            //show_snackbar("设置成功",500);
            //show_snackbar("设置失败",1500);
            limit_discount=limit_discount/100;
            $.ajax({
                url: "../products/set_categ_ratio_commission/"+rowid_categ+"/"+limit_discount,
                success: function (result) {
                    show_snackbar("设置成功",500);
                },
                error: function (result) {
                    $("#"+rowid_categ+"_label").html("错误，设置失败");
                    show_snackbar("错误，设置失败",2500);
                }
            });
        }
        //显示提示函数
        function show_snackbar(message,timeout){
            var snackbarContainer = document.querySelector('#snackbar');
            var data = {
                message: message,
                timeout: timeout,
            };
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        }
 </script>
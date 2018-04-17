<div class="col-md-10 col-md-offset-1">
    <input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
    <!--产品自定义属性-->
    <table>
        <tr>
            <td width="30%">
                <input type="text" id="add_brand_label" class="form-control"/>
            </td>
            <td>
                &nbsp&nbsp&nbsp&nbsp&nbsp
                <input type="button" id="add_brand_button" value="<?php echo lang('add')?>" class='btn btn-primary btn-sm'>
                <label id="info_brand">
                    <!--添加品牌成功或失败显示在这里-->
                    <?php echo lang('add_new_brand_here')?>
                </label>
            </td>
        </tr>
    </table>
    <h5>品牌列表</h5>
    <table class="table table-hover table-bordered">
        <?php foreach ($brands as $value): ?>
        <tr>
            <td>
                <?php echo $value['label']?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>


<script>
    /*select 插件函数*/
    function dataParserA(data, selected) {
        retval = [ { val: "-1" , text: "-" } ];

        data.forEach(function(v){
            if(selected == "-1" && v.val == 3)
                v.selected = true;
            retval.push(v);
        });

        return retval;
    }

    var categ_json;
    $.ajax({ type: "GET",
        url: "../Ajax_products/get_categ",
        async: false,
        success : function(json)
        {
            categ_json = json;
        }
    });



    //获得品牌列表
    $("#brand").tinyselect({ searchCaseSensitive: false, dataUrl: "../Ajax_products/get_brand" , dataParser: dataParserA });
    $("#havoc").show()
    //添加品牌
    $("#add_brand_button").click(function(){
        var label=$("#add_brand_label").val();
        if(label!=""){
            $.ajax({
                url: "../Ajax_products/add_brand/" +label,
                success: function (result) {
                    $("#add_brand_label").val("");
                    $("#info_brand").html("添加成功");
                    window.location.reload();
                },
                error: function (result) {
                    $("#info_brand").html("<font color='#8b0000'>该品牌已存在</font>");
                }
            });
        }
    });






</script>
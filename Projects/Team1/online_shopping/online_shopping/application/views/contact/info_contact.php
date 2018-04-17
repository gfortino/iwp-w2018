<?php
/**
 * Created by Zherui. The best back-end developper
*/
?>
<?php require_once dirname(__FILE__) . '/../../models/functions.php';?>

<div class="col-md-10 col-md-offset-1">
    <h4 align="center"><?php echo lang('info_contact');?></h4>
    <?php foreach ($contact as $un_contact): ?>
        <input hidden id="rowid" value="<?php echo $un_contact['rowid']?>">
        <table class="table table-hover table-bordered">
            <tr>
                <td width="7.4%"><?php echo lang('first_name');?></td>
                <td width="19.6%" id="td_firstname" ondblclick="click_element(this.id)">
                    <span id="firstname"><?php echo $un_contact['firstname']?></span>
                </td>
                <td width="7.4%"><?php echo lang('last_name');?></td>
                <td width="16.6%" id="td_lastname">
                    <span id="lastname" ondblclick="click_element(this.id)"><?php echo $un_contact['lastname']?></span>
                </td>
                <td width="5.2%">
                    <?php echo lang('civility');?>
                </td>
                <td colspan="3">
                    <?php echo $un_contact['civility']?>
                </td>
            </tr>
            <!--合伙人-->
            <tr>
                <td><?php echo lang('societe')?></td>
                <td colspan="7">
                    <?php echo $un_contact['societe_nom']?>
                </td>
            </tr>

            <tr>
                <td><?php echo lang('poste');?></td>
                <td>
                    <?php echo $un_contact['poste']?>
                </td>
                <td>
                    <label><?php echo lang('address');?></label>
                </td>
                <td colspan="7">
                    <?php echo $un_contact['address']?>
                </td>
            </tr>

            <tr>
                <td>
                    <label><?php echo lang('zip');?></label>
                </td>
                <td>
                    <?php echo $un_contact['zip']?>
                </td>
                <td>
                    <label><?php echo lang('town');?></label>
                </td>
                <td>
                    <?php echo $un_contact['town']?>
                </td>
                <td>
                    <label><?php echo lang('pays');?></label>
                </td>
                <td width="19.6%">
                    <?php echo $un_contact['pays']?>
                </td>
                <td width="5.2%">
                    <label><?php echo lang('departement');?></label>
                </td>
                <td>
                    <?php echo $un_contact['departement']?>
                </td>
            </tr>



            <tr>
                <td>
                    <label><?php echo lang('phone_mobile');?></label>
                </td>
                <td>
                    <?php echo $un_contact['phone_mobile']?>
                </td>
                <td>
                    <label><?php echo lang('fax');?></label>
                </td>
                <td>
                    <?php echo $un_contact['phone']?>
                </td>
                <td>
                    <label><?php echo lang('email');?></label>
                </td>
                <td>
                    <?php echo $un_contact['email']?>
                </td>
                <td>
                    <label><?php echo lang('skype');?></label>
                </td>
                <td>
                    <?php echo $un_contact['skype']?>
                </td>
            </tr>

            <tr>
                <td><?php echo lang('note');?></td>
                <td colspan="7">
                    <?php echo $un_contact['note_public']?>
                </td>
            </tr>
        </table>

        <table class="table table-hover table-bordered">
            <!--标签-->
            <tr>
                <td width="14%">
                    <label><?php echo lang('categ_selected') ?></label>
                </td>
                <td colspan="8">
                    <div id="sous_categ_div">
                        <?php foreach ($categ_selected as $value): ?>
                            <input value=<?php echo $value['label'] ?> type='button' class='btn btn-primary disabled'/>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
        </table>
    <div align="right">
        <a  href="<?php echo base_url('/index.php/contact/edit_contact/').$un_contact['rowid'] ?>" class="btn btn-default"><?php echo lang('edit');?></a>
    </div>
</div>

<?php endforeach; ?>
<script>
    //点击需要编辑的区域后变成可编辑状态
    function click_element(id){
        var id=id.slice(3);
        var value=document.getElementById(id).innerHTML;
        $("#td_"+id).html("<input id='"+id+"' value='"+value+"' onblur='valide_element(this.id,this.value)' class='form-control'/>");
        $("#"+id).focus();
    }
    //确认编辑
    function valide_element(id,value){
        var url="Contact/edit_element/";
        edit_element(id,value,url);
    }
    //确认编辑函数
    function edit_element(id,value,url){
        $("#td_"+id).html("<span id='"+id+"' class='element_info' onclick='click_element(this.id)'>"+value+"</span>");
        var rowid=document.getElementById('rowid').value;
        //alert("value"+rowid);
        $.ajax({
            url: "<?php echo base_url().'index.php/'?>"+url+rowid+"/"+id+"/"+value,
            success: function (result) {
                //$("#"+label_id+"_label").html("设置成功");
                show_snackbar("设置成功",500);
            },
            error: function (result) {
                //$("#"+label_id+"_label").html("错误，设置失败");
                show_snackbar("错误，设置失败",2500);
            }
        });
    }
</script>

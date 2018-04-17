//获得用户选项，隐藏不需要的标签
var base_url=document.getElementById("base_url").value+"index.php/";  
$(document).ready(function(){
    $.ajax({url: base_url+"Ajax_login/get_option", success: function(result){
        json_user_option=eval(result);
        $.each(json_user_option, function() {
            if(this.fk_option==2&&this.status==1){
                $("#fr").hide();
            }
            if(this.fk_option==3&&this.status==1){
                $("#en").hide();
            }
            if(this.fk_option==4&&this.status==1){
                $("#es").hide();
            }
            if(this.fk_option==5&&this.status==1){
                $("#de").hide();
            }
            if(this.fk_option==6&&this.status==1){
                $("#it").hide();
            }
        });
    }});
});
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>鼠标悬停显示提示信息窗口</title>
    <meta http-equiv="content-type" content="text/html;charset=gb2312">
    <style type="text/css">
        .us{display:none;width:300px;height:40px;
            padding:10px;position:relative;top:0px;left:50px;
            background-color:#0099FF;
        }
    </style>
    <script src="jquery-1.6.2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".contact").mouseover(function(){
                $(".us").fadeIn();
                $(".contact").mouseout(function(){
                    $(".us").hide("slow");
                });
            });
        })
    </script>
</head>
<body>
<div class="contact">联系我们</div>
<div class="us">提示内容！提示内容！提示内容！</div>
<div>http://www.jb51.net/</div>
</body>
</html>
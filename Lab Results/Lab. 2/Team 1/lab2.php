<?php
$p1=array(
    'last_name'=>'alx',
    'first_name'=>'john',
    "email"=>'aj@gmail.com'
);
$p2=array(
    'last_name'=>'golden',
    'first_name'=>'oni',
    "email"=>'goni@outlook.com'
);
$p3=array(
    'last_name'=>'messi',
    'first_name'=>'caw',
    "email"=>'mcw@163.com'
);
$p4=array(
    'last_name'=>'andrey',
    'first_name'=>'jia',
    "email"=>'ajiy@orange.com'
);
$infos=array(
    '0'=>$p1,
    '1'=>$p2,
    '2'=>$p3,
    '3'=>$p4
);
?>
<html>
    <head>
        <style>
            tr.c1 td {
                background-color: #CC9999; color: pink;
                border: 1px solid black;
            }
            tr.c2 td {
                background-color: #9999CC; color: powderblue;
                border: 1px solid black;
            }
            table.t1{
                border: 1px solid black; width:40%;
            }
            table.t1 td{
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        lastname
                    </th>
                    <th>
                        firstname
                    </th>
                    <th>
                        email
                    </th>
                </tr>
            </thead>
            <?php $i=1; foreach ($infos as $value):?>
                <tr class="<?php if ($i%2==0) echo "c1"; else echo "c2"?>">
                    <td>
                        <?php echo $i?>
                    </td>
                    <td>
                        <?php echo $value['last_name']?>
                    </td>
                    <td>
                        <?php echo $value['first_name']?>
                    </td>
                    <td>
                        <?php echo $value['email']?>
                    </td>
                </tr>
                <?php $i++?>
            <?php endforeach;?>
        </table>
        <br>
        <table class="t1">
            <tr>
                <td rowspan="3" width="20%">
                    <img id="img1" onmouseover="changePic1()" onmouseout="changePic2()" src="hqdefault.jpg" width="300px">
                </td>
                <td>
                    Jiang is angry !
                </td>
            </tr>
            <tr>
                <td>
                    $000
                </td>
            </tr>
            <tr>
                <td>available</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p id="pharagraph1">
                        Jiang: I just wanted to... Every time... In Chinese we have saying, "Make a fortune quietly." If I had said nothing, that would have been the best. But I thought I've seen all of you so enthusiastic. If I said nothing, that wouldn't be good. So, a moment ago you just insisted... In spreading the news, if your reports are inaccurate, you must be responsible. I did not say giving an imperial appointment. No such meaning. But you insisted on asking me whether I supported Mr. Tung or not. He is still the current Chief Executive. How could we not support the Chief Executive?
                    </p>
                </td>
            </tr>
        </table>
    </br>
    <button onclick="show_paragraph()">show</button>&nbsp<button onclick="hide_paragraph()">hide</button>
    </br>
    <input id="text1" onkeyup="count_string()" type="text" />&nbsp<label id="count_string"></label>
    </body>
</html>
<script>
    function changePic1() {
        document.getElementById("img1").src = 'maxresdefault.jpg';
    }
    function changePic2(){
        document.getElementById("img1").src = "hqdefault.jpg";
    }
    function hide_paragraph(){
        document.getElementById("pharagraph1").style.visibility = "hidden";
    }
    function show_paragraph(){
        document.getElementById("pharagraph1").style.visibility = "visible";
    }
    function count_string(){
        var count=document.getElementById("text1").value.length;
    
        document.getElementById("count_string").innerHTML=count;
    }
</script>

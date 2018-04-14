<?php
$p1=array(
    'last_name'=>'Berthol',
    'first_name'=>'Patoch',
    "email"=>'beber@outlook.com'
);
$p2=array(
    'last_name'=>'Veuveu',
    'first_name'=>'Isa',
    "email"=>'VeveEnLele@gmail.com'
);
$p3=array(
    'last_name'=>'Oubler',
    'first_name'=>'Jean',
    "email"=>'Jouble@yopmail.com'
);
$p4=array(
    'last_name'=>'Merdcier',
    'first_name'=>'Brunio',
    "email"=>'BmR@free.fr'
);
$p5=array(
    'last_name'=>'Bissar',
    'first_name'=>'Brunio',
    "email"=>'BBiss@hotmail.fr'
);
$infos=array(
    '0'=>$p1,
    '1'=>$p2,
    '2'=>$p3,
    '3'=>$p4,
	'4'=>$p5,
);
?>
<html>
    <head>
        <style>
            tr.c1 td {
                background-color: #CC00FF;
				color: cyan;
                border: 1px solid black;
            }
            tr.c2 td {
                background-color: #FF0000; color: yellow;
                border: 1px solid blak;
            }
            table.t1{
                border: 2px solid black; width:50%;
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
				<?php $i=1?>
                    <img id="img1" onmouseover="emmeu()" onmouseout="pandafox()" src="default.jpg" width="300px">
					<?php $i++?>
                </td>
                <td style="text-align:center;">
                    Try to pet him several times
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
                    $1
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
					Only one left, hurry !
				</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p id="wikipedia" style="text-align:center;">
                        The red panda (Ailurus fulgens), also called the lesser panda, the red bear-cat, and the red cat-bear, is a mammal native to the eastern Himalayas and southwestern China. The Ostrich is a species of running birds of the family Struthionidae. It is the largest of all current birds.
                    </p>
                </td>
            </tr>
        </table>
    </br>
		<button onclick="show_wikipedia()">
			show
		</button>
	&nbsp
		<button onclick="hide_wikipedia()">
			hide
		</button>
    </br>
    <input id="text1" onkeyup="count_string()" type="text" />
	&nbsp
		<label id="count_string">
		</label>
    </body>
</html>
<script>
    function emmeu() {
		document.getElementById("img1").src = "Emmeu.jpg";
	}
    function pandafox(){
        document.getElementById("img1").src = "PandaRoux.jpg";
    }
    function hide_wikipedia(){
        document.getElementById("wikipedia").style.visibility = "hidden";
    }
    function show_wikipedia(){
        document.getElementById("wikipedia").style.visibility = "visible";
    }
    function count_string(){
        var count=document.getElementById("text1").value.length;
        document.getElementById("count_string").innerHTML=count;
    }
</script>
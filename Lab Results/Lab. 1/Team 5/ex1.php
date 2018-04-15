<html>
<head>
	<title>PHP</title>
	<style>
	table, tr{
	    border: 1px solid black;
	    border-collapse: collapse;
	}
	body{
		font-family: Arial, sans-serif;
		margin-left: 5%;
	}
	tr:nth-child(even){
		background-color:#ffffcc;
	}
	tr:nth-child(odd){
		background-color:#99ccff;
	}
	</style>
</head>
<body>

<table>
<tr>
 <th style="border: 1px solid black;">#</th>
 <th>Last</th>
 <th>First</th>
 <th>Mail</th>
</tr>
<?php

$users = array(
	$hugo = array("last"=>"Leclere",
								"first"=>"Hugo",
								"mail"=>"hl@gmail.com"),
	$romain = array("last"=>"LePottier",
								"first"=>"Romain",
								"mail"=>"rl@gmail.com"),
	$jean = array("last"=>"Dupont",
								"first"=>"Jean",
								"mail"=>"jd@gmail.com"),
	$giu = array("last"=>"Fortino",
								"first"=>"Giuseppe",
								"mail"=>"gf@gmail.com"),
);

$i = 1;
foreach($users as $user){
	echo "<td style=\"border: 1px solid black;\">".$i."</div><td>".$user['last']."</td><td>".$user['first']."</td><td>".$user['mail']."</td></tr>";
	$i++;
}
echo "</table></html>";


?>
</body>
</html>

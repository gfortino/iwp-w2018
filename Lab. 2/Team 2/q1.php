<html>
	<head>
		<title> My first website </title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<table>
			<tbody>
				<tr>
					<th>#</th>
					<th>First</th>
					<th>Last</th>
					<th>Email</th>
				</tr>
			</tbody>
			<?php
			$person1 = array("Alexis", "Bugielski", "alexis.bugielski@toto.com");
			$person2 = array("Julien", "Dos Santos", "julien.dossantos@toto.com");
			$person3 = array("Antoine", "Wang", "antoine.wang@toto.com");
			$persons = array($person1, $person2, $person3);
			$i = 0;
			foreach($persons as $p){
				echo("<tbody class=");
				if($i%2==0){
					echo("lightBlue>");
				}
				else{
					echo("darkBlue>");
				}
					echo("<tr>");
						echo("<td>$i</td>");
						echo("<td>".$p[0]."</td>");
						echo("<td>".$p[1]."</td>");
						echo("<td>".$p[2]."</td>");
					echo("</tr>");
				echo("</tbody>");
				$i++;
			}
			?>
		</table>
	</body>
</html>
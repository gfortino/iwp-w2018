<html>
	<head>
		<title>Name Table.</title>
		<link rel = "stylesheet" href = "bckgrnt.css">
		<link rel = "stylesheet" href = "tablent.css">
	</head>
	
	<body>
	<?php
		$num = 1;
	?>
		<table>
			<tr>
				<td>Last name.</td>
				<td>First name.</td>
				<td>E-mail.</td>
			</tr>
			<tr class = "paire">
				<td > <?php echo $num ; num++; ?></td>
				<td>Bocquet</td>
				<td>Anne-Laure</td>
				<td>alb@voila.com</td>
			</tr>
			<tr class = "impaire">
				<td > <?php echo $num ; num++; ?></td>
				<td>Bugielski</td>
				<td>Alexis</td>
				<td>ab@voila.com</td>
			</tr>
			<tr class = "paire">
				<td > <?php echo $num ; num++; ?></td>
				<td>Dos Santos</td>
				<td>Julien</td>
				<td>jds@voila.com</td>
			</tr>
			<tr class = "impaire">
				<td > <?php echo $num ; num++; ?></td>
				<td>Wang</td>
				<td>Antoine</td>
				<td>aw@voila.com</td>
			</tr>
			
		</table>
	
	</body>
<html>
	<head>
		<title>Question 2</title>
	</head>
	
	<body>
		<?php
			echo("<pre>");
			$phone1 = array('Type phone' => 'Home', 'Phone number' => 0102030405);
			$phone2 = array('Type phone' => 'Work', 'Phone number' => 2125550485);
			$phone3 = array('Type phone' => 'cell', 'Phone number' => 2125550169);

			$person = array($phone1, $phone2, $phone3);

			var_dump($person);
		?>
	</body>
		
</html>
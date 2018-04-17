<html>
	<head>
		<title>Question 1</title>
	</head>
	
	<body>
		<?php
			echo("<pre>");
			
			$email = array('Address type' => 'mailling', 'civic number' => 'None', 'street' => 'None', 'City' => 'None', 'Province' => 'None', 'Country' => 'Canada', 'Postal code' => 12456);
			$address1 = array('Address type' => 'billing', 'Civic number' => 670, 'Street' => 'St Catherine', 'City' => 'Montreal', 'Province' => 'QC', 'Country' => 'Canada', 'Postal code' => 12456);
			$person = array($email, $address1);
			
			 var_dump($person);
			
			
		?>
	</body>
		
</html>
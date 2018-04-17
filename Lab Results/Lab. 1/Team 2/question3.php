<html>
	<head>
		<title>Question 3</title>
	</head>
	
	<body>
		<?php
			echo("<pre>");
			
			$person = ["first name" => "Bob", "last name" => "DYLAN"];
			
			$email1 = array('Address type' => 'mailling', 'Address' => 'bob.dylan@gmail.com', 'Country' => 'Canada', 'Postal code' => 12456);
			$email2 = array('Address type' => 'mailling', 'Address' => 'bob.dylan@outlook.com', 'Country' => 'Canada', 'Postal code' => 12456);
			$email3 = array('Address type' => 'mailling', 'Address' => 'bob.dylan@yahoo.com', 'Country' => 'Canada', 'Postal code' => 12456);
			$emails = array($email1, $email2, $email3);
			
			$phone1 = array('Type phone' => 'Home', 'Phone number' => 2125559875);
			$phone2 = array('Type phone' => 'Work', 'Phone number' => 2125550485);
			$phone3 = array('Type phone' => 'cell', 'Phone number' => 2125550169);
			$phones = array($phone1, $phone2, $phone3);
			
			$person["Email"] = $emails;
			$person["Phone"] = $phones;
			
			 var_dump($person);
		?>
	</body>
		
</html>
<html>
	<head>
		<title>Assignment</title>
	</head>
	<body>

<?php
	
	//Question 1
	$address1 = ['address type' => billing,'civic number' => 333, 'street' => 221B Baker street, 'city' => London, 'province' => none, 'country' => England, 'Postal Code'=> 22 100];
	$email1 = ['address type' => mailing,'email'=> Sherlock.H@gmail.fr];
	
	$SH = [$address1,$email1];
	var_dump($SH);
	
	//question 2
	
	$phone1 = ['phone type' => cell,'phone number' => 0617558805];
	$phone2 = ['phone type' => work,'phone number' => 2004656028];
	$contact =[$phone1,$phone2];
	var_dump($contact);
	
	//Question 3
	
	$identity1 = ['first name' => Sherlock, 'last name' => Holmes];
	$phone3 = ['phone number' => 0617558805,];
	$phone4 = ['phone number' => 2004656028,];
	$email3 = ['address type' => mailing,'email'=> Sherlock.H@gmail.fr];
	$fullidentity = [$identity1, $phone3,$phone4, $email3];
	var_dump($fullidentity);
	
	//Question 4
	
	
	$item1 = ['itemdescription' => fish, 'item number' => 5, 'unit price' => 50, 'quantity'=> 3];
	$item2 = ['itemdescription' => chips, 'item number' => 105, 'unit price' => 10, 'quantity'=> 12];
	
	$cart1 = [$item1,$item2];
	
	//Question 5 
	$price1 = [$item1[3]*$item1[2]+$item2[3]*$item2[2]];
	$price2 = [$price1[0]*1.05];
	$price3 = [$price2[0]*1.09975];
	if ($price1 < 35) {
	$price4 = [$price3[0]+10];
	}
	echo('total price :' $price4];
	
?>
	</body>
</html>


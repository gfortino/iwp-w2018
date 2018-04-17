<html>
	<head>
		<title>Assignment</title>
	</head>
	<body>

<?php
	
	//Question 1
// INSTRUCTOR: parse error for 'street' -0.1
// INSTRUCTOR: parse error for 'Postal Code' -0.1
// INSTRUCTOR: 'billing', 'London', 'none', 'England' require single quotes as they are literals -0.1
	$address1 = ['address type' => 'billing','civic number' => 333, 'street' => '221B Baker street', 'city' => 'London', 'province' => 'none', 'country' => 'England', 'Postal Code'=> 22100];
// INSTRUCTOR: parse error for 'email' -0.1
// INSTRUCTOR: 'mailing' is a literal, not a constant -0.1
	$email1 = ['address type' => 'mailing','email'=> 'Sherlock.H@gmail.fr'];
	
	$SH = [$address1,$email1];
	var_dump($SH);
	
	//question 2
	
// INSTRUCTOR: numbers starting with 0 in PHP are octal.  No points deducted as this was not covered in class.
	$phone1 = ['phone type' => 'cell','phone number' => 617558805];
	$phone2 = ['phone type' => 'work','phone number' => 2004656028];
	$contact =[$phone1,$phone2];
	var_dump($contact);
	
	//Question 3

// INSTRUCTOR: more errors with strings not in quotes...	
	$identity1 = ['first name' => 'Sherlock', 'last name' => 'Holmes'];
	$phone3 = ['phone number' => 617558805,];
	$phone4 = ['phone number' => 2004656028,];
	$email3 = ['address type' => 'mailing','email'=> 'Sherlock.H@gmail.fr'];
	$fullidentity = [$identity1, $phone3,$phone4, $email3];
	var_dump($fullidentity);
	
	//Question 4
	
	
	$item1 = ['itemdescription' => 'fish', 'item number' => 5, 'unit price' => 50, 'quantity'=> 3];
	$item2 = ['itemdescription' => 'chips', 'item number' => 105, 'unit price' => 10, 'quantity'=> 12];
	
	$cart1 = [$item1,$item2];
	
	//Question 5 
// INSTRUCTOR: should consider using a loop and array of items. -0.1
// INSTRUCTOR: precedence is forced using parenthesis rather than square brackets. -0.1
// INSTRUCTOR: associative arrays must be referenced by index name and not numeric position.  -0.1
	$price1 = $item1['quantity']*$item1['unit price']+$item2['quantity']*$item2['unit price'];
	$price2 = $price1[0]*1.05;
// INSTRUCTOR: QST tax only applies to residents of Quebec.  You must check the province in the address.  -0.1
	$price3 = $price2[0]*1.09975;
// INSTRUCTOR: $price4 is not defined for orders under $35 since line 55 will not be executed.
// INSTRUCTOR: the error will be reported on line 60.  -0.1
	$price4 = 0;
	if ($price1 < 35) {
		$price4 = $price3[0]+10;
	}
// INSTRUCTOR: missing parenthesis at the end instead of square bracket. -0.1
	echo('total price :' . $price4);
	
?>
	</body>
</html>


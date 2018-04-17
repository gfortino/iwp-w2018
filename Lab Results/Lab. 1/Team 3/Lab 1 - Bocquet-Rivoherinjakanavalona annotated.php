<html>
	<head>
		<title> LAB 1 </title>
	</head>


	<body>

		<h1>Question 1 </h1>
			<?php
				echo("<pre>");


						
$allAddresses = array(	1 =>array(	'Address type' => 'mailling',
																		'Civic number' =>  '22',
																		'Street' => 'Robert Bourassa',
																		'City' => 'Montréal',
																		'Province' => 'QC',
																		'Postal Code' => 'H2L'),
												2 =>array('Address type' => 'bailling',
																		'Civic number' =>  '52',
																		'Street' => 'Camille Desmoulins',
																		'City' => 'Cachan',
																		'Province' => 'IDF',
																		'Postal Code' => '94230')
											);

	
var_dump($allAddresses)	;		


$person = array(	'Anna' => array($allAddresses[1]),
									'Laure' => array($allAddresses[1], $allAddresses[2]));

var_dump($person);						
?>


<h1>Question 2 </h1>
<?php
$phoneNumber = array ( 'phone type' => 'mobile',
						'phone number' => '0632587415'
						);
$phoneNumber2 = array ( 'phone type' => 'work',
						'phone number' => '0589536112'
						);
$allPhoneNumber = array(1 => $phoneNumber, 2 => $phoneNumber2);

$person = array ( 	'John' => array ($allPhoneNumber[1], $allPhoneNumber[2]),
				  					'Tom' => array ($allPhoneNumber[2], $allPhoneNumber[1])
				  );
						
var_dump($person);

?>
<h1>Question 3 </h1>
<?php
$person = array( 1 => array( 'FirstName' => 'Dupont',
															'LastName' => 'Anna',
															'mailing addresse' =>array('annedu94@gmail.com','anne.dupont@efrei.net'),
															'phone numbers' => '0699531802'
															),
									2 =>array( 'FirstName' => 'Leroux',
															'LastName' => 'Bruno',
															'mailing addresse' =>array('b.leroux@gmail.com','leroux.bruno@efrei.net'),
															'phone numbers' => array(	'cell' => '0699530956',
																										 			'home' => '0145738235')
															) );

var_dump($person);
echo "	Personne 1 : {$person[1]['FirstName']} {$person[1]['LastName']}  \n	Personne 2 : {$person[2]['FirstName']}  {$person[2]['LastName']}  \n";



?>
<h1>Question 4 </h1>
<?php
$shopcart = array(	1 => array(	'item description' => 'Pink dress',
															 	'item number' => 1,
									 							'unit price' => '50.99',
									 							'quantity' => 2),
									 	2 => array(	'item description' => 'Black bag',
															 	'item number' => 2,
									 							'unit price' => '100',
									 							'quantity' => 1)
									 							
									 	);
									 
var_dump($shopcart);


?>
<h1>Question 5 </h1>
<?php
$total = ($shopcart[1]['unit price'] * $shopcart[1]['quantity']) + ($shopcart[2]['unit price'] * $shopcart[2]['quantity']) ;
echo "Total shopping : {$total} \n";
$addTaxe1 = $total + ($total*0.05);
echo "\t+GST : {$addTaxe1}\n";
if($total<35) {
	$addTaxe2 = $addTaxe1+($addTaxe1*0.09975);
	$addTaxe2 = $addTaxe2addTaxe2 + 10;
	echo "\t+QST : {$addTaxe2} ( with shipping charge )\n";
}else {
	$addTaxe2 = $addTaxe1+($addTaxe1*00.9975);
	echo "\t+QST : {$addTaxe2} \n";
}

// INSTRUCTOR:
//		QST only applies if province is QC.  You need to check the address record.  -0.1
//		QST should be calculated the same way in regardless of shipping (see lines 101 and 105).
//		Using constants would help in preventing these errors (tax on line 105 is actually 99.75% instead of 9.975%). -0.1

?>
	</body>


</html>



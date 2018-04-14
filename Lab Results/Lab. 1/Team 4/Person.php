<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Bills</title>
	Bills 
	<br>
	</head>
	<body>
		

<?php
	$personaddress= array(
		'mail' =>'robert.bourassa@gmail.com',
		'billing' => '58 st antoine street'
	);

	$personaddress['civic number'] = '0123456789';
	$personaddress['street'] = '21 jump street';
	$personaddress['city'] = 'Newyork';
	$personaddress['province'] = 'Quebec';
	$personaddress['postal code']='369';

	print "<br>";
	print "\t Personnal informations : <br> ";
foreach($personaddress as $info){
	
	print "\t $info <br> \n" ;
	
}


$personphone = array(
		'Home'=>'5465465456',
		'Work'=>'1231231233',
		'Cell'=>'7897897899'
);
	print '<br>Phone numbers : <br>';
	print "Home: $personphone[Home]<br>";
	print "Work: $personphone[Work]<br>";
	print "Cell: $personphone[Cell]<br>";

	
$item1['itemnumber']='1000';
$item1['description']='really beautiful';
$item1['price/unit'] = 1;
$item1['quantity'] =10;

$item2['itemnumber']='1001';
$item2['description']='really awful';
$item2['price/unit'] = 2;
$item2['quantity'] =5;



$shoppingcart[] = $item1;
$shoppingcart[] = $item2;

		
print"<br>Content of the cart : <br>";

		
foreach($shoppingcart as $contenu){ 
		// print key($contenu);
	foreach($contenu as $item){
		
		print " $item<br> " ;
}
}
// Here we have try to display the index of $contenu to get every name index of items to get
//better visibility but without sucess . 
$totalprice1=0;
foreach($shoppingcart as $content) {

	$totalprice1=$totalprice1 + ($content['price/unit']*$content['quantity']);
	}
print "<br>Price without taxes is : $totalprice1 <br>";
print " Do you exceed 35 dollars? <br>";
$shippingcharge = 10 ;
if($totalprice1>35){
	print "Yes, then you have 10 dollars reduction <br>";
	$totalprice2=$totalprice1-$shippingcharge;
}
else {
	print " No ";
	$totalprice2=$totalprice1;
}
print " Your price without taxes is : $totalprice2 <br>";
$GST = 0.05;
$additionnal_1=$GST*$totalprice2;
print" Your additionnal GST taxe is  : $additionnal_1 <br> ";

$totalprice3=$totalprice2*(1+$GST);
print " Do you live in the province Quebec ? <br> ";

$QST=0.0975;
if($personaddress['province']=='Quebec'){
	print"Yes, then you must pay the QST <br> ";
	$additionnal_2=$totalprice3*$QST;
	print"Your additionnal taxe is : $additionnal_2<br>" ;
	$totalprice4=$totalprice3*(1+$QST);
}
else {
	print"No";
	$totalprice4=$totalprice3;
}

print " So you must pay : $totalprice4 ";
?>
	</body>
</html>

<!--Hugo LECLERE, Romain LE POTTIER-->
<html>
	<head>
		<title>Lab Exercise 1</title>
		<style>
		body{
			font-family: Arial, sans-serif;
			margin-left: 5%;
		}
		h1{
			color:#f44141;
		}
		</style>
	</head>
	<body>
		<h1>Lab Exercise 1</h1>

<?php
// Person's postal address
$addresses = array(
    $address1 = ['type' => 'Billing',
    'civicNumber' => '190',
    'street' => 'St Catherine',
    'city' => 'Montreal',
    'province' => 'Quebec',
    'country' => 'Canada',
    'postalCode' => 'H3C3Z7',
    ],
    $address2 = ['type' => 'Mailing',
    'civicNumber' => '1124',
    'street' => 'Ralph Drive',
    'city' => 'Toronto',
    'province' => 'Ontario',
    'country' => 'Canada',
    'postalCode' => 'M1R0E9',
    ],
);

//Person's phone number
$phones = array(
    $phone1 = ['type' => 'Home',
    'number' => '636-438-3644',
    ],
    $phone2 = ['type' => 'Fax',
    'number' => '440-287-5405',
    ]
);

// Find only the mailing addresses
foreach ($addresses as $address) {
    if ($address['type'] == 'Mailing') {
        $mailingAddress[] = $address;
    }
}

// Person's information
$informations = ['firstName' => 'Hugo',
                                 'lastName' => 'Leclere',
                                 'mailingAddresses' => $mailingAddress,
                                 'phones' => $phones];


// Shopping cart
$shopCart = array(
    $item1 = ['itemDescription' => 'Table',
                        'itemNumber' => '120',
                        'unitPrice' => 20,
                        'quantity' => 1],
    $item2 = ['itemDescription' => 'chair',
                        'itemNumber' => '65',
                        'unitPrice' => 10,
                        'quantity' => 1]
 );

$i=1;
$s = "<li><b>Person's postal address</b><br>".
         "First name : ".$informations['firstName']."<br>".
         "Last name : ".$informations['lastName']."<br>";
foreach ($addresses as $address) {
    $s .= "<b>Address n°".$i."</b><br>".
        "Address type : ".$address['type']."<br>".
                "Civic number : ".$address['civicNumber']."<br>".
                "Street : ".$address['street']."<br>".
                "City : ".$address['city']."<br>".
                "Province : ".$address['province']."<br>".
                "Country : ".$address['country']."<br>".
                "Postal code : ".$address['postalCode']."<br><br>";
    $i++;
}

$s .= "<li><b>Person's phone number</b><br>";
foreach ($phones as $phone) {
    $s .= "Type : ".$phone['type']."<br>".
                "Number : ".$phone['number']."<br><br>";
}

$s = $s."<li><b>Shopping cart</b><br>";
foreach ($shopCart as $item) {
    $s .= "Item description : ".$item['itemDescription']."<br>".
                "Item number : ".$item['itemNumber']."<br>".
                "Unit price : ".$item['unitPrice']."$<br>".
                "Quantity : ".$item['quantity']."<br><br>";
}

$total = 0.0;
$qst = 0.0;
$fees = 10;

// Test if the sopping cart is not empty
if (!empty($shopCart)) {
    foreach ($shopCart as $product) {
        // Price of all products before taxes
        $total += $product['unitPrice'] * $product['quantity'];
    }

    // GST
    $gst = (5*$total)/100;
    $s .= "<li><b>Total</b> without fees : ".$total."$<br>" ;

    // If total price < 35$
    if ($total<35) {
        $total+= 10;
        $s .= "Shipping +10$<br>" ;
    } else {
        $s .= "Free shipping<br>";
    }

    // QST
    foreach ($addresses as $address) {
        if ($address['province'] == 'Quebec') {
            $qst =  (9.975*$total)/100;
            $s.= "QST +".round($qst, 2)."$<br>" ;
        }
    }
    $s .= "GST +".round($gst, 2)."$<br>" ;
    // Add taxes
    $total += $gst + $qst;
    $s .= "<li><b>Total ".round($total, 2)."$</b></body></html>";
}
echo $s;

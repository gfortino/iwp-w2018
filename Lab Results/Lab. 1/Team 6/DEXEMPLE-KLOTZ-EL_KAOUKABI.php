<?php
    echo ("<pre>");
    //1. Create an array that contains a person's postal address:
    $persons = array('address' => ["Address 1", "Address 2"],
                    'civicNumber' => '10',
                    'street' => 'streetname',
                    'city' => 'cityName',
                    'province' => 'proviceName',
                    'country' => 'countryName',
                    'postalCode' => 'postalCode'
                    );

    var_dump($persons);

    //2. Create an array that contains a person's phone number:
    $phone1 = array('Home' => '561521',
                    'Mobile' => '14615');

    $phone2 = array('Home' => '5254521',
                    'Mobile' => '125415');

    $peoplePhone = array($phone1,$phone2);

    var_dump($peoplePhone);


    //3.Create an array that contains a person's information:
    $personsInfos = array(
                    'firstName' => 'Francois',
                    'lastName' => 'Dexemple',
                    'mailingAddress' => ["francois.dexemple@epita.fr", "dexemple.francois@epita.fr"],
                    'phoneNumber' => ["0645852687", "0746268531"]
                    );

    var_dump($personsInfos);

    //4. Create an array that contains a shop cart of purchased items
    $item1 = array(
                    'itemDescription' => 'Nice pen',
                    'itemNumber' => 102,
                    'unitPrice' => 4,
                    'quantity' => 2
                    );

    $item2 = array(
                    'itemDescription' => 'Other pen',
                    'itemNumber' => 103,
                    'unitPrice' => 8,
                    'quantity' => 1
                    );


    $cart = array($item1,$item2);
    var_dump($cart);
    echo PHP_EOL . PHP_EOL .PHP_EOL;
    //5.  Implement the following features:

    $tot = 0;
    foreach ($cart as $item) {
        $tot+=$item['unitPrice']*$item['quantity'];
    }

    echo "Total of cart = " . $tot . PHP_EOL;
    $GST =  $tot*5/100;
    echo "GST = " . $GST . PHP_EOL;
    $QST = $tot*9.975/100;
    echo "QST = " . $QST .PHP_EOL;
    if ($tot<35) {
        echo "Shipping = 10" . PHP_EOL;
        $tot+=10;
    }
    $tot+=$QST+$GST;
    echo "Total = " . $tot . PHP_EOL;
?>

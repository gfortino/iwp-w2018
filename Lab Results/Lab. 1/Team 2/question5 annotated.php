<html>
	<head>
		<title>Question 5</title>
	</head>
	
	<body>
		<?php
			echo("<pre>");
			
			$item1 = ["item descritption" => "Asus rog", "item number" => 100002, "unit price" => 2200, "quantity" =>1];
			$item2 = ["item descritption" => "StarCraft Collection", "item number" => 100999, "unit price" => 60, "quantity" =>1];
			$item3 = ["item descritption" => "Bose headset", "item number" => 100003, "unit price" => 300, "quantity" =>1];
			
			$card = [$item1, $item2, $item3];
			var_dump($card);
			
			$total = 0;
			foreach($card as $i){
				$total += $i['quantity']*$i['unit price'];
			}
			
			$gst = $total * 0.05;
			$qst = $total * 0.09975;
			
			$shipping = 0;
			if($total < 35){
				$shipping = 10;
			}
// INSTRUCTOR: QST only applies to residents of Quebec.  You need to check address record. -0.1
			$total_price = $total + $qst + $gst + $shipping;
			
			echo('Total: ' . $total . '<br>');
			echo('GST: ' . $gst . '<br>');
			echo('QST: ' . $qst . '<br>');
			if($shipping > 0){
				echo('Shipping: ' . $shipping . '<br>');
			}
			echo('Total price: ' . $total_price . '<br>');
		?>
		
	</body>
		
</html>
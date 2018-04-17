<html>
	<head>
		<title>Question 4</title>
	</head>
	
	<body>
		<?php
			echo("<pre>");
			
			$item1 = ["item descritption" => "Asus rog", "item number" => 100002, "unit price" => 2200, "quantity" =>1];
			$item2 = ["item descritption" => "StarCraft Collection", "item number" => 100999, "unit price" => 60, "quantity" =>1];
			$item3 = ["item descritption" => "Bose headset", "item number" => 100003, "unit price" => 300, "quantity" =>1];
			
			$card = [$item1, $item2, $item3];
			 var_dump($card);
			
			
		?>
	</body>
		
</html>
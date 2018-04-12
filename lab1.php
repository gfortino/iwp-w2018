<?php
	$address1=array(
		'type'=>'mailing',
		'civic_number'=>'12345',
		'street'=>'st vincent',
		'city'=>'Metz',
		'province'=>'Lorraine',
		'country'=>'France',
		'postal_code'=>'57000'
	);
	$address2=array(
		'type'=>'billing',
		'civic_number'=>'3232',
		'street'=>'st louis',
		'city'=>'Metz',
		'province'=>'Lorraine',
		'country'=>'France',
		'postal_code'=>'57065'
	);
	$phone_number1=array(
		'type'=>'home',
		'phone_number'=>'0783463984',
	);
	$phone_number2=array(
		'type'=>'work',
		'phone_number'=>'0383593934',
	);

	$addresses=array(
		'0'=>$address1,
		'1'=>$address2
	);
	$phone_numbers=array(
		'0'=>$phone_number1,
		'1'=>$phone_number2
	);

	$person_info=array(
		'first_name'=>'zherui',
		'last_name'=>'LI',
		'mailing_address'=>$addresses,
		'phone_numbers'=>$phone_numbers

	);
	//print_r($person_info);


	$shop_card=array(
		'description'=>'carrefour point card',
		'number'=>'QW1234',
		'unit_price'=>'20',
		'quantity'=>'30'
	);
	//echo "<br><br>";
	//print_r($shop_card);

	$total_ht=$shop_card['unit_price']*$shop_card['quantity'];
	$tax=$shop_card['unit_price']*$shop_card['quantity']*(0.05+0.09975);
	if($tax<35){
		$tax+=10;
	}
	$total_ttc=$total_ht+$tax;
?>
<html>
	<body>
		<table>
			<tr>
				<td>first_name:</td>
				<td><?php echo $person_info['first_name']?></td>
			</tr>
			<tr>
				<td>last_name:</td>
				<td><?php echo $person_info['last_name']?></td>
			</tr>
			<tr>
				<td>first_name:</td>
				<td><?php echo $person_info['first_name']?></td>
			</tr>
			<?php foreach ($person_info['mailing_address'] as $value): ?>
				<tr>
					<td>
						type: 
						</td>
						<td><?php echo $value['type']?>
					</td>
				</tr>
				<tr>
					<td>
						civic_number: </td>
						<td><?php echo $value['civic_number']?>
					</td>
				</tr>
				<tr>
					<td>
					street: </td><td><?php echo $value['street']?>
					</td>
				</tr>
				<tr>
					<td>
					city: </td><td><?php echo $value['city']?>
					</td>
				</tr>
				<tr>
					<td>
					province: </td><td><?php echo $value['province']?>
					</td>
				</tr>
				<tr>
					<td>
					country: </td><td><?php echo $value['country']?>
					</td>
				</tr>
				<tr>
					<td>
					postal_code: </td><td><?php echo $value['postal_code']?>
					</td>
				</tr>
			<?php endforeach;?>
			<?php foreach ($person_info['phone_numbers'] as $value): ?>
				<tr>
					<td>
						type: <?php echo $value['type']?>
					</td>
				</tr>
				<tr>
					<td>
					phone_number: <?php echo $value['phone_number']?>
					</td>
				</tr>
			<?php endforeach;?>
		</table>
		<br>
		<table>
			<tr>
				<td>
					description: </td><td><?php echo $shop_card['description'];?>
				</td>
			<tr>
			<tr>
				<td>
				number: </td><td><?php echo $shop_card['number'];?>
				</td>
			<tr>
			<tr>
				<td>
				unit_price: </td><td><?php echo $shop_card['unit_price'];?>
				</td>
			<tr>
			<tr>
				<td>
				quantity: </td><td><?php echo $shop_card['quantity'];?>
				</td>
			<tr>
		</table>
		<br>
		total ht: <?php echo $total_ht?>
		<br>
		tax: <?php echo $tax;?>
		<br>
		total_ttc: <?php echo $total_ttc;?>
	<body>
</html>
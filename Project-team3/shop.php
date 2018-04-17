<?php

	include("connexion_bd.php");
    $bsCont = new beautyShopController();
    // on verifie l'existence des sessions
   // if(isset($_SESSION['lastName']) and ($_SESSION['firstName']))
    //{
  
  
  		if(!empty($_GET["action"])) {
			switch($_GET["action"]) {
					case "add":
							echo "je suis dans add";
							if(!empty($_POST["quantity"])) {
								//we get all item by their Code
									$itemCodeArray = $bsCont->runQuery("SELECT * FROM item WHERE code='" . $_POST["code"] . "'");
									$itemArray = array($itemCodeArray[0]["code"]=>array('name'=>$itemCodeArray[0]["name"], 'code'=>$itemCodeArray[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
			
									if(!empty($_SESSION["cart"])) {
											if(in_array($itemCodeArray[0]["code"],array_keys($_SESSION["cart"]))) {
													foreach($_SESSION["cart"] as $k => $v) {
														if($itemCodeArray[0]["code"] == $k) {
																if(empty($_SESSION["cart"][$k]["quantity"])) {
																		$_SESSION["cart"][$k]["quantity"] = 0;
																}
																$_SESSION["cart"][$k]["quantity"] += $_POST["quantity"];
														}
													}
											} else {
												$_SESSION["cart"] = array_merge($_SESSION["cart"],$itemArray);
											}
									} else {
											$_SESSION["cart"] = $itemArray;
									}
									
							}
							//header("Location: cbForm.php");
				break;
				case "remove":
					if(!empty($_SESSION["cart"])) {
							foreach($_SESSION["cart"] as $k => $v) {
								if($_POST["code"] == $k)
										unset($_SESSION["cart"][$k]);				
											if(empty($_SESSION["cart"]))
													unset($_SESSION["cart"]);
							}
					}
				break;
				case "empty":
						unset($_SESSION["cart"]);
				break;	
		}
	}
?>

<html>
    <head>
		<title>Beauty Shop</title>
		<meta charset = "utf-8">
		<meta name="viewreport" content="width=device-width, initial-scale=1.0">
<link href="shop.css" type="text/css" rel="stylesheet" />


			
			<div class ="pres1">
				<div class = "pres2">
					<h1 class="top">Beauty Store</h1>
				</div>
			</div>

			<nav>
					<div class="table"> 
						<ul>
							<li class="profil">
								<a href="userSession.php">Home</a>
							</li>
							<li class="shop">
								<a href="shop.php">Shop</a>
									<ul class="items">
										<li><a href="#">Shampoo</a></li>
										<li><a href="#">Shower gel</a></li>
										<li><a href ="#">Lotion</a></li>
										<li><a href ="#">Make up</a></li>
										<li><a href ="#">Accessories</a></li>
									</ul>
							</li>
							<li class="profil">
								<a href="profil.php">Profil</a>
									<ul class="items">
										<li><a href ="profil.php">My profil</a></li>
										<li><a href ="deconnexion.php">Loge out</a></li>
									</ul>
							</li>
						</ul>
					</div>
			</nav>
	</head>

    <body>
 
 <h2>My Cart</h2>
				<div><input type="submit" value="Buy" class="button" onclick='buy()' /></div>
				<script >
						function buy() {
								window.location.replace("cbForm.php");
						}
				</script>
<div id="mycart" class="block-page" style="display: none;" >

<?php

if(isset($_SESSION["cart"])){
    $item_total = 0;


    foreach ($_SESSION["cart"] as $item){
		?>
				<p>
				<label><?php echo $item["name"]; ?></strong></label>
				</br>
				<label><?php echo $item["code"]; ?></strong></label>
				</br>
				<label><?php echo $item["quantity"]; ?></strong></label>
				</br>
				<label><?php echo "$".$item["price"]; ?></strong></label>
				</br>
				<a href="shop.php?action=remove&code=<?php echo $item["code"]; ?>" class="button">Remove Item</a>
				</br>
				</p>
				<?php
        $item_total += ($item["price"]*$item["quantity"]);
        ?>
        <label><?php echo "Total : $".$item_total; ?></strong></label>
				</br>
				<?php
		}

}else if ( ! isset($_SESSION['cart']) ){
		$_SESSION['cart'] = array();
}
?>
</div>


<h1> Shop </h1>
    			
<div id="shop_item" class="myitem">

	<?php
	$product_array = $bsCont->runQuery("SELECT * FROM item ORDER BY idItem ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product">
			<form method="post" action="shop.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="imgDiv">
					<img src="<?php echo $product_array[$key]["image"]; ?>" class="image">
					<div class="inside">  
						<div><input type="submit" value="Add to cart" class="button" /></div>
					</div>
			</div>
			<div class="desc">
			<div class="header"><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
			<div class="price"><?php echo "$".$product_array[$key]["price"]; ?></div>
			<input type="text" name="quantity" value="1" size="2" />
			</div>
			</form>
		</div>
	<?php
			}
	}else {
		echo "no rows";
	}
	?>
</div>



    </body>

    

</html>



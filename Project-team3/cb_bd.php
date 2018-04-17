<?php
    // INCLUDE
    include("connexion_bd.php");
    
    session_start();      
        $bsCont = new beautyShopController();
			
		$idUser = $_SESSION['idUser'];
		$crypto = md5($_POST['crypto']);
		$numCB = md5($_POST['cbNumber']);
		$typeCB = $_POST['typeCB'];
		$dateExp = $_POST['expirationDate'];
		
		$check="SELECT typeCB, numCB, expDate,idUser FROM cb WHERE typeCB = '".$typeCB."' AND numCB = '".$numCB."' AND idUser = '".$idUser."'  ";
       $test = $bsCont->numRows($check);
		if($test >= 1) {
    		//echo "item already exists<br/>".$test;
    				?>
    			<script language="JavaScript">
        				alert("CB already exists. Purchase done");
        				window.location.replace("shop.php");
    			</script>
    			<?php
    		
    		
		}else {
			$addAddress = "INSERT INTO cb (typeCB, numCB, expDate,idUser, crypto) VALUES ('$typeCB','$numCB', '$dateExp', '$idUser', '$crypto')"; 
			$result = $bsCont->queryFunc($addAddress);
			?>
    			<script language="JavaScript">
						alert("Purchase done");
        				window.location.replace("shop.php");
    			</script>
    <?php
		}
		
	
			
			
?>
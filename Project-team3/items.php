<?php

	include("connexion_bd.php");
	
	
    function &getItems()
    {
    	$co = connexion();
    	$getinfo = "SELECT idItem, nameItem, brandItem, price,type FROM item";
		$query = mysqli_query($co, $getinfo);
		

		
    	$allItem = array();


		while ($row = mysqli_fetch_array($query)) {
    		
       $allItem[] = array(
        	"idItem" => $row['idItem'], 
        	"nameItem" => $row['nameItem'],
        	"brandItem" => $row['brandItem'],
        	"price" => $row['price'],
        	"type" => $row['type']

		 );
		
    	}
    	 return $allItem;

    }
                            
?>
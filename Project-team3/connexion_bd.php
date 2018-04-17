<?php
class beautyShopController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "beautyShop";
	public $conn;
	
	function __construct() {
		$this->conn = $this->connexionBD();
	}
	
	function connexionBD() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function queryGetEl($query) {
			$result = mysqli_query($this->conn,$query);
			$row=mysqli_fetch_assoc($result);
			return $row;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	
	function queryFunc($query) {
		$result = mysqli_query($this->conn,$query);
		return $result;
	}
}
?>
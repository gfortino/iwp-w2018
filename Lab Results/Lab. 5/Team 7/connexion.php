<?php
	//mysql_connect(infodb.iutmetz.univ-lorraine.fr/phpmyadmin,li128u_appli,31521728);
	$db_config=array();
	$db_config['SGBD']='mysql';
	$db_config['HOST']='127.0.0.1';
	$db_config['DB_NAME']='lab5';//the name of the base (le nom de base)
	$db_config['USER']='root';
	$db_config['PASSWORD']='';
	
	//====
	//connection avec PDO
	try
	{

	$objPdo=new PDO($db_config['SGBD'].':host='.$db_config['HOST'].';dbname='.$db_config['DB_NAME'],$db_config['USER'],$db_config['PASSWORD']);
	unset($db_config);

	}
	catch(Exception $exception)
	{
		die($exception->getMessage());
	}
?>

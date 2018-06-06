<?php
	include("config.php");
	
	$id_teste = $_POST['id_teste'];
	
	try
	{
		$sql_teste = mysql_query("DELETE FROM teste WHERE id_teste=$id_teste");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
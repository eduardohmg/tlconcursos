<?php
	include("config.php");
	
	$id_resolucao = $_POST['id_resolucao'];
	
	try
	{
		$sql_resolucao = mysql_query("DELETE FROM resolucao WHERE id_resolucao=$id_resolucao");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
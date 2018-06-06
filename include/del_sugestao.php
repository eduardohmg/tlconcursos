<?php
	include("config.php");
	
	$id_sugestao = $_POST['id_sugestao'];
	
	try
	{
		$sql_sugestao = mysql_query("DELETE FROM sugestao WHERE id_sugestao=$id_sugestao");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
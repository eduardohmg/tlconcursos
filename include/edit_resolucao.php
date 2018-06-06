<?php
	include("config.php");
	
	$resolucao = $_POST['resolucao'];
	$id_resolucao = $_POST['id_resolucao'];
	$img = $_POST['img_resolucao'];
	
	try
	{
		$sql_resolucao = mysql_query("UPDATE resolucao SET texto='$resolucao', img='$img' WHERE id_resolucao=$id_resolucao");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
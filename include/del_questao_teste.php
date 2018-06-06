<?php
	include("config.php");
	
	$id_questao = $_POST['id_questao'];
	$id_teste = $_POST['id_teste'];
	
	try
	{
		$sql_deletar = mysql_query("DELETE FROM banco WHERE id_questao='$id_questao' AND id_teste='$id_teste'");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
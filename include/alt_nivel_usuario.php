<?php
	include("config.php");
	
	try
	{
		$id_usuario = $_POST['id_usuario'];
		$nivel = ($_POST['nivel']) + 1;
		$sql_alterar = mysql_query("UPDATE usuario SET nivel=$nivel WHERE id_usuario=$id_usuario");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
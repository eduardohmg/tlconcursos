<?php
	include('config.php');
	Sugerir($_POST);
	
	function Sugerir($DATA)
	{
		try
		{
			$sql_sugestao = mysql_query("INSERT INTO sugestao (titulo, corpo, id_usuario) VALUES ('".$DATA['titulo']."', '".$DATA['corpo']."', '".$_SESSION['id_usuario']."')");
			echo "1";
			return true;
		}
		catch(Exception $e)
		{
			echo "erro";
			return false;
		}
	}
?>
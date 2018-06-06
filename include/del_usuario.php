<?php
	include('config.php');
	DelUsuario($_POST['id_usuario']);
	
	function DelUsuario($id_usuario)
	{
		try
		{
			$sql_usuario = mysql_query("DELETE FROM usuario WHERE id_usuario = ".$id_usuario);
			if($sql_usuario)
			{
				echo "1";
			}
		}
		catch(Exception $e)
		{
			echo "0";
		}
	}
?>
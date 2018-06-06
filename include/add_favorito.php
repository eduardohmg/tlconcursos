<?php
	include('config.php');
	AddFavorito($_POST['id_questao']);
	
	function AddFavorito($id_questao)
	{
		try
		{
			$sql_verifica = mysql_query("SELECT * FROM favorito WHERE id_questao = ".$id_questao." AND id_usuario = ".$_SESSION['id_usuario']);
			$numrows = mysql_num_rows($sql_verifica);
			
			if($numrows == 0)
			{
				$sql_favorita = mysql_query("INSERT INTO favorito(id_favorito, id_usuario, id_questao) VALUES('', '".$_SESSION['id_usuario']."', '$id_questao')");
				echo "1";
			}
			else
			{
				$sql_desfavorita = mysql_query("DELETE FROM favorito WHERE id_usuario = ".$_SESSION['id_usuario']." AND id_questao = '$id_questao'");
				echo "0";
			}
		}
		catch(Exception $e)
		{
			echo "0";
		}
	}
?>
<?php
	include("config.php");
	
	Comprar($_POST);
	function Comprar($DATA)
	{
		try
		{
			if(isset($_POST['descricao']) && isset($_POST['valor']) && isset($_POST['quantidade']))
			{
				$sql_compra = mysql_query("INSERT INTO compra (id_usuario, data_pagamento, status, descricao, valor) VALUES ('".$_SESSION['id_usuario']."', Now(), 1, '".$DATA['descricao']."', '".$DATA['valor']."')");
				
				$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = ".$_SESSION['id_usuario']);
				$result_usuario = mysql_fetch_assoc($sql_usuario);
				
				$sql_saldo = mysql_query("UPDATE usuario SET saldo = ".($result_usuario['saldo'] + $DATA['quantidade'])." WHERE id_usuario = ".$_SESSION['id_usuario']);
				echo "1";
				return true;
			}
			else
			{
				echo "erro";
				return true;
			}
		}
		catch(Exception $e)
		{
			echo "erro";
			return true;
		}
	}
?>
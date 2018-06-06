<?php
	include("config.php");
	
	Comprar($_POST);
	function Comprar($DATA)
	{
		try
		{
			if(isset($_POST['id_questao']))
			{
				$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao='".$DATA['id_questao']."'");
				$dados_questao = mysql_fetch_assoc($sql_questao);
			
				$sql_compra = mysql_query("INSERT INTO inventario (id_usuario,id_questao,valor) VALUES ('".$_SESSION['id_usuario']."','".$DATA['id_questao']."','".$dados_questao['valor']."')");
				
				$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = ".$_SESSION['id_usuario']);
				$result_usuario = mysql_fetch_assoc($sql_usuario);
				
				$sql_saldo = mysql_query("UPDATE usuario SET saldo = ".($result_usuario['saldo'] - $dados_questao['valor'])." WHERE id_usuario = ".$_SESSION['id_usuario']);
				echo $result_usuario['saldo'] - $dados_questao['valor'];
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
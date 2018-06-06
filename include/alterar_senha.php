<?php
	include("config.php");
	
	$senha_atual = md5($_POST['senha_atual']);
	$nova_senha = md5($_POST['nova_senha']);
	$confirmar_senha = md5($_POST['confirmar_senha']);
	$email = $_SESSION['email'];
	
	try
	{
		$sql_verifica_senha = mysql_query("SELECT * FROM usuario WHERE email='".$email."' AND senha='".$senha_atual."'");
		$numrows_verifica_senha = mysql_num_rows($sql_verifica_senha);
		
		if($numrows_verifica_senha == 0)
		{
			echo "-2";
		}
		else
		{
			if($nova_senha != $confirmar_senha)
			{
				echo "-3";
			}
			else
			{
				$sql_altera_senha = mysql_query("UPDATE usuario SET senha='".$nova_senha."' WHERE email='".$email."'");
				if($sql_altera_senha)
				{
					echo "1";
				}
				else
				{
					echo "0";
				}
			}
		}
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
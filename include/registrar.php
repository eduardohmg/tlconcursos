<?php
	include('config.php');

	$nome = $_POST['nome'];
	$sobrenome = $_POST['sobrenome'];
	$email=$_POST['email'];
	$senha=md5($_POST['senha']);
	$confirma_senha=md5($_POST['confirma_senha']);

	try
	{
		$row=mysql_query("SELECT * FROM usuario WHERE email='".$email."'");
		$numrows=mysql_num_rows($row);
		if($numrows==0)
		{
			if ($senha!=$confirma_senha)
			{
				echo "-2";
			}
			else
			{
				$sql_inserir = mysql_query("INSERT INTO usuario(id_usuario, email, senha, nome, sobrenome, nivel, saldo) VALUES ('','$email','$senha','$nome','$sobrenome','1','0')");

				if($sql_inserir)
				{
					echo "1";
				}
				else
				{
					echo "0";
				}
			}
		
		} 
		else
		{
			echo "-3";
		}
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
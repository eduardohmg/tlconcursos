<?php
	include("config.php");
	
	Redefinir($_POST);
	function Redefinir($DATA)
	{
		try
		{
			// Falta verificar se o token passou da validade
			$sql_token_senha = mysql_query("SELECT * FROM token_senha WHERE utilizado = '0' AND token = '".$DATA['token']."'");
			
			if(mysql_num_rows($sql_token_senha) > 0)
			{
				$result_token_senha = mysql_fetch_assoc($sql_token_senha);
				mysql_query("UPDATE token_senha SET utilizado = '1', dt_utilizacao = Now() WHERE token = '".$DATA['token']."'");
				mysql_query("UPDATE usuario SET senha = '".md5($DATA['senha'])."' WHERE id_usuario = '".$result_token_senha['id_usuario']."'");
				
				echo "1";
				return true;
			}
			else
			{
				echo "0";
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
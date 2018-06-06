<?php
	session_start();
	error_reporting(E_ALL ^ E_DEPRECATED);
	$serverx="127.0.0.1";
	$bdx="simulado";
	$userx="root";
	$passx="";
	//$userx="u972138764_admin";
	//$passx="031097";

	$query = mysql_connect($serverx,$userx,$passx);
	mysql_select_db($bdx,$query);
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	date_default_timezone_set('America/Sao_Paulo');
		
	if(isset($_SESSION['id_usuario']))
	{
		if(isset($_COOKIE['token']))
		{
			if($_SESSION['token'] != $_COOKIE['token'])
			{
				$_SESSION['token'] = md5(md5(uniqid(mt_rand(), true))).md5(md5(uniqid(mt_rand(), true)));
				setcookie('token', $_SESSION['token'], (time() + (7*24*60*60)),"/",null, null, true);
				$update_token = mysql_query("UPDATE token_conectado SET token=".$_SESSION['token']." WHERE id_usuario='".$_SESSION['id_usuario']."'");
				if(mysql_affected_rows($update_token) == 0)
				{
					$sql_inserir_token = mysql_query("INSERT INTO token_conectado(id_token,token,id_usuario,utilizado,validade) VALUES('','".$_SESSION['token']."','".$_SESSION['id_usuario']."','0',7,)");
				}
			}
		}
	}
	else
	{
		if(isset($_COOKIE['token']))
		{
			$sql_usuario_token = mysql_query("SELECT * FROM token_conectado WHERE token='".$_COOKIE['token']."'");
			$dados_usuario_token = mysql_fetch_assoc($sql_usuario_token);
			
			$sql_busca_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario='".$dados_usuario_token['id_usuario']."'");
			$dados_usuario = mysql_fetch_array($sql_busca_usuario);
			
			$_SESSION['token'] = $_COOKIE['token'];
			$_SESSION['id_usuario'] = $dados_usuario['id_usuario'];
			$_SESSION['email'] = $dados_usuario['email'];
			$_SESSION['nome'] = $dados_usuario['nome'];
			$_SESSION['nivel'] = $dados_usuario['nivel'];
		}
		else
		{
			//header("Location: Index");
		}
	}
?>
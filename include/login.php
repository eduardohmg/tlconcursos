<?php 
	include('config.php');
	
	$email=$_POST['email'];
	$senha=md5($_POST['senha']);
	$manter=$_POST['manter'];
	
	try
	{
		$res = mysql_query("SELECT * FROM usuario WHERE email='".$email."' AND senha='".$senha."'");
		$numrows = mysql_num_rows($res);

		if($numrows != 0)
		{
			if($row=mysql_fetch_assoc($res))
			{
				if($manter == 1)
				{
					$_SESSION['token'] = md5(md5(uniqid(mt_rand(), true))).md5(md5(uniqid(mt_rand(), true)));
					setcookie('token', $_SESSION['token'], (time() + (7*24*60*60)),"/",null, null, true);
					
					$select_token = mysql_query("SELECT * FROM token_conectado WHERE token = '".$_SESSION['token']."' AND id_usuario = '".$row['id_usuario']."'");
					
					if(mysql_num_rows($select_token) == 0)
					{
						$sql_inserir_token = mysql_query("INSERT INTO token_conectado(token,id_usuario,utilizado,validade) VALUES('".$_SESSION['token']."','".$row['id_usuario']."','0','7')");
					}
					else
					{
						$update_token = mysql_query("UPDATE token_conectado SET token='".$_SESSION['token']."' WHERE id_usuario='".$row['id_usuario']."'");
					}
				}
				else
				{
					$_SESSION['id_usuario'] = $row['id_usuario'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['nome'] = $row['nome'];
					$_SESSION['nivel'] = $row['nivel'];
				}
				echo "1";
			}
		}
		else
		{
			echo "0";
		}
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
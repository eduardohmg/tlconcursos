<?php
	include('config.php');

	RefazerSimulado();

	function RefazerSimulado()
	{
		if(isset($_POST['id_teste']))
		{
			try
			{
				$id_teste = $_POST['id_teste'];
				
				$sql_teste_origem = mysql_query("SELECT * FROM teste WHERE id_teste = ".$id_teste);
				$result_teste_origem = mysql_fetch_assoc($sql_teste_origem);
				
				$sql_update_teste_origem = mysql_query("UPDATE teste SET visibilidade=2 WHERE id_teste=$id_teste");
				
				$sql_teste = "INSERT INTO teste (id_usuario, nome, descricao, status, img, tipo, id_teste_origem) VALUES ('".$_SESSION['id_usuario']."', '".$result_teste_origem['nome']."', '".$result_teste_origem['descricao']."', '".$result_teste_origem['status']."', '".$result_teste_origem['img']."', '".$result_teste_origem['tipo']."', '".$id_teste."')";
				$result_teste = mysql_query($sql_teste);
				
				$id_teste_novo = mysql_insert_id(); // Busca o último id inserido na tabela
				
				$sql_teste_categoria = mysql_query("SELECT * FROM teste_categoria WHERE id_teste = ".$id_teste);
				
				while($result_teste_categoria=mysql_fetch_array($sql_teste_categoria))
				{
					$result_novo_teste_categoria = mysql_query("INSERT INTO teste_categoria(id_teste, id_categoria) VALUES('".$id_teste_novo."', '".$result_teste_categoria['id_categoria']."')");
				}
				
				$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste = ".$id_teste);
				
				while($result_sql_banco=mysql_fetch_array($sql_banco))
				{
					$result_novo_banco = mysql_query("INSERT INTO banco(id_questao, id_teste, num_questao) VALUES('".$result_sql_banco['id_questao']."','".$id_teste_novo."', '".$result_sql_banco['num_questao']."')");
				}
				
				echo $id_teste_novo;
				return true;
			}
			catch(Exception $e)
			{
				echo "erro";
				return false;
			}
		}
		else
		{
			echo "erro";
			return false;
		}
	}
?>
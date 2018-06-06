<?php
	include("config.php");
	
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$categorias = json_decode($_POST['categorias']);
	$tamanho = $_POST['tamanho'];
	$id_teste = $_POST['id_teste'];
	
	try
	{
		$sql_teste = mysql_query("UPDATE teste SET nome='".$nome."', descricao='".$descricao."' WHERE id_teste=$id_teste");
		if(!$sql_teste)
		{
			echo "-3";
		}
		$sql_deletar = mysql_query("DELETE FROM teste_categoria WHERE id_teste=$id_teste");
		if(!$sql_deletar)
		{
			echo "-2";
		}
		for($i = 0; $i < $tamanho; $i++)
		{
			$sql_teste_categoria = mysql_query("INSERT INTO teste_categoria(id_teste_categoria, id_teste, id_categoria) VALUES ('','".$id_teste."','".$categorias[$i]."')");
		}
		echo "1";
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
<?php
	include("config.php");
	
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$categorias = json_decode($_POST['categorias']);
	$tamanho = $_POST['tamanho'];
	$status = $_POST['status'];
	$img = "";
	$usuario = $_SESSION['id_usuario'];
	
	try
	{
		$sql_teste = mysql_query("INSERT INTO teste(id_teste,id_usuario,nome,descricao,status,id_usuario_edit,tipo,visibilidade,id_teste_origem,finalizado) VALUES('','$usuario','$nome','$descricao','1','$usuario','1','1','0','1')");
		$id_teste = mysql_insert_id();
		
		for($i = 0; $i < $tamanho; $i++)
		{
			$sql_teste_categoria = mysql_query("INSERT INTO teste_categoria(id_teste_categoria, id_teste, id_categoria) VALUES ('','".$id_teste."','".$categorias[$i]."')");
		}
		echo $id_teste;
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
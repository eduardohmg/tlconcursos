<?php
	include("config.php");

	$descricao = $_POST['descricao'];
	$img = $_POST['img'];
	$categorias = json_decode($_POST['categorias']);
	$alternativas = json_decode($_POST['alternativas']);
	$correta = json_decode($_POST['correta']);
	$tamanho_cat = $_POST['tamanho_x'];
	$tamanho_alt = $_POST['tamanho_y'];
	$id_teste = $_POST['id_teste'];
	$id_questao = $_POST['id_questao'];
	$valor = $_POST['valor'];
	
	try
	{
		$sql_questao = mysql_query("UPDATE questao SET texto='".$descricao."', valor='".$valor."', img='".$img."' WHERE id_questao=$id_questao");
		if(!$sql_questao)
		{
			echo "0";
		}
		
		$sql_banco = mysql_query("SELECT * FROM banco WHERE id_questao=$id_questao AND id_teste=$id_teste");
		if(!$sql_banco)
		{
			echo "2";
		}
		if(mysql_num_rows($sql_banco) == 0)
		{
			$sql_num_questoes = mysql_query("SELECT * FROM banco WHERE id_teste=$id_teste");
			if(!$sql_num_questoes)
			{
				echo "3";
			}
			$num_questao = mysql_num_rows($sql_num_questoes)+1;
			$sql_inserir_banco = mysql_query("INSERT INTO banco(id_banco,id_teste,id_questao,num_questao) VALUES('','$id_teste','$id_questao','$num_questao')");
			if(!$sql_inserir_banco)
			{
				echo "4";
			}
		}
		
		$sql_deletar_categoria = mysql_query("DELETE FROM questao_categoria WHERE id_questao=$id_questao");
		
		for($i = 0; $i < $tamanho_cat; $i++)
		{
			$sql_questao_categoria = mysql_query("INSERT INTO questao_categoria(id_questao_categoria, id_questao, id_categoria) VALUES ('','".$id_questao."','".$categorias[$i]."')");
		}
		
		$sql_deletar_alternativa = mysql_query("DELETE FROM alternativa WHERE id_questao=$id_questao");
		
		for($i = 0; $i < $tamanho_alt; $i++)
		{
			$sql_alternativa = mysql_query("INSERT INTO alternativa(id_alternativa,id_questao,texto,correta) VALUES('','".$id_questao."','".$alternativas[$i]."','".$correta[$i]."')");
		}
		echo "1";
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
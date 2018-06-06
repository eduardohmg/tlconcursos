<?php
	include("config.php");
	
	$id_questao = $_POST['id_questao'];
	
	try
	{
		$sql_questao = mysql_query("DELETE FROM questao WHERE id_questao=$id_questao");
		$sql_alternativa = mysql_query("DELETE FROM alternativa WHERE id_questao=$id_questao");
		$sql_banco = mysql_query("DELETE FROM banco WHERE id_questao=$id_questao");
		$sql_carrinho = mysql_query("DELETE FROM carrinho_questao WHERE id_questao=$id_questao");
		$sql_favorito = mysql_query("DELETE FROM favorito WHERE id_questao=$id_questao");
		$sql_historico = mysql_query("DELETE FROM historico WHERE id_questao=$id_questao");
		$sql_inventario = mysql_query("DELETE FROM inventario WHERE id_questao=$id_questao");
		$sql_questao_categoria = mysql_query("DELETE FROM questao_categoria WHERE id_questao=$id_questao");
		$sql_questao_pendente = mysql_query("DELETE FROM questao_pendente WHERE id_questao=$id_questao");
		$sql_resolucao = mysql_query("DELETE FROM resolucao WHERE id_questao=$id_questao");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
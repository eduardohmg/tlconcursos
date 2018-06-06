<?php
	include("config.php");
	
	$id_noticia = $_POST['id_noticia'];
	$titulo = $_POST['titulo'];
	$descricao = $_POST['descricao'];
	$img = $_POST['img'];
	if($img != null)
	{
		$sql_noticia = mysql_query("UPDATE noticia SET titulo='$titulo', descricao='".$descricao."', img='".$img."' WHERE id_noticia='".$id_noticia."'");
	}
	else
	{
		$sql_noticia = mysql_query("UPDATE noticia SET titulo='$titulo', descricao='".$descricao."' WHERE id_noticia='".$id_noticia."'");
	}
	if($sql_noticia)
	{
		echo "1";
	}
	else
	{
		echo "0";
	}
?>
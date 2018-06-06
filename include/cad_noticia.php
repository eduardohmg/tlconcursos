<?php
	include("config.php");
	include('upload_img.php');
	
	$titulo = $_POST['txtTitulo'];
	$descricao = $_POST['txtaDescricao'];
	$img = "";
	
	try
	{
		if($_FILES['fileImage']['name'] != null)
		{
			if(ValidaImg('fileImage'))
			{
				$img = UploadImg('fileImage', 'noticias');
			}
			else
			{
				echo "0";
			}
			
		}
		$sql_noticia = mysql_query("INSERT INTO noticia(titulo,descricao,img,id_usuario) VALUES('$titulo','$descricao','$img','".$_SESSION['id_usuario']."')");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "-1";
	}
?>
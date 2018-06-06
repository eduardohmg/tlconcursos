<?php
	include("config.php");
	include("upload_img.php");
	
	$texto = $_POST['InputDescricao1'];
	$id_questao = $_POST['inputTeste'];
	$img = "";
	
	try
	{
		if($_FILES['imgResolucao1']['name'] != null)
		{
			if(ValidaImg('imgResolucao1'))
			{
				$img = UploadImg('imgResolucao1', 'resolucoes');
			}
			else
			{
				echo "0";
			}
		}
		$sql_resolucao = mysql_query("INSERT INTO resolucao(texto,id_questao,img) VALUES('$texto','$id_questao','$img')");
		echo "1";
	}
	catch(Exception $e)
	{
		echo "0";
	}
?>
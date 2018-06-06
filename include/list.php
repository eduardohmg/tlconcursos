<?php
	include("config.php");
	
	if(isset($_POST['func']))
	{
		$func = $_POST['func'];
		if($func == "ids")
		{
			PegarIdsTipos();
		}
		else if($func == "categorias" && isset($_POST['id_tipo_categoria']))
		{
			PegarInfo($_POST['id_tipo_categoria']);
		}
	}

	function PegarIdsTipos()
	{
		$arTipos = array();
		
		$sql_tipo_categoria = mysql_query("SELECT * FROM tipo_categoria");
		for($i = 0; $result_tipo_categoria = mysql_fetch_array($sql_tipo_categoria); $i++)
		{
			array_push($arTipos, $result_tipo_categoria);
		}
		
		echo json_encode($arTipos);
		return true;
	}
	
	function PegarInfo($id_tipo_categoria)
	{
		$arCategorias = array();
		
		$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_tipo_categoria = ".$id_tipo_categoria);
		for($i = 0; $result_categoria = mysql_fetch_array($sql_categoria); $i++)
		{
			array_push($arCategorias, $result_categoria);
		}
		
		echo json_encode($arCategorias);
		return true;
	}
?>
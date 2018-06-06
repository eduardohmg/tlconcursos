<?php
	include('config.php');
	DelNoticia($_POST['id_noticia']);
	
	function DelNoticia($id_noticia)
	{
		try
		{
			$del_noticia = mysql_query("DELETE FROM noticia WHERE id_noticia = ".$id_noticia);
			echo "1";
		}
		catch(Exception $e)
		{
			echo "0";
		}
	}
?>
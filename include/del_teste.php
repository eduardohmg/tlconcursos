<?php
	include('config.php');
	DelTeste($_POST['id_teste']);
	
	function DelTeste($id_teste)
	{
		try
		{
			$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste = ".$id_teste);
			$numrows = mysql_num_rows($sql_teste);
			
			if($numrows > 0)
			{
				$sql_oculta = mysql_query("UPDATE teste SET visibilidade = 0 WHERE id_teste = ".$id_teste);
				echo "1";
				return true;
			}
		}
		catch(Exception $e)
		{
			echo "0";
		}
	}
?>
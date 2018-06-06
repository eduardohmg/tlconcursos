<?php
	include("config.php");
	
	$sql_teste = mysql_query("SELECT * FROM teste");
	while($dados_teste = mysql_fetch_array($sql_teste))
	{
		$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste=".$dados_teste['id_teste']."");
		if(mysql_num_rows($sql_banco) <= 0)
		{
			$delete_teste = mysql_query("DELETE FROM teste WHERE id_teste=".$dados_teste['id_teste']."");
			$del_teste_categoria = mysql_query("DELETE FROM teste_categoria WHERE id_teste=".$dados_teste['id_teste']."");
			$delete_historico = mysql_query("DELETE FROM historico WHERE id_teste=".$dados_teste['id_teste']."");
			$delete_questao = mysql_query("DELETE FROM questao_pendente WHERE id_teste=".$dados_teste['id_teste']."");
		}
	}
?>
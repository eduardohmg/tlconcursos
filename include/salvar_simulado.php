<?php
	include("config.php");
	
	SalvarSimulado($_POST);
	function SalvarSimulado($DATA)
	{
		try
		{
			$id_teste = $DATA['id_teste'];
			$hidden = $DATA['codigos'];
			$array = array();
			$element = "";
			$id_questao;
			$id_alternativa;
			
			$update_teste = mysql_query("UPDATE teste SET visibilidade=1 WHERE id_teste=$id_teste");
			
			for($i = 0; $i < strlen($hidden); $i++)
			{
				$char = substr($hidden, $i, 1);
				if($char <> ";")
				{
					$element = $element.$char;
				}
				else
				{
					array_push($array, $element);
					$element = "";
				}
			}
			
			for($i = 0; $i < count($array); $i++)
			{
				$id_alternativa;
				
				if(isset($DATA[$array[$i]]))
				{
					$id_alternativa = $DATA[$array[$i]];
				}
				else
				{
					$id_alternativa = 0;
				}
				
				$id_questao = $array[$i];
				
				$sql_verifica_questao_pendente = mysql_query("SELECT * FROM questao_pendente WHERE id_teste = ".$id_teste." AND id_questao = ".$id_questao);
				
				if(mysql_num_rows($sql_verifica_questao_pendente) > 0)
				{
					$sql_questao_pendente = mysql_query("UPDATE questao_pendente SET id_alternativa = '$id_alternativa' WHERE id_teste = ".$id_teste." AND id_questao = ".$id_questao);
				}
				else
				{
					$sql_questao_pendente = mysql_query("INSERT INTO questao_pendente(id_teste,id_questao,id_alternativa) VALUES('$id_teste','$id_questao','$id_alternativa')");
				}
			}
			
			echo "1";
			return true;
		}
		catch(Exception $e)
		{
			echo "erro";
			return true;
		}
	}
?>
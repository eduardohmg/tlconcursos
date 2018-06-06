<?php
	include('config.php');

	GerarSimulado();

	function GerarSimulado()
	{
		//$img = "";

		$nome = $_POST['txtNome'];
		$descricao = $_POST['txtDescricao'];
		$status = "1";
		$nquestoes = $_POST['cbxQuantidade'];
		$chkCategorias = "";
		
		$id_teste;
		
		$validado = true; // Essa variável vai determinar se o formulário foi preenchido

		// Inicio das validações
		
		if(empty($_REQUEST['chkCategorias']))
		{
			echo "error:cat_null"; // error:cat_null => Nenhuma categoria selecionada
			return false;
			$validado = false;
		}
		else
		{
			$chkCategorias = $_REQUEST['chkCategorias'];
		}

		// Fim das validações

		if($validado == true) // Efetua todo o cadastro do teste
		{
			try
			{
				$sql_teste = "INSERT INTO teste (id_usuario, nome, descricao, status, visibilidade) VALUES ('".$_SESSION['id_usuario']."', '$nome', '$descricao', '$status', '1')";
				$result_teste = mysql_query($sql_teste);
				
				$id_teste = mysql_insert_id(); // Busca o último id inserido na tabela
				
				$comando_questao_categoria = "SELECT DISTINCT tb.id_questao FROM questao_categoria tb";
				
				$filtros = "";
				
				$indice_tb = 1;
				
				if(!empty($chkCategorias))
				{                
					$qtd = count($chkCategorias);
					for ($contChkCategorias = 0; $contChkCategorias < $qtd; $contChkCategorias++)
					{
						mysql_query("INSERT INTO teste_categoria(id_teste_categoria, id_teste, id_categoria) VALUES('', $id_teste, ".$chkCategorias[$contChkCategorias].")");
						
						$filtros = $filtros." INNER JOIN questao_categoria tb".$indice_tb." on tb".$indice_tb.".id_questao = tb.id_questao AND tb".$indice_tb.".id_categoria = ".$chkCategorias[$contChkCategorias];
						$indice_tb++;
					}
				}
				
				$comando_questao_categoria = $comando_questao_categoria.$filtros." ORDER BY RAND()";
				
				$sql_questao_categoria = mysql_query($comando_questao_categoria);
				
				$i = 1;
				
				while($result_questao_categoria = mysql_fetch_array($sql_questao_categoria))
				{
					$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao = ".$result_questao_categoria['id_questao']);
					$result_questao = mysql_fetch_assoc($sql_questao);
					$sql_banco = mysql_query("INSERT INTO banco(id_banco, id_questao, id_teste, num_questao) VALUES('','".$result_questao_categoria['id_questao']."','$id_teste', '$i')");
					$i++;
					
					if($i > $nquestoes)
					{
						break;
					}
				}
				
				if($i == 1)
				{
					echo "error:questions_insuficient";
					return true;
				}
				
				echo $id_teste;
				
				return true;
			}
			catch(Exception $e)
			{
				echo "erro";
				//echo $e;
				return false;
			}
		}
		else
		{
			echo "erro";
			//echo "oo";
			return false;
		}
	}

?>
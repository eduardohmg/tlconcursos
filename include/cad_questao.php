<?php
	include('config.php');
	include('upload_img.php');

	CadastrarQuestao($_POST);

	function CadastrarQuestao($formulario)
	{
		$descricao = $_POST['txtaDescricao'];
		$img = "";
		$radio = $_POST['rbtnAlternativa'];
		$id_teste = $_POST['txtId_teste'];
		$valor = $_POST['txtValor'];
		$id_teste = "";

		$num_alternativas = 0; // Armazena o número de alternativas preenchidas
		$num_radios = 0; // Armazena o número de radio buttons existentes no formulário
		$validado = true; // Essa variável vai determinar se o formulário foi preenchido
		
		$img_questao = false; // Se for true o sistema vai tentar fazer o upload da imagem

		// Inicio das validações
		
		if(!isset($_POST['lstCategorias']))
		{
			echo "Selecione pelo menos uma das categorias";
			return false;
		}

		for($i = 1; true; $i++) // Verifica se as alternativas foram preenchidas, soma a quantidade de radio buttons existem no formulário e verifica as imagens
		{
			if(isset($_POST['alt'.$i]))
			{
				$num_radios++;
				$alternativa = $_POST['alt'.$i];
				
				if($radio == $i)
				{
					if($alternativa == "")
					{
						$validado = false;
						echo "A alternativa correta está vázia";
						return false;
					}
				}
				
				if($alternativa <> "")
				{
					$num_alternativas++;
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_img_alt = ValidaImg('img'.$i); // Valida imagem da alternativa
						
						if($result_img_alt == false)
						{
							echo "Imagem da alternativa ".$i." inválida. Selecione somente .jpg, .jpeg, .gif";
							return false;
						}
					}
				}
			}
			else
			{
				break;
			}
		}

		if($num_alternativas < 2) // Se apenas duas alternativas, ou menos, foram preenchidas...
		{
			$validado = false;
			echo "Preencha no mínimo duas alternativas";
			return false;
		}
		
		if(isset($_FILES['img']['name']) && $_FILES['img']['name'] <> "")
		{
			$result_img_questao = ValidaImg('img'); // Valida imagem da questao
			
			if($result_img_questao == false)
			{
				echo "Imagem da questão inválida. Selecione somente .jpg, .jpeg, .gif";
				return false;
			}
			else
			{
				$img_questao = true;
			}
		}

		try
		{
			if($id_teste <> "")
			{
				$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste = $id_teste");
				$cont = mysql_num_rows($sql_teste);
				if($cont <= 0)
				{
					$validado = false;
					echo "Nenhum teste foi encontrado com o ID inserido";
					return false;
				}
			}
		}
		catch(Exception $e)
		{

		}

		// Fim das validações

		if($validado == true) // Efetua todo o cadastro da questão (questão, alternativas, categorias, etc)
		{
			try
			{	
				if($img_questao == true)
				{
					$img = UploadImg('img', 'questoes');
				}
				
				$sql_questao = "INSERT INTO questao(id_questao, img,  texto, id_usuario, id_usuario_edit, valor) VALUES('','$img', '$descricao', '1', '1', '$valor')";
				$result_questao = mysql_query($sql_questao);
				
				$id_questao = mysql_insert_id(); // Busca o último id inserido na tabela
				
				try
				{
					if($id_teste <> "")
					{
						$sql_banco = mysql_query("INSERT INTO banco(id_banco, id_questao, id_teste) VALUES('','$id_questao','$id_teste')");
					}
				}
				catch(Exception $e)
				{
					echo "Erro inesperado!";
					return false;
				}
				
				for($i = 1; $i <= $num_radios; $i++)
				{
					$alternativa = $_POST['alt'.$i]; //Armazena o texto da alternativa
					
					$img_alt = "";
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_upload_alt = UploadImg('img'.$i, 'alternativas');
						
						if($result_upload_alt == false)
						{
							echo "Imagem ".$i." inválida. Selecione somente .jpg, .jpeg, .gif";
							return false;
						}
						else
						{
							$img_alt = $result_upload_alt;
						}
					}
					
					if($alternativa != "")
					{
						try
						{
							$correta = 0;
							if($radio == $i) // Se essa for a alternativa correta...
							{
								 $correta = 1;
							}
							
							$sql_alternativa = "INSERT INTO alternativa(id_alternativa,id_questao, img, texto, correta) VALUES('','$id_questao','$img_alt','$alternativa','$correta')";
							$result_alternativa = mysql_query($sql_alternativa);
						}
						catch(Exception $e)
						{
							echo "Erro inesperado!";
							return false;
						}
					}	
				}
				
				if(isset($_POST['lstCategorias']))
				{
					foreach($_POST['lstCategorias'] as $id_categoria)
					{
						mysql_query("INSERT INTO questao_categoria(id_questao_categoria, id_questao, id_categoria) VALUES('', $id_questao, $id_categoria)");
					}
				}
				
				if($result_questao)
				{
					echo "1";
					return false;
				}
			}
			catch(Exception $e)
			{
				echo "Erro inesperado!";
				return false;
			}
		}
	}

?>
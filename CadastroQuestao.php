<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
	}
	
	$desabilitar = "";
	
	if(isset($_GET['id_teste']))
	{
		$id_teste = $_GET['id_teste'];
		$desabilitar = "readonly";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="img/favicon.png">

		<title>TL Concursos | Ensinando para o futuro</title>

		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/offcanvas.css" rel="stylesheet">
		<link href="css/theme.css" rel="stylesheet">
		<link href="css/extra.css" rel="stylesheet">
		<link href="css/font-awesome.css" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Cadastro de questão</h2>
			</div>
			<div class="row">
			<form method="post" action="">
				<div class="col-md-8">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
						<div class="form-group">
							<label for="InputDescricao">Descrição da questão</label>
							<textarea style="resize: vertical;" class="form-control" id="InputDescricao" placeholder="Digite aqui as informações sobre a questão..." maxlength="4096" name="descricao" rows="5" required></textarea>
						</div>
						<hr>
						<div class="form-group">
							<label for="InputImage">Imagem da questão</label>
							<input type="file" name="img" id="img">
						</div>
						<hr>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt1" value="1" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="A)" cols="100%" maxlength="4096"  name="alt1" id="alt1" rows="2"></textarea>
									<input type="file" name="img1">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt2" value="2" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="B)" cols="100%" maxlength="4096"  name="alt2" id="alt2" rows="2"></textarea>
									<input type="file" name="img2">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt3" value="3" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="C)" cols="100%" maxlength="4096"  name="alt3" id="alt3" rows="2"></textarea>
									<input type="file" name="img3">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt4" value="4" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="D)" cols="100%" maxlength="4096"  name="alt4" id="alt4" rows="2"></textarea>
									<input type="file" name="img4">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt5" value="5" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="E)" cols="100%" maxlength="4096"  name="alt5" id="alt5" rows="2"></textarea>
									<input type="file" name="img5">
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="radio">
								<label>
									<input type="radio" name="rbtnAlternativa" id="rbt6" value="6" required>
									<textarea style="resize: vertical;" class="form-control" placeholder="F)" cols="100%" maxlength="4096"  name="alt6" id="alt6" rows="2"></textarea>
									<input type="file" name="img6">
								</label>
							</div>
						</div>
						<hr>
						<?php include('include/lista_categorias.php'); ?>
						<hr>
						<div class="float-static">
							<div class="pull-right">
								<a class="btn btn-default" href="#" role="button"><span class="glyphicon glyphicon-plus"></span></a>
							</div>
						</div>
						<div class="form-group">
							<label for="InputResolucao1">Resolução 1</label>
							<textarea style="resize: vertical;" class="form-control" id="InputDescricao1" placeholder="Digite aqui a resolução da questão..." maxlength="4096" name="resolucao1" rows="5"></textarea>
						</div>
						<div class="form-group">
							<input type="file" name="imgResolucao1">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="jumbotron">
						<hr>
						<div class="form-group">
							<label for="id_teste" class="control-label">ID do teste</label>
							<input type="number" value="<?php echo $id_teste; ?>" class="form-control" <?php echo $desabilitar; ?> id="id_teste" name="id_teste" placeholder="Número..." min="0" max="65535" step="1" required>
						</div>
						<div class="form-group">
							<label for="inputValor" class="control-label">Valor (créditos) </label>
							<input type="number" class="form-control" id="inputValor" min="1" max="65535" value="10" step="1" name="valor" required>
						</div>
						<hr>
						<button style="margin-bottom: 10px; "type="button" name="continuar" onclick="" class="btn btn-primary btn-block">Cadastrar e continuar</button>

						<button type="submit" name="submit" class="btn btn-primary">Finalizar</button>
						<button type="reset" class="btn btn-default">Cancelar</button>

					</div>
				</div>
				</form>

			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>

<?php
	include('include/upload_img.php');

	if(isset($_POST['submit']))
	{
		$descricao = $_POST['descricao'];
		$img = "";
		$radio = $_POST['rbtnAlternativa'];
		$id_teste = $_POST['id_teste'];
		$valor = $_POST['valor'];

		$num_alternativas = 0;
		$num_radios = 0;
		$validado = true;
		
		$img_questao = false;
		
		for($i = 1; true; $i++)
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
						echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'A alternativa correta está vazia.';
								document.getElementById('div_msg').style.display = 'block';
							  </script>";
						return false;
					}
				}
				
				if($alternativa <> "")
				{
					$num_alternativas++;
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_img_alt = ValidaImg('img'.$i);
						
						if($result_img_alt == false)
						{
							echo "<script type='text/javascript'>
									document.getElementById('txtMsg').textContent = 'Imagem da alternativa ".$i." iinválida. Selecione somente .jpg, .jpeg, .gif';
									document.getElementById('div_msg').style.display = 'block';
								  </script>";
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

		if($num_alternativas < 2)
		{
			$validado = false;
			echo "Preencha no mínimo duas alternativas";
			return false;
		}
		
		if(isset($_FILES['img']['name']) && $_FILES['img']['name'] <> "")
		{
			$result_img_questao = ValidaImg('img');
			
			if($result_img_questao == false)
			{
				echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Imagem da questão inválida. Selecione somente .jpg, .jpeg, .gif';
								document.getElementById('div_msg').style.display = 'block';
					  </script>";
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
					echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Nenhum teste foi encontrado com o ID inserido.';
								document.getElementById('div_msg').style.display = 'block';
						  </script>";
					return false;
				}
			}
		}
		catch(Exception $e)
		{

		}

		if($validado == true)
		{
			try
			{	
				if($img_questao == true)
				{
					$img = UploadImg('img', 'questoes');
				}
				
				$sql_questao = "INSERT INTO questao(id_questao, img, texto, id_usuario, id_usuario_edit, valor) VALUES('','$img', '$descricao', '".$_SESSION['id_usuario']."', '".$_SESSION['id_usuario']."', '$valor')";
				$result_questao = mysql_query($sql_questao);
				
				$id_questao = mysql_insert_id();
				
				try
				{
					if($id_teste <> "")
					{
						$sql_num_questao = mysql_query("SELECT * FROM banco WHERE id_teste = $id_teste");
						$num_questao_teste = (mysql_num_rows($sql_num_questao)) + 1;
						$sql_banco = mysql_query("INSERT INTO banco(id_banco, id_questao, id_teste, num_questao) VALUES('','$id_questao','$id_teste','$num_questao_teste')");
					}
				}
				catch(Exception $e)
				{
					echo "Erro inesperado!";
					return false;
				}
				
				for($i = 1; $i <= $num_radios; $i++)
				{
					$alternativa = $_POST['alt'.$i];
					
					$img_alt = "";
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_upload_alt = UploadImg('img'.$i, 'alternativas');
						
						if($result_upload_alt == false)
						{
							echo "<script type='text/javascript'>
									document.getElementById('txtMsg').textContent = 'Imagem ".$i." iinválida. Selecione somente .jpg, .jpeg, .gif';
									document.getElementById('div_msg').style.display = 'block';
								  </script>";
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
							if($radio == $i)
							{
								 $correta = 1;
							}
							
							$sql_alternativa = "INSERT INTO alternativa(id_alternativa,id_questao, img, texto, correta) VALUES('','$id_questao','$img_alt','$alternativa','$correta')";
							$result_alternativa = mysql_query($sql_alternativa);
						}
						catch(Exception $e)
						{
							echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Erro inesperado.';
								document.getElementById('div_msg').style.display = 'block';
								  </script>";
							return false;
						}
					}	
				}
				
				if(isset($_POST['chkCategorias']))
				{
					foreach($_POST['chkCategorias'] as $id_categoria)
					{
						mysql_query("INSERT INTO questao_categoria(id_questao_categoria, id_questao, id_categoria) VALUES('', $id_questao, $id_categoria)");
					}
				}
				
				if($result_questao)
				{
					echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = '1';
								document.getElementById('div_msg').style.display = 'block';
						  </script>";
					return false;
				}
			}
			catch(Exception $e)
			{
				echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Erro inesperado';
								document.getElementById('div_msg').style.display = 'block';
					  </script>";
				return false;
			}
		}
		header("Location: EditarSimulado?id_teste=$id_teste");
	}
	
	if(isset($_POST['continuar']))
	{
		$descricao = $_POST['descricao'];
		$img = "";
		$radio = $_POST['rbtnAlternativa'];
		$id_teste = $_POST['id_teste'];
		$valor = $_POST['valor'];

		$num_alternativas = 0;
		$num_radios = 0;
		$validado = true;
		
		$img_questao = false;
		
		for($i = 1; true; $i++)
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
						echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'A alternativa correta está vazia.';
								document.getElementById('div_msg').style.display = 'block';
							  </script>";
						return false;
					}
				}
				
				if($alternativa <> "")
				{
					$num_alternativas++;
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_img_alt = ValidaImg('img'.$i);
						
						if($result_img_alt == false)
						{
							echo "<script type='text/javascript'>
									document.getElementById('txtMsg').textContent = 'Imagem da alternativa ".$i." iinválida. Selecione somente .jpg, .jpeg, .gif';
									document.getElementById('div_msg').style.display = 'block';
								  </script>";
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

		if($num_alternativas < 2)
		{
			$validado = false;
			echo "Preencha no mínimo duas alternativas";
			return false;
		}
		
		if(isset($_FILES['img']['name']) && $_FILES['img']['name'] <> "")
		{
			$result_img_questao = ValidaImg('img');
			
			if($result_img_questao == false)
			{
				echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Imagem da questão inválida. Selecione somente .jpg, .jpeg, .gif';
								document.getElementById('div_msg').style.display = 'block';
					  </script>";
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
					echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Nenhum teste foi encontrado com o ID inserido.';
								document.getElementById('div_msg').style.display = 'block';
						  </script>";
					return false;
				}
			}
		}
		catch(Exception $e)
		{

		}

		if($validado == true)
		{
			try
			{	
				if($img_questao == true)
				{
					$img = UploadImg('img', 'questoes');
				}
				
				$sql_questao = "INSERT INTO questao(id_questao, img, texto, id_usuario, id_usuario_edit, valor) VALUES('','$img', '$descricao', '".$_SESSION['id_usuario']."', '".$_SESSION['id_usuario']."', '$valor')";
				$result_questao = mysql_query($sql_questao);
				
				$id_questao = mysql_insert_id();
				
				try
				{
					if($id_teste <> "")
					{
						$sql_num_questao = mysql_query("SELECT * FROM banco WHERE id_teste = $id_teste");
						$num_questao_teste = (mysql_num_rows($sql_num_questao)) + 1;
						$sql_banco = mysql_query("INSERT INTO banco(id_banco, id_questao, id_teste, num_questao) VALUES('','$id_questao','$id_teste','$num_questao_teste')");
					}
				}
				catch(Exception $e)
				{
					echo "Erro inesperado!";
					return false;
				}
				
				for($i = 1; $i <= $num_radios; $i++)
				{
					$alternativa = $_POST['alt'.$i];
					
					$img_alt = "";
					
					if(isset($_FILES['img'.$i]['name']) && $_FILES['img'.$i]['name'] <> "")
					{
						$result_upload_alt = UploadImg('img'.$i, 'alternativas');
						
						if($result_upload_alt == false)
						{
							echo "<script type='text/javascript'>
									document.getElementById('txtMsg').textContent = 'Imagem ".$i." iinválida. Selecione somente .jpg, .jpeg, .gif';
									document.getElementById('div_msg').style.display = 'block';
								  </script>";
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
							if($radio == $i)
							{
								 $correta = 1;
							}
							
							$sql_alternativa = "INSERT INTO alternativa(id_alternativa,id_questao, img, texto, correta) VALUES('','$id_questao','$img_alt','$alternativa','$correta')";
							$result_alternativa = mysql_query($sql_alternativa);
						}
						catch(Exception $e)
						{
							echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Erro inesperado.';
								document.getElementById('div_msg').style.display = 'block';
								  </script>";
							return false;
						}
					}	
				}
				
				if(isset($_POST['chkCategorias']))
				{
					foreach($_POST['chkCategorias'] as $id_categoria)
					{
						mysql_query("INSERT INTO questao_categoria(id_questao_categoria, id_questao, id_categoria) VALUES('', $id_questao, $id_categoria)");
					}
				}
				
				if($result_questao)
				{
					echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = '1';
								document.getElementById('div_msg').style.display = 'block';
						  </script>";
					return false;
				}
			}
			catch(Exception $e)
			{
				echo "<script type='text/javascript'>
								document.getElementById('txtMsg').textContent = 'Erro inesperado';
								document.getElementById('div_msg').style.display = 'block';
					  </script>";
				return false;
			}
		}
		
		header("Location: CadastroQuestao?id_teste=$id_teste");
	}
?>
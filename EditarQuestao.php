<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
	}
	
	if(isset($_GET['questao']))
	{
		$id_questao = $_GET['questao'];
	}
	
	$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao=$id_questao");
	$dados_questao = mysql_fetch_assoc($sql_questao);
	
	$sql_banco = mysql_query("SELECT * FROM banco WHERE id_questao=$id_questao");
	$dados_banco = mysql_fetch_assoc($sql_banco);
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
	
	<script type="text/javascript">
		function atualizar()
		{
			var id_questao = document.getElementById("id_questao").value;
			var descricao = document.getElementById("InputDescricao").value;
			var id_teste = document.getElementById("inputTeste").value;
			var valor = document.getElementById("inputValor").value;
			var categorias = new Array();
			var alternativas = new Array();
			var correta = new Array();
			var x = document.getElementsByName('chkCategorias[]');
			var tamanho_x = 0;
			var tamanho_y = 7;
			
			var fileName = "";
			if(document.getElementById("img") != "")
			{
				var img = document.getElementById("img");
				var fileName = img.value.split(/(\\|\/)/g).pop();
			}
			
			for (i = 0; i < x.length; i++) 
			{
				if (x[i].checked == true) 
				{
					categorias[tamanho_x] = x[i].value;
					tamanho_x += 1
				}
			}
			for(i = 0; i < tamanho_y; i++)
			{
				if(document.getElementById("alt"+(i+2)) == null)
				{
					tamanho_y = i+1;
				}
				if(document.getElementById("rbt"+(i+1)).checked == true)
				{
					correta[i] = 1;
				}
				else
				{
					correta[i] = 0;
				}
				alternativas[i] = document.getElementById("alt"+(i+1)).value;
			}
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/edit_questao.php',
				data: {descricao: descricao, img: fileName, categorias: JSON.stringify(categorias), alternativas: JSON.stringify(alternativas), tamanho_x: tamanho_x, tamanho_y: tamanho_y, id_questao: id_questao, id_teste: id_teste, valor: valor, correta: JSON.stringify(correta)},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="QuestoesCadastradas";
					}
					else
					{
						alert("Erro inesperado, contate o administrador.");
					}
				},
				error: function(data){
					alert("Erro inesperado - ou esperado.");
				}
			});
		}
	</script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	.radio{
		margin-bottom: 20px;
	}
	.jumbotron hr{
		border-top-color: #d5d5d5;
	}
	
	</style>
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Editar questão</h2>
			</div>
			<div class="row">
			<form method="post" action="javascript:atualizar();">
				<div class="col-md-8">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
						<div class="form-group">
							<label for="InputDescricao">Descrição da questão</label>
							<textarea style="resize: vertical;" class="form-control" id="InputDescricao" placeholder="Digite aqui as informações sobre a questão..." maxlength="4096" name="descricao" rows="5" required><?php echo $dados_questao['texto'];?></textarea>
						</div>
						<hr>
						<div class="form-group">
							<label for="InputImage">Imagem da questão</label>
							<input type="file" name="img" id="img">
							<?php
								if($dados_questao['img'] != "")
								{
									//echo "<img style='margin-bottom: 30px;' class='img-responsive' src='img/questao/".$dados_questao['img']."'";
									//Mostrar imagem certa, está bugando o layout
									echo $dados_questao['img'];
								}
							?>
						</div>
						<hr>
						<?php
							$cont = 1;
							$letras = ["A)","B)","C)","D)","E)","F)"];
							$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_questao=$id_questao");
							while($dados_alternativa = mysql_fetch_array($sql_alternativa))
							{
								$checked = "";
								if($dados_alternativa['correta'] == 1)
								{
									$checked = "checked";
								}
								echo "<div class='radio'>
										<label>
											<input type='radio' name='rbtnAlternativa' id='rbt".$cont."' value='$cont' required $checked>
											<textarea style='resize: vertical;' class='form-control' placeholder='".$letras[$cont-1]."' cols='100%' maxlength='4096'  name='alt".$cont."' id='alt".$cont."' rows='2'>".$dados_alternativa['texto']."</textarea>
											<input type='file' name='img1'>
										</label>
									</div>";
									$cont++;
							}
						?>
						<hr>
						<?php include('include/lista_categorias.php'); ?>
						<?php
								$sql_questao_categoria = mysql_query("SELECT * FROM questao_categoria WHERE id_questao=$id_questao");
								while($dados_questao_categoria = mysql_fetch_array($sql_questao_categoria))
								{
									$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_categoria=".$dados_questao_categoria['id_categoria']."");
									$dados_categoria = mysql_fetch_assoc($sql_categoria);
									echo "<script type='text/javascript'>
											var x = document.getElementsByName('chkCategorias[]');
											for (i = 0; i < x.length; i++) 
											{
												if (x[i].value == ".$dados_categoria['id_categoria'].") 
												{
													x[i].checked = true;
												}
											}
									</script>";
								}
							?>
						<hr>
						<div class="float-static">
							<div class="pull-right">
								<a class="btn btn-default" href="#" role="button"><span class="glyphicon glyphicon-plus"></span></a>
							</div>
						</div>
						<?php
						$cont = 1;
						$sql_resolucao = mysql_query("SELECT * FROM resolucao WHERE id_questao=$id_questao");
						while($dados_resolucao = mysql_fetch_array($sql_resolucao))
						{
							$img = "";
							if($dados_resolucao['img'] != "")
							{
								$img = "src='img/resolucao/".$dados_resolucao['img']."'";
							}
							echo "<div class='form-group'>
									  <label for='InputResolucao'>Resolução 1</label>
									  <textarea style='resize: vertical;' class='form-control' id='InputDescricao1' placeholder='Digite aqui a resolução da questão...' maxlength='4096' name='resolucao".$cont."' rows='5'>".$dados_resolucao['texto']."</textarea>
								  </div>
								  <div class='form-group'>
									  <input type='file' name='imgDescricao".$cont."'>
									  ".$dados_resolucao['img']."
								  </div>";
								$cont++;
						}	
						?>
						
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="jumbotron">
						<div class='float-static'>
							<div class='pull-right'>
								<a class='btn btn-default' href='#' role='button'><span class='glyphicon glyphicon-trash'></span></a>
							</div>
						</div>
						<div class="form-group">
							<label for="inputTeste" class="control-label">ID do teste</label>
							<input type="number" class="form-control" id="inputTeste" placeholder="Número..." name="id_teste" min="0" max="65535" step="1" value="<?php echo $dados_banco['id_teste'];?>" required>
						</div>
						<div class="form-group">
							<label for="inputValor" class="control-label">Valor (créditos) </label>
							<input type="number" class="form-control" id="inputValor" min="1" max="65535" value="<?php echo $dados_questao['valor'];?>" step="1" name="valor" required>
						</div>
						<hr>
						<button type="submit" name="submit" class="btn btn-primary">Salvar</button>
						<button type="reset" class="btn btn-default">Cancelar</button>
						<input type="hidden" id="id_questao" value="<?php echo $id_questao;?>">
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
	}
?>
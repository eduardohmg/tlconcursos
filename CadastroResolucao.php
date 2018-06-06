<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
	}
	
	$descricao = "";
	$resolucao = "";
	$id_questao = "";
	$id_resolucao = "";
	$valor = 10;
	
	if(isset($_GET['questao']))
	{
		$id_questao = $_GET['questao'];
	}
	
	if(isset($_GET['resolucao']))
	{
		$id_resolucao = $_GET['resolucao'];
		$sql_resolucao = mysql_query("SELECT * FROM resolucao WHERE id_resolucao=$id_resolucao");
		$dados_resolucao = mysql_fetch_assoc($sql_resolucao);
		$resolucao = $dados_resolucao['texto'];
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
				<h2>Cadastro de resolução</h2>
			</div>
			<div class="row">
			<form id="formCadResolucao" method="post" action="javascript: cadastrar();">
				<div class="col-md-8">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
							<div class="form-group">
								<label for="InputDescricao">Descrição da questão</label>
								<textarea style="resize: vertical;" class="form-control" name="InputDescricao" id="InputDescricao" placeholder="Digite aqui as informações sobre a questão..." maxlength="4096" name="descricao" rows="5" required><?php echo $descricao;?></textarea>
							</div>
						<hr>
						<div class="form-group">
							<label for="InputImage">Imagem da questão</label>
							<input type="file" name="img" id="img">
						</div>
						<hr>
						<div class="float-static">
							<div class="pull-right">
								<a class="btn btn-default" href="#" role="button"><span class="glyphicon glyphicon-plus"></span></a>
							</div>
						</div>
						<div class="form-group">
							<label for="InputResolucao1">Resolução 1</label>
							<textarea style="resize: vertical;" class="form-control" name="InputDescricao1" id="InputDescricao1" placeholder="Digite aqui a resolução da questão..." maxlength="4096" name="resolucao1" rows="5"><?php echo $resolucao;?></textarea>
						</div>
						<div class="form-group">
							<input type="file" name="imgResolucao1" id="imgResolucao1">
						</div>
						<hr>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="jumbotron">
						<div class="form-group">
							<label for="inputTeste" class="control-label">ID da questão</label>
							<input type="number" class="form-control" name="inputTeste" id="inputTeste" placeholder="Número..." name="id_teste" min="0" max="65535" step="1" value="<?php echo $id_questao;?>" required>
						</div>
						<div class="form-group">
							<label for="inputValor" class="control-label">Valor (créditos) </label>
							<input type="number" class="form-control" name="inputValor" id="inputValor" min="1" max="65535" value="<?php echo $valor;?>" step="1" name="valor" required>
						</div>
						<hr>
						<button type="submit" name="submit" class="btn btn-primary">Salvar</button>
						<button type="reset" class="btn btn-default">Cancelar</button>
					</div>
				</div>
			</form>

			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	
	<script>
		function cadastrar()
		{
			$.ajax({
			type: 'post',
			cache: false,
			url: 'include/cad_resolucao.php',
			data: new FormData(document.getElementById('formCadResolucao')),
			contentType: false,
			enctype: 'multipart/form-data',
			cache: false,
			processData:false,
			success: function (data) {
				var ret = String(data);
				if(ret == 1)
				{
					location.href = "CadastroResolucao";
				}
				else if(ret == 0)
				{
					alert('Imagem com formato inválido.');
				}
				else
				{
					alert('Erro inesperado ao cadastrar a resolucao - Por favor, contate o administrador');
				}
			},
			error: function(data){
				alert('Erro inesperado ao cadastrar a resolucao - Por favor, contate o administrador');
			}
			});
			
		}
	</script>
  </body>
</html>
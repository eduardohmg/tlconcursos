<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
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

	<script type="text/javascript">
		function cadastrar()
		{
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/cad_noticia.php',
				data: new FormData(document.getElementById('frmCadNoticia')),
				contentType: false,
				enctype: 'multipart/form-data',
				cache: false,
				processData:false,
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="CadastroNoticia";
					}
					else if(ret == 0)
					{
						document.getElementById("txtMsg").textContent = "Imagem com formato inválido.";
						document.getElementById("div_msg").style.display = 'block';
					}
					else
					{
						document.getElementById("txtMsg").textContent = data;
						document.getElementById("div_msg").style.display = 'block';
					}
				},
				error: function(data){
					document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador";
					document.getElementById("div_msg").style.display = 'block';
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
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Cadastro de notícia</h2>
			</div>
			<div class="row">
			<form name="frmCadNoticia" enctype="multipart/form-data" id="frmCadNoticia" action="javascript:cadastrar();" method="post">
				<div class="col-md-10">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
						<div class="form-group">
							<label for="txtTitulo" class="control-label">Título da notícia</label>
							<input type="text" class="form-control" id="txtTitulo" placeholder="Digite aqui..." name="txtTitulo" required>
						</div>
						<div class="form-group">
							<label for="txtaDescricao">Descrição da notícia</label>
							<textarea style="resize: vertical;" class="form-control" id="txtaDescricao" placeholder="Digite aqui..." maxlength="4096" name="txtaDescricao" rows="5" required></textarea>
						</div>
						<hr>
						<div class="form-group">
							<label for="fileImage">Imagem do teste</label>
							<input type="file" name="fileImage" id="fileImage">
						</div>	
						<div class="float-static">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary">Cadastrar</button>
								<button type="reset" class="btn btn-default">Cancelar</button>
							</div>
						</div>
						<div class="form-group" style="margin-top: 25px; margin-bottom: -15px;">
							
								<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<strong id="txtMsg"></strong>
								</div>
						</div>
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
<?php
	include('include/config.php');
	include('include/general_security.php');
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
		<?php include('include/modalAguardar.php'); ?>
		
		<form id="frmTeste" action="Simultest" method="post">
			<input id="id_teste" name="id_teste" type="hidden" value="" />
		</form>

		<div class="container">
			<ol class="breadcrumb">
						<li><a href="Home">TL Concursos</a></li>
						<li class="active">Gerar Simulado</li>
			</ol>
			<div class="row">
			<form id="frmGerarSimulado" action="javascript:GerarSimulado();" method="POST">
				<div class="col-md-8">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
						<div class="form-group">
							<label for="inputNome" class="control-label">Nome do simulado</label>
							<input type="text" class="form-control" id="inputNome" placeholder="Digite aqui..." name="txtNome" required>
						</div>
						<div class="form-group">
							<label for="inputDescricao">Descrição do simulado</label>
							<textarea name="txtDescricao" style="resize: vertical;" class="form-control" id="inputDescricao" placeholder="Digite aqui..." maxlength="4096" name="txtaDescricao" rows="5" required></textarea>
						</div>
						<hr>
						<?php include('include/lista_categorias.php'); ?>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="jumbotron">
						<hr>
						<div class="form-group">
							<label for="cbxResolverAgora">Resolver agora?</label>
							<select name="cbxResolverAgora" class="form-control" id="cbxResolverAgora" required>
								<option value="s">Sim</option>
								<option value="n">Não</option>
							</select>
						</div>
						<div class="form-group">
							<label for="selectNumeroQuestoes">Número de questões</label>
							<select name="cbxQuantidade" class="form-control" id="selectNumeroQuestoes" required>
								<option value="60">60</option>
								<option value="50">50</option>
								<option value="40">40</option>
								<option value="30">30</option>
								<option value="20">20</option>
								<option value="10">10</option>
							</select>
						</div>
						<hr>
						<button type="submit" class="btn btn-primary">Gerar</button>
						<button type="reset" class="btn btn-default">Cancelar</button>
							<div id="div_msg" style="display: none; margin-top: 20px;" class="alert alert-warning alert-dismissible" role="alert">
								<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
								<strong id="txtMsg"></strong>
							</div>
					</div>
				</div>
				</form>

			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript">
		function GerarSimulado(){
			$("#aguardar").modal("show");
			//var formdata = $("#frmGerarSimulado").serialize();
			var dados = jQuery("#frmGerarSimulado").serialize();
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/gerar_simulado.php',
				data:  dados,
				success: function (data) {
					var ret = String(data);
					if(ret == "error:cat_null")
					{
						document.getElementById("txtMsg").textContent = "Selecione pelo menos uma categoria";
						document.getElementById("div_msg").style.display = 'block';
						$("#aguardar").modal("hide");
					}
					else if(ret == "error:questions_insuficient")
					{
						document.getElementById("txtMsg").textContent = "Não foram encontradas questões para as categorias selecionadas";
						document.getElementById("div_msg").style.display = 'block';
						$("#aguardar").modal("hide");
					}
					else if(ret == "erro")
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado";
						document.getElementById("div_msg").style.display = 'block';
						$("#aguardar").modal("hide");
					}
					else
					{
						if(document.getElementById("cbxResolverAgora").value == "s")
						{
							document.getElementById("id_teste").value = ret;
							frmTeste.submit();
						}
						else
						{
							location.href = "Simulados";
						}
					}
				},
				error: function(data){
					document.getElementById("txtMsg").textContent = "Erro inesperado";
					document.getElementById("div_msg").style.display = 'block';
					$("#aguardar").modal("hide");
				}
			});
		}
</script>
  </body>
</html>
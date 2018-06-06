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

	<script type="text/javascript">
		function cadastrar()
		{
			var nome = document.getElementById("inputNome").value;
			var descricao = document.getElementById("inputDescricao").value;
			var status = document.getElementById("selectStatus").selectedIndex;
			var fileName = "";
			var x = document.getElementsByName('chkCategorias[]');
			var categorias = new Array();
			var tamanho = 0;
			for (i = 0; i < x.length; i++) 
			{
				if (x[i].checked == true) 
				{
					categorias[tamanho] = x[i].value;
					tamanho += 1;
				}
			}
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/cad_teste.php',
				data: {nome: nome, descricao: descricao, status: status, img: fileName, categorias: JSON.stringify(categorias), tamanho: tamanho},
				success: function (data) {
					var ret = parseInt(data);
					if(ret > 0)
					{
						location.href="CadastroQuestao?id_teste=" + ret;
					}
					else
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado ao cadastrar.";
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
	
	</style>
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Cadastro de simulado</h2>
			</div>
			<div class="row">
			<form action="javascript:cadastrar();" method="post">
				<div class="col-md-8">
					<div class="jumbotron" style="overflow: hidden;">
						<hr>
						<div class="form-group">
							<label for="inputNome" class="control-label">Nome do teste</label>
							<input type="text" class="form-control" id="inputNome" placeholder="Digite aqui..." name="txtNome" required>
						</div>
						<div class="form-group">
							<label for="inputDescricao">Descrição do teste</label>
							<textarea style="resize: vertical;" class="form-control" id="inputDescricao" placeholder="Digite aqui..." maxlength="4096" name="txtaDescricao" rows="5" required></textarea>
						</div>
						<hr>
						<div class="form-group">
							<label for="InputImage">Imagem do teste</label>
							<input type="file" id="InputImage">
						</div>		
						<hr>
						
						<?php include('include/lista_categorias.php'); ?>
						
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="jumbotron">
						<hr>
						<div class="form-group">
							<label for="selectStatus">Status</label>
							<select class="form-control" id="selectStatus" required>
								<option value="1">Rascunho</option>
							</select>
						</div>
						<hr>
						<button type="submit" class="btn btn-primary">Cadastrar</button>
						<button type="reset" class="btn btn-default">Cancelar</button>
					</div>
				</div>
				<div class="form-group" style="margin-bottom: -14px;">
					<div class="col-sm-12">
						<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong id="txtMsg"></strong>
						</div>
					</div>
				</div>
				<div class="form-group" style="margin-bottom: -14px;">
					<div class="col-sm-12">
						<div id="div_msg2" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong id="txtMsg2"></strong>
						</div>
					</div>
				</div> 
				<div class="form-group" style="margin-bottom: -14px;">
					<div class="col-sm-12">
						<div id="div_msg3" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong id="txtMsg3"></strong>
						</div>
					</div>
				</div> 
				<div class="form-group" style="margin-bottom: -14px;">
					<div class="col-sm-12">
						<div id="div_msg4" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong id="txtMsg4"></strong>
						</div>
					</div>
				</div> 
				<div class="form-group" style="margin-bottom: -14px;">
					<div class="col-sm-12">
						<div id="div_msg5" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<strong id="txtMsg5"></strong>
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
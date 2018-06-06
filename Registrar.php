<?php
	include('include/config.php');
	
	if(isset($_SESSION['id_usuario']))
	{
		header("Location: home");
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
		function registrar()
		{
			var nome = document.getElementById("txtNome").value;
			var sobrenome = document.getElementById("txtSobrenome").value;
			var email = document.getElementById("txtEmail").value;
			var senha = document.getElementById("txtSenha").value;
			var confirma_senha = document.getElementById("txtConfirmaSenha").value;
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/registrar.php',
				data: {nome: nome, sobrenome: sobrenome, email: email, senha: senha, confirma_senha: confirma_senha},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="home"; // Redirecionar usuário para uma página depois de logar-se
					}
					else if(ret == 0)
					{
						document.getElementById("txtMsg").textContent = "Erro ao registrar.";
						document.getElementById("div_msg").style.display = 'block';
					}
					else if(ret == -2)
					{
						document.getElementById("txtMsg").textContent = "Senhas não conferem.";
						document.getElementById("div_msg").style.display = 'block';
					}
					else if(ret == -3)
					{
						document.getElementById("txtMsg").textContent = "Email já cadastrado.";
						document.getElementById("div_msg").style.display = 'block';
					}
					else
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador";
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
	
	<style>
	body{
		background: url(img/background.jpeg) no-repeat;
		background-position-x: auto;
		background-position-y: auto;
		background-size: cover;
		vertical-align: middle;
		margin: 0px 0px 0px 0px;
	}
	
	@media (max-width: 768px) {

		body {
			margin-bottom: 0px;
			}
	}
	body > .container {
		padding: 90px 15px 100px 15px;
	}
	
	
	.footer {
		position: absolute;
		bottom: 0;
		width: 100%;
		height: auto;
		background-color: #333;
		line-height: 20px;
		font-size: auto;
		color: white;
	}

	@media (max-width: 768px) {
		.footer {
				font-size: 75%;
		}
	}

	.container .text-muted {
		margin: 0px 0;
	}

	.footer > .container {
		padding-right: 15px;
		padding-left: 15px;
	}

	code {
		font-size: 80%;
	}	
	
	.footer {
		background-image: -webkit-linear-gradient(top, #3c3c3c 0%, #222 100%);
		background-image:      -o-linear-gradient(top, #3c3c3c 0%, #222 100%);
		background-image: -webkit-gradient(linear, left top, left bottom, from(#3c3c3c), to(#222));
		background-image:         linear-gradient(to bottom, #3c3c3c 0%, #222 100%);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff3c3c3c', endColorstr='#ff222222', GradientType=0);
		filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
		background-repeat: repeat-x;
		border-radius: 0px;
	}
	

	</style>
  </head>
	<body>  
		<?php include('include/headerOut.php'); ?>
		<div class="container">
		    <div class="row">
				<div style="background-color: none;" class="col-md-6 col-sm-offset-3">
					<div class="generic-background">					
						<form action="javascript:registrar();" method="post" class="form-horizontal">
							<div class="form-group" >
								<div class="col-sm-12">
								  <h2><strong>Registro de Usuário</strong></h2>
								  <hr style="margin-bottom: 10px;">
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon" id="nome">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
										</span>
										<input maxlength="32" type="text" id="txtNome" class="form-control" placeholder="Nome" aria-describedby="nome" required>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon" id="sobrenome">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
										</span>
										<input maxlength="128" type="text" id="txtSobrenome" class="form-control" placeholder="Sobrenome" aria-describedby="sobrenome" required>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon" id="email">
											<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
										</span>
										<input maxlength="64" type="email" id="txtEmail" class="form-control" placeholder="E-mail" aria-describedby="email" required>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon" id="senha">
											<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
										</span>
										<input maxlength="16" type="password" id="txtSenha" class="form-control" placeholder="Senha" aria-describedby="senha" required>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon" id="confirma_senha">
											<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
										</span>
										<input maxlength="16" type="password" id="txtConfirmaSenha" class="form-control" placeholder="Confirmar senha" aria-describedby="confirma-senha" required>
									</div>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-0 col-sm-10">
								  <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
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
							  <hr style="margin-bottom: 10px;">
							  <div class="form-group">
								<div class="col-sm-12">
								  Já é registrado? <a href="Index">Clique aqui</a>
								</div>
							  </div>
						</form>		
					</div>
				</div>
			</div>
		</div>		
		<?php include('include/footerOut.php'); ?>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
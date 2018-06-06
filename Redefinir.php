<?php
	include('include/config.php');
	
	if(isset($_SESSION['id_usuario']) || isset($_COOKIE['id_usuario']))
	{
		header("Location: Home");
	}
	
	if(!isset($_GET['token']))
	{
		header("Location: Index");
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
		function Redefinir()
		{
			var senha = document.getElementById("txtNovaSenha").value;
			var senhaConfirm = document.getElementById("txtConfirmarSenha").value;
			var token = document.getElementById("hdToken").value;
			
			if(senha == senhaConfirm)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/redefinir.php',
					data: {senha: senha, token: token},
					success: function (data) {
						var ret = parseInt(data);
						if(ret == 1)
						{
							document.getElementById("txtMsg").textContent = "Senha redefinida com sucesso!";
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
			else
			{
				document.getElementById("txtMsg").textContent = "As senhas não conferem";
				document.getElementById("div_msg").style.display = 'block';
			}
		}
	</script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	body {
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
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">
                    <img src="img/logo.png" style="height: 50px;" alt="">
              </a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right nav-pills">
				  <li>
					  <a href="http://facebook.com/" class="btn btn-social-icon btn-facebook">
						  <i class="fa fa-facebook"></i>
					  </a>
				  </li>
				  <li>
					  <a href="http://twitter.com/" class="btn btn-social-icon btn-twitter" >
						  <i class="fa fa-twitter"></i>
					  </a>
				  </li>
				  <li>
					  <a href="https://plus.google.com/"  class="btn btn-social-icon btn-google-plus">
						  <i class="fa fa-google-plus"></i>
					  </a>
				  </li>
			  </ul>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="#">Sobre</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>

		<!-- Begin page content -->
		<div class="container">
		    <div class="row">
				<div class="col-md-6 col-sm-offset-3">
				<div class="generic-background">
						<form action="javascript:Redefinir();" method="post" class="form-horizontal">
						<div class="form-group" >
							  <h2><strong>Redefinir senha</strong></h2>
							  <hr style="margin-bottom: 0px;">
						 </div>
						<div class="form-group">
							<label for="alterar_senha">Nova senha </label>
							<div class="input-group">
								<span class="input-group-addon" id="email">
									<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
								</span>
								<input maxlength="16" type="password" class="form-control" id="txtNovaSenha" placeholder="Alterar senha">
							</div>
						</div>
						<div class="form-group">
							<label for="confirmar_senha">Confirmar senha </label>
							<div class="input-group">
								<span class="input-group-addon" id="email">
									<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
								</span>
								<input maxlength="16" type="password" class="form-control" id="txtConfirmarSenha" placeholder="Confirmar senha">
							</div>
						</div>
						  <div class="form-group">
								<input type="hidden" id="hdToken" value="<?php echo $_GET['token']; ?>">
							  <button type="submit" class="btn btn-primary btn-lg btn-block">Redefinir</button>
						  </div>
						<div class="form-group" style="margin-bottom: -14px;">
								<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<strong id="txtMsg"></strong>
								</div>
						</div> 
						   <div class="form-group">
						   						  <hr style="margin-bottom: 10px;">

							  Página inicial <a href="Home">Clique aqui</a>
						   </div>
						   <input type="hidden" id="token" value="<?php echo $token; ?>" />
						</form>		
					</div>
									
				</div>
			</div>
		</div>
		<footer class="footer" style="overflow: hidden; padding: 15px 0px 15px 0px;">
			<div class="container">
				<p class="text-muted" style="color: white;text-align:center;">TL Concursos • © 2015 • Todos os direitos reservados </p>
			</div>
		</footer>  
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
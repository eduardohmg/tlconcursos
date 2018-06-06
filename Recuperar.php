<?php
	include('include/config.php');
	
	if(isset($_SESSION['id_usuario']) || isset($_COOKIE['id_usuario']))
	{
		header("Location: Home");
	}
	
	$_SESSION['token'] = md5(uniqid(mt_rand(), true));
	$token = $_SESSION['token'];
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
		function EnviarEmail()
		{
			$("#aguardar").modal("show");
			
			var email = document.getElementById("txtEmail").value;
			
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/recuperar.php',
				data: {email: email},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						document.getElementById("txtMsg").textContent = "Enviamos um link para o seu e-mail.\nPor meio dele você pode redefinir sua senha.";
						document.getElementById("div_msg").style.display = 'block';
					}
					else if(ret == 0)
					{
						document.getElementById("txtMsg").textContent = "E-mail não cadastrado";
						document.getElementById("div_msg").style.display = 'block';
					}
					else
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador)";
						document.getElementById("div_msg").style.display = 'block';
					}
					$("#aguardar").modal("hide");
				},
				error: function(data){
					document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador)";
					document.getElementById("div_msg").style.display = 'block';
					$("#aguardar").modal("hide");
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
	
	<?php include('include/modalAguardar.php'); ?>
	
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
			  <a class="navbar-brand" href="Index">
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
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default" style="box-shadow: 2px 2px 2px 2px  #000000;">
				<div class="panel-body">
					<div class="text-center">
						<i class="fa fa-question-circle fa-5x"></i>
						<h3>Esqueceu sua senha?</h3>
						<p>Digite seu E-mail.</p>
					</div>
					<div class="panel-body">
						<form action="javascript:EnviarEmail();" method="post" class="form">
							<fieldset>
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
										<input id="txtEmail" name="txtEmail" placeholder="E-mail" class="form-control" type="email" required="">
									</div>
								</div>
								<div class="form-group">
									<input class="btn btn-lg btn-primary btn-block" value="Enviar" type="submit">
								</div>
								<div class="form-group">
									<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<strong id="txtMsg"></strong>
									</div>
								</div>
								<hr >
								<div class="form-group">
									<div class="col-sm-12">
										Página inicial. <a href="Home">Clique aqui</a>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
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
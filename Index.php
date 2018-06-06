<?php
	if(isset($_SESSION['id_usuario']) || isset($_COOKIE['token']))
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
		function logar()
		{
			var email = document.getElementById("txtEmail").value;
			var senha = document.getElementById("txtSenha").value;
			if(document.getElementById("manter").checked == true)
			{
				var manter = document.getElementById("manter").value;
			}
			else
			{
				var manter = 0;
			}
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/login.php',
				data: {email: email, senha: senha, manter: manter},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="Home"; // Redirecionar usuário para uma página depois de logar-se
					}
					else if(ret == 0)
					{
						document.getElementById("txtMsg").textContent = "Login ou senha inválidos!";
						document.getElementById("div_msg").style.display = 'block';
					}
					else
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador)";
						document.getElementById("div_msg").style.display = 'block';
					}
				},
				error: function(data){
					document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador)";
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
		<?php include('include/headerOut.php'); ?>
		<div class="container">
		    <div class="row">
				<div class="col-md-6 col-sm-offset-3">
					<div class="generic-background">
						<form action="javascript:logar();" method="post" class="form-horizontal">
						<div class="form-group" >
							<div class="col-sm-12">
							  <h2><strong>Login de Usuário</strong></h2>
							  <hr style="margin-bottom: 0px;">
							</div>
						 </div>
						  <div class="form-group">
							<div class="col-sm-12">
							  Quer se registrar? <a href="Registrar">Clique aqui</a>
							</div>
						  </div>
						  <div class="form-group">
							<div class="col-sm-12">
							  <div class="input-group">
								<span class="input-group-addon" id="email">
									<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
								</span>
								<input maxlength="64" id='txtEmail' type="email" class="form-control" placeholder="E-mail" aria-describedby="email" required>
							  </div>
							</div>
						  </div>
						  <div class="form-group">
							<div class="col-sm-12">
							  <div class="input-group">
								<span class="input-group-addon" id="senha">
									<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
								</span>
								<input maxlength="16" id='txtSenha' type="password" class="form-control" placeholder="Senha" aria-describedby="senha" required>
							  </div>
							</div>
						  </div>
						  <div class="form-group">
							<div class="col-sm-offset-0 col-sm-10">
							  <div class="checkbox">
								<label>
								  <input type="checkbox" id="manter" value="1"> Mantenha-me conectado
								</label>
							  </div>
							</div>
						  </div>
						  <div class="form-group">
							<div class="col-sm-offset-0 col-sm-10">
							  <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
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
							  Perdeu sua senha? <a href="Recuperar">Clique aqui</a>
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
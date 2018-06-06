<?php
	include('../include/config.php');
	include('../include/general_security.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
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
	body { background-image: url(img/backgroundErro.png);}
	.erro {padding: 40px 15px;text-align: center;}
	.erro-detalhe {margin-top:15px;margin-bottom:15px;}
	.erro-acao .btn { margin-right:10px; }
	</style>
				
	</head>
	<body>  
	<?php include('../include/header.php'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="erro">
					<h1>
						Oops!</h1>
					<h2>
						404 - Página Não Encontrada</h2>
					<div class="erro-detalhe">
						Um erro ocorreu. Página solicitada não encontrada!
					</div>
					<div class="erro-acao">
						<a href="Home" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
							Ir para Home </a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include('../include/footer.php'); ?>   

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	</body>
</html>
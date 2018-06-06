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
	
	.panel{
		margin-bottom: 30px;
	}	
	</style>
  </head>
	<body>  
		<?php include('include/header.php'); ?>
		<?php include('include/modalCompra.php'); ?>

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li class="active">Financeiro</li>
			</ol>	
			<div class="row">
				<div class="col-md-12 col-md-offset-0">
					<div class="row">
						<div class="col-md-3">
							<div class="panel panel-blue">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-credit-card fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">250</div>
											<div>Créditos</div>
										</div>
									</div>
								</div>
								<a href="javascript:Comprar(250, 2.50);">
									<div class="panel-footer">
										<span class="pull-left">Comprar (R$ 2,50)</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-green">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-credit-card fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">500</div>
											<div>Créditos</div>
										</div>
									</div>
								</div>
								<a href="javascript:Comprar(500, 4.90);">
									<div class="panel-footer">
										<span class="pull-left">Comprar (R$ 4,90)</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-yellow">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-credit-card fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">750</div>
											<div>Créditos</div>
										</div>
									</div>
								</div>
								<a href="javascript:Comprar(750, 6.90);">
									<div class="panel-footer">
										<span class="pull-left">Comprar (R$ 6,90)</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="panel panel-red">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-credit-card fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">1000</div>
											<div>Créditos</div>
										</div>
									</div>
								</div>
								<a href="javascript:Comprar(1000, 8.90);">
									<div class="panel-footer">
										<span class="pull-left">Comprar (R$ 8,90)</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-12 ">
							<blockquote>
								<p class="text-justify">
									O sistema funcionará com créditos...
								</p>
							</blockquote>
							<blockquote>
								<p class="text-justify">
									Para comprar basta...
								</p>
							</blockquote>
							<blockquote>
								<p class="text-justify">
									Um crédito vale...
								</p>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include('include/footer.php'); ?>   

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	
	<script>
		function Comprar(quantidade, valor)
		{
			descricao = quantidade + ' unidades de crédito.';
			
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/comprar.php',
				data: {descricao: descricao, valor: valor, quantidade: quantidade},
				success: function (data) {
					var ret = String(data);
					if(ret == 1)
					{
						$("#CompraEfetuada").modal("show");
						document.getElementById("spanSaldo").textContent = parseInt(document.getElementById("spanSaldo").textContent) + quantidade;
					}
				},
				error: function(data){
					alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
				}
			});
		}
	</script>
	
  </body>
</html>
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
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="home">TL Concursos</a></li>
				<li class="active">Cartão</li>
			</ol>	
			<div class="row">
				<div class="col-md-12 col-md-offset-0">
					<form class="form-horizontal" role="form">
						<fieldset>
							<legend>Cadastro de cartão</legend>
							<div class="form-group">
								<label class="col-md-3 control-label" for="nomeCartao">Nome do cartão:</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="nomeCartao" id="nomeCartao" placeholder="Nome do seu cartão">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="numeroCartao">Número do cartão:</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="numeroCartao" id="numeroCartao" placeholder="Número do cartão de crédito/débito">
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="expiracaoData">Data de expiração:</label>
								<div class="col-md-9">
									<div class="row">
										<div class="col-md-3">
											<select class="form-control col-md-2" name="expiracaoData" id="expiracaoData">
												<option>Mês</option>
												<option value="01">Janeiro (01)</option>
												<option value="02">Fevereiro (02)</option>
												<option value="03">Março (03)</option>
												<option value="04">Abril (04)</option>
												<option value="05">Maio (05)</option>
												<option value="06">Junho (06)</option>
												<option value="07">Julho (07)</option>
												<option value="08">Agosto (08)</option>
												<option value="09">Setembro (09)</option>
												<option value="10">Outubro (10)</option>
												<option value="11">Novembro (11)</option>
												<option value="12">Dezembro (12)</option>
											</select>
										</div>
										<div class="col-md-3">
											<select class="form-control" name="expiracaoData">
												<option value="15">2015</option>
												<option value="16">2016</option>
												<option value="17">2017</option>
												<option value="18">2018</option>
												<option value="19">2019</option>
												<option value="20">2020</option>
												<option value="21">2021</option>
												<option value="22">2022</option>
												<option value="23">2023</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="cvv">Código de segurança:</label>
								<div class="col-md-3">
									<input type="text" class="form-control" name="cvv" id="cvv" placeholder="Código de segurança do cartão">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-3 col-md-9">
									<button type="button" class="btn btn-success">Cadastrar</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		
		<?php include('include/footer.php'); ?>   

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
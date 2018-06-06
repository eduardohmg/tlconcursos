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
	
	<style>
		
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
			<div class="page-header">
				<h2>Sobre</h2>
			</div>
			<ol class="breadcrumb">
						<li><a href="home">TL Concursos</a></li>
						<li class="active">Sobre</li>
					</ol>		
			<div class="row">
				<div class="col-md-8 ">
					<blockquote>
							<p style="font-size: 17px;" class="text-justify"><br>
							
									A <font style="font-size: 15px; font-family: Arial Black; font-color: ">TL Concursos</font> foi criada em 2015 por um grupo de estudantes na Escola Técnica Tupy de Joinville, Santa Catarina.
									Somos uma empresa dedicada em ajudar as pessoas certas a chegarem nos lugares certos e acreditamos que apenas os 
									esforçados com ferramentas eficazes alcançam o sucesso.<br><br> 

									Nós criamos uma dessas ferramentas que ajuda seus usuários na hora de testar seus conhecimentos. 
									Com nosso sistema, hoje é possível ter acesso a um material de qualidade sem custo operacional que ofereça
									um retorno ao estudante sobre seu desempenho como nenhum outro programa ou sistema de testes online.<br><br> 

									Relatórios e gráficos bem como tabelas de respostas são apresentados aos estudantes logo após a resolução de seus 
									testes e em conformidade com seus resultados anteriores, com TL Concursos não há erros, apenas melhorias!<br><br> 

									<font style="font-size: 20px; font-family: Comic Sans MS">E você, o quê está esperando?  Vá logo se registrar e comece á se preparar!</font><br><br> 
									
								</p>
						</blockquote>
				</div>
				
			</div>
		</div>
		
		<?php include('include/footerOut.php'); ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
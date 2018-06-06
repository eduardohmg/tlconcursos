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
	
	.table-responsive .glyphicon
		{color: black;}

	.table-responsive .glyphicon:hover
	{color: #23527c;}
	</style>
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><a href="home">Home</a></li>
						<li class="active">Lista de simulados</li>
					</ol>
					<div class="row">
						<div class="col-md-10 col-md-offset-0">					
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Simulados cadastrados</h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered">
											<colgroup>
												<col class="col-xs-1">
												<col class="col-xs-5">
												<col class="col-xs-1">
												<col class="col-xs-1">
												<col class="col-xs-1">
											</colgroup>
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th>Simulado</th>
													<th class="text-center">Ano</th>
													<th class="text-center">Nº questões</th>
													<th class="text-center">Resolver</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$limite = 10;
													$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
													$inicio = ($limite * $pagina) - $limite;
													$total = mysql_num_rows(mysql_query("SELECT * FROM teste WHERE tipo = 1 AND status = 2"));
													$numPaginas = ceil($total/$limite);
													
													$sql_simulados = mysql_query("SELECT * FROM teste WHERE tipo = 1 AND status = 2 ORDER BY data DESC LIMIT ".$inicio.",".$limite."");
													while($dados_simulado = mysql_fetch_array($sql_simulados))
													{
														$sql_num_questoes = mysql_query("SELECT * FROM banco WHERE id_teste=".$dados_simulado['id_teste']."");
														$num_questoes = mysql_num_rows($sql_num_questoes);
														echo "<tr>
																<th class='text-center' scope='row'>1</th>
																<td>".$dados_simulado['nome']."</td>
																<td class='text-center'>2002</td>
																<td class='text-center'>".$num_questoes."</td>
																<td class='text-center'><a href='Simultest'><span class='glyphicon glyphicon-pencil'></a></td>
															</tr>";
													}
												?>
											</tbody>
										</table>
									</div>
									<div class="pull-left" style="margin-top: 10px; margin-bottom: -25px;">
										<a href="SimuladosCadastrados">Gerenciar simulados</a>
									</div>
								</div>
								<hr style="margin-bottom: 5px;">
								<center>
								<nav>
									<ul class="pagination">
										<?php
											if($pagina <= 1)
											{
												echo "<li class='disabled'><a aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
											}
											else
											{
												echo "<li><a href='ListaSimulados?page=".($pagina - 1)."' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
											}
											
											$cont = 1;
											while($cont <= $numPaginas)
											{
												$ativo = "";
												if(isset($_GET['page']))
												{
													if($_GET['page'] == $cont)
													{
														$ativo = "class='active'";
													}
												}
												else
												{
													if($cont == 1)
													{
														$ativo = "class='active'";
													}
												}
												echo "<li $ativo><a href='ListaSimulados?page=".$cont."'>$cont</a></li>";
												$cont++;
											}
											
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
											}
											else
											{
												echo "<li><a href='ListaSimulados?page=".($pagina + 1)."' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
											}
										?><!--
										<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
										<li class="active"><a href="#">1</a></li>
										<li><a href="#">2</a></li>
										<li><a href="#">3</a></li>
										<li><a href="#">4</a></li>
										<li><a href="#">5</a></li>
										<li>
											<a href="#" aria-label="Next">
												<span aria-hidden="true">&raquo;</span>
											</a>
										</li>
										!-->
									</ul>
								</nav>
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
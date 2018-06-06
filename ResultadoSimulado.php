<?php
	include('include/config.php');
	include('include/general_security.php');
	
	$questoes_por_tabela = 10;
	
	$id_teste;
	
	$questoes_acertadas = 0;
	$questoes_erradas = 0;
	$questoes_branco = 0;
	$questoes_total = 0;
	
	$per_questoes_acertadas = 0;
	$per_questoes_erradas = 0;
	$per_questoes_branco = 0;
	
	if(isset($_POST['id_teste']))
	{
		$id_teste = $_POST['id_teste'];
	}
	else
	{
		header("Location: Simulados");
	}
	
	$sql_bancos = mysql_query("SELECT * FROM banco WHERE id_teste = ".$id_teste);
	
	$arr_bancos = array();
	
	for($i = 0; $result_bancos=mysql_fetch_array($sql_bancos); $i++)
	{
		$arr_bancos[$i] = $result_bancos;
	}
	
	$sql_questoes_total = mysql_query("SELECT COUNT(*) as total FROM banco WHERE id_teste = ".$id_teste);
	$result_questoes_total = mysql_fetch_assoc($sql_questoes_total);
	
	$questoes_total = $result_questoes_total['total'];
	
	$sql_questoes_historico = mysql_query("SELECT * FROM historico WHERE id_teste = ".$id_teste." AND id_usuario = ".$_SESSION['id_usuario']);
	
	while($result_questoes_historico=mysql_fetch_array($sql_questoes_historico))
	{
		$sql_historico_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_alternativa = ".$result_questoes_historico['id_alternativa']);
		$result_historico_alternativa = mysql_fetch_assoc($sql_historico_alternativa);
		
		if($result_questoes_historico['id_alternativa'] <> 0)
		{
			if($result_historico_alternativa['correta'] == 1)
			{
				$questoes_acertadas++;
			}
			else
			{
				$questoes_erradas++;
			}
		}
		else
		{
			$questoes_branco++;
		}
	}
	
	$per_questoes_acertadas = ($questoes_acertadas / $questoes_total) * 100;
	$per_questoes_erradas = ($questoes_erradas / $questoes_total) * 100;
	$per_questoes_branco = ($questoes_branco / $questoes_total) * 100;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TL Concursos | Ensinando para o futuro</title>

	<link rel="shortcut icon" href="img/favicon.png">
    <link href="css/style.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">
	<link href="css/font-awesome.css" rel="stylesheet">	
	
	<script src="js/jsapi.js"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
		.table a {
		color: #000000;
		text-decoration: none;
		}
		.table a:hover, focus {
		text-decoration: none;
		}	
		a {
		text-decoration: none;
		}
		a:hover, focus {
		text-decoration: none;
		}		
		.glyphicon-remove{color: red;}
		.glyphicon-ok{color: green;}
		.generic-background {box-shadow: none;}
			
	</style>
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Resultado do Simulado</h2>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron" style="margin-bottom:20px;box-shadow: 2px 2px 2px 2px  #000000;">
						<div class="generic-background" style="padding: 15px;">
							<div class="row">
								<div class="col-md-8">
									<div class="panel panel-default" style="margin-bottom:10px; padding-bottom: 10px;">
										<div class="panel-heading"><strong>Informações</strong>
										</div>
										<div class="panel-body">
											<ul class="list-unstyled">
												<li><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <strong>Acertou</strong></li>
												<li><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Errou</strong></li>
												<li><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <strong>Não resolveu</strong></li>
											</ul>
											<ul class="list-group">
												<li class="list-group-item"><strong>Acertadas:</strong> <?php echo $questoes_acertadas; ?>/<?php echo $questoes_total; ?> (<?php echo number_format($per_questoes_acertadas, 0, '.', ''); ?>%)</li>
												<li class="list-group-item"><strong>Erradas:</strong> <?php echo $questoes_erradas; ?>/<?php echo $questoes_total; ?> (<?php echo number_format($per_questoes_erradas, 0, '.', ''); ?>%)</li>
												<li class="list-group-item"><strong>Não resolvidas:</strong> <?php echo $questoes_branco; ?>/<?php echo $questoes_total; ?> (<?php echo number_format($per_questoes_branco, 0, '.', ''); ?>%)</li>
											</ul>
										</div>
										<a style="margin-left: 20px;" href="Simulados"> Simulados realizados</a>
									</div>
								</div>
								<div class="col-md-4">
								<div class="panel panel-default">
										<div class="panel-heading"><strong>Gráfico</strong>
										</div>
										<div class="panel-body">
											<?php echo "<div id='piechart'>
											<strong>
												<script type='text/javascript'>
												  google.load('visualization', '1', {packages:['corechart']});
												  google.setOnLoadCallback(drawChart);
												  function drawChart() {
													var data = google.visualization.arrayToDataTable([
														['Task', 'Hours per Day'],
														['Corretas',".$questoes_acertadas."],
														['Incorretas',".$questoes_erradas."],
														['Não Resolvidas',".$questoes_branco."]
													]);

													var options = {
														title: 'Desempenho',
														colors: ['#90EE90', '#EE6363', '#CCCCCC'],
														width: '100%',
														height: '100%',
														pieSliceText: 'percentage',
														chartArea: {
															left: '3%',
															top: '3%',
															height: '100%',
															width: '100%'
															}
														};

													var chart = new google.visualization.PieChart(document.getElementById('piechart'));

													chart.draw(data, options);
												  }
												</script>
											</strong>
										</div>";
										?>
										</div>
									</div>
										
								</div>
							</div>
						</div>
						<div class="alert alert-warning alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<strong>Observação:</strong> Clique no ícone para visualizar a(s) questão(ões)
						</div>
						<div class="row">
							<?php
								$contador_questoes = 0;
								$sub_contador_questoes = 0;
								
								while($contador_questoes < $questoes_total)
								{
									echo "<div class='col-md-4 col-md-offset-0'>
											<div class='generic-background' style='margin-bottom: 30px;padding: 0px'>
												<table class='table table-bordered table-hover'>
													<colgroup>
														<col class='col-xs-4'>
														<col class='col-xs-4'>
														<col class='col-xs-4'>
													</colgroup>
													<thead>
														<tr class='success'>
															<th class='text-center'>Questão</th>
															<th class='text-center'>Resultado</th>
															<th class='text-center'>Ver</th>
														</tr>
													</thead>
													<tbody>";
								
									for($sub_contador_questoes = 0; $contador_questoes < $questoes_total && $sub_contador_questoes < $questoes_por_tabela; $sub_contador_questoes++, $contador_questoes++)
									{
										$icone_resposta = "class='glyphicon glyphicon-";
										
										$sql_historico = mysql_query("SELECT * FROM historico WHERE id_teste = ".$id_teste." AND id_questao = ".$arr_bancos[$contador_questoes]['id_questao']." AND id_usuario = ".$_SESSION['id_usuario']);
										$result_historico = mysql_fetch_assoc($sql_historico);
										
										if(mysql_num_rows($sql_historico) > 0)
										{
										
											$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_alternativa = ".$result_historico['id_alternativa']);
											$result_alternativa = mysql_fetch_assoc($sql_alternativa);
											
											if($result_historico['id_alternativa'] <> 0)
											{
												if($result_alternativa['correta'] == 1)
												{
													$icone_resposta = $icone_resposta."ok";
												}
												else
												{
													$icone_resposta = $icone_resposta."remove";
												}
											}
											else
											{
												$icone_resposta = $icone_resposta."alert";
											}
										}
										else
										{
											$icone_resposta = "";
										}
										
										
										
										$icone_resposta = $icone_resposta."'";
										
										echo "<tr>
													<th class='text-center' scope='row'>".$arr_bancos[$contador_questoes]['num_questao']."</th>
													<td class='text-center'><span ".$icone_resposta." aria-hidden='true'></td>
													<td class='text-center'><a href='#resultado' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalResultadoSimulado.php?id_questao=".$arr_bancos[$contador_questoes]['id_questao']."&id_teste=".$arr_bancos[$contador_questoes]['id_teste']."' data-remote-target='#resultado .modal-content' data-tooltip='tooltip' title='Questão ".$arr_bancos[$contador_questoes]['num_questao']."' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
												</tr>";
									}
									
									echo "</tbody>
										</table>
									</div>
								</div>";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
    
		<!-- Modal HTML -->
		<div id="resultado" class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!-- Content will be loaded here from "remote.php" file -->
				</div>
			</div>
		</div>
		
		
		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	<script>
		$('[data-load-remote]').on('click',function(e) {
			e.preventDefault();
			var $this = $(this);
			var remote = $this.data('load-remote');
			if(remote) {
				$($this.data('remote-target')).load(remote);
			}
		});
		
		$(document).ready(function()
		{
			$('body').tooltip({
				selector: "[data-tooltip=tooltip]",
				container: "body"
			});
		});
	</script>
  </body>
</html>
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
		
		<script src="js/jsapi.js"></script>
	</head>

	<body>
    
		<?php include('include/header.php'); ?>   

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Desempenho</li>
			</ol>
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item"><i class="fa fa-info fa-fw"></i> Informações</a>
						<a href="QuestoesAdquiridas" class="list-group-item"><i class="fa fa-shopping-cart fa-fw"></i> Questões adquiridas</a>
						<a href="Simulados" class="list-group-item"><i class="fa fa-check-square-o fa-fw"></i> Simulados realizados</a>
						<a href="Favoritos" class="list-group-item"><i class="fa fa-star fa-fw"></i> Questões favoritadas</a>
						<a href="Desempenho" class="list-group-item active"><i class="fa fa-area-chart fa-fw"></i> Desempenho</a>
						<?php
							if($_SESSION['nivel'] >= 2)
							{
							$controle = "";
								if($_SESSION['nivel'] == 3)
								{
									$controle = "<a href='ControleUsuario' class='list-group-item'><i class='fa fa-user fa-fw'></i> Controle de usuários</a>";
								}
								echo "	".$controle."
										<a href='SimuladosCadastrados' class='list-group-item'><i class='fa fa-check fa-fw'></i> Simulados cadastrados</a>
										<a href='QuestoesCadastradas' class='list-group-item'><i class='fa fa-check fa-fw'></i> Questões cadastradas</a>	
										<a href='Noticias' class='list-group-item'><i class='fa fa-newspaper-o fa-fw'></i> Notícias</a>
										<a href='Resolucoes' class='list-group-item'><i class='fa fa-sign-in fa-fw'></i> Cadastro de resoluções</a>
										<a href='Sugestoes' class='list-group-item'><i class='fa fa-comment fa-fw'></i> Sugestões</a>
									";
							}
						?>
					</div>
				</div>
				<div class="col-md-9">
					<p class="pull-left visible-xs">
						<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas"><i class="fa fa-th-list"></i> Menu</button>
					</p>
					<div class="off-menu">
							<?php
								$ano[0] = 2015;
								$j = 0;
								$i = 0;
								$cont = 0;
								$sql_datas = mysql_query("SELECT * FROM historico WHERE id_usuario=".$_SESSION['id_usuario']." ORDER BY data DESC");
								while($dados_datas = mysql_fetch_array($sql_datas))
								{
									$tamanho = count($ano);
									while($i < $tamanho)
									{
										$sql_datas_diferentes = mysql_query("SELECT * FROM historico WHERE id_usuario=".$_SESSION['id_usuario']." AND data != '%".$ano[$i]."-%'");
										if(mysql_num_rows($sql_datas_diferentes) > 0)
										{
											while($cont < $tamanho)
											{
												while($dados_datas_diferentes = mysql_fetch_array($sql_datas_diferentes))
												{
													$data_arrumada = strtotime($dados_datas_diferentes['data']);
													$data_A = date('Y', $data_arrumada);
													if($data_A != $ano[$cont])
													{
														$ano[$tamanho] = $data_A;
														$tamanho++;
													}
												}
												$cont++;
											}
										}
										$i++;
									}
								}
							?>
						</select>
						<br>
						<div class="panel panel-primary min-panel">
							<div class="panel-heading"><strong>Desempenho</strong>
							</div>
							<?php
									for($i = 1; $i <= 12; $i++)
									{
										$total_mes[$i-1] = 0;
										$corretas_mes[$i-1] = 0;
										$porcentagem_acerto[$i-1] = 0;
										$sql_historico_mes = mysql_query("SELECT * FROM historico WHERE data LIKE '%-$i-%' AND id_usuario=".$_SESSION['id_usuario']." AND id_alternativa!=0");
										if(mysql_num_rows($sql_historico_mes) > 0)
										{
											while($dados_mes = mysql_fetch_array($sql_historico_mes))
											{
												$total_mes[$i-1] += 1;
												$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_alternativa=".$dados_mes['id_alternativa']."");
												$dados_alternativa = mysql_fetch_assoc($sql_alternativa);
												if($dados_alternativa['correta'] == 1)
												{
													$corretas_mes[$i-1] += 1;
												}
											}
										}
										if($total_mes[$i-1] != 0 && $corretas_mes[$i-1] != 0)
										{
											$porcentagem_acerto[$i-1] = ($corretas_mes[$i-1]/$total_mes[$i-1]) * 100;
										}
										else
										{
											$porcentagem_acerto[$i-1] = 0;
										}
										$porcentagem_erro[$i-1] = 100 - $porcentagem_acerto[$i-1];
									}
									
									$j = 0;
									$meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];											 
									
									echo "<script type='text/javascript'>
											  google.load('visualization', '1', {packages:['corechart']});
											  google.setOnLoadCallback(drawChart);
											  function drawChart() {
												var data = google.visualization.arrayToDataTable([
												  ['Mês', 'Acertos'],";
												  for($i = 1; $i <= 12; $i++)
												  {
													echo "['".$meses[$i-1]."',  ".$porcentagem_acerto[$i-1]."],";
												  }
												echo "]);

												var options = {
												  title: 'Desempenho mensal de 2015',
												  colors: ['#228B22'],
												  hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
												  vAxis: {minValue: 0}
												};

												var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
												chart.draw(data, options);
											  }
											</script>";
							?>
							<div id='chart_div' style='width: 900px; height: 500px;'></div>
						</div>
					</div>
				</div> 
			</div>
		</div>
	
		<?php include('include/footer.php'); ?>   

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>

		<script src="js/offcanvas.js"></script>
		
		<script>
			function favoritar(id_questao)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/add_favorito.php',
					data:  "id_questao="+id_questao,
					success: function (data)
					{
						$('table#tb_favoritas tr#tr_'+id_questao).remove();
					},
					error: function(data){
						alert('Erro inesperado ao excluir questão - Por favor, contate o administrador');
					}
				});
			}
		</script>
	
		<script>
			function VerResultado(questao)
			{
				var inputs = '<input type="hidden" name="questao" value="' + questao + '" />';
				$("body").append('<form action="Questao" method="post" id="poster">'+inputs+'</form>');
				$("#poster").submit();
				
				/*alert(id_teste);
				$.post('ResultadoSimulado.php', { id_teste: id_teste }, function() { window.location.href = 'ResultadoSimulado.php' });*/
			}
		</script>
	
	</body>
</html>
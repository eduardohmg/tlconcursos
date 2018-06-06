<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');
	
	function RetornaDesempenho($id_teste)
	{
		$total = 0;
		$corretas = 0;
		$desempenho = 0;
		
		$sql_historicos = mysql_query("SELECT * FROM historico WHERE id_usuario = ".$_SESSION['id_usuario']." AND id_teste = ".$id_teste);
		
		while($result_historico = mysql_fetch_array($sql_historicos))
		{
			$total++;
			$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_alternativa = ".$result_historico['id_alternativa']);
			$result_alternativa = mysql_fetch_assoc($sql_alternativa);
			
			if($result_alternativa['correta'] == 1)
			{
				$corretas++;
			}
		}
		
		if($total == 0)
		{
			return 0;
		}
		
		$desempenho = ($corretas / $total) * 100;
		
		return $desempenho;
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
	</head>

	<body>
    
		<?php include('include/header.php'); ?>   
		<?php include('include/modalSimuladosAlert.php'); ?>   

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Questões favoritadas</li>
			</ol>
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item"><i class="fa fa-info fa-fw"></i> Informações</a>
						<a href="QuestoesAdquiridas" class="list-group-item"><i class="fa fa-shopping-cart fa-fw"></i> Questões adquiridas</a>
						<a href="Simulados" class="list-group-item active"><i class="fa fa-check-square-o fa-fw"></i> Simulados realizados</a>
						<a href="Favoritos" class="list-group-item"><i class="fa fa-star fa-fw"></i> Questões favoritadas</a>
						<a href="Desempenho" class="list-group-item"><i class="fa fa-area-chart fa-fw"></i> Desempenho</a>
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
						<div class="panel panel-primary">
							<div class="panel-heading"><strong>Simulados</strong>
							</div>
							<div class="table-responsive" style="padding: 0 10px 0 10px;">							
								<form action="javascript: Pesquisar();" role="search">
									<div class="input-group" style="margin: 10px 0 0 0;">
										<input maxlength="128" id="pesquisaSimulados" type="text" class="form-control" placeholder="Pesquisar...">
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
											</button>
										</span>
									</div>
								</form>
								<table id="tb_testes" class="table table-striped table-bordered">
									<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-0">
										<col class="col-xs-3">
									</colgroup>
										<?php
											$limite = 10;
											$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
											$total = mysql_num_rows(mysql_query("SELECT * FROM teste WHERE visibilidade = 1 AND id_usuario = ".$_SESSION['id_usuario'].""));
											$numPaginas = ceil($total/$limite);
											$inicio = ($limite * $pagina) - $limite;
											
											$cont = $total - ($limite * ($pagina-1));
											$k = 0;
											
											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaSimuladosRealizados($_GET['pesquisa']);
												if(count($resultado) > 0)
												{
													echo "<thead>
																<tr>
																	<th class='text-left'>#</th>
																	<th>Nome</th>
																	<th>Data</th>
																	<th class='text-center'>Desempenho</th>
																	<th class='text-center'>Info</th>
																	<th class='text-center'>Ver</th>
																	<th class='text-center'>Resolver</th>
																	<th class='text-center'>Excluir</th>
																</tr>
															</thead>
															<tbody>";
													while($k < count($resultado))
													{
														$data_arrumada = strtotime($resultado[$k]['data']);
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														
														$complemento = "";
														$cor = "";
														$ver_simulado = "<a class='postresult' href=\"javascript:VerResultado(".$resultado[$k]['id'].");\" >";
														
														$funcao = "RegerarSimulado";
														
														if($resultado[$k]['finalizado'] == 0)
														{
															$complemento = "class='text-danger'";
															$cor = "#a94442";
															$funcao = "ContinuarSimulado";
															$ver_simulado = "<a data-toggle='modal' href='#alertFinalizacao'>";
														}
														echo "<tr ".$complemento." id='tr_".$resultado[$k]['id']."'>
																<th class='text-left' scope='row'>".$resultado[$k]['id']."</th>
																<td>".$resultado[$k]['nome']."</td>
																<td>".$data_DMA." às ".$data_MS."</td>
																<td class='text-center'>".number_format(RetornaDesempenho($resultado[$k]['id']), 0, '.', '')."%</td>
																<td class='text-center'><a href='#simuladoInfo' style='cursor: pointer; color: ".$cor."' role='button' data-toggle='modal' data-load-remote='include/modalSimulados.php?id_simulado=".$resultado[$k]['id']."' data-remote-target='#simuladoInfo .modal-content' data-tooltip='tooltip' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
																<td class='text-center'>".$ver_simulado."<span class='glyphicon glyphicon-share-alt' style='color: ".$cor."' aria-hidden='true'></td>
																<td class='text-center'><a href=\"javascript:".$funcao."(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-pencil' style='color: ".$cor."' aria-hidden='true'></a></td>
																<td class='text-center'><a href=\"javascript:Excluir(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-trash' style='color: ".$cor."' aria-hidden='true'></a></td>
															</tr>";
															
														$cont--;
														$k++;
													}
												}
												else
												{
													echo "<tbody>";
													echo "<h4>Nenhum simulado encontrado.</h4>";
												}
											}
											else
											{
												$sql_testes = mysql_query("SELECT * FROM teste WHERE visibilidade = 1 AND id_usuario = ".$_SESSION['id_usuario']." ORDER BY id_teste DESC LIMIT ".$inicio.",".$limite."");
												echo "<thead>
																<tr>
																	<th class='text-left'>#</th>
																	<th>Nome</th>
																	<th>Data</th>
																	<th class='text-center'>Desempenho</th>
																	<th class='text-center'>Info</th>
																	<th class='text-center'>Ver</th>
																	<th class='text-center'>Resolver</th>
																	<th class='text-center'>Excluir</th>
																</tr>
															</thead>
															<tbody>";
												while($result_testes = mysql_fetch_array($sql_testes))
												{
													$data_arrumada = strtotime($result_testes['data'] );
													$data_DMA = date('d/m/Y', $data_arrumada);
													$data_MS = date('H:i', $data_arrumada);
													
													$complemento = "";
													$cor = "";
													$ver_simulado = "<a class='postresult' href=\"javascript:VerResultado(".$result_testes['id_teste'].");\" >";
													
													$funcao = "RegerarSimulado";
													
													if($result_testes['finalizado'] == 0)
													{
														$complemento = "class='text-danger'";
														$cor = "#a94442";
														$funcao = "ContinuarSimulado";
														$ver_simulado = "<a data-toggle='modal' href='#alertFinalizacao'>";
													}
													
													echo "<tr ".$complemento." id='tr_".$result_testes['id_teste']."'>
															<th class='text-left' scope='row'>".$cont."</th>
															<td>".$result_testes['nome']."</td>
															<td>".$data_DMA." às ".$data_MS."</td>
															<td class='text-center'>".number_format(RetornaDesempenho($result_testes['id_teste']), 0, '.', '')."%</td>
															<td class='text-center'><a href='#simuladoInfo' style='cursor: pointer; color: ".$cor."' role='button' data-toggle='modal' data-load-remote='include/modalSimulados.php?id_simulado=".$result_testes['id_teste']."' data-remote-target='#simuladoInfo .modal-content' data-tooltip='tooltip' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
															<td class='text-center'>".$ver_simulado."<span class='glyphicon glyphicon-share-alt' style='color: ".$cor."' aria-hidden='true'></td>
															<td class='text-center'><a href=\"javascript:".$funcao."(".$result_testes['id_teste'].");\"><span class='glyphicon glyphicon-pencil' style='color: ".$cor."' aria-hidden='true'></a></td>
															<td class='text-center'><a href=\"javascript:Excluir(".$result_testes['id_teste'].");\"><span class='glyphicon glyphicon-trash' style='color: ".$cor."' aria-hidden='true'></a></td>
														</tr>";
														
													$cont--;
												}
											}
										?>
									</tbody>
								</table>
								<nav>
									<ul class="pager">
										<?php
											if($pagina <= 1)
											{
												echo "<li class='disabled'><a>Anterior</a></li>";
											}
											else
											{
												echo "<li><a href='Simulados?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='Simulados?page=".($pagina + 1)."'>Próximo</a></li>";
											}
										?>
									</ul>
								</nav>
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div>
	
		<!-- Modal HTML -->
		<div id="simuladoInfo" class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">

				</div>
			</div>
		</div>
			
		<?php include('include/footer.php'); ?>  
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/offcanvas.js"></script>
	
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
	
	<script type="text/javascript">
		function Pesquisar()
		{
			location.href = "Simulados?pesquisa="+document.getElementById('pesquisaSimulados').value;
		}
	
		function Excluir(id_teste)
		{
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/del_teste.php',
				data: {id_teste: id_teste},
				success: function (data) {
					var ret = String(data);
					if(ret == 1)
					{
						$('table#tb_testes tr#tr_'+id_teste).remove();
					}
				},
				error: function(data){
					alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
				}
			});
		}
		
		function ContinuarSimulado(id_teste)
		{
			var inputs = '<input type="hidden" name="id_teste" value="' + id_teste + '" />';
			$("body").append('<form action="Simultest" method="post" id="frmTeste">'+inputs+'</form>');
			$("#frmTeste").submit();
		}
		
		function RegerarSimulado(id_teste){
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/regerar_simulado.php',
				data: {id_teste: id_teste},
				success: function (data) {
					var ret = String(data);
					if(ret == "erro")
					{
						alert('Erro!');
					}
					else
					{
						var inputs = '<input type="hidden" name="id_teste" value="' + ret + '" />';
						$("body").append('<form action="Simultest" method="post" id="frmTeste">'+inputs+'</form>');
						$("#frmTeste").submit();
					}
				},
				error: function(data){
					alert('Erro');
				}
			});
		}
	</script>
	
	<script>
		function VerResultado(id_teste)
		{
			var inputs = '<input type="hidden" name="id_teste" value="' + id_teste + '" />';
			$("body").append('<form action="ResultadoSimulado" method="post" id="poster">'+inputs+'</form>');
			$("#poster").submit();
			
			/*alert(id_teste);
			$.post('ResultadoSimulado.php', { id_teste: id_teste }, function() { window.location.href = 'ResultadoSimulado.php' });*/
		}
	</script>
  </body>
</html>
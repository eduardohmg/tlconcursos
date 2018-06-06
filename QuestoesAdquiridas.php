<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');
	
	$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = ".$_SESSION['id_usuario']);
	$result_usuario = mysql_fetch_assoc($sql_usuario);
	
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
	<style>
		.glyphicon-remove{color: red;}
		.glyphicon-ok{color: green;}
		.generic-background {box-shadow: none;}	
	</style>
	

	<body>
    
		<?php include('include/header.php'); ?>   

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Questões adquiridas</li>
			</ol>	
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item"><i class="fa fa-info fa-fw"></i> Informações</a>
						<a href="QuestoesAdquiridas" class="list-group-item active"><i class="fa fa-shopping-cart fa-fw"></i> Questões adquiridas</a>
						<a href="Simulados" class="list-group-item"><i class="fa fa-check-square-o fa-fw"></i> Simulados realizados</a>
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
							echo "		".$controle."
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
						<div class="panel panel-primary min-panel">
							<div class="panel-heading"><strong>Questões</strong>
							</div>
							<div class="table-responsive" style="padding:0 10px 0 10px;">
							<form action="javascript: Pesquisar();" role="search">
								<div class="input-group" style="margin: 10px 0 0 0;">
									<input maxlength="128" id="pesquisaQuestao" type="text" class="form-control" placeholder="Pesquisar..." required>
									<span class="input-group-btn">
										<button class="btn btn-default" type="submit">
											<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
										</button>
									</span>
								</div>
							</form>
								<table id="tb_favoritas" class="table table-striped table-bordered">
									<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-1">
										<col class="col-xs-8">
										<col class="col-xs-0">
									</colgroup>
									<thead>
										<tr>
											<th >ID</th>
											<th >Data</th>
											<th >Descrição</th>
											<th class="text-center">Info</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$resultado = "";
											$k = 0;
											
											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaQuestoesAdquiridas($_GET['pesquisa']);
												$limite = 5;
												$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
												$total = count($resultado);
												$numPaginas = ceil($total/$limite);
												$inicio = ($limite * $pagina) - $limite;
												
												echo "<script>DeletarLinhas();</script>";
													if(count($resultado) > 0)
													{
														while($k < count($resultado))
														{
															$data_arrumada = strtotime($resultado[$k]['data']);
															$data_DMA = date('d/m/Y', $data_arrumada);
															$data_MS = date('H:i', $data_arrumada);
															
															echo "<tr id='tr_".$resultado[$k]['id']."'>
																	<th scope='row'>".$resultado[$k]['id']."</th>
																	<td>".$data_DMA." às ".$data_MS."</td>
																	<td>".$resultado[$k]['descricao']."</td>
																	<td class='text-center'><a href='#QuestaoInfo' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalQuestao.php?questao=".$resultado[$k]['id']."' data-remote-target='#QuestaoInfo .modal-content' data-tooltip='tooltip' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
																</tr>";
																
															$k++;
														}
													}
													else
													{
														echo "<tr id='tr_".$resultado[$k]['id']."'>
																	<th scope='row'>".$resultado[$k]['id']."</th>
																	<td></td>
																	<td><h4>Nenhum resultado encontrado.</h4></td>
																	</tr>";
													}
											}
											else
											{
												$limite = 5;
												$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
												$total = mysql_num_rows(mysql_query("SELECT * FROM inventario WHERE id_usuario = ".$_SESSION['id_usuario'].""));
												$numPaginas = ceil($total/$limite);
												$inicio = ($limite * $pagina) - $limite;
												
												$sql_inventario = mysql_query("SELECT * FROM inventario WHERE id_usuario = ".$_SESSION['id_usuario']." ORDER BY data DESC LIMIT ".$inicio.",".$limite."");
												while($dados_inventario = mysql_fetch_array($sql_inventario))
												{
													$sql_questoes = mysql_query("SELECT * FROM questao WHERE id_questao = ".$dados_inventario['id_questao']);
													while($reg_questoes = mysql_fetch_array($sql_questoes))
													{
														$data_arrumada = strtotime($reg_questoes['data'] );
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														
														echo "<tr id='tr_".$dados_inventario['id_questao']."'>
																<th scope='row'>".$reg_questoes['id_questao']."</th>
																<td>".$data_DMA." às ".$data_MS."</td>
																<td>".$reg_questoes['texto']."</td>
																<td class='text-center'><a href='#QuestaoInfo' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalQuestao.php?questao=".$reg_questoes['id_questao']."' data-remote-target='#QuestaoInfo .modal-content' data-tooltip='tooltip' title='Questão ".$reg_questoes['id_questao']."' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
															</tr>";
													}
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
												echo "<li id='anterior' value='1' class='disabled'><a>Anterior</a></li>";
											}
											else
											{
												echo "<li id='anterior' value='2'><a href='QuestoesAdquiridas?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li id='proximo' value='3' class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li id='proximo' value='4'><a href='QuestoesAdquiridas?page=".($pagina + 1)."'>Próximo</a></li>";
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
		<div id="QuestaoInfo" class="modal fade">
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
		
		<script>
			function DeletarLinhas()
			{
				$('table#tb_favoritas').remove();
			}
			
			function Pesquisar()
			{
				location.href = "QuestoesAdquiridas?pesquisa="+document.getElementById('pesquisaQuestao').value;
			}
		</script>
	</body>
</html>
<?php
	include('include/config.php');
	include('include/general_security.php');

	if($_SESSION['nivel'] < 2)
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
	</head>
	
	<body>
	
		<?php include('include/header.php'); ?>  
				
		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Cadastro de resoluções</li>
			</ol>
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item"><i class="fa fa-info fa-fw"></i> Informações</a>
						<a href="QuestoesAdquiridas" class="list-group-item"><i class="fa fa-shopping-cart fa-fw"></i> Questões adquiridas</a>
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
								echo "	".$controle."
										<a href='SimuladosCadastrados' class='list-group-item'><i class='fa fa-check fa-fw'></i> Simulados cadastrados</a>
										<a href='QuestoesCadastradas' class='list-group-item'><i class='fa fa-check fa-fw'></i> Questões cadastradas</a>	
										<a href='Noticias' class='list-group-item'><i class='fa fa-newspaper-o fa-fw'></i> Notícias</a>
										<a href='Resolucoes' class='list-group-item active'><i class='fa fa-sign-in fa-fw'></i> Cadastro de resoluções</a>
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
							<div class="table-responsive" style="padding: 0 10px 0 10px;">							
								<form>
									<div class="input-group" style="margin: 10px 0 0 0;">
										<input maxlength="128" type="text" class="form-control" placeholder="Pesquisar...">
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
										<col class="col-xs-3">
										<col class="col-xs-5">
										<col class="col-xs-4">
										<col class="col-xs-1">
										<col class="col-xs-1">
										<col class="col-xs-1">
									</colgroup>
									<thead>
										<tr>
											<th >ID</th>
											<th >Descrição</th>
											<th >Data</th>
											<th class='text-center'>Ver</th>
											<th class='text-center'>Add</th>
											<th class='text-center'>Excluir</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql_inventario = mysql_query("SELECT * FROM `inventario` WHERE id_usuario = ".$_SESSION['id_usuario']." LIMIT $inicio,$limite");
											while($dados_inventario = mysql_fetch_array($sql_inventario))
											{
												$sql_resolucao = mysql_query("SELECT * FROM resolucao WHERE id_questao=".$dados_inventario['id_questao']."");
												while($dados_resolucao = mysql_fetch_array($sql_resolucao))
												{
													$data_arrumada = strtotime($dados_resolucao['data']);
													$data_DMA = date('d/m/Y', $data_arrumada);
													$data_MS = date('H:i', $data_arrumada);
													echo "<tr id='tr_".$dados_resolucao['id_resolucao']."'>
													<th scope='row'>".$dados_resolucao['id_resolucao']."</th>
													<td >".$dados_resolucao['texto']."</td>
													<td>".$data_DMA." às ".$data_MS."</td>
													<td class='text-center'><a href='#Resolucao' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalResolucoes.php?id_resolucao=".$dados_resolucao['id_resolucao']."' data-remote-target='#Resolucao .modal-content' data-tooltip='tooltip' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
													<td class='text-center'><a data-toggle='modal' href='#addResolucao'><span class='glyphicon glyphicon-plus' aria-hidden='true'></a></td>
													<td class='text-center'><a href=\"javascript:Excluir(".$dados_resolucao['id_resolucao'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
													</tr>";
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
												echo "<li><a href='Resolucoes?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='Resolucoes?page=".($pagina + 1)."'>Próximo</a></li>";
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
		
		<div id="Resolucao" class="modal fade">
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
			function Excluir(id_resolucao)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/del_resolucao.php',
					data: {id_resolucao: id_resolucao},
					success: function (data) {
						var ret = String(data);
						if(ret == 1)
						{
							$('table#tb_testes tr#tr_'+id_resolucao).remove();
						}
					},
					error: function(data){
						alert('Erro inesperado ao excluir a resolucao - Por favor, contate o administrador');
					}
				});
			}
		</script>
		
	</body>
</html>
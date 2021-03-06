<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');
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
				<li class="active">Questões favoritadas</li>
			</ol>
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item"><i class="fa fa-info fa-fw"></i> Informações</a>
						<a href="QuestoesAdquiridas" class="list-group-item"><i class="fa fa-shopping-cart fa-fw"></i> Questões adquiridas</a>
						<a href="Simulados" class="list-group-item"><i class="fa fa-check-square-o fa-fw"></i> Simulados realizados</a>
						<a href="Favoritos" class="list-group-item active"><i class="fa fa-star fa-fw"></i> Questões favoritadas</a>
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
						<div class="panel panel-primary min-panel">
							<div class="panel-heading"><strong>Favoritos</strong>
							</div>
							<div class="table-responsive" style="padding:0 10px 0 10px;">
							<form action="javascript: Pesquisar();" role="search">
							<div class="input-group" style="margin: 10px 0 0 0;">
								<input maxlength="128" type="text" id="pesquisaFavorito" class="form-control" placeholder="Pesquisar..." required>
								<span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
									</button>
								</span>
							</div>
							</form>
								<table id="tb_favoritas" class="table table-striped table-bordered">
								<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-7">
										<col class="col-xs-1">
										<col class="col-xs-1">
									</colgroup>
										<?php
											$limite = 5;
											$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
											$total = mysql_num_rows(mysql_query("SELECT * FROM favorito WHERE id_usuario = ".$_SESSION['id_usuario'].""));
											$numPaginas = ceil($total/$limite);
											$inicio = ($limite * $pagina) - $limite;
											$k = 0;
											
											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaFavoritos($_GET['pesquisa']);
												if(count($resultado) > 0)
												{
													echo "<thead>
															<tr>
																<th >ID</th>
																<th >Texto</th>
																<th >Data</th>
																<th class='text-center'>Ver</th>
																<th class='text-center'>Exclusão</th>
															</tr>
														</thead>
														<tbody>";
													while($k < count($resultado))
													{
														$data_arrumada = strtotime($resultado[$k]['data']);
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														
														echo "<tr id='tr_".$resultado[$k]['id']."'>
																<th scope='row'>".$resultado[$k]['id']."</th>
																<td>".$resultado[$k]['descricao']."</td>
																<td>".$data_DMA." às ".$data_MS."</td>
																<td class='text-center'><a href=\"javascript:VerResultado(".$resultado[$k]['id'].");\"> <span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a></td>
																<td class='text-center'><a href=\"javascript:favoritar(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
														</tr>";
														$k++;
													}
												}
												else
												{
													echo "<h4>Nenhuma questão encontrada.</h4>";
												}
											}
											else
											{
												echo "<thead>
															<tr>
																<th >ID</th>
																<th >Texto</th>
																<th >Data</th>
																<th class='text-center'>Ver</th>
																<th class='text-center'>Exclusão</th>
															</tr>
														</thead>
														<tbody>";
														
												$sql_Favoritos = mysql_query("SELECT * FROM favorito WHERE id_usuario = ".$_SESSION['id_usuario']." ORDER BY id_favorito DESC LIMIT ".$inicio.",".$limite."");
												while($reg_Favoritos = mysql_fetch_array($sql_Favoritos))
												{
													$sql_questoes = mysql_query("SELECT * FROM questao WHERE id_questao = ".$reg_Favoritos['id_questao']);
													while($reg_questoes = mysql_fetch_array($sql_questoes))
													{
														$data_arrumada = strtotime($reg_questoes['data'] );
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														echo "<tr id='tr_".$reg_Favoritos['id_questao']."'>
																<th scope='row'>".$reg_questoes['id_questao']."</th>
																<td>".$reg_questoes['texto']."</td>
																<td>".$data_DMA." às ".$data_MS."</td>
																<td class='text-center'><a href=\"javascript:VerResultado(".$reg_Favoritos['id_questao'].");\"> <span class='glyphicon glyphicon-share-alt' aria-hidden='true'></span></a></td>
																<td class='text-center'><a href=\"javascript:favoritar(".$reg_Favoritos['id_questao'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
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
												echo "<li class='disabled'><a>Anterior</a></li>";
											}
											else
											{
												echo "<li><a href='Favoritos?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='Favoritos?page=".($pagina + 1)."'>Próximo</a></li>";
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
			
			function Pesquisar()
			{
				location.href = "Favoritos?pesquisa="+document.getElementById('pesquisaFavorito').value;
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
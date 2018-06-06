<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');

	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
	}
	
	function strLess($str, $max = 200, $end = '')
	{
		$str = strip_tags($str);
		$countChar = strlen($str);

		if($countChar <= $max)
			return $str;

		else
		{
			$str    = substr($str, 0, $max);
			$space  = strrpos($str, ' ');
			$str    = substr($str, 0, $space);
			return $str.'...'.$end;
		}
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
				<li class="active">Noticias</li>
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
										<a href='Noticias' class='list-group-item active'><i class='fa fa-newspaper-o fa-fw'></i> Notícias</a>
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
							<div class="panel-heading"><strong>Noticias</strong>
							</div>
							<div class="row" style="padding: 0 10px 0 10px;">
								<div class="col-md-1 col-xs-2">
									<button onClick="location.href='CadastroNoticia'" style="margin-top: 10px;" type="button" class="btn btn-default" >
										<span class="glyphicon glyphicon-plus"></span> 
									</button>
								</div>
								<div class="col-md-11 col-xs-10">
									<form action="javascript: Pesquisar();" role="search">
										<div class="input-group" style="margin: 10px 0 0 0;">
											<input maxlength="128" type="text" id="pesquisaNoticia" class="form-control" placeholder="Pesquisar..." required>
											<span class="input-group-btn">
												<button class="btn btn-default" type="button">
													<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
												</button>
											</span>
										</div>
									</form>
								</div>
							</div>
							<div class="table-responsive" style="padding: 0 10px 0 10px;">							
								<table id="tb_noticias" class="table table-striped table-bordered">
									<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-3">
										<col class="col-xs-5">
										<col class="col-xs-4">
										<col class="col-xs-1">
										<col class="col-xs-1">
										<col class="col-xs-1">
									</colgroup>
										<?php
											$limite = 10;
											$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
											$total = mysql_num_rows(mysql_query("SELECT * FROM noticia"));
											$numPaginas = ceil($total/$limite);
											$inicio = ($limite * $pagina) - $limite;

											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaNoticia($_GET['pesquisa']);
												$k = 0;
												
												if(count($resultado) > 0)
												{
													echo "<thead>
														<tr>
															<th >ID</th>
															<th >Título</th>
															<th >Descrição</th>
															<th >Data</th>
															<th class='text-center'>Ver</th>
															<th class='text-center'Editar</th>
															<th class='text-center'>Excluir</th>
														</tr>
													</thead>
													<tbody>";
													
													while($k < count($resultado))
													{
														$n = "";

														for($i = 0; $i < strlen($resultado[$k]['nome']); $i++)
														{
															$char = substr($resultado[$k]['nome'], $i, 1);

															if((substr($resultado[$k]['nome'], $i+1, 1) == "-" || substr($resultado[$k]['nome'], $i+1, 1) == " ") && $char == " ")
															{
																continue;
															}
															else if($char == " ")
															{
																$n .= "-";
															}
															else if($char == "-")
															{
																continue;
															}
															else
															{
																$n .= $char;
															}
														}

														$data_arrumada = strtotime($resultado[$k]['data']);
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														echo "<tr id='tr_".$resultado[$k]['id']."'>
														<th scope='row'>".$resultado[$k]['id']."</th>
														<td>".strLess($resultado[$k]['nome'], 100, "")."</td>
														<td>".strLess($resultado[$k]['descricao'], 150, "")."</td>
														<td>".$data_DMA." às ".$data_MS."</td>
														<td class='text-center'><a href='Noticia?n=".$n."&d=".$resultado[$k]['id']."'><span class='glyphicon glyphicon-share-alt'></a></td>
														<td class='text-center'><a href='EditarNoticia?id=".$resultado[$k]['id']."'><span class='glyphicon glyphicon-edit'></a></td>
														<td class='text-center'><a href=\"javascript:Excluir(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
														</tr>";
														
														$k++;
													}
												}
												else
												{
													echo "<h4>Nenhuma noticia encontrada.</h4>";
												}
											}
											else
											{
												echo "<thead>
														<tr>
															<th >ID</th>
															<th >Título</th>
															<th >Descrição</th>
															<th >Data</th>
															<th class='text-center'>Ver</th>
															<th class='text-center'Editar</th>
															<th class='text-center'>Excluir</th>
														</tr>
													</thead>
													<tbody>";
												
												$sql_noticias = mysql_query("SELECT * FROM noticia ORDER BY data DESC LIMIT ".$inicio.",".$limite."");
												while($result_noticias = mysql_fetch_array($sql_noticias))
												{
													$n = "";

													for($i = 0; $i < strlen($result_noticias['titulo']); $i++)
													{
														$char = substr($result_noticias['titulo'], $i, 1);

														if((substr($result_noticias['titulo'], $i+1, 1) == "-" || substr($result_noticias['titulo'], $i+1, 1) == " ") && $char == " ")
														{
															continue;
														}
														else if($char == " ")
														{
															$n .= "-";
														}
														else if($char == "-")
														{
															continue;
														}
														else
														{
															$n .= $char;
														}
													}

													$data_arrumada = strtotime($result_noticias['data'] );
													$data_DMA = date('d/m/Y', $data_arrumada);
													$data_MS = date('H:i', $data_arrumada);
													echo "<tr id='tr_".$result_noticias['id_noticia']."'>
													<th scope='row'>".$result_noticias['id_noticia']."</th>
													<td>".strLess($result_noticias['titulo'], 100, "")."</td>
													<td>".strLess($result_noticias['descricao'], 150, "")."</td>
													<td>".$data_DMA." às ".$data_MS."</td>
													<td class='text-center'><a href='Noticia?n=".$n."&d=".$result_noticias['id_noticia']."'><span class='glyphicon glyphicon-share-alt'></a></td>
													<td class='text-center'><a href='EditarNoticia?id=".$result_noticias['id_noticia']."'><span class='glyphicon glyphicon-edit'></a></td>
													<td class='text-center'><a href=\"javascript:Excluir(".$result_noticias['id_noticia'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
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
												echo "<li><a href='Noticias?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='Noticias?page=".($pagina + 1)."'>Próximo</a></li>";
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
	
		<script type="text/javascript">
			function Pesquisar()
			{
				location.href = "Noticias?pesquisa=" + document.getElementById('pesquisaNoticia').value;
			}
			
			function Excluir(id_noticia)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/del_noticia.php',
					data: {id_noticia: id_noticia},
					success: function (data) {
						var ret = String(data);
						if(ret == 1)
						{
							$('table#tb_noticias tr#tr_'+id_noticia).remove();
						}
					},
					error: function(data){
						alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
					}
				});
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
							$("body").append('<form action="simultest" method="post" id="frmTeste">'+inputs+'</form>');
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
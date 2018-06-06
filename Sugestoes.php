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
				<li class="active">Sugestões</li>
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
										<a href='Resolucoes' class='list-group-item'><i class='fa fa-sign-in fa-fw'></i> Cadastro de resoluções</a>
										<a href='Sugestoes' class='list-group-item active'><i class='fa fa-comment fa-fw'></i> Sugestões</a>
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
							<div class="panel-heading"><strong>Sugestões</strong>
							</div>
							<div class="table-responsive" style="padding: 0 10px 0 10px;">
								<form action="javascript: Pesquisar();">
									<div class="input-group" style="margin: 10px 0 0 0;">
										<input maxlength="128" type="text" id="pesquisaSugestao" class="form-control" placeholder="Pesquisar..." required>
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
											</button>
										</span>
									</div>
								</form>							
								<table id="tb_noticias" class="table table-striped table-bordered">
									<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-3">
										<col class="col-xs-5">
										<col class="col-xs-4">
										<col class="col-xs-1">
										<col class="col-xs-1">
									</colgroup>
										<?php
											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaSugestao($_GET['pesquisa']);
												$k = 0;
												
												if(count($resultado) > 0)
												{
													$limite = 10;
													$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
													$total = mysql_num_rows(mysql_query("SELECT * FROM sugestao"));
													$numPaginas = ceil($total/$limite);
													$inicio = ($limite * $pagina) - $limite;
												
													echo "<thead>
															<tr>
																<th >ID</th>
																<th >Assunto</th>
																<th >Descrição</th>
																<th >Data</th>
																<th class='text-center'>Info</th>
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

														$data_arrumada = strtotime($resultado[$k]['data'] );
														$data_DMA = date('d/m/Y', $data_arrumada);
														$data_MS = date('H:i', $data_arrumada);
														echo "<tr id='tr_".$resultado[$k]['id']."'>
														<th scope='row'>".$resultado[$k]['id']."</th>
														<td>".strLess($resultado[$k]['nome'], 100, "")."</td>
														<td>".strLess($resultado[$k]['descricao'], 150, "")."</td>
														<td>".$data_DMA." às ".$data_MS."</td>
														<td class='text-center'><a href='#sugestao' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalSugestoes.php?sugestao=".$resultado[$k]['id']."' data-remote-target='#sugestao .modal-content' data-tooltip='tooltip' title='".$resultado[$k]['nome']."' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
														<td class='text-center'><a href=\"javascript:Excluir(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
														</tr>";
														
														$k++;
													}
												}
												else
												{
													$pagina = 0;
													$numPaginas = 0;
													echo "<h4>Nenhuma sugestão encontrada.</h4>";
												}
											}
											else
											{
												$limite = 10;
												$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
												$total = mysql_num_rows(mysql_query("SELECT * FROM sugestao"));
												$numPaginas = ceil($total/$limite);
												$inicio = ($limite * $pagina) - $limite;
												
												echo "<thead>
															<tr>
																<th >ID</th>
																<th >Assunto</th>
																<th >Descrição</th>
																<th >Data</th>
																<th class='text-center'>Info</th>
																<th class='text-center'>Excluir</th>
															</tr>
														</thead>
														<tbody>";
														
												$sql_sugestao = mysql_query("SELECT * FROM sugestao ORDER BY data DESC LIMIT ".$inicio.",".$limite."");
												while($result_sugestao = mysql_fetch_array($sql_sugestao))
												{
													$n = "";

													for($i = 0; $i < strlen($result_sugestao['titulo']); $i++)
													{
														$char = substr($result_sugestao['titulo'], $i, 1);

														if((substr($result_sugestao['titulo'], $i+1, 1) == "-" || substr($result_sugestao['titulo'], $i+1, 1) == " ") && $char == " ")
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

													$data_arrumada = strtotime($result_sugestao['data'] );
													$data_DMA = date('d/m/Y', $data_arrumada);
													$data_MS = date('H:i', $data_arrumada);
													echo "<tr id='tr_".$result_sugestao['id_sugestao']."'>
													<th scope='row'>".$result_sugestao['id_sugestao']."</th>
													<td>".strLess($result_sugestao['titulo'], 100, "")."</td>
													<td>".strLess($result_sugestao['corpo'], 150, "")."</td>
													<td>".$data_DMA." às ".$data_MS."</td>
													<td class='text-center'><a href='#sugestao' style='cursor: pointer' role='button' data-toggle='modal' data-load-remote='include/modalSugestoes.php?sugestao=".$result_sugestao['id_sugestao']."' data-remote-target='#sugestao .modal-content' data-tooltip='tooltip' title='".$result_sugestao['titulo']."' class='glyphicon glyphicon-zoom-in' aria-hidden='true' /></td>
													<td class='text-center'><a href=\"javascript:Excluir(".$result_sugestao['id_sugestao'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
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
												echo "<li><a href='Sugestoes?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='Sugestoes?page=".($pagina + 1)."'>Próximo</a></li>";
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
		
		<div id="sugestao" class="modal fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!-- Content will be loaded here from "remote.php" file -->
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
				location.href = "Sugestoes?pesquisa=" + document.getElementById('pesquisaSugestao').value;
			}
			
			function Excluir(id_sugestao)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/del_sugestao.php',
					data: {id_sugestao: id_sugestao},
					success: function (data) {
						var ret = String(data);
						if(ret == 1)
						{
							$('table#tb_noticias tr#tr_'+id_sugestao).remove();
						}
					},
					error: function(data){
						alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
					}
				});
			}
		</script>
	</body>
</html>
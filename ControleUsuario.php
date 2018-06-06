<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');
	
	if($_SESSION['nivel'] != 3)
	{
		header("Location: Home");
	}
	
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
	
	function($id_usuario,$nivel_usuario)
	{
		try
		{
			$nivel_usuario = $nivel_usuario + 1;
			$sql_alterar = mysql_query("UPDATE usuario SET nivel=$nivel WHERE id_usuario=$id_usuario");
			echo "1";
		}
		catch(Exception $e)
		{
			echo "-1";
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
			<?php include('include/modalConfirmar.php'); ?>

		<div class="container">
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Controle de usuários</li>
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
									$controle = "<a href='ControleUsuario' class='list-group-item active'><i class='fa fa-user fa-fw'></i> Controle de usuários</a>";
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
							<div class="panel-heading"><strong>Controle</strong>
							</div>
							<div class="table-responsive" style="padding: 0 10px 0 10px;">							
								<form action="javascript: Pesquisar();">
									<div class="input-group" style="margin: 10px 0 0 0;">
										<input maxlength="128" type="text" id="pesquisaUsuario" class="form-control" placeholder="Pesquisar..." required>
										<span class="input-group-btn">
											<button class="btn btn-default" type="button">
												<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
											</button>
										</span>
									</div>
								</form>
								<table id="tb_usuario" class="table table-striped table-bordered">
										<?php
											$limite = 5;
											$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
											$total = mysql_num_rows(mysql_query("SELECT * FROM usuario"));
											$numPaginas = ceil($total/$limite);
											$inicio = ($limite * $pagina) - $limite;
															
											$resultado = "";
											$k = 0;
															
											if(isset($_GET['pesquisa']))
											{
												$resultado = pesquisaUsuario($_GET['pesquisa']);
												
												if(count($resultado) > 0)
												{
													echo "<thead>
															<tr>
																<th >ID</th>
																<th >Nome / Sobrenome</th>
																<th >Data de registro</th>
																<th >E-mail</th>
																<th >Nível</th>
																<th class='text-center'>Excluir</th>
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
																<td>".$resultado[$k]['nome']." ".$resultado[$k]['sobrenome']."</td>
																<td>".$data_DMA." às ".$data_MS."</td>
																<td>".$resultado[$k]['email']."</td>
																<td>";
																?>
																<select name='<?php echo "nivel".$resultado[$k]['id'];?>' id='<?php echo "nivel".$resultado[$k]['id'];?>' class='form-control' onchange='javascript:MostrarModal(<?php echo $resultado[$k]['id'];?>, <?php echo $resultado[$k]['nivel'];?>);'>
																<?php
																for($i = 1; $i <= 3;$i++)
																{
																	$nivel = '';
																	if($i == $resultado[$k]['nivel'])
																	{
																		$nivel = 'selected';
																	}
																	echo "<option id='opt".$resultado[$k]['id']."' $nivel>$i</option>";
																}
																echo "</select>
																</td>
																<td class='text-center'><a href=\"javascript:Excluir(".$resultado[$k]['id'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
															</tr>";
															$k++;
													}
												}
												else
												{
													echo "<h4>Nenhum usuário encontrado.</h4>";
												}
											}
											else
											{
												echo "<thead>
															<tr>
																<th >ID</th>
																<th >Nome / Sobrenome</th>
																<th >Data de registro</th>
																<th >E-mail</th>
																<th >Nível</th>
																<th class='text-center'>Excluir</th>
															</tr>
														</thead>
														<tbody>";
														
												$sql_usuario = mysql_query("SELECT * FROM usuario ORDER BY id_usuario DESC LIMIT ".$inicio.",".$limite."");
												while($result_usuario= mysql_fetch_array($sql_usuario))
												{
													$data_arrumada = strtotime($result_usuario['data_cadastro'] );
													$data_DMA = date('d/m/Y', $data_arrumada);
													$data_MS = date('H:i', $data_arrumada);
													echo "<tr id='tr_".$result_usuario['id_usuario']."'>
															<th scope='row'>".$result_usuario['id_usuario']."</th>
															<td>".$result_usuario['nome']." ".$result_usuario['sobrenome']."</td>
															<td>".$data_DMA." às ".$data_MS."</td>
															<td>".$result_usuario['email']."</td>
															<td>";
															?>
															<select name='<?php echo "nivel".$result_usuario['id_usuario'];?>' id='<?php echo "nivel".$result_usuario['id_usuario'];?>' class='form-control' onchange='javascript:MostrarModal(<?php echo $result_usuario['id_usuario'];?>, <?php echo $result_usuario['nivel'];?>);'>
															<?php
															for($i = 1; $i <= 3;$i++)
															{
																$nivel = '';
																if($i == $result_usuario['nivel'])
																{
																	$nivel = 'selected';
																}
																echo "<option id='opt".$result_usuario['id_usuario']."' $nivel>$i</option>";
															}
															echo "</select>
															</td>
															<td class='text-center'><a href=\"javascript:Excluir(".$result_usuario['id_usuario'].");\"><span class='glyphicon glyphicon-trash' aria-hidden='true'></a></td>
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
												echo "<li><a href='ControleUsuario?page=".($pagina - 1)."'>Anterior</a></li>";
											}
											if($pagina >= $numPaginas)
											{
												echo "<li class='disabled'><a>Próxima</a></li>";
											}
											else
											{
												echo "<li><a href='ControleUsuario?page=".($pagina + 1)."'>Próximo</a></li>";
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
			var id_usuario_edit = 0;
			var nivel_edit = 0;
			
			jQuery(document).ready(function(){
				jQuery('#btnConfirmarSim').click(function()
				{
					Alterar(id_usuario_edit);
					$("#confirmar").modal("hide");
				});
				jQuery('#btnConfirmarNao').click(function()
				{
					var combo = document.getElementById("nivel"+id_usuario_edit);
					for (var i = 0; i < combo.options.length; i++)
					{
						if (combo.options[i].value == nivel_edit)
						{
							combo.options[i].selected = "true";
							break;
						}
					}
					
					$("#confirmar").modal("hide");
				});
			});
		
			function Excluir(id_usuario)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/del_usuario.php',
					data: {id_usuario: id_usuario},
					success: function (data) {
						var ret = String(data);
						if(ret == 1)
						{
							$('table#tb_usuario tr#tr_'+id_usuario).remove();
						}
					},
					error: function(data){
						alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
					}
				});
			}
			
			function MostrarModal(id_usuario, nivel_usuario)
			{
				$("#confirmar").modal("show");
				id_usuario_edit = id_usuario;
				nivel_edit = nivel_usuario;
			}
			
			function Alterar(id_usuario)
			{
				var nivel = document.getElementById("nivel"+id_usuario).selectedIndex;
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/alt_nivel_usuario.php',
					data: {id_usuario: id_usuario, nivel: nivel},
					success: function (data) {
					},
					error: function(data){
						alert('Erro inesperado ao excluir o teste - Por favor, contate o administrador');
					}
				});
			}
			
			function Pesquisar()
			{
				location.href = "ControleUsuario?pesquisa="+document.getElementById('pesquisaUsuario').value;
			}
		</script>
	</body>
</html>
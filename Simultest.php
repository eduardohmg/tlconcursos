<?php
	include('include/config.php');
	include('include/general_security.php');

	date_default_timezone_set('America/Sao_Paulo');
	
	$id_teste = 0;
	
	if(isset($_POST['id_teste']))
	{
		$id_teste = $_POST['id_teste'];
	}
	else
	{
		header("Location: Home");
	}
	
	$gabarito = array();
	if(isset($_POST["submit"]))
	{
		try
		{
			$id_teste = $_POST['id_teste'];
			$hidden = $_POST['codigos'];
			$array = array();
			$element = "";
			$id_questao;
			$id_alternativa;
			$email = $_SESSION['email'];
			
			$update_simulado = mysql_query("UPDATE teste SET finalizado='1', visibilidade='1' WHERE id_teste=$id_teste");
			
			for($i = 0; $i < strlen($hidden); $i++)
			{
				$char = substr($hidden, $i, 1);
				if($char <> ";")
				{
					$element = $element.$char;
				}
				else
				{
					array_push($array, $element);
					$element = "";
				}
			}
			
			$deletar_historico = mysql_query("DELETE FROM historico WHERE id_teste = $id_teste");
			
			for($i = 0; $i < count($array); $i++)
			{
				$id_alternativa;
				
				if(isset($_POST[$array[$i]]))
				{
					$id_alternativa = $_POST[$array[$i]];
				}
				else
				{
					$id_alternativa = 0;
				}
				
				$id_questao = $array[$i];
				$historico = mysql_query("INSERT INTO historico(id_historico, id_usuario, id_teste,id_questao,id_alternativa) VALUES('', '".$_SESSION['id_usuario']."', '$id_teste','$id_questao','$id_alternativa')");
			}
		}
		catch(Exception $e)
		{
			?>
			<script type="text/javascript">$("#aguardar").modal("hide");</script>
			<?php
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
		
		<link rel="stylesheet" href="css/jquery_ui/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		
		<?php
			if(isset($_POST["submit"]))
			{
				echo "<script>$(function() {
						$('body').append(\"<form action='ResultadoSimulado' method='post' id='poster'><input type='hidden' name='id_teste' value='".$id_teste."' /></form>\");
						$('#poster').submit();
					});</script>";
			}
		?>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<style>
			a {
			color: #000000;
			text-decoration: none;
			}
			a:hover, focus {
			text-decoration: none;
			}		
			.generic-background .glyphicon-remove{color: red;}
			.generic-background .glyphicon-ok{color: green;}
			
		
		</style>
		
		<script>
			function favoritar(id_questao){
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/add_favorito.php',
					data:  "id_questao="+id_questao,
					success: function (data) {
						var ret = String(data);
						if(ret == 1)
						{
							document.getElementById("fav_"+id_questao).style.color = "#FFC929";
						}
						else
						{
							document.getElementById("fav_"+id_questao).style.color = "#000000";
						}
					},
					error: function(data){
						alert('Erro inesperado ao favoritar questão - Por favor, contate o administrador');
					}
				});
			}
			
			$(function() {
				$("#tabs").tabs();
			});
		</script>
		
		<script>
			jQuery(document).ready(function(){
				jQuery('#btnSalvar').click(function()
				{
					$("#aguardar").modal("show");
					var formData = new FormData($("#dados")[0]);

					$.ajax({
						url: 'include/salvar_simulado.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						success: function (returndata) {
						  location.href="Simulados";
						}
					});

					return false;
				});
			});
		</script>
		
	</head>
	<body>
		<?php include('include/header.php'); ?>
		<?php include('include/modalSimultest.php'); ?> 
		<?php include('include/modalAguardar.php'); ?>
		
		<?php 
			$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste=$id_teste");
			$dados_teste = mysql_fetch_assoc($sql_teste);
			if($dados_teste['img'] != "")
			{
				$imagem_teste = "<img style='max-width: 100px;' class='img-responsive' src='img/noticias/".$dados_teste['img']."' alt=''>";
			}
			else
			{
				$imagem_teste = "";
			}
		?>
		
		<!-- Begin page content -->
		<div class="container">
		  <div class="page-header">
			<h2>Simulado Gerado</h2>
		  </div>
			<div class="row">
				<div class="col-md-12">
					<div class="jumbotron" style="  box-shadow: 2px 2px 2px 2px  #000000;">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<form id="dados" action="" method="POST">
								<div class="panel panel-default" style="margin-bottom:20px;box-shadow: 2px 2px 2px 2px  #000000;">
									<div class="panel-heading">
									    <h3 class="panel-title">Simulado</h3>
									</div>
									<div class="panel-body">
										<div class="form-group">
										<?php echo $imagem_teste;?>
										</div>
										<div class="form-group">
											<strong>Nome:</strong> <?php echo $dados_teste['nome'];?>
										</div>
										<div class="form-group">
											<strong>Descrição:</strong> <?php echo $dados_teste['descricao'];?>
										</div>
									</div>
									<div class="panel-footer"></div>
								</div>
								<input type="hidden" name="id_teste" value="<?php echo $id_teste ?>">
									<?php
										$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste = ".$id_teste." ORDER BY num_questao ASC");
										
										$ids = "";
										$cont = 0;
										
										$numquestoes = mysql_num_rows($sql_banco);
										
										$qpaba = 4;
										
										$numabas = $numquestoes / $qpaba ;
										
										if($numquestoes % $qpaba )
										{
											$numabas++;
										}
										
										echo "<div id='tabs' style='background: none; border: none'>
												<ul class='abas' style='list-style-type:none;'>";
										
										$de = 1;
										$ate = $qpaba;
										
										for($i = 1; $i <= $numabas; $i++)
										{
											$de = ($i * $qpaba) - $qpaba + 1;
											$ate = $qpaba * $i;
											
											if($ate > $numquestoes)
											{
												$ate = $numquestoes;
											}
											
											echo "
												<li>
													<a href='#".$i."'>".$de." - ".$ate."</a>
												</li>";
										}
										
										echo "</ul>";
										
										$contador = 1;
										$id_div = 1;
										
										echo "<div id=".$id_div.">";
										
										while($reg_banco = mysql_fetch_array($sql_banco))
										{
											$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao = ".$reg_banco['id_questao']);
											
											$reg = mysql_fetch_assoc($sql_questao);
											
											$sql_inventario = mysql_query("SELECT * FROM inventario WHERE id_usuario='".$_SESSION['id_usuario']."' AND id_questao='".$reg['id_questao']."'");
											
											$categorias = "";
											
											$sql_questao_categoria = mysql_query("SELECT * FROM questao_categoria WHERE id_questao = ".$reg['id_questao']);
											while($reg_questao_categoria = mysql_fetch_array($sql_questao_categoria))
											{
												$sql_categorias = mysql_query("SELECT * FROM categoria WHERE id_categoria = ".$reg_questao_categoria['id_categoria']);
												$reg_categorias = mysql_fetch_assoc($sql_categorias);
												$categorias = $categorias.", ".$reg_categorias['descricao'];
											}
											
											$categorias = substr($categorias, 1);
											
											
											echo "<div class='generic-background' style='padding-bottom: 40px; padding-top: 20px; margin-bottom: 60px;'>";
											
											echo "<div id='questao_".$reg['id_questao']."'>";
											
											echo "<strong>Questão ".$reg_banco['num_questao']."</strong>";
											
											// Verificar se a questão já foi favoritada
											
											$sql_verifica = mysql_query("SELECT * FROM favorito WHERE id_questao = ".$reg['id_questao']." AND id_usuario = ".$_SESSION['id_usuario']);
											$numrows = mysql_num_rows($sql_verifica);
											
											$star_color = "";
											
											if($numrows == 0)
											{
												$star_color = "#000000";
											}
											else
											{
												$star_color = "#FFC929";
											}
											
											echo "<div class='pull-right'>
													<a style='cursor:pointer' onclick='favoritar(".$reg['id_questao'].")'>
														<span id='fav_".$reg['id_questao']."' class='glyphicon glyphicon-star' style='color: ".$star_color."' aria-hidden='true' >
														</span>
														Favoritar
													</a>
												</div>";
												
											echo "<hr style='margin-top: 15px;'>
														<ul class='list-unstyled'>
															<li><strong>ID da questão:</strong> ".$reg['id_questao']."</li>
															<li><strong>Categoria(s):</strong> ".$categorias." </li>
														</ul>
													<hr>";
											
											// Mostrar as categorias corretamente
											
											echo "<ul class='list-unstyled'>
														<li style='margin-bottom: 15px;'>
															<p id='espacamento'>
																".$reg['texto']."
															</p>
														</li>		
													</ul>";
													
											if(!empty($reg['img']))
											{
												echo "<a class='thumbnail'>
														<img src='img/questoes/".$reg['img']."'>
													</a>";
											}
												
											echo "<hr>";
											
											$ids = $ids.$reg['id_questao'].";";
											
											$sql2 = mysql_query("SELECT * FROM alternativa WHERE id_questao = '".$reg['id_questao']."'");

											while($reg2 = mysql_fetch_array($sql2))
											{
												if(isset($_POST["submit"]))
												{
													echo $reg2['texto']."    ";
												}
												else
												{
													$checked = "";
													$sql_questao_pendente = mysql_query("SELECT * FROM questao_pendente WHERE id_questao = '".$reg['id_questao']."' AND id_alternativa = '".$reg2['id_alternativa']."' AND id_teste='".$id_teste."'");
													if(mysql_num_rows($sql_questao_pendente) > 0)
													{
														$checked = "checked";
													}
													echo "<div class='radio'>
															<label>
																<input type='radio' ".$checked." id='optionsRadios1' name='".$reg['id_questao']."' value='".$reg2['id_alternativa']."'>
																	".$reg2['texto']."</input>
															</label>";
													if(!empty($reg2['img']))
													{
														echo "<a class='thumbnail'>
																	<img src='img/alternativas/".$reg2['img']."'>
																</a>";
													}
													echo "</div>";
												}
											}
											if($cont < count($gabarito))
											{
												echo $gabarito[$cont];
												$cont++;
											}
											
											echo "</div>";
											
											if(mysql_num_rows($sql_inventario) == 0)
											{
												echo "<hr>
												<div class='pull-right'>
													<a id='linkComprar' href='javascript:MostrarModal(".$reg['id_questao'].")'>
														<span class='glyphicon glyphicon-shopping-cart' aria-hidden='true' >
														</span>
													Comprar
													</a>
												</div>";
											}
											else
											{
												echo "<hr>
												<div class='pull-right'>
														<span class='glyphicon glyphicon-ok' aria-hidden='true' >
														</span>
													Adquirida
												</div>";
											}
											
											echo "</div>";
											
											if($contador % $qpaba == 0)
											{
												$id_div++;
												echo "</div>";
												echo "<div id=".$id_div.">";
											}
											
											$contador++;
										}
										
										echo "</div>";
										echo "</div>";
										
										echo "<input type='hidden' name='codigos' value='".$ids."' />";
									?>
									<div class="pull-right">
										<button type="button" id="btnSalvar" name="btnSalvar" class="btn btn-primary btn-block" data-toggle="modal" data-target="#aguardar">
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Continuar depois (Salvar)
										</button>
										<button type="submit" name="submit" class="btn btn-default btn-block" data-toggle="modal" data-target="#aguardar">
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Finalizar
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include('include/footer.php'); ?>
		<script>
			id_questao_comprar = 0;
		
			jQuery(document).ready(function(){
				jQuery('#btnComprar').click(function()
				{
					comprar(id_questao_comprar);
					$("#ComprarQuestao").modal("hide");
				});
			});
				
			function MostrarModal(id_questao)
			{
				$("#ComprarQuestao").modal("show");
				id_questao_comprar = id_questao;
			}
				
			function comprar(id_questao)
			{
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/comprarQuestao.php',
					data: {id_questao: id_questao},
					success: function (data) {
						var ret = parseInt(data);
						if(ret >= 0)
						{
							document.getElementById("spanSaldo").textContent = ret + " C";
							$('#linkComprar').remove();
						}
						else
						{
							alert("You do not have grana...");
						}
					},
					error: function(data){
						document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador)";
						document.getElementById("div_msg").style.display = 'block';
					}
				});
			}
		</script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
<?php
	include('include/config.php');
	include('include/general_security.php');
	
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
			
		<script type="text/javascript">
			function sugerir()
			{
				var titulo = document.getElementById("txtTitulo").value;
				var corpo = document.getElementById("txtCorpo").value;
				
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/sugestao.php',
					data: {titulo: titulo, corpo: corpo},
					success: function (data) {
						var ret = parseInt(data);
						if(ret == 1)
						{
							document.getElementById("txtMsg").textContent = "Sugestão enviada com sucesso!";
							document.getElementById("div_msg").style.display = 'block';
						}
						else
						{
							document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador";
							document.getElementById("div_msg").style.display = 'block';
						}
					},
					error: function(data){
						document.getElementById("txtMsg").textContent = "Erro inesperado - Por favor, contate o administrador";
						document.getElementById("div_msg").style.display = 'block';
					}
				});
			}
		</script>
	</head>
	<body>  

	<?php include('include/header.php'); ?>   
		
		<div class="container">
			<div class="page-header">
				<h2>Ensinando para o futuro</h2>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="jumbotron" >
						<hr>
						<blockquote class="blockquote-content">
							<p>Clique no botão para criar um simulado.</p>
						</blockquote>
						<p><a class="btn btn-primary btn-lg" href="GerarSimulado" role="button"><i class="fa fa-book"></i> Criar</a></p>
					</div>
				</div>
				<div class="col-md-4 col-md-offset-0">
					<div class="panel panel-default" >
						<div class="panel-heading">
							<h3 class="panel-title">Simulados recentes</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped">
									<colgroup>
										<col class="col-xs-1">
										<col class="col-xs-5">
										<col class="col-xs-1">
									</colgroup>
									<thead>
										<tr>
											<th>#</th>
											<th>Simulado</th>
											<th class="text-center">Resolver</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql_teste = mysql_query("SELECT * FROM teste WHERE tipo=1 AND status = 2 AND visibilidade=1 ORDER BY data DESC LIMIT 3");
											$i = 1;
											while($dados_teste = mysql_fetch_array($sql_teste))
											{
												echo "<tr>
														<th scope='row'>".$i."</th>
														<td>".$dados_teste['nome']."</td>
														<td class='text-center'><a href=\"javascript:RegerarSimulado(".$dados_teste['id_teste'].");\"><span class='glyphicon glyphicon-pencil'></a></td>
													  </tr>";
												$i++;
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel-footer">
							<a href="ListaSimulados">Todos os simulados</a>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<ol class="breadcrumb">
				<li><a href="Home">Home</a></li>
				<li class="active">Notícias</li>
			</ol>					
			<div class="row">
				<div class="col-md-9 col-md-offset-0">
					<?php
						$limite = 3;
						$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
						$total = mysql_num_rows(mysql_query("SELECT * FROM noticia"));
						$numPaginas = ceil($total/$limite);
						$inicio = ($limite * $pagina) - $limite;
						$sql_busca_noticias = mysql_query('SELECT * FROM noticia ORDER BY data DESC LIMIT '.$inicio.','.$limite.'');
							while($dados_noticias = mysql_fetch_array($sql_busca_noticias))
							{
								$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario=".$dados_noticias['id_usuario']."");
								$dados_usuario = mysql_fetch_assoc($sql_usuario);
								$data_arrumada = strtotime($dados_noticias['data'] );
								$data_DMA = date('d/m/Y', $data_arrumada);
								$data_MS = date('H:i', $data_arrumada);
								
								if($_SESSION['nivel'] >= 2)
								{
									echo "
										<div class='float-static'>
											<div class='pull-right'>
												<a class='btn btn-default' href='EditarNoticia?id=".$dados_noticias['id_noticia']."' role='button'><span class='glyphicon glyphicon-edit'></span></a>
											</div>
										</div>";
								}
								
								// Trocar espaços por hífen
								
								$n = "";
								
								for($i = 0; $i < strlen($dados_noticias['titulo']); $i++)
								{
									$char = substr($dados_noticias['titulo'], $i, 1);
									
									if((substr($dados_noticias['titulo'], $i+1, 1) == "-" || substr($dados_noticias['titulo'], $i+1, 1) == " ") && $char == " ")
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
								
								echo "<blockquote>
									<h3>
									<a href='Noticia?n=".$n."&d=".$dados_noticias['id_noticia']."'>".$dados_noticias['titulo']."</a>
									</h3>
									<div class='float-static'>
										<div class='pull-left'>
											<p><span class='glyphicon glyphicon-time'></span> Postado em ".$data_DMA." às ".$data_MS."</p>
										</div>
										<div class='pull-right2'>
											<p><span class='glyphicon glyphicon-user'></span> Postado por ".$dados_usuario['nome']." ".$dados_usuario['sobrenome']."</p>
										</div>
									</div>
									<hr>
									";
									if($dados_noticias['img'] != null)
									{
										echo "<a href='Noticia?n=".$n."&d=".$dados_noticias['id_noticia']."'><img style='margin-bottom: 30px;' class='img-responsive' src='img/noticias/".$dados_noticias['img']."' alt='".$dados_noticias['titulo']."'></a>";
									}
									
									echo "<p class='color-descricao espacamento'>".strLess($dados_noticias['descricao'], 400, "")."</p>
									<div class='float-static'>
										<div class='pull-right'>
											<a class='btn btn-primary' href='Noticia?n=".$n."&d=".$dados_noticias['id_noticia']."'><span class='glyphicon glyphicon-share-alt'></span> Leia mais </a>
										</div>
									</div>
									</blockquote>
									<hr>
								";
							}
					?>

					<!-- Pager -->
					<nav>
						<ul class="pager">
							<?php
								if($pagina <= 1)
								{
									echo "<li class='disabled'><a>Anterior</a></li>";
								}
								else
								{
									echo "<li><a href='Home?page=".($pagina - 1)."'>Anterior</a></li>";
								}
								if($pagina >= $numPaginas)
								{
									echo "<li class='disabled'><a>Próxima</a></li>";
								}
								else
								{
									echo "<li><a href='Home?page=".($pagina + 1)."'>Próximo</a></li>";
								}
							?>
						</ul>
					</nav>
				</div>
				<div class="col-md-3 col-md-offset-0">
					<form action="javascript:sugerir();" method="post">
						<div class="panel panel-default" >
							<div class="panel-heading">
								<h3 class="panel-title">Sugestões</h3>
							</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="txtTitulo" class="control-label">Assunto</label>
									<input type="text" class="form-control" id="txtTitulo" placeholder="Digite aqui..." name="txtTitulo" required>
								</div>
								<div class="form-group">
									<label for="txtCorpo">Descrição</label>
									<textarea style="resize: vertical;" class="form-control" id="txtCorpo" placeholder="Digite aqui..." maxlength="4096" name="txtCorpo" rows="5" required></textarea>
								</div>
								<button type="submit" class="btn btn-default">Enviar</button>
							</div>
							<div class="form-group" >
								<div class="col-sm-12">
									<div id="div_msg" style="display: none" style="margin-bottom: 80px" class="alert alert-warning alert-dismissible" role="alert">
										<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
										<strong id="txtMsg"></strong>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php include('include/footer.php'); ?>   

	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.js"></script>
	
	<script>
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
	</body>
</html>
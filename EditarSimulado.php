<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if(isset($_GET['simulado']))
	{
		$id_teste = $_GET['simulado'];
	}
	
	$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste=$id_teste");
	$dados_teste = mysql_fetch_assoc($sql_teste);
	
	$limite = 10;
	$pagina = (isset($_GET['page']))? $_GET['page'] : 1;
	$inicio = ($limite * $pagina) - $limite;
	$sql_testes = mysql_query("SELECT * FROM banco WHERE id_teste=$id_teste");
	$total = mysql_num_rows($sql_testes);
	$numPaginas = ceil($total/$limite);
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
		function atualizar()
		{
			var id_teste = document.getElementById("id").value;
			var nome = document.getElementById("inputNome").value;
			var descricao = document.getElementById("inputDescricao").value;
			var x = document.getElementsByName('chkCategorias[]');
			var categorias = new Array();
			var tamanho = 0;
			for (i = 0; i < x.length; i++) 
			{
				if (x[i].checked == true) 
				{
					categorias[tamanho] = x[i].value;
					tamanho += 1;
				}
			}
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/edit_teste.php',
				data: {nome: nome, descricao: descricao, categorias: JSON.stringify(categorias), tamanho: tamanho, id_teste: id_teste},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="SimuladosCadastrados";
					}
					else
					{
						alert("Erro inesperado, contate o administrador.");
					}
				},
				error: function(data){
					alert("Erro inesperado - ou esperado.");
				}
			});
		}
	</script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	.radio{
		margin-bottom: 20px;
	}
	.jumbotron hr{
		border-top-color: #d5d5d5;
	}
	.table-responsive .glyphicon
		{color: black;}

	.table-responsive .glyphicon:hover
	{color: #23527c;}
	
	.glyphicon-remove{color: red;}
	.glyphicon-ok{color: green;}
	</style>
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="page-header">
				<h2>Editar simulado</h2>
			</div>
			<div class="row">
				<form method="post" action="javascript: atualizar();">
					<div class="col-md-7 col-md-offset-0">	
						<div class="jumbotron" style="overflow: hidden;">
							<div class='float-static'>
								<div class='pull-right'>
									<a class='btn btn-default' href='javascript: excluir(<?php echo $id_teste;?>)' role='button'><span class='glyphicon glyphicon-trash'></span></a>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<label for="inputNome" class="control-label"> Nome</label>
								<input type="text" class="form-control" id="inputNome" placeholder="Digite aqui..." name="txtNome" value="<?php echo $dados_teste['nome'];?>" required>
							</div>
							<div class="form-group">
								<label for="inputDescricao"> Descrição</label>
								<textarea style="resize: vertical;" class="form-control" id="inputDescricao" placeholder="Digite aqui..." maxlength="4096" name="txtaDescricao" rows="5" required><?php echo $dados_teste['descricao'];?></textarea>
							</div>
							<div class="form-group" style="width: 150px;">
								<label for="selectStatus">Status</label>
								<select class="form-control" id="selectStatus" required>
									<option <?php if($dados_teste['status'] == 1){echo "selected";}?>>Privado</option>
									<option <?php if($dados_teste['status'] == 2){echo "selected";}?>>Público</option>
								</select>
							</div>						
							<hr>
							<?php include('include/lista_categorias.php'); ?>
							<?php
								$sql_teste_categoria = mysql_query("SELECT * FROM teste_categoria WHERE id_teste=$id_teste");
								while($dados_teste_categoria = mysql_fetch_array($sql_teste_categoria))
								{
									$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_categoria=".$dados_teste_categoria['id_categoria']."");
									$dados_categoria = mysql_fetch_assoc($sql_categoria);
									echo "<script type='text/javascript'>
											var x = document.getElementsByName('chkCategorias[]');
											for (i = 0; i < x.length; i++) 
											{
												if (x[i].value == ".$dados_categoria['id_categoria'].") 
												{
													x[i].checked = true;
												}
											}
									</script>";
								}
							?>
						</div>
					</div>
					<div class="col-md-5 col-md-offset-0">	
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Questões</h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
										<div class="input-group" style="margin: 0px 0 0 0;">
											<input maxlength="128" type="text" class="form-control" placeholder="Pesquisar...">
											<span class="input-group-btn">
												<button class="btn btn-default" type="button">
													<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
												</button>
											</span>
										</div>
										<div class="float-static" style="margin: 10px 0 10px 0;">
											<div class="pull-right">
												<button onClick="location.href='CadastroQuestao?id_teste=<?php echo $id_teste;?>'" type="button" class="btn btn-default" >
													<span class="glyphicon glyphicon-plus"></span> 
												</button>
											</div>
										</div>
										<table class="table table-striped table-bordered">
											<colgroup>
												<col class="col-xs-1">
												<col class="col-xs-8">
												<col class="col-xs-1">
												<col class="col-xs-1">
											</colgroup>
											<thead>
												<tr>
													<th class="text-center">#</th>
													<th>Descrição</th>
													<th class="text-center">Editar</th>
													<th class="text-center">Excluir</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$i = 1;
										
													$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste=$id_teste ORDER BY data DESC LIMIT ".$inicio.",".$limite."");
													while($dados_banco = mysql_fetch_array($sql_banco))
													{
														$sql_questoes = mysql_query("SELECT * FROM questao WHERE id_questao=".$dados_banco['id_questao']."");
														while($dados_questao = mysql_fetch_assoc($sql_questoes))
														{
															echo "<tr id='questao".$dados_banco['id_questao']."'>
																	<th class='text-center' scope='row'>$i</th>
																	<td>".$dados_questao['texto']."</td>
																	<td class='text-center'><a href='EditarQuestao?questao=".$dados_questao['id_questao']."'><span class='glyphicon glyphicon-edit'></a></td>
																	<td class='text-center'><a href='javascript: excluirQuestao(".$dados_banco['id_questao'].",$id_teste);'><span class='glyphicon glyphicon-trash'></a></td>
																</tr>";
														}
														$i++;
													}
												?>
											</tbody>
										</table>
								</div>
							</div>
							<hr style="margin-bottom: 5px;">
							<nav>
								<ul class="pager">
									<?php
										if($pagina <= 1)
										{
											echo "<li class='disabled'><a>Anterior</a></li>";
										}
										else
										{
											echo "<li><a href='EditarSimulado?simulado=".$id_teste."&page=".($pagina - 1)."'>Anterior</a></li>";
										}
										if($pagina >= $numPaginas)
										{
											echo "<li class='disabled'><a>Próxima</a></li>";
										}
										else
										{
											echo "<li><a href='EditarSimulado?simulado=".$id_teste."&page=".($pagina + 1)."'>Próximo</a></li>";
										}
									?>
								</ul>
							</nav>
						</div>
						<div class="float-static" style="margin-top: 30px;">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary">Salvar</button>
								<button type="reset" class="btn btn-default">Cancelar</button>
								<input type="hidden" id="id" value="<?php echo $id_teste;?>">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	
	<script type="text/javascript">
		function excluir(id_teste)
		{
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/excluir_teste.php',
				data: {id_teste: id_teste},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="SimuladosCadastrados";
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
		
		function excluirQuestao(id_questao, id_teste)
		{
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/del_questao_teste.php',
				data: {id_questao: id_questao, id_teste: id_teste},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						$('#questao'+id_questao).remove();
						location.href="SimuladosCadastrados";
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
	
  </body>
</html>
<?php
	include('include/config.php');
	include('include/general_security.php');
	
	$id_teste = $_GET['teste'];
	$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste = $id_teste");
	$dados_teste = mysql_fetch_assoc($sql_teste);
	
	$titulo = $dados_teste['nome'];
	$descricao = $dados_teste['descricao'];
	$img = $dados_teste['img'];
	
	$data_arrumada = strtotime($dados_teste['data'] );
	$data_DMA = date('d/m/Y', $data_arrumada);
	$data_MS = date('H:i', $data_arrumada);
	
	$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste=$id_teste");
	$num_questoes = mysql_num_rows($sql_banco);
	
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
		
	</style>
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><a href="home">Search</a></li>
						<li class="active">Simulado</li>
					</ol>
					<div class="row">
						<div class="col-md-10 col-md-offset-0">		
							<?php 
								if($_SESSION['nivel'] != 1)
								{
									echo "<div class='float-static'>
											<div class='pull-right'>
												<a class='btn btn-default' href='EditarSimulado' role='button'><span class='glyphicon glyphicon-edit'></span></a>
											</div>
										</div>";
								}
							?>
							<blockquote>
							<h3>
							<?php echo $titulo;?>
							</h3>
							<hr>
							<ul class="list-unstyled">
								<li><strong>ID do simulado: </strong><?php echo $id_teste;?></li>
								<li><strong>Número de questões: </strong><?php echo $num_questoes;?></li>
								<li><strong>Categoria(s): </strong> 
									<?php
										$sql_teste_categoria = mysql_query("SELECT * FROM teste_categoria WHERE id_teste=".$id_teste."");
										$num_rows = mysql_num_rows($sql_teste_categoria);
										$cont = 1;
										$complemento = ", ";
										while($dados_teste_categoria = mysql_fetch_array($sql_teste_categoria))
										{
											if($cont == $num_rows)
											{
												$complemento = ".";
											}
											$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_categoria=".$dados_teste_categoria['id_categoria']."");
											$dados_categoria = mysql_fetch_assoc($sql_categoria);
											echo $dados_categoria['descricao'].$complemento;
											$cont++;
										}
									?> 
								</li>
							</ul>
							<?php
								if($img != "")
								{
									echo "<img style='margin-bottom: 30px;' class='img-responsive' src='img/noticias/$img' alt=''>";
								}
							?>
							<hr>
							<p class="color-descricao espacamento"><?php echo $descricao;?></p>
							<hr>
							<p><a href="javascript: ResolverSimulado(<?php echo $id_teste;?>);">Resolver agora?</a></p>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
	
	<script>
		function ResolverSimulado(id_teste)
		{
			var inputs = '<input type="hidden" name="id_teste" value="' + id_teste + '" />';
			$("body").append('<form action="Simultest" method="post" id="poster">'+inputs+'</form>');
			$("#poster").submit();
		}
	</script>
  </body>
</html>
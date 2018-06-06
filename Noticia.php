<?php
	include('include/config.php');
	include('include/general_security.php');
	
	$id_noticia = $_GET['d'];
	$sql_noticia = mysql_query("SELECT * FROM noticia WHERE id_noticia = $id_noticia");
	
	$dados_noticia = mysql_fetch_assoc($sql_noticia);
	
	$titulo = $dados_noticia['titulo'];
	$descricao = $dados_noticia['descricao'];
	$img = $dados_noticia['img'];
	$id_usuario = $dados_noticia['id_usuario'];
	
	$data_arrumada = strtotime($dados_noticia['data'] );
	$data_DMA = date('d/m/Y', $data_arrumada);
	$data_MS = date('H:i', $data_arrumada);
	
	$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = $id_usuario");
	$dados_usuario = mysql_fetch_assoc($sql_usuario);
	$nome_usuario = $dados_usuario['nome']." ".$dados_usuario['sobrenome'];
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
						<li><a href="home">Home</a></li>
						<li class="active">Notícia</li>
					</ol>
					<div class="row">
						<div class="col-md-10 col-md-offset-0">		
							<div class='float-static'>
								<div class='pull-right'>
									<a class='btn btn-default' href='EditarNoticia?id=<?php echo $dados_noticia['id_noticia'];?>' role='button'><span class='glyphicon glyphicon-edit'></span></a>
								</div>
							</div>	
							<blockquote>
							<h3>
							<?php echo $titulo;?>
							</h3>
							<div class="float-static">
								<div class="pull-left">
									<p><span class='glyphicon glyphicon-time'></span> Postado em <?php echo $data_DMA;?> às <?php echo $data_MS;?></p>
								</div>
								<div class="pull-right2">
									<p><span class='glyphicon glyphicon-user'></span> Postado por <?php echo $nome_usuario;?></p>
								</div>
							</div>
							<hr>
							<?php
								if($img != "")
								{
									echo "<img style='margin-bottom: 30px;' class='img-responsive' src='img/noticias/$img' alt=''>";
								}
							?>
							<p class="color-descricao espacamento"><?php echo $descricao;?></p>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include('include/footer.php'); ?>   
   
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
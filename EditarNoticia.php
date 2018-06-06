<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if($_SESSION['nivel'] < 2)
	{
		header("Location: Home");
	}
	
	$id_noticia = $_GET['id'];
	$sql_noticia = mysql_query("SELECT * FROM noticia WHERE id_noticia = $id_noticia");
	$result_noticia = mysql_fetch_assoc($sql_noticia);
	
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
			var id_noticia = <?php echo $id_noticia;?>;
			var titulo = document.getElementById("txtTitulo").value;
			var descricao = document.getElementById("txtDescricao").value;
			var img = "";
			if(document.getElementById("InputImage").value != "")
			{
				var fileName = document.getElementById("InputImage");
				img = fileName.value.split(/(\\|\/)/g).pop();
			}
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/edit_noticia.php',
				data: {titulo: titulo, descricao: descricao, img: img, id_noticia: id_noticia},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="Noticias"; // Noticia?n=blabla&d=99
					}
					else if(ret == 0)
					{
						document.getElementById("txtMsg").textContent = "Erro inesperado ao cadastrar.";
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
			<div class="page-header">
				<h2>Editar notícia</h2>
			</div>
			<div class="row">
			<form action="javascript:atualizar();" method="post">
				<div class="col-md-10">
					<div class="jumbotron" style="overflow: hidden;">
						<div class='float-static'>
							<div class='pull-right'>
								<a class='btn btn-default' href='javascript: excluir(<?php echo $id_noticia;?>);' role='button'><span class='glyphicon glyphicon-trash'></span></a>
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label for="txtTitulo" class="control-label">Título da notícia</label>
							<input type="text" class="form-control" id="txtTitulo" placeholder="título..." name="txtTitulo" value="<?php echo htmlspecialchars($result_noticia['titulo'], ENT_QUOTES); ?>" required>
						</div>
						<div class="form-group">
							<label for="txtDescricao">Descrição da notícia</label>
							<textarea style="resize: vertical;" class="form-control" id="txtDescricao" placeholder="descrição..." maxlength="4096" name="txtDescricao" rows="5" required><?php echo $result_noticia['descricao']; ?></textarea>
						</div>
						<hr>
						<div class="form-group">
							<label for="InputImage">Imagem</label>
							<input type="file" id="InputImage">
							<img class='img-responsive' id="imgNoticia" src="<?php echo "img/noticias/".$result_noticia['img']; ?>">
						</div>	
						<div class="float-static">
							<div class="pull-right">
								<button type="submit" class="btn btn-primary">Salvar</button>
								<button type="reset" class="btn btn-default">Cancelar</button>
							</div>
						</div>
						<div class="form-group" style="margin-top: 25px; margin-bottom: -15px;">
								<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<strong id="txtMsg"></strong>
								</div>
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
		function excluir(id_noticia)
		{
			$.ajax({
				type: 'post',
				cache: false,
				url: 'include/del_noticia.php',
				data: {id_noticia: id_noticia},
				success: function (data) {
					var ret = parseInt(data);
					if(ret == 1)
					{
						location.href="Noticias";
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
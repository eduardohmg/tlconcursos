<?php
	include('include/config.php');
	include('include/general_security.php');
	
	if(isset($_POST['questao']))
	{	
		$id_questao = $_POST['questao'];
	}
	else
	{
		header("Location: Home");
	}
	$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao=$id_questao");
	$dados_questao = mysql_fetch_assoc($sql_questao);
	$img = "";
	if($dados_questao['img'] != "")
	{
		$img = "<img src='img/questao/".$dados_questao['img']."'>";
	}
	
	$sql_favorito = mysql_query("SELECT * FROM favorito WHERE id_usuario=".$_SESSION['id_usuario']." AND id_questao=$id_questao");
	$num_rows = mysql_num_rows($sql_favorito);
											
	$star_color = "";
	
	if($num_rows == 0)
	{
		$star_color = "#000000";
	}
	else
	{
		$star_color = "#FFC929";
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	
	.generic-background a {
	color: #000000;
	}
	.generic-background a:hover, focus {
	text-decoration: none;
	color: #23527c;
	}
	.glyphicon-remove{color: red;}
	.glyphicon-ok{color: green;}
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
							document.getElementById("questao").style.color = "#FFC929";
						}
						else
						{
							document.getElementById("questao").style.color = "#000000";
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
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>
		<?php include('include/modalSimultest.php'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><a href="Home">TL Concursos</a></li>
						<li><a href="Informacoes">Minha conta</a></li>
						<li><a href="Favoritos">Questões favoritadas</a></li>
						<li class="active">Questão</li>
					</ol>
					<div class="row">
						<div class="col-md-10 col-md-offset-0">					
							<div class="generic-background" style="padding-top: 20px; padding-bottom: 20px;">
								<strong>Questão 1</strong>
								<div class="pull-right">
									<a style='cursor:pointer' onclick='favoritar(<?php echo $id_questao;?>)'>
										<span id="questao" class="glyphicon glyphicon-star" style='color: <?php echo $star_color;?>' aria-hidden="true" >
										</span>
										Favoritar
									</a>
								</div>	
								<hr style="margin-top: 15px;">
								<ul class="list-unstyled">
									<li><strong>ID da questão:</strong> <?php echo $dados_questao['id_questao'];?></li>
									<li><strong>Categoria(s):</strong> 
										<?php
											$sql_questao_categoria = mysql_query("SELECT * FROM questao_categoria WHERE id_questao=".$id_questao."");
											$num_rows = mysql_num_rows($sql_questao_categoria);
											$cont = 1;
											$complemento = ", ";
											while($dados_teste_categoria = mysql_fetch_array($sql_questao_categoria))
											{
												if($cont == $num_rows)
												{
													$complemento = ". ";
												}
												$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_categoria=".$dados_teste_categoria['id_categoria']."");
												$dados_categoria = mysql_fetch_assoc($sql_categoria);
												echo $dados_categoria['descricao'].$complemento;
												$cont++;
											}
										?> 
									</li>
								</ul>
								<hr>
								<ul class="list-unstyled">
									<li style="margin-bottom: 15px;">
										<p class="text-justify">
											<?php echo $dados_questao['texto'];?>
										</p>
									</li>		
								</ul>
								<a class="img-responsive">
									<?php echo $img;?>
								</a>
								<hr>
								<?php
									$alternativa = ["A","B","C","D","E","F"];
									$cont = 0;
									$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_questao = ".$id_questao);
									while($result_alternativa=mysql_fetch_array($sql_alternativa))
									{
										$checked = "";
										$certa = "";
										if($result_alternativa['correta'] == 1)
										{
											$certa = " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
											$checked = "checked";
										}
								?>
									<div class="radio">
										<label>
											<input type="radio" name="option" id="optionsRadios1" value="option1" <?php echo $checked;?> disabled>
												<strong><?php echo $alternativa[$cont]; ?>)</strong> <?php echo $result_alternativa['texto'].$certa; ?>
										</label>
									</div>
								<?php
									$cont++;
									}
								?>
								<hr>
								<div class="float-static">
									<div class="pull-right">
										<a data-toggle='modal' href='#ComprarQuestao'>
											<span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'>
											</span>
											Comprar
										</a>
									</div>	
								</div>

							</div>
							<hr>
							<a href="Favoritos"> Questões favoritadas</a>
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
<?php
	include('include/config.php');
	include('include/general_security.php');
	include('include/pesquisas.php');
	
	if(isset($_GET['pesq']) && isset($_GET['tipo']))
	{
		$pesquisa = $_GET['pesq'];
		$tipo = $_GET['tipo'];
		$funcao = "pesquisa".$tipo;
		$k = 0;
		
		$resultado = $funcao($pesquisa);
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TL Concursos | Ensinando para o futuro | Ensinando para o futuro</title>

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
	.table-responsive .glyphicon
		{color: black;}

	.table-responsive .glyphicon:hover
	{color: #23527c;}
	</style>
	
  </head>
	<body>  
		<?php include('include/header.php'); ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">
						<li><a href="home">Home</a></li>
						<li class="active">Pesquisa</li>
					</ol>
					<div class="row">
						<div class="col-md-10 col-md-offset-0">					
							<?php
								if(count($resultado) > 0)
								{
									while($k < count($resultado))
									{
										if($resultado[$k]['tipo'] == "Noticia")
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
										}
										
										if($resultado[$k]['img'] != "")
										{
											$img = "<img style='margin-bottom: 30px;' class='img-responsive' src='img/".$resultado[$k]['pasta']."/".$resultado[$k]['img']."' alt='".$resultado[$k]['nome']."'>";
										}
										else
										{
											$img = "";
										}	
										
										echo "<h4>".$resultado[$k]['tipo']."</h4>
												<blockquote>
													<h3>
														<a href='".$resultado[$k]['href']."'>".$resultado[$k]['nome']."</a>
													</h3>
													<p class='color-descricao espacamento'>".strLess($resultado[$k]['descricao'],400,"")."</p>
														$img
												</blockquote>
												<hr>";
												$k++;
									}
								}
								else
								{
									echo "<h4>Nenhum Resultado Encontrado</h4>";	
								}
							?>
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
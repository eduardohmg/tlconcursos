<?php
	include('config.php');
	
	$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = ".$_SESSION['id_usuario']);
	$result_usuario = mysql_fetch_assoc($sql_usuario);
?>

<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
		<a class="navbar-brand" href="Home">
		<img src="img/logo.png" style="height: 100%;" alt="TL Concursos | Ensinando para o futuro">
	</a>    
  </div>
	<div id="navbar" class="collapse navbar-collapse">
  <ul class="nav navbar-nav navbar-right">
	<li style="margin-left: 15px; margin-right: 15px;">
		<form class="navbar-form navbar-right" role="search" action="javascript: pesquisa();">
			<div class="input-group">
				<input type="text" id="pesquisa" class="form-control" placeholder="Pesquisar..." required>
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit">
								<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</button>
				</span>
			</div>
		</form>
	</li>
	<li><a href="Informacoes"><span id="spanSaldo" style="margin-top: -2px" class="badge"><?php echo $result_usuario['saldo']; ?> C</span></a></li>	<li class="dropdown">
	  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['nome'].""; ?><i class="fa fa-fw fa-caret-down"></i></a>
	  <ul class="dropdown-menu">
		<li><a href="Informacoes"><i class="fa fa-fw fa-user"></i> Minha Conta</a></li>
		<li><a href="GerarSimulado"><i class="fa fa-fw fa-book"></i> Gerar Simulado</a></li>
		<li><a href="Financeiro"><i class="fa fa-fw fa-usd"></i> Financeiro</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="Logout"><i class="fa fa-fw fa-power-off"></i> Sair</a></li>
	  </ul>
	</li>
  </ul>
  <!--<ul class="nav navbar-nav navbar-right nav-pills">
	  <li>
		  <a href="http://facebook.com/" target="_blank" class="btn btn-social-icon btn-facebook">
			  <i class="fa fa-facebook"></i>
		  </a>
	  </li>
	  <li>
		  <a href="http://twitter.com/" target="_blank" class="btn btn-social-icon btn-twitter" >
			  <i class="fa fa-twitter"></i>
		  </a>
	  </li>
	  <li>
		  <a href="https://plus.google.com/" target="_blank" class="btn btn-social-icon btn-google-plus">
			  <i class="fa fa-google-plus"></i>
		  </a>
	  </li>
  </ul>-->
</div><!--/.nav-collapse -->
  </div><!-- /.container -->
</nav><!-- /.navbar -->


<script type="text/javascript">
	function pesquisa()
	{
		location.href = "Pesquisa?pesq="+document.getElementById('pesquisa').value+"&tipo=Header";
	}
</script>

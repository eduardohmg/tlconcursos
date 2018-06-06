<?php
	include('include/config.php');
	include('include/general_security.php');
	
	$sql_usuario = mysql_query("SELECT * FROM usuario WHERE id_usuario = ".$_SESSION['id_usuario']);
	$result_usuario = mysql_fetch_assoc($sql_usuario);
	$data_arrumada = strtotime($result_usuario['data_cadastro'] );
	$data_DMA = date('d/m/Y', $data_arrumada);
	$data_MS = date('H:i', $data_arrumada);
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
			function alterar()
			{
				var senha_atual = document.getElementById("senha_atual").value;
				var nova_senha = document.getElementById("alterar_senha").value;
				var confirmar_senha = document.getElementById("confirmar_senha").value;
				$.ajax({
					type: 'post',
					cache: false,
					url: 'include/alterar_senha.php',
					data: {senha_atual: senha_atual, nova_senha: nova_senha, confirmar_senha: confirmar_senha},
					success: function (data) {
						var ret = parseInt(data);
						if(ret == 1)
						{
							document.getElementById("txtMsg").textContent = "Senha alterada.";
							document.getElementById("div_msg").style.display = 'block';
							var senha_atual = document.getElementById("senha_atual").value = "";
							var nova_senha = document.getElementById("alterar_senha").value = "";
							var confirmar_senha = document.getElementById("confirmar_senha").value = "";
							//Coloquei pra limpar os campos mas não sei se era pra fazer isso
						}
						else if(ret == 0)
						{
							document.getElementById("txtMsg").textContent = "Erro ao alterar a senha.";
							document.getElementById("div_msg").style.display = 'block';
						}
						else if(ret == -2)
						{
							document.getElementById("txtMsg").textContent = "Senha atual incorreta.";
							document.getElementById("div_msg").style.display = 'block';
						}
						else if(ret == -3)
						{
							document.getElementById("txtMsg").textContent = "As novas senhas não conferem.";
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
			<ol class="breadcrumb">
				<li><a href="Home">TL Concursos</a></li>
				<li><a href="Informacoes">Minha conta</a></li>
				<li class="active">Informações</li>
			</ol>	
			<div class="row row-offcanvas row-offcanvas-left">
				<div class="col-md-3 sidebar-offcanvas" id="sidebar">
					<div class="list-group">
						<a href="Informacoes" class="list-group-item active"><i class="fa fa-info fa-fw"></i> Informações</a>
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
								$controle = "<a href='ControleUsuario' class='list-group-item'><i class='fa fa-user fa-fw'></i> Controle de usuários</a>";
							}
							echo "		".$controle."
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
							<div class="panel-heading"><strong>Conta</strong>
							</div>
							<ul class="list-group" style="padding:0 10px 0 10px;">
								<li class="list-group-item"><strong>Nome:</strong> <?php echo $result_usuario['nome']; ?></li>
								<li class="list-group-item"><strong>Sobrenome:</strong> <?php echo $result_usuario['sobrenome']; ?></li>
								<li class="list-group-item"><strong>E-mail:</strong> <?php echo $result_usuario['email']; ?></li>
								<li class="list-group-item"><strong>Data de registro:</strong> <?php echo $data_DMA." às ".$data_MS; ?></li>
								<li class="list-group-item"><strong>Saldo:</strong> <?php echo $result_usuario['saldo'].""; ?> Créditos</li>
								<li class="list-group-item">
								<form class="form-group" action="javascript:alterar();" method="post">
									<div class="form-group">
										<label for="senha_atual">Senha atual: </label>
										<input maxlength="16" type="password" class="form-control" id="senha_atual" placeholder="Senha atual" required>
									</div>
									<div class="form-group">
										<label for="alterar_senha">Alterar senha: </label>
										<input maxlength="16" type="password" class="form-control" id="alterar_senha" placeholder="Alterar senha" required>
									</div>
									<div class="form-group">
										<label for="confirmar_senha">Confirmar senha: </label>
										<input maxlength="16" type="password" class="form-control" id="confirmar_senha" placeholder="Confirmar senha" required>
									</div>
									<div class="form-group">
									<button type="submit" class="btn btn-default">Alterar Senha</button>
									</div>
									<div class="form-group">
										<div id="div_msg" style="display: none" class="alert alert-warning alert-dismissible" role="alert">
											<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											<strong id="txtMsg"></strong>
										</div>
									</div> 
								</form>
								</li>											
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php include('include/footer.php'); ?>   

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/offcanvas.js"></script>
		
	</body>
</html>
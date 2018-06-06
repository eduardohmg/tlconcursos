<?php 
	include("config.php");
	
	if(isset($_GET['questao']))
	{
		$id_questao = $_GET['questao'];
	}
	
	$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao=$id_questao");
	$dados_questao = mysql_fetch_assoc($sql_questao);
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Visualizar questão</h4>
			</div>
			<div class="modal-body">
				<strong>Questão 1</strong>
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
				<hr>
				<ul class="list-unstyled">
					<li style="margin-bottom: 15px;">
						<p class="text-justify">
							<?php echo $dados_questao['texto'];?>
						</p>
					</li>		
				</ul>
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

					$sql_inventario = mysql_query("SELECT * FROM inventario WHERE id_questao=$id_questao AND id_usuario=".$_SESSION['id_usuario']."");
					$num_resoluções = mysql_num_rows($sql_inventario);
					if($num_resoluções > 0)
					{
						$cont = 1;
						$sql_resolucao = mysql_query("SELECT * FROM resolucao WHERE id_questao=$id_questao");
						while($dados_resolucao = mysql_fetch_array($sql_resolucao))
						{
							$img = "";
							if($dados_resolucao['img'] != "")
							{
								$img = "src='img/resolucoes/".$dados_resolucao['img']."'";
							}
							echo "<div class='panel panel-success' >
									<div class='panel-heading'>
										<h3 class='panel-title'><strong>Resolução $cont</strong></h3>
									</div>
									<div class='panel-body'>
										<p class='text-success font-bold'>
											".$dados_resolucao['texto']."
										</p>
										<img style='margin-bottom: 30px;' class='img-responsive' $img?>
									</div>
									<div class='panel-footer'>
									</div>
								</div>
								<br>";
								$cont++;
						}	
					}
				?>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
				</div>
			</div>
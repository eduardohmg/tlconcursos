<?php
	include('config.php');
	
	if(isset($_GET['id_questao']) && isset($_GET['id_teste']))
	{
		$id_teste = $_GET['id_teste'];
		$id_questao = $_GET['id_questao'];
		
		$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste = ".$id_teste." AND id_questao = ".$id_questao);
		$result_banco = mysql_fetch_assoc($sql_banco);
		
		$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao = ".$id_questao);
		$result_questao = mysql_fetch_assoc($sql_questao);
		
		$categorias = "";
		
		$sql_questao_categoria = mysql_query("SELECT * FROM questao_categoria WHERE id_questao = ".$id_questao);
		while($reg_questao_categoria = mysql_fetch_array($sql_questao_categoria))
		{
			$sql_categorias = mysql_query("SELECT * FROM categoria WHERE id_categoria = ".$reg_questao_categoria['id_categoria']);
			$reg_categorias = mysql_fetch_assoc($sql_categorias);
			$categorias = $categorias.", ".$reg_categorias['descricao'];
		}
		
		$categorias = substr($categorias, 1);
		
		?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Visualizar questão</h4>
			</div>
			<div class="modal-body">
				<strong>Questão <?php echo $result_banco['num_questao']; ?></strong>
				<ul class="list-unstyled">
					<li><strong>ID da questão:</strong> <?php echo $result_banco['id_questao']; ?></li>
					<li><strong>Categoria(s):</strong> <?php echo $categorias; ?> </li>
				</ul>
				<hr>
				<ul class="list-unstyled">
					<li style="margin-bottom: 15px;">
						<p class="text-justify">
							<?php echo $result_questao['texto']; ?>
						</p>
					</li>		
				</ul>
				<hr>
				<?php
					$alternativa = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
					$cont = 0;
					$sql_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_questao = ".$id_questao);
					while($result_alternativa=mysql_fetch_array($sql_alternativa))
					{
						$checked = "";
						$certa = "";
						if($result_alternativa['correta'] == 1)
						{
							$certa = " <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
						}
						$sql_historico = mysql_query("SELECT * FROM historico WHERE id_alternativa='".$result_alternativa['id_alternativa']."' AND id_teste='".$id_teste."'");
						if(mysql_num_rows($sql_historico) > 0)
						{
							$checked = "checked";
							if($result_alternativa['correta'] == 0)
							{
								$certa = " <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
							}
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
			</div>
		<?php
	}
?>
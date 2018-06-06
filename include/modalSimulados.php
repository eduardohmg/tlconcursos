<?php
	include("config.php");
	
		if(isset($_GET['id_simulado']))
		{
			$id_teste = $_GET['id_simulado'];
			$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste=".$id_teste."");
			$dados_teste = mysql_fetch_assoc($sql_teste);
			$descricao = $dados_teste['descricao'];
			$img = "";
			if($dados_teste['img'] != "")
			{
				$img = "src='img/noticias/".$dados_teste['img']."'";
			}
			$data_arrumada = strtotime($dados_teste['data']);
			$data_DMA = date('d/m/Y', $data_arrumada);
			$data_MS = date('H:i', $data_arrumada);
			
			$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste=$id_teste");
			$num_questoes = mysql_num_rows($sql_banco);
			
			$questoes_acertadas = 0;
			$sql_questoes_historico = mysql_query("SELECT * FROM historico WHERE id_teste = ".$id_teste." AND id_usuario = ".$_SESSION['id_usuario']);
			while($dados_questoes_historico=mysql_fetch_array($sql_questoes_historico))
			{
				$sql_historico_alternativa = mysql_query("SELECT * FROM alternativa WHERE id_alternativa = ".$dados_questoes_historico['id_alternativa']);
				$dados_historico_alternativa = mysql_fetch_assoc($sql_historico_alternativa);
				
				if($dados_questoes_historico['id_alternativa'] <> 0)
				{
					if($dados_historico_alternativa['correta'] == 1)
					{
						$questoes_acertadas++;
					}
				}
			}
			
			$percentual_acerto = ($questoes_acertadas / $num_questoes) * 100;
		}
?>
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo $dados_teste['nome'];?></h4>
			</div>
			<div class="modal-body">
				<ul class="list-unstyled">
					<li><strong>ID do simulado:</strong> <?php echo $id_teste;?></li>
					<li><strong>Nome:</strong> <?php echo $dados_teste['nome'];?></li>
					<li><strong>Data de criação:</strong> <?php echo $data_DMA." às ".$data_MS;?></li>
					<li><strong>Número de questões:</strong> <?php echo $num_questoes;?></li>
					<li><strong>Seu desempenho:</strong> <?php echo $percentual_acerto."%";?></li>
					<li><strong>Categoria(s):</strong> 
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
							<hr>
							<img style='margin-bottom: 30px;' class='img-responsive' <?php echo $img;?> alt=''>
							<ul class="list-unstyled">
								<li style="margin-bottom: 15px;">
									<p class="text-justify">
										<?php echo $descricao;?>
									</p>
								</li>		
							</ul>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
			</div>

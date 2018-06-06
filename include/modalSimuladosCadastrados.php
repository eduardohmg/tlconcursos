<?php
	include("config.php");
	if(isset($_GET['simulado']))
	{
		$id_simulado = $_GET['simulado'];
		
		$sql_simulado = mysql_query("SELECT * FROM teste WHERE id_teste=$id_simulado");
		$dados_simulado = mysql_fetch_assoc($sql_simulado);
		
		$img = "";
		if($dados_simulado['img'] != "")
		{
			$img = "src='img/noticias/".$dados_simulado['img']."'";
		}
		
		$data_arrumada = strtotime($dados_simulado['data']);
		$data_DMA = date('d/m/Y', $data_arrumada);
		$data_MS = date('H:i', $data_arrumada);
		
		$sql_banco = mysql_query("SELECT * FROM banco WHERE id_teste=$id_simulado");
		$num_questoes = mysql_num_rows($sql_banco);
	}
	
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel2">Informações do Simulado</h4>
</div>
<div class="modal-body">
	<ul class="list-unstyled">
		<li><strong>ID:</strong> <?php echo $id_simulado;?></li>
		<li><strong>Nome:</strong> <?php echo $dados_simulado['nome'];?></li>
		<li><strong>Data de criação:</strong> <?php echo $data_DMA." às ".$data_MS;?></li>
		<li><strong>Número de questões:</strong> <?php echo $num_questoes;?> </li>
		<li><strong>Categoria(s):</strong> 
			<?php
				$sql_teste_categoria = mysql_query("SELECT * FROM teste_categoria WHERE id_teste=".$id_simulado."");
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
				<img style='margin-bottom: 30px;' class='img-responsive' <?php $img;?> alt=''>
				<ul class="list-unstyled">
					<li style="margin-bottom: 15px;">
						<p class="text-justify">
							<?php echo $dados_simulado['descricao'];?>
						</p>
					</li>		
				</ul>

</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
</div>
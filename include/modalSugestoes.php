<?php
	include("config.php");

	if(isset($_GET['sugestao']))
	{
		$id_sugestao = $_GET['sugestao'];
		
		$sql_sugestao = mysql_query("SELECT * FROM sugestao WHERE id_sugestao=$id_sugestao");
		$dados_sugestao = mysql_fetch_assoc($sql_sugestao);
		
		$data_arrumada = strtotime($dados_sugestao['data'] );
		$data_DMA = date('d/m/Y', $data_arrumada);
		$data_MS = date('H:i', $data_arrumada);
	}
?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Sugestão</h4>
      </div>
      <div class="modal-body">
        <ul class="list-unstyled">
			<li><strong>ID da sugestão: </strong><?php echo $dados_sugestao['id_sugestao'];?></li>
			<li><strong>Data: </strong><?php echo $data_DMA." às ".$data_MS;?></li>
			<li><strong>Descrição: </strong><?php echo $dados_sugestao['corpo'];?></li> 
		</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
<?php
	include("config.php");
	
	$id_resolucao = $_GET['id_resolucao'];
	
	$sql_resolucao = mysql_query("SELECT * FROM resolucao WHERE id_resolucao=$id_resolucao");
	$dados_resolucao = mysql_fetch_assoc($sql_resolucao);
?>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Resoluções</h4>
</div>
<div class="modal-body">
<div class="form-group">
	<label for="InputResolucao1">ID Questão: <?php echo $dados_resolucao['id_questao'];?></label>
</div>
<div class="form-group">
	<label for="InputResolucao1">Resolução</label>
	<textarea style="resize: vertical;" class="form-control" id="InputDescricao1" placeholder="Digite aqui a resolução da questão..." maxlength="4096" name="resolucao1" rows="5"><?php echo $dados_resolucao['texto'];?></textarea>
</div>
<div class="form-group">
	<input type="file" id="imgResolucao1" name="imgResolucao1">
</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary" onclick="javascript: atualizar();">Atualizar</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
</div>

<script>
	function atualizar()
	{
		var resolucao = document.getElementById("InputDescricao1").value;
		var id_resolucao = <?php echo $id_resolucao;?>;
		var img_resolucao = "LOL";
		if(document.getElementById("imgResolucao1") != "")
		{
			var img = document.getElementById("imgResolucao1");
			img_resolucao = img.value.split(/(\\|\/)/g).pop();
		}
		$.ajax({
			type: 'post',
			cache: false,
			url: 'include/edit_resolucao.php',
			data: {resolucao: resolucao, id_resolucao: id_resolucao, img_resolucao: img_resolucao},
			success: function (data) {
				var ret = String(data);
				if(ret == 1)
				{
					$("#Resolucao").modal("hide");
					alert("Resolução atualizada com sucesso.");
					location.href = "Resolucoes";
				}
				else
				{
					alert("Erro inesperado ao atualizar a resolucao - Por favor, contate o administrador");
				}
			},
			error: function(data){
				alert('Erro inesperado ao excluir a resolucao - Por favor, contate o administrador');
			}
		});
	}
</script>
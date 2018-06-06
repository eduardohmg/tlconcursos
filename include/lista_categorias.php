<?php
	$complemento = "";
	$complemento2 = "";
	
	echo "<div style='background-color: #fff; border-radius: 4px; padding: 5px; min-height: 250px;margin-bottom: 20px;'>
				<ul style='font-weight: bold;' id='tabs' class='nav nav-tabs nav-justified' data-tabs='tabs'>";
			
	$sql_tipo_categoria = mysql_query("SELECT * FROM tipo_categoria");
	for($i = 0; $result_tipo_categoria = mysql_fetch_array($sql_tipo_categoria); $i++)
	{
		$id_div = $result_tipo_categoria['id_tipo_categoria'];
		
		if($i == 0)
		{
			$complemento = "class = 'active'";
			$complemento2 = "aria-expanded='true'";
		}
		else
		{
			$complemento = "";
		}
		
		echo "<li ".$complemento."><a href='#".$result_tipo_categoria['id_tipo_categoria']."' data-toggle='tab' ".$complemento2.">".$result_tipo_categoria['nome']."</a></li>";
	}
	
	echo "</ul>
			<div id='my-tab-content' class='tab-content'>";
	
	$sql_tipo_categoria = mysql_query("SELECT * FROM tipo_categoria");
	for($i = 0; $result_tipo_categoria = mysql_fetch_array($sql_tipo_categoria); $i++)
	{
		if($i == 0)
		{
			$complemento = "active";
		}
		else
		{
			$complemento = "";
		}
		
		echo "<div class='tab-pane ".$complemento."' id='".$result_tipo_categoria['id_tipo_categoria']."'><br>";
		
		$sql_disciplina = mysql_query("SELECT * FROM categoria WHERE id_tipo_categoria = ".$result_tipo_categoria['id_tipo_categoria']);
		while($valor_disciplina = mysql_fetch_array($sql_disciplina))
		{
			echo "<label style='cursor: pointer;font-weight: normal;'><input type='checkbox' name='chkCategorias[]' id='chkCategorias' value='".$valor_disciplina['id_categoria']."'> ".$valor_disciplina['descricao']."</input></label><br>";
		}
		
		echo "</div>";
	}
	
	echo "</div>
			</div>";
?>
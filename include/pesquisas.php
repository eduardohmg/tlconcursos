<?php	
	function pesquisaHeader($pesq)
	{
		$resultado = null;
		$k = 0;
		$n = "";

		$sql_teste = mysql_query("SELECT * FROM teste WHERE status=2 AND tipo=1 AND (nome LIKE '%".$pesq."%' OR descricao LIKE '%".$pesq."%') ORDER BY id_teste DESC");
		while($dados_teste = mysql_fetch_array($sql_teste))
		{
			$resultado[$k]['id'] = $dados_teste['id_teste'];
			$resultado[$k]['nome'] = $dados_teste['nome'];
			$resultado[$k]['descricao'] = $dados_teste['descricao'];
			$resultado[$k]['tipo'] = "Teste";
			$resultado[$k]['href'] = "Simulado?teste=".$dados_teste['id_teste']."";
			$resultado[$k]['img'] = $dados_teste['img'];
			$resultado[$k]['pasta'] = "testes";
			$k++;
		}
		
		$sql_categoria = mysql_query("SELECT * FROM categoria WHERE descricao LIKE '%".$pesq."%'");
		if(mysql_num_rows($sql_categoria) > 0)
		{
			while($dados_categoria = mysql_fetch_array($sql_categoria))
			{
				$sql_teste_categoria = mysql_query("SELECT * FROM teste_categoria WHERE id_categoria='".$dados_categoria['id_categoria']."'");
				while($dados_teste_categoria = mysql_fetch_array($sql_teste_categoria))
				{
					$sql_teste = mysql_query("SELECT * FROM teste WHERE id_teste='".$dados_teste_categoria['id_teste']."' AND status=2 AND tipo=1");
					while($dados_teste = mysql_fetch_assoc($sql_teste))
					{
						$resultado[$k]['id'] = $dados_teste['id_teste'];
						$resultado[$k]['nome'] = $dados_teste['nome'];
						$resultado[$k]['descricao'] = $dados_teste['descricao'];
						$resultado[$k]['tipo'] = "Teste";
						$resultado[$k]['href'] = "Simulado?teste=".$dados_teste['id_teste']."";
						$resultado[$k]['img'] = $dados_teste['img'];
						$resultado[$k]['pasta'] = "testes";
						$k++;
					}
				}
			}
		}
		
		$sql_noticias = mysql_query("SELECT * FROM noticia WHERE titulo like '%".$pesq."%' OR descricao LIKE '%".$pesq."%'");
		while($dados_noticia = mysql_fetch_array($sql_noticias))
		{
			$resultado[$k]['id'] = $dados_noticia['id_noticia'];
			$resultado[$k]['nome'] = $dados_noticia['titulo'];
			$resultado[$k]['descricao'] = $dados_noticia['descricao'];
			$resultado[$k]['tipo'] = "Noticia";
			$resultado[$k]['href'] = "Noticia?n=".$n."&d=".$dados_noticia['id_noticia']."";
			$resultado[$k]['img'] = $dados_noticia['img'];
			$resultado[$k]['pasta'] = "noticias";
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaQuestoesAdquiridas($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_inventario = mysql_query("SELECT * FROM inventario WHERE id_usuario=".$_SESSION['id_usuario']."");
		while($dados_inventario = mysql_fetch_array($sql_inventario))
		{
			$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao=".$dados_inventario['id_questao']." AND texto LIKE '%".$pesq."%'");
			while($dados_questao = mysql_fetch_array($sql_questao))
			{
				$resultado[$k]['id'] = $dados_questao['id_questao'];
				$resultado[$k]['descricao'] = $dados_questao['texto'];
				$resultado[$k]['data'] = $dados_questao['data'];
				$k++;
			}
		}
		
		return $resultado;
	}
	
	function pesquisaSimuladosRealizados($pesq)
	{
		$resultado = null;
		$k = 0;
		$sql_teste = mysql_query("SELECT * FROM teste WHERE id_usuario=".$_SESSION['id_usuario']." AND (nome LIKE '%$pesq%' OR descricao LIKE '%$pesq%')");
		
		while($dados_teste = mysql_fetch_array($sql_teste))
		{
			$resultado[$k]['id'] = $dados_teste['id_teste'];
			$resultado[$k]['nome'] = $dados_teste['nome'];
			$resultado[$k]['descricao'] = $dados_teste['descricao'];
			$resultado[$k]['data'] = $dados_teste['data'];
			$resultado[$k]['finalizado'] = $dados_teste['finalizado'];
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaFavoritos($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_favoritos = mysql_query("SELECT * FROM favorito WHERE id_usuario=".$_SESSION['id_usuario']."");
		while($dados_favoritos = mysql_fetch_array($sql_favoritos))
		{
			$sql_questao = mysql_query("SELECT * FROM questao WHERE id_questao=".$dados_favoritos['id_questao']." AND texto LIKE '%$pesq%'");
			while($dados_questao = mysql_fetch_array($sql_questao))
			{
				$resultado[$k]['id'] = $dados_questao['id_questao'];
				$resultado[$k]['descricao'] = $dados_questao['texto'];
				$resultado[$k]['data'] = $dados_questao['data'];
				$k++;
			}
		}
		
		return $resultado;
	}
	
	function pesquisaUsuario($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_usuario = mysql_query("SELECT * FROM usuario WHERE nome LIKE '%$pesq%' OR sobrenome LIKE '%$pesq%' OR email LIKE '%$pesq%'");
		while($dados_usuario = mysql_fetch_array($sql_usuario))
		{
			$resultado[$k]['id'] = $dados_usuario['id_usuario'];
			$resultado[$k]['nome'] = $dados_usuario['nome'];
			$resultado[$k]['sobrenome'] = $dados_usuario['sobrenome'];
			$resultado[$k]['email'] = $dados_usuario['email'];
			$resultado[$k]['data'] = $dados_usuario['data_cadastro'];
			$resultado[$k]['nivel'] = $dados_usuario['nivel'];
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaSimuladosCadastrados($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_simulados = mysql_query("SELECT * FROM teste WHERE nome LIKE '%$pesq%' OR descricao LIKE '%$pesq%'");
		while($dados_simulados = mysql_fetch_array($sql_simulados))
		{
			$resultado[$k]['id'] = $dados_simulados['id_teste'];
			$resultado[$k]['nome'] = $dados_simulados['nome'];
			$resultado[$k]['descricao'] = $dados_simulados['descricao'];
			$resultado[$k]['data'] = $dados_simulados['data'];
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaQuestoesCadastradas($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_questoes = mysql_query("SELECT * FROM questao WHERE texto LIKE '%$pesq%'");
		while($dados_questoes = mysql_fetch_array($sql_questoes))
		{
			$sql_questao_categoria = mysql_query("SELECT * FROM questao_categoria WHERE id_questao=".$dados_questoes['id_questao']."");
			$num_rows = mysql_num_rows($sql_questao_categoria);
			$categoria = "";
			$cont = 1;
			$complemento = ",";
			while($dados_teste_categoria = mysql_fetch_array($sql_questao_categoria))
			{
				if($cont == $num_rows)
				{
					$complemento = ".";
				}
				$sql_categoria = mysql_query("SELECT * FROM categoria WHERE id_categoria=".$dados_teste_categoria['id_categoria']."");
				$dados_categoria = mysql_fetch_array($sql_categoria);
				$categoria .= $dados_categoria['descricao'].$complemento;
				$cont++;
			}
			$resultado[$k]['id'] = $dados_questoes['id_questao'];
			$resultado[$k]['descricao'] = $dados_questoes['texto'];
			$resultado[$k]['data'] = $dados_questoes['data'];
			$resultado[$k]['categoria'] = $categoria;
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaNoticia($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_noticia = mysql_query("SELECT * FROM noticia WHERE titulo LIKE '%$pesq' OR descricao LIKE '%$pesq%'");
		while($dados_noticia = mysql_fetch_array($sql_noticia))
		{
			$resultado[$k]['id'] = $dados_noticia['id_noticia'];
			$resultado[$k]['nome'] = $dados_noticia['titulo'];
			$resultado[$k]['descricao'] = $dados_noticia['descricao'];
			$resultado[$k]['data'] = $dados_noticia['data'];
			$k++;
		}
		
		return $resultado;
	}
	
	function pesquisaSugestao($pesq)
	{
		$resultado = null;
		$k = 0;
		
		$sql_sugestao = mysql_query("SELECT * FROM sugestao WHERE titulo LIKE '%$pesq%' OR corpo LIKE '%$pesq%'");
		while($dados_sugestao = mysql_fetch_array($sql_sugestao))
		{
			$resultado[$k]['id'] = $dados_sugestao['id_sugestao'];
			$resultado[$k]['nome'] = $dados_sugestao['titulo'];
			$resultado[$k]['descricao'] = $dados_sugestao['corpo'];
			$resultado[$k]['data'] = $dados_sugestao['data'];
			$k++;
		}
		
		return $resultado;
	}
?>
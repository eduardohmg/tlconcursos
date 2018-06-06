<?php
	function ValidaImg($arquivo)
	{
		$nome = $_FILES[$arquivo]['name'];

		// Pega a extensao
		$extensao = strrchr($nome, '.');

		// Converte a extensao para mimusculo
		$extensao = strtolower($extensao);

		// Somente imagens, .jpg;.jpeg;.gif;.png
		// Aqui eu enfilero as extensões permitidas e separo por ';'
		// Isso serve apenas para eu poder pesquisar dentro desta String
		if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
		{
			return true;
		}
		
		return false;
	}

	function UploadImg($arquivo, $subpasta)
	{
		$arquivo_tmp = $_FILES[$arquivo]['tmp_name'];
		$nome = $_FILES[$arquivo]['name'];

		// Pega a extensao
		$extensao = strrchr($nome, '.');

		// Converte a extensao para mimusculo
		$extensao = strtolower($extensao);

		// Somente imagens, .jpg;.jpeg;.gif;.png
		// Aqui eu enfilero as extensões permitidas e separo por ';'
		// Isso serve apenas para eu poder pesquisar dentro desta String
		if(strstr('.jpg;.jpeg;.gif;.png', $extensao))
		{
			// Cria um nome único para esta imagem
			// Evita que duplique as imagens no servidor.
			$novoNome = md5(microtime()).$extensao;
			
			// Concatena a pasta com o nome
			$destino = "../img/".$subpasta."/".$novoNome; 
			
			// tenta mover o arquivo para o destino
			if(@move_uploaded_file($arquivo_tmp, $destino))
			{
				/*echo "Arquivo salvo com sucesso em : <strong>" . $destino . "</strong><br />";
				echo "<img src=\"" . $destino . "\" />";*/
				$imagem = $novoNome;
				return $imagem;
			}
		}
		
		return false;
	}
?>
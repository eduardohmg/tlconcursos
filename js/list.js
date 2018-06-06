var arAbas = new Array();

function stAba(menu_cad_questao,conteudo)
{
	this.menu_cad_questao = menu_cad_questao;
	this.conteudo = conteudo;
}

function AlternarAbas(menu_cad_questao,conteudo)
{
	for (i=0;i<arAbas.length;i++)
	{
		m = document.getElementById(arAbas[i].menu_cad_questao);
		m.className = 'menu_cad_questao';
		c = document.getElementById(arAbas[i].conteudo)
		c.style.display = 'none';
	}
	m = document.getElementById(menu_cad_questao)
	m.className = 'menu_cad_questao-sel';
	c = document.getElementById(conteudo)
	c.style.display = '';
}

function move(list, proc)
{
	var lista = document.getElementById(list);

	if(proc == 1)
	{
		var listaAlvo = document.getElementById('lstCategorias');
		var opcaoSelecionada = lista.options.selectedIndex;
		var valor = lista.options[opcaoSelecionada].value;
		var texto = lista.options[opcaoSelecionada].text;
		
		for(var i = 0; i < listaAlvo.options.length; i++)
		{
			if(valor == listaAlvo.options[i].value)
			{
				alert('Esta categoria já foi selecionada');
				return false;
			}
		}

		var newOption = document.createElement("option"); 
		newOption.value = valor;
		newOption.text = texto;
		listaAlvo.add(newOption, null);
	}
	else
	{
		var opcaoSelecionada = lista.options.selectedIndex;
		
		if(opcaoSelecionada != -1)
		{
			lista.remove(opcaoSelecionada);
			
			if(lista.options.length > 0)
			{
				lista.options[0].selected = true;
			}
			else
			{
				alert('A lista de categorias está limpa');
			}
			
			return true;
		}
		else
		{
			if(lista.options.length > 0)
			{
				alert('Selecione uma categoria para remover da lista');
				return false;
			}
			else
			{
				alert('A lista de categorias está limpa');
				return true;
			}
		}
	}
}

function selectAll(list) 
{
	selectBox = document.getElementById(list);
	
	if(selectBox.options.length <= 0)
	{
		return false;
	}
	else
	{
		for (var i = 0; i < selectBox.options.length; i++) 
		{ 
			selectBox.options[i].selected = true; 
		}
		return true;
	}
}
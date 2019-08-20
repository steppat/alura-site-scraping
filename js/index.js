var dados;
var total_count;
var links;
var pages;

//Organização do código
_$ = function(obj){
	return document.getElementById(obj);
}

function selectPage(val){
	requisitar("https://alura-scraping.herokuapp.com/produtos?_page=" + val + "&_limit=10");
}

// Montando os cards de anúncios
function createCard(){
	// Paginação
	response = '<ul class="pagination">';

	var count = 0
	for (var i in links) { // Solução para navegadores antigos
		if (links.hasOwnProperty(i)) {
			count++;
		}
	}
	
	if(count == 4){
		response +=
			'	<li class="page-item"><a id="novos" class="page-link" href="./index?page='+(pages-1)+'">&#9668;</a></li>' +
			'	<li class="page-item"><a id="usados" class="page-link" href="./index?page='+(pages+1)+'">&#9658;</a></li>' +
			'</ul>';
	}else{
		if(links[1].type == 'prev'){
			response +=
				'	<li class="page-item"><a id="novos" class="page-link" href="./index?page='+(pages-1)+'">&#9668;</a></li>' +
				'	<li class="page-item"><a id="usados" class="page-link">&#9658;</a></li>' +
				'</ul>';
		}else{
			response +=
				'	<li class="page-item"><a id="novos" class="page-link">&#9668;</a></li>' +
				'	<li class="page-item"><a id="usados" class="page-link" href="./index?page='+(pages+1)+'">&#9658;</a></li>' +
				'</ul>';
		}
	}
	
	$('.container-pagination').append(response);
	
}

//Função para instanciar o objeto XMLHttpResquest
function iniciaAjax(){
	var objetoAjax = false;
	if(window.XMLHttpRequest){
		objetoAjax = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		try{
			objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(ex){
				objetoAjax = false;
			}
		}
	}
	return objetoAjax;
}

//Função para requisitar um arquivo
function requisitar(arquivo){
	pages = Number(getParameterByName('_page', arquivo));
	var requisicaoAjax = iniciaAjax();
	if(requisicaoAjax){
		requisicaoAjax.onreadystatechange = function(){
			trataRespostaJSON(requisicaoAjax);
			$('#loadingModal_content').html('Carregando...');
			$('#loadingModal').modal('show');
		};
		requisicaoAjax.open("GET", arquivo, true);
		requisicaoAjax.send(null);
		return true;
	}else{
		return false;
	}
}

//Função para tratamento de arquivo JSON
function trataRespostaJSON(requisicaoAjax){
	if(requisicaoAjax.readyState == 4){
		if(requisicaoAjax.status == 200 || requisicaoAjax.status == 304){
			try {
				dados = JSON.parse(requisicaoAjax.responseText);
				loadModal(true);
				resetModal();
			} catch(e) {
				dados = eval("(" + requisicaoAjax.responseText + ")");
				loadModal(true);
				resetModal();
			}
			
			// Obtendo o tamanho total da resposta
			string_headers = requisicaoAjax.getAllResponseHeaders().split('\r\n');
			var headers = string_headers.reduce(function (acc, current, i){
				var parts = current.split(': ');
				acc[parts[0].toLowerCase()] = parts[1];
				return acc;
			}, {});			
			total_count = Number(headers['x-total-count']);
			
			// Obtendo os links de paginação
			parts = headers['link'].split(',');
			links = parts.reduce(function (acc, current, i){
				aux = current.trim().split(';');
				acc[i] = {'link': aux[0].replace("<", "'").replace(">", "'"), 'type': aux[1].replace(" rel=", "").replace('"', "").replace('"', "")};
				return acc;
			}, {})
			
			// Criando os cards de anúncios
			createCard();

		}else{
			alert("Problema de comunicação com os servidor. Tente mais tarde.");
			loadModal(false);
			resetModal();
		}
	}
}

// Carregamento do modal de progresso da requisição
function loadModal(type){
	if (type){ // Sucesso
		$('#loader').removeClass('loader');
		$('#loader').addClass('glyphicon glyphicon-ok');
		$('#loadingModal_label').html('Sucesso!');
		$('#loadingModal_content').html('<br>Busca concluída!');
	}else{ // Fracasso
		$('#loader').removeClass('loader');
		$('#loader').addClass('glyphicon glyphicon-remove');
		$('#loadingModal_label').html('Falha!');
		$('#loadingModal_content').html('<br>Tente Novamente Mais Tarde!');	
	}
}

// Descarregamento do modal de progresso da requisição
function resetModal(){
	//Aguarda 2 segundos até restaurar e fechar o modal
	setTimeout(function() {
		$('#loader').removeClass();
		$('#loader').addClass('loader');
		$('#loadingModal_label').html('<span class="glyphicon glyphicon-refresh"></span>Aguarde...');
		$('#loadingModal').modal('hide');
	}, 500);
}

// Função para obter os parâmetros da query
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
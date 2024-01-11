/**
* Função para criar um objeto XMLHTTPRequest
*/
function CriaRequest() {
	try{
		request = new XMLHttpRequest();        
	}catch (IEAtual){

		try{
			request = new ActiveXObject("Msxml2.XMLHTTP");       
		}catch(IEAntigo){

			try{
				request = new ActiveXObject("Microsoft.XMLHTTP");          
			}catch(falha){
				request = false;
			}
		}
	}

	if (!request) 
	alert("Seu Navegador não suporta Ajax!");
	else
	return request;
}

var filas;
var fichas;
var result = document.getElementById('filas');

function getFilas() {

	// Declaração de Variáveis
	var xmlreq = CriaRequest();
	
	// Exibi a imagem de progresso
	result.innerHTML = '<img class="text-center" src="../img/loading.gif" style="height: 25px; width: 25px;"/>';

	// Iniciar uma requisição
	xmlreq.open("GET", "./GetFilas.php", true);
	
	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200){
				filas = JSON.parse(xmlreq.responseText);
				for(i = 0; i < filas.length; i++){
					GetFichas(filas[i]);
				}
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		}
	};
	
	xmlreq.send(null);
}

function GetFichas(fila){
	var xmlreq = CriaRequest();
	
	// Iniciar uma requisição
	xmlreq.open("POST", "./GetFichas.php", true);
	xmlreq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200){
				fichas = JSON.parse(xmlreq.responseText);
				var igDDD = fila["IgnoraDDD_fila"].split(",").map(Number);
				if(igDDD[0] != 0){
					for(i = 0; i < fichas.length; i++){
						contatos = JSON.parse(fichas[i]["to"]);
						for(b = 0; b < contatos.length; b++){
							if(igDDD.indexOf(contatos[b]["number"].substring(2)) > -1){
								contatos.splice(b);
							}
							
							if(contatos.length == 0 ){
								fichas.splice(i);
							}else{
								fichas[i]["to"] = contatos;
							}
						}
					}
				}
				
				SendFichas(fila["iddisc_fila"], fichas);
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		}
	};
	
	
	xmlreq.send(JSON.stringify(fila));
}

function SendFichas(fila, fichas){
	
	var xmlreq = CriaRequest();
	
	// Iniciar uma requisição
	xmlreq.open("POST", "./SendFichas.php", true);
	xmlreq.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200){
				result.innerHTML = xmlreq.responseText;
			}
		}
	}
	
	dados = '{"fila": "' + fila + '", "fichas": ' + JSON.stringify(fichas) + '}';
	xmlreq.send(dados);
}


//window.setInterval(function(){getFilas();},1000);
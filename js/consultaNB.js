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

/**
* Função para enviar os dados
*/
function getDados(NB) {

	// Declaração de Variáveis
	var xmlreq = CriaRequest();
	
	// Iniciar uma requisição
	xmlreq.open("GET", "./_app/control/ConsultaNb2.php?NB="+NB, true);
	
	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){
		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200){
				var data = JSON.parse(xmlreq.responseText);
				console.log(data);
				//result.innerHTML = "";
				document.location.reload(true);
			}else{
				console.log("Erro: " + xmlreq.statusText);
				//result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		}
	};
	
	xmlreq.send(null);
}
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

var tempo = 120;

/**
* Função para enviar os dados
*/
function getDados() {

	// Declaração de Variáveis
	var Sup   = document.getElementById("Supervisor").value;
	var Equipe   = document.getElementById("Equipe").value;
	var result = document.getElementById("Resultado");
	var xmlreq = CriaRequest();
	
	// Exibi a imagem de progresso
	result.innerHTML = '<img class="text-center" src="img/loading.gif" style="height: 25px; width: 25px;"/>';

	// Iniciar uma requisição
	xmlreq.open("GET", "./_app/control/VendasGerencialDash.php?Sup="+ Sup +"&Equipe=" + Equipe, true);

	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function(){

		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
		if (xmlreq.readyState == 4) {
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200){
				document.getElementById("TabVendas").innerHTML = xmlreq.responseText;
				result.innerHTML = "";
			}else{
				result.innerHTML = "Erro: " + xmlreq.statusText;
			}
		}
	};
	
	xmlreq.send(null);
	
	tempo = 120;
}

var label = document.getElementById("Time");
window.setInterval(function(){
  
  var min = parseInt(tempo/60);
  var sec = tempo%60;
  
	if(min < 10){
		min = "0"+min;
		min = min.substr(0, 2);
	}
	
	if(sec <=9){
		sec = "0"+sec;
	}
	
	label.innerHTML = " 0:" + min + ":" + sec;
  
	if(tempo <= 0){
		getDados();
		tempo = 60
	}
	tempo--;
},1000);
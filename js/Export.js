function PostExt() {

	// Declaração de Variáveis
	var Tabela   = document.getElementById("tabela");
	
	console.log(Tabela.outerHTML);
	
	window.open('data:application/vnd.ms-excel, ' + encodeURIComponent(Tabela.outerHTML));
	//tempo = 120;
	
	
}
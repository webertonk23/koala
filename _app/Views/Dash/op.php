<?php

	$Read = new Read;
	$Read->FullRead("SELECT DISTINCT produto FROM funcionarios WHERE status != 'Ativo' AND cargo = 'Operador'");
	if($Read->GetRowCount()>0){
		$produto = $Read->GetResult();
	}

?>

<form  method='POST'>
	<div class='form-row mb-2'>
		<div class='form-group mr-2'>
			<label>Produto</label>
			<select class='form-control col-sm' name='produto' Id='produto'>
				<option value='0'>Todos</option>
				<?php
					if(!empty($produto)){
						foreach($produto as $Value){
							$Selected = (!empty($_POST['produto']) AND $_POST['produto'] == $Value['produto']) ? 'selected' : '';
							echo "<option $Selected value='{$Value['produto']}'>{$Value['produto']}</option>";
						}
					}
				?>
			</select>
		</div>
	</div>
</form>

<div class='row' id='painel'></div>

<script>
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
	
	var tempo = 0;
	function getDados() {

		var xmlreq = CriaRequest();
		var produto = document.getElementById('produto').value;
		// Exibi a imagem de progresso
		// result.innerHTML = '<img class="text-center" src="img/loading.gif" style="height: 25px; width: 25px;"/>';
		
		// Iniciar uma requisição
		xmlreq.open("GET", "./_app/control/StatusOp.php?p="+produto, true);
		
		agent = document.getElementById('painel');
		
		// Atribui uma função para ser executada sempre que houver uma mudança de ado
		xmlreq.onreadystatechange = function(){

			// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
			if (xmlreq.readyState == 4) {
				// Verifica se o arquivo foi encontrado com sucesso
				if (xmlreq.status == 200){
					agent.innerHTML = xmlreq.responseText;
				}else{
					agent.innerHTML = "Erro: " + xmlreq.statusText;
				}
			}
		};
			
		xmlreq.send(null);
		
		tempo = 5;
	}

	window.setInterval(function(){
		getDados();
	},5000);
</script>
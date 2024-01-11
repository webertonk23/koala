<?php
	set_time_limit(6000);
	
	$Read = new Read;
	$Check = new Check;
	$Insert = new Create;
	$Update = new Update;
?>

<div class='row justify-content-center'>
	<div class="card col-6">
		<form method='POST' enctype="multipart/form-data">
			<div class='card-body'>
				<h4 class='card-title'>Extrato Comissão</h4>
				<div class='form-group'>
					<label>Arquivo</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="4194299904" />
					<input type='file' class='form-control'  name='File'/>
				</div>
				
				<div class='form-group'>
					<input type='submit' class='form-control' name='Importar' value='Importar'/>
				</div>
			</div>
		</form>
		
		<div class='text-center'>
			<div id='Loading' class="load spinner-border " role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
</div>



<?php
	
	set_time_limit(0);
	$phpFileUploadErrors = array(
		0 => 'Não há erro, o arquivo foi enviado com sucesso',
		1 => 'O arquivo enviado excede a diretiva upload_max_filesize no php.ini',
		2 => 'O arquivo enviado excede a diretiva MAX_FILE_SIZE que foi especificada no formulário HTML',
		3 => 'O arquivo enviado foi apenas parcialmente carregado',
		4 => 'Nenhum arquivo foi enviado',
		6 => 'Faltando uma pasta temporária',
		7 => 'Falha ao gravar o arquivo no disco',
		8 => 'Uma extens?o PHP parou o upload do arquivo.',
	);
	
	
	if(!empty($_FILES) AND !empty($_POST)){
		
		if($_FILES['File']['error'] == 0){
			$file = $_FILES['File']['tmp_name'];
			
			$file = fopen($file, 'r');
			
			$registro = array();
			$i = 0;
			$erro = array();
			
			while ($linha = fgetcsv($file, 0, ';')){
				$linha = array_map('strtolower', $linha);
				
				$Cabecalho = array(
					'ade_excom', 
					'nomecli_excom', 
					'cpfcli_excom', 
					'status_excom', 
					'dtpag_excom', 
					'vlbase_excom', 
					'vlcom_excom', 
					'banco_excom', 
					'produto_excom'
				);
				
				if(!empty($linha[0]) AND $linha[0] != "ade"){
					$linha[0] = (int) $linha[0]; //Ade
					$linha[1] = $Check->name($linha[1]); // Nome
					
					$linha[2] = trim(str_replace(array("-", "."), array(), $linha[2])); // CPF
					$linha[2] = str_pad($linha[2], 11, 0, STR_PAD_LEFT);
					
					if(in_array($linha[3], array('p', 'e'))){ // status
						switch($linha[3]){
							case 'p':
								$linha[3] = 1;
								break;
							case 'e':
								$linha[3] = -1;
								break;
						}
					}else{
						$erro[$i] = "A coluna de situacão deve ser preenchida com 'p' para pagamentos ou 'e' para estornos, gentileza verificar!";
					}
					
					// dtpag
					if($Data = explode('/', $linha[4])){
						$linha[4] = $Data[2].'-'.$Data[1].'-'.$Data[0];
					}else{
						$erro[$i] = "A coluna de dtpag esta com o formato incorreto, gentileza verificar!";
					}
					
					$linha[5] = trim(str_replace(array(".", ",", "r$", "-"), array("", ".", ""), $linha[5])); // valor base
					$linha[6] = trim(str_replace(array(".", ",", "r$", "-"), array("", ".", ""), $linha[6])); // valor comissao
					
					
					$linha[7] = trim(iconv("ISO-8859-1", "UTF-8", $linha[7])); // banco
					$linha[8] = trim(iconv("ISO-8859-1", "UTF-8", $linha[8])); // produto
					
					
					if(empty($erro[$i])){
						$Dados = array_combine($Cabecalho, $linha);
						//$registro[] = $Dados;
						
						$Read->FullRead("SELECT id_excom FROM extratocomissao WHERE ade_excom = :ade AND status_excom = :status", "ade={$Dados['ade_excom']}&status={$Dados['status_excom']}");
						
						if($Read->GetRowCount() == 0){
							$Insert->ExeCreate("extratocomissao", $Dados);
						}else{
							if($Read->GetErro() == 0){
								$Update->ExeUpdate("extratocomissao", $Dados, "WHERE id_excom = :id", "id={$Read->Getresult()[0]['id_excom']}");
							}
						}
					}
					
					//var_dump($Dados);
				}
				
				$i++;
			}
		}
		
		if(!empty($erro)){
		foreach($erro as $k => $v){
			echo "<p>Erro na linha {$k}:  {$v}</p>"; 
		}
		}else{
			echo "<p>Arquivo totalmente processado!!</p>"; 
		}
	}
	
	
	
?>

<script>
    //código usando DOM (JS Puro)
    document.addEventListener("DOMContentLoaded", function(event) { 
		var estilo = document.getElementsByClassName('load');
		estilo[0].style.visibility = "hidden";
	 });
</script>
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
				<h4 class='card-title'>Pausas Vonix</h4>
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
	</div>
</div>



<?php
	
	set_time_limit(0);
	$phpFileUploadErrors = array(
		0 => 'N?o h? erro, o arquivo foi enviado com sucesso',
		1 => 'O arquivo enviado excede a diretiva upload_max_filesize no php.ini',
		2 => 'O arquivo enviado excede a diretiva MAX_FILE_SIZE que foi especificada no formul?rio HTML',
		3 => 'O arquivo enviado foi apenas parcialmente carregado',
		4 => 'Nenhum arquivo foi enviado',
		6 => 'Faltando uma pasta tempor?ria',
		7 => 'Falha ao gravar o arquivo no disco',
		8 => 'Uma extens?o PHP parou o upload do arquivo.',
	);
	
	
	if(!empty($_FILES) AND !empty($_POST)){
		
		if($_FILES['File']['error'] == 0){
			$file = fopen($_FILES['File']['tmp_name'], 'r');
			
			if(substr($_FILES['File']['name'], -4, 4) == '.csv'){
				
				$registro = array();
				$i = 0;
				while ($linha = fgetcsv($file, 0, ';', '"')){
					if(is_array($linha) AND $i!=0 AND count($linha) == 5){
						$registro['agente_histp'] = $Check->Name(utf8_encode($linha[0]));
						$registro['matricula_histp'] = (int) $linha[1];
						$registro['descpausa_histp'] = $Check->Name(utf8_encode($linha[2]));
						
						
						$registro['inipausa_histp'] =  $Check->DataI2($linha[3]);
						$registro['fimpausa_histp'] =  $Check->DataI2($linha[4]);
						
						$Read->ExeRead("funcionarios", "WHERE idsistema = :id", "id={$registro['matricula_histp']}");
						if($Read->GetRowCount() == 1){
							$registro['idfunc_histp'] = $Read->GetResult()[0]['Id'];
							$Read->ExeRead(
								"histpausa",
								"WHERE
									descpausa_histp = :desc AND
									agente_histp = :agente AND
									matricula_histp = :mat AND
									idfunc_histp = :idfunc AND
									inipausa_histp = :ini AND
									fimpausa_histp = :fim",
								"desc={$registro['descpausa_histp']}&agente={$registro['agente_histp']}&mat={$registro['matricula_histp']}&idfunc={$registro['idfunc_histp']}&ini={$registro['inipausa_histp']}&fim={$registro['fimpausa_histp']}"
							);
							
							if($Read->GetRowCount()==0){
								$Insert->ExeCreate('histpausa', $registro);
								echo ($Insert->GetResult() > 0) ? "<p>Registro importado</p>" : "";
							}else{
								echo "<p>Registro já importado</p>";
							}
						}else if($Read->GetRowCount() > 1){
							echo "<p>mais de um funcionário estão com o mesmo ID de Sistema: {$registro['matricula_histp']}</p>";
						}else{
							echo "<p>agente {$registro['agente_histp']} não se encontra cadastrado como funcionário</p>";
						}
					}
					
					$i++;
					
				}
			}else{
				echo "<br>";
				Erro("Arquivo não esta no formato correto, Arquivo deve ser csv separdo por ; !", ERRO);
			}
		}
	}
	
	
	
	// if(!empty($registro)){
		// $Import = new Import($registro, $_POST['Carteira'], $_POST['Layout'], $_FILES['File']['name'] );
		// $Import->ProcImport();
	// }
	
?>
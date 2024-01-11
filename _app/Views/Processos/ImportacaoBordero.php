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
				<h4 class='card-title'>Borderô</h4>
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
				while ($linha = fgetcsv($file, 0, ',', '"')){
					//$linha = fgetcsv($file, 0, ';', '"');
					if(is_array($linha) AND $i!=0 AND count($linha) == 29){
						if($linha[1] == 52514 OR $linha[1] == 52849  OR $linha[1] == 53153){
							$registro['Servico'] = $Check->Name(utf8_encode($linha[0]));
							$registro['Cod_Loja'] = (int) $linha[1];
							$registro['Cod_Ent'] = (int) $linha[2];
							$registro['Data'] = ($linha[3]== '') ? null : $Check->DataI2($linha[3]);
							$registro['ADE'] =  (int) $linha[4];
							$registro['Contrato'] =  (int) $linha[5];
							$registro['Nome'] =  $Check->Name(utf8_encode($linha[6]));
							$registro['CPF'] =  $Check->Name($linha[7]);
							$registro['Matricula'] = (int) $linha[8];
							$registro['Prazo'] = $linha[9];
							$registro['Valor_PMT'] = (float) $linha[10];
							$registro['Valor_Soli_Limite_Cartao'] = (float) str_replace(",", ".", str_replace(".", "", $linha[11]));
							$registro['Valor_Fin'] = (float) str_replace(",", ".", str_replace(".", "", $linha[12]));
							$registro['Valor_Liberado_Saque'] = (float) str_replace(",", ".", str_replace(".", "", $linha[13]));
							$registro['Margem'] = (float) str_replace(",", ".", str_replace(".", "", $linha[14]));
							$registro['Valor_da_IOF'] = (float) $linha[15];
							$registro['Usuario'] = $Check->Name($linha[16]);
							$registro['Data_Averbacao'] = ($linha[17] == '') ? null : $Check->DataI($linha[17]);
							$registro['Averbacao'] =  $Check->Name($linha[18]);
							$registro['Telefone'] = $linha[19];
							$registro['Status'] =  $Check->Name(utf8_encode($linha[20]));
							$registro['Situacao'] =  $Check->Name(utf8_encode($linha[21]));
							$registro['Motivo_Sit'] =  $Check->Name(utf8_encode($linha[22]));
							$registro['Canal_de_Venda'] =  $Check->Name(utf8_encode($linha[23]));
							$registro['Forma_Envio'] =  $Check->Name(utf8_encode($linha[24]));
							$registro['Detalhes_da_situacao'] =  "";
							$registro['Possui_Conta_BMG_Simples'] =  substr($linha[26], 0, 1);
							$registro['Possui_Seguro'] =  substr($linha[27], 0, 1);
							$registro['Valor_Mensalidade'] = (float) $linha[28];
							
							// Debug($registro);
							
							if($registro['ADE'] != 0){
								//$registro['Servico'] = ($registro['Servico'] == 'Cartao Bmg Master' AND $registro['Valor_Liberado_Saque'] > 0) ? 'Cartao Sacado' : $registro['Servico'];
								$Ade = $registro['ADE'];
								$Read->ExeRead("bordero", "WHERE ADE = :ADE", "ADE={$Ade}");
								if($Read->GetRowCount()>0){
									
									$registro['DtAlt'] = date("Y-m-d H:i:s");
									unset($registro['ADE']);
									$Update->ExeUpdate("bordero", $registro, "WHERE ADE = :ADE", "ADE={$Ade}");
									
									echo "Ade {$Ade} existente, atualizada!<br>";
								}else{
									$Insert->ExeCreate('bordero', $registro);
									echo "Inclusa nova Ade {$registro['ADE']}!<br>";
								}
							}
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
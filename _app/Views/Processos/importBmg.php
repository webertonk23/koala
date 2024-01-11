<div class='row justify-content-center'>
	<div class="card col-6">
		<form method='POST' enctype="multipart/form-data">
			<div class='card-body'>
				<h4 class='card-title'>Arquivos Comissão BMG</h4>
				<div class='form-group'>
					<label>Arquivo</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="4194299904" />
					<input type='file' class='form-control'  name='File[]' multiple="multiple" accept=".csv"/>
				</div>
				
				<div class='form-group'>
					<input type='submit' class='form-control' name='proc' value='Importar arquivos'/>
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

<script>
    //código usando DOM (JS Puro)
    document.addEventListener("DOMContentLoaded", function(event) { 
		var estilo = document.getElementsByClassName('load');
		estilo[0].style.visibility = "hidden";
	 });
</script>

<div class='row justify-content-center mt-2'>
	<div class="card col-8">
		<div class='cadr-body'>
			<h2>Resultado:</h2>
			<div>
<?php
	if(!empty($_POST['proc'])){
		$Read = new Read;
		$Update = new Update;
		$Check = new Check;
		$Create = new Create;
		
		//set_time_limit(0);
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
			foreach($_FILES['File']['name'] AS $i => $arquivo){
				if(substr($arquivo,-4) == ".csv"){
					$fileName = str_replace(".csv", "", $arquivo);
					
					if(preg_match("/"."GESTAO_SEGURO"."/", $fileName)){
					
						$a = explode("_", $fileName);
						
						$a[4] = $a[4][6].$a[4][7].$a[4][4].$a[4][5].$a[4][0].$a[4][1].$a[4][2].$a[4][3];
						
						$fileName = implode("_", $a);				
					}
					
					$Read->FullRead("SELECT DISTINCT produto_ext, comp_ext FROM extrato WHERE comp_ext = :comp", "comp={$fileName}");
					
					if($Read->GetRowCount() > 0){
						$Produto = $Read->GetResult()[0]['produto_ext'];
						
						echo "<p>Arquivo: <b>$arquivo</b>, Produto: <b>$Produto</b></p>";
						$Read->ExeRead('comissaobmg',"WHERE arq_com = :arq","arq={$fileName}");
						
						if($Read->GetRowCount() == 0){
							
							$file = fopen($_FILES['File']['tmp_name'][$i], 'r');
							
							if($Produto == 'Card'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(!empty($linha[4]) AND $linha[4] != ' ' AND $linha[0] != 'Cliente'){
										$Registro['cliente_com'] = utf8_encode($linha[0]);
										$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
										$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
										$Registro['contrato_com'] = $linha[6];
										$Registro['valor_com'] = (float) str_replace(",", ".", $linha[8]);
										$Registro['situacao_com'] = $linha[14];
										$Registro['tipocom_com'] = utf8_encode($linha[15]);
										$Registro['loja_com'] = utf8_encode($linha[18]);
										$Registro['ade_com'] = $linha[25];
										$Registro['usuario_com'] = $linha[17];
										$Registro['arq_com'] = $fileName;
										
										$Create->ExeCreate('comissaobmg', $Registro);
										
										unset($Registro);
										
									}
								}
							}else if($Produto == 'Seguro'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(!empty($linha[6]) AND $linha[6] != ' ' AND $linha[0] != 'Cliente'){
										$Registro['cliente_com'] = utf8_encode($linha[0]);
										$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
										$Registro['contrato_com'] = $linha[2];
										$Registro['dtpag_com'] = $Check->DataI2($linha[6]);
										$Registro['valor_com'] = (float) str_replace(",", ".", $linha[10]);
										$Registro['situacao_com'] = $linha[17];
										$Registro['tipocom_com'] = utf8_encode($linha[30]);
										$Registro['loja_com'] = utf8_encode($linha[20]);
										$Registro['ade_com'] = $linha[26];
										$Registro['usuario_com'] = utf8_encode($linha[19]);
										$Registro['arq_com'] = $fileName;
										
										$Create->ExeCreate('comissaobmg', $Registro);
										
										unset($Registro);
										
									}
								}
							}else if($Produto == 'Conta Pgto'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(!empty($linha[3]) AND $linha[3] != ' ' AND $linha[0] != 'Cliente'){
										$Registro['cliente_com'] = utf8_encode($linha[0]);
										$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
										$Registro['contrato_com'] = $linha[2];
										$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
										$Registro['valor_com'] = (float) str_replace(",", ".", $linha[7]);
										$Registro['situacao_com'] = $linha[13];
										$Registro['tipocom_com'] = utf8_encode($linha[20]);
										$Registro['loja_com'] = utf8_encode($linha[14]);
										$Registro['ade_com'] = $linha[18];
										$Registro['usuario_com'] = utf8_encode($linha[27]);
										$Registro['arq_com'] = $fileName;
										
										$Create->ExeCreate('comissaobmg', $Registro);
										
										unset($Registro);
										
									}
								}
							}else if($Produto == 'Saque Diferido'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(preg_match("/"."_CARTAO_DIFERIDO"."/", $fileName)){
										if(!empty($linha[4]) AND $linha[4] != ' ' AND $linha[0] != 'Cliente'){
											$Registro['cliente_com'] = utf8_encode($linha[0]);
											$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
											$Registro['contrato_com'] = $linha[6];
											$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[8]); // Revisar
											$Registro['situacao_com'] = $linha[18];
											$Registro['tipocom_com'] = utf8_encode($linha[19]);
											$Registro['loja_com'] = utf8_encode($linha[22]);
											$Registro['ade_com'] = $linha[29];
											$Registro['usuario_com'] = utf8_encode($linha[21]);
											$Registro['arq_com'] = $fileName;
										}
									}else if(preg_match("/"."_ReposicaoCard_"."/", $fileName)){
										if(!empty($linha[3]) AND $linha[3] != ' ' AND utf8_encode($linha[0]) != 'Número do Contrato'){
											$Registro['cliente_com'] = '';
											$Registro['cpf_com'] = $Check->CpfCnpj($linha[1]);
											$Registro['contrato_com'] = $linha[0];
											$Registro['dtpag_com'] = $Check->DataI2($linha[11]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[15]) * -1; // Revisar
											$Registro['situacao_com'] = 'Estornada';
											//$Registro['tipocom_com'] = utf8_encode($linha[22]);
											$Registro['loja_com'] = utf8_encode($linha[24]);
											$Registro['ade_com'] = $linha[2];
											$Registro['usuario_com'] = utf8_encode($linha[29]);
											$Registro['arq_com'] = $fileName;
										}
									}
									
									if(!empty($Registro)){
										$Create->ExeCreate('comissaobmg', $Registro);
										unset($Registro);
									}
								}
							}else if($Produto == 'Saque Antecipado'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(preg_match("/"."_AcertoCard_"."/", $fileName)){
										if(!empty($linha[8]) AND $linha[8] != ' ' AND $linha[0] != 'Contrato'){
											$Registro['cliente_com'] = utf8_encode($linha[2]);
											$Registro['cpf_com'] = $Check->CpfCnpj($linha[3]);
											$Registro['contrato_com'] = $linha[0];
											$Registro['dtpag_com'] = $Check->DataI2($linha[8]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[18]) * -1; // Revisar
											$Registro['situacao_com'] = 'Estornada';
											//$Registro['tipocom_com'] = utf8_encode($linha[19]);
											$Registro['loja_com'] = utf8_encode($linha[21]);
											$Registro['ade_com'] = $linha[1];
											$Registro['usuario_com'] = utf8_encode($linha[36]);
											$Registro['arq_com'] = $fileName;
										}
									}else if(preg_match("/"."_SaldoPagoCard_"."/", $fileName)){
										if(!empty($linha[3]) AND $linha[3] != ' ' AND $linha[0] != 'Cliente'){
											$Registro['cliente_com'] = utf8_encode(trim($linha[0]));
											$Registro['cpf_com'] = $Check->CpfCnpj($linha[1]);
											$Registro['contrato_com'] = $linha[8];
											$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[25]); // Revisar
											$Registro['situacao_com'] = 'Paga';
											$Registro['tipocom_com'] = utf8_encode($linha[27]);
											$Registro['loja_com'] = utf8_encode($linha[28]);
											$Registro['ade_com'] = $linha[33];
											$Registro['usuario_com'] = utf8_encode($linha[45]);
											$Registro['arq_com'] = $fileName;
										}
									}
									
									if(!empty($Registro)){
										$Create->ExeCreate('comissaobmg', $Registro);
										unset($Registro);
									}
								}
							}else if($Produto == 'Consig Antecipado'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(preg_match("/"."_SaldoPagoConsig_"."/", $fileName)){	
										if(!empty($linha[3]) AND $linha[3] != ' ' AND $linha[0] != 'Cliente'){
											$Registro['cliente_com'] = utf8_encode(trim($linha[0]));
											$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
											$Registro['contrato_com'] = $linha[7];
											$Registro['dtpag_com'] = $Check->DataI2($linha[3]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[16]); // Revisar
											$Registro['situacao_com'] = 'Paga';
											$Registro['tipocom_com'] = utf8_encode($linha[22]);
											$Registro['loja_com'] = utf8_encode($linha[23]);
											$Registro['ade_com'] = $linha[28];
											$Registro['usuario_com'] = utf8_encode($linha[40]);
											$Registro['arq_com'] = $fileName;
										}
									}else if(preg_match("/"."_AcertoConsig_"."/", $fileName)){	
										if(!empty($linha[3]) AND $linha[3] != ' ' AND $linha[0] != 'Contrato'){
											$Registro['cliente_com'] = utf8_encode(trim($linha[2]));
											$Registro['cpf_com'] = $Check->CpfCnpj($linha[3]);
											$Registro['contrato_com'] = $linha[0];
											$Registro['dtpag_com'] = $Check->DataI2($linha[8]); //Revisar
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[18]) * -1; // Revisar
											$Registro['situacao_com'] = 'Estornada';
											//$Registro['tipocom_com'] = utf8_encode($linha[22]);
											$Registro['loja_com'] = utf8_encode($linha[21]);
											$Registro['ade_com'] = $linha[1];
											$Registro['usuario_com'] = utf8_encode($linha[36]);
											$Registro['arq_com'] = $fileName;
										}
									}
									
									if(!empty($Registro)){
										$Create->ExeCreate('comissaobmg', $Registro);
										unset($Registro);
									}
									
									
								}
							}else if($Produto == 'Consig Diferido'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(preg_match("/"."_CONSIGNADO_DIFERIDO"."/", $fileName)){	
										if(!empty($linha[4]) AND $linha[4] != ' ' AND $linha[0] != 'Cliente'){
											$Registro['cliente_com'] = utf8_encode(trim($linha[0]));
											$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
											$Registro['contrato_com'] = $linha[6];
											$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[9]); // Revisar
											$Registro['situacao_com'] = utf8_encode($linha[18]);
											$Registro['loja_com'] = utf8_encode($linha[21]);
											$Registro['ade_com'] = $linha[38];
											$Registro['usuario_com'] = utf8_encode($linha[20]);
											$Registro['arq_com'] = $fileName;
										}
									}else if(preg_match("/"."_ReposicaoConsig_"."/", $fileName)){
										if(!empty($linha[11]) AND $linha[11] != ' ' AND utf8_encode($linha[0]) != 'Número do Contrato'){
											$Registro['cliente_com'] = '';
											$Registro['cpf_com'] = $Check->CpfCnpj($linha[1]);
											$Registro['contrato_com'] = $linha[0];
											$Registro['dtpag_com'] = $Check->DataI2($linha[11]);
											$Registro['valor_com'] = (float) str_replace(",", ".", $linha[15]) * -1; // Revisar
											$Registro['situacao_com'] = 'Estornada';
											$Registro['loja_com'] = utf8_encode($linha[24]);
											$Registro['ade_com'] = $linha[2];
											$Registro['usuario_com'] = utf8_encode($linha[29]);
											$Registro['arq_com'] = $fileName;
										}
									}
									
									if(!empty($Registro)){
										$Create->ExeCreate('comissaobmg', $Registro);
										unset($Registro);
									}
								}
								
							}else if($Produto == 'Rotativo'){
								while ($linha = fgetcsv($file, 0, ';', '"')){
									if(!empty($linha[4]) AND $linha[4] != ' ' AND $linha[0] != 'Cliente'){
										$Registro['cliente_com'] = utf8_encode(trim($linha[0]));
										$Registro['cpf_com'] = str_pad($linha[1], 11, 0,STR_PAD_LEFT);
										$Registro['contrato_com'] = $linha[6];
										$Registro['dtpag_com'] = $Check->DataI2($linha[4]);
										$Registro['valor_com'] = (float) str_replace(",", ".", $linha[8]); // Revisar
										$Registro['situacao_com'] = utf8_encode(trim($linha[14]));
										$Registro['tipocom_com'] = utf8_encode($linha[15]);
										$Registro['loja_com'] = utf8_encode($linha[18]);
										$Registro['ade_com'] = $linha[25];
										$Registro['usuario_com'] = utf8_encode($linha[17]);
										$Registro['arq_com'] = $fileName;
									}
									
									if(!empty($Registro)){
										$Create->ExeCreate('comissaobmg', $Registro);
										unset($Registro);
									}
								}
								
							}else{
								echo "<p>Produto <b>{$Produto}</b> não parametrizadao</p>";
							}
						}else{
							echo "<p>O arquivo já foi importado anteriormente!</p>";
						}
					}else{
						echo "<p>Arquivo <b>$arquivo</b> não localizado no extrato!</p>";
					}
				}else{
					echo "<p>Extenção do arquivo $arquivo é invalida</p>";
				}
				
				echo "<hr>";
			}
			//var_dump($_FILES);
		}
	}
?>
			</div>
		</div>
	</div>
</div>
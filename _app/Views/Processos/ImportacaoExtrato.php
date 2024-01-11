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
				<h4 class='card-title'>Extrato</h4>
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
			include_once("./_app/PHPExcel/PHPExcel.php");
			$file = $_FILES['File']['tmp_name'];
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load($file);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
			$csvFileName = str_replace('.xlsx', '.csv', $file);
			$objWriter->save($csvFileName);
			
			$file = fopen($csvFileName, 'r');
				
			$registro = array();
			$i = 0;
			$Saldo = 0;
			while ($linha = fgetcsv($file, 0, ',')){
				//$linha = fgetcsv($file, 0, ';', '"');
				$Cabecalho = array(
					'data_ext', 
					'loja_ext', 
					'hist_ext', 
					'comp_ext', 
					'doc_ext', 
					'valor_ext', 
					'valorbloq_ext', 
					'tipo_ext', 
					'saldo_ext', 
					'produto_ext'
				);
				
				if(!empty($linha[0]) AND !empty($linha[5]) AND $linha[5] !== "0.00" AND $linha[2] !== "ENVIO DE TED" AND $linha[0] !== "Data" AND !empty($linha[0])){
					if(!empty($Cabecalho)){
						$linha[0] = $Check->DataI2($linha[0]);
						
						$linha[2] = trim($linha[2]);
						
						$linha[3] =	str_replace(".CSV", "", $linha[3]);
						$linha[3] =	str_replace(".csv", "", $linha[3]);
						$linha[3] = trim($linha[3], " ");
						
						
						
						$linha[3] =	str_replace(" ", "_", $linha[3]);
						$linha[3] =	str_replace("_BMG", "", $linha[3]);
						$linha[3] =	str_replace("_CARTAO_ROTATIVO", "_ROTATIVO", $linha[3]);
						$linha[3] =	str_replace("GESTAO_DE_SEGUROS", "GESTAO_SEGURO", $linha[3]);
						$linha[3] =	str_replace("_CONSIGNADO", "_CONSIGNADO_DIFERIDO", $linha[3]);
						
						$linha[5] = trim(str_replace("$", "", $linha[5]));
						
						switch($linha[7]){
							case "C":
								$linha[7] = 1;
							break;
							case "D":
								$linha[7] = -1;
							break;
						}
						
						if(($linha[2] == "COMISSAO CARTAO") OR ($linha[2] == "EST COMISSAO CARTAO")){
							$linha[9] = "Card";
						}else if(($linha[2] == "COMISSAO CARTAO DIFERIDA") OR (preg_match("/"."_REPOSICAOCARD_"."/", $linha[2])) OR ($linha[2] == "EST COMISSAO CARTAO DIFERIDA")){
							$linha[9] = "Saque Diferido";
						}else if(($linha[2] == "COMISSAO CONSIGNADO DIFERIDA") OR (preg_match("/"."_REPOSICAOCONSIG_"."/", $linha[2])) OR ($linha[2] == "EST COMISSAO CONSIG DIFERIDA")){
							$linha[9] = "Consig Diferido";
						}else if(($linha[2] == "COMISSAO SEGURO") OR ($linha[2] == "EST COMISSAO SEGURO")){
							$linha[9] = "Seguro";
						}else if($linha[2] == "COMISSAO CONTA PAGAMENTO"){
							$linha[9] = "Conta Pgto";
						}else if((preg_match("/"."_SALDOPAGOCARD_"."/", $linha[2])) OR (preg_match("/"."_ACERTOCARD_"."/", $linha[2]))){
							$linha[9] = "Saque Antecipado";
						}else if((preg_match("/"."_SALDOPAGOCONSIG_"."/", $linha[2])) OR (preg_match("/"."_ACERTOCONSIG_"."/", $linha[2]))){
							$linha[9] = "Consig Antecipado";
						}else if(($linha[2] == "COMISSAO ROTATIVO") OR ($linha[2] == "EST COMISSAO ROTATIVO")){
							$linha[9] = "Rotativo";
						}else{
							$linha[9] = "";
						}
						
						$Dados = array_combine($Cabecalho, $linha);
						$registro[] = $Dados;
						
						$Saldo = $Saldo + ($linha[7] * $linha[5]);
						
						$Read->FullRead("SELECT Id_ext FROM extrato WHERE doc_ext = :doc", "doc={$linha[4]}");
						
						if($Read->GetRowCount() == 0){
							$Insert->ExeCreate("extrato", $Dados);
						}

					}
					
				}

			}
		}
	}
	
?>

<div class='row justify-content-center'>
	<div class="card col-6 text-center">
		<div class='card-body'>
			<h4 class='card-title'>
				Saldo do Arquivo Importado: <?php echo (isset($Saldo)) ? number_format($Saldo, 2, ",", ".") : "0,00"?>
			</h4>
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
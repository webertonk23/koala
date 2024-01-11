<?php
	set_time_limit(6000);
	
	$Read = new Read;
	
	$Read->Exeread('Carteira');
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
	
	$Read->Exeread('Layout');
	if($Read->GetRowCount()>0){
		$Layout = $Read->GetResult();
	}
	
?>

<div class='row justify-content-center'>
	<div class="card col-6">
		<form method='POST' enctype="multipart/form-data">
			<div class='card-body'>
				<div class='form-group'>
					<label>Carteria</label>
					<select class='form-control' name='Carteira'>
						<option value='0' disabled selected>Selecione</option>
						<?php
							foreach($Carteiras as $Key => $Values){
								echo "<option value='{$Values['Id_Cart']}'>{$Values['Desc_Cart']}</option>";
							}
						?>
					</select>
				</div>
				
				<div class='form-group'>
					<label>Layout</label>
					<select class='form-control' name='Layout'>
						<option value='0' disabled selected>Selecione</option>
						<?php
							foreach($Layout as $Key => $Values){
								echo "<option value='{$Values['Id_lay']}'>{$Values['Desc_lay']}</option>";
							}
						?>
					</select>
				</div>
				
				<div class='form-group'>
					<label>Arquivo</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="41943040‬" />
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
			// $file = fopen($_FILES['File']['tmp_name'], 'r');
			
			// if(substr($_FILES['File']['name'], -4, 4) == '.csv'){
				
				// $registro = array();
				
				// $cabecalho = fgetcsv($file, 0, ';', '"');
				
				// Debug($_FILES);
				
				// while ($linha = fgetcsv($file, 0, ';', '"')){
					// $linha = fgetcsv($file, 0, ';', '"');
					
					// if(is_array($linha)){
						// $registro[] = array_combine($cabecalho, $linha);
					// }
					
				// }
			// }else{
				// echo "<br>";
				// Erro("Arquivo não esta no formato correto, Arquivo deve ser csv separdo por ; !", ERRO);
			// }
		}
	}
	
	//Debug($registro = (object) $registro);
	
	// if(!empty($registro)){
		// Debug($registro);
		// $Import = new Import_($registro, $_POST['Carteira'], $_POST['Layout'], $_FILES['File']['name'] );
		
		// $Import->ProcImport();
	// }
	
	echo "<p class='card-text'>Tempo de processamento: ".ToHora(time() - $_SERVER['REQUEST_TIME'])."</p>";
	
?>

<script>
    //código usando DOM (JS Puro)
    document.addEventListener("DOMContentLoaded", function(event) { 
		var estilo = document.getElementsByClassName('load');
		estilo[0].style.visibility = "hidden";
	 });
 </script>
 
 
<?php
	
	$Read = new Read;
	$Email = new Email;
	
	
	if(!empty($_POST['Enviar'])){
		$_POST['email'] = explode(";", $_POST['email']);
		$Email->Enviar($_POST['email'], "Relatório Analise Mailing", "Segue anexo o relatório solicitado", $_POST['Enviar']);
		echo (!empty($Email->GetResult())) ? $Email->GetResult() : "Email enviado com sucesso";
	
	}else if(!empty($_POST['Carteira'])){
		$Query = "
			SELECT
				Nome_Pes,
				CpfCnpj_Pes,
				ArqInc_Ficha,
				DtUltAcio_Ficha,
				DtProxAcio_Ficha,
				UltTab_Ficha,
				COUNT(DISTINCT Id_hist) as Tabulacoes,
				SUM(CASE WHEN Origem_tab = 'Operador' THEN 1 ELSE 0 END) AS 'TabOperador',
				SUM(CASE WHEN Origem_tab = 'Discador' THEN 1 ELSE 0 END) AS 'TabDiscador',
				SUM(sucesso_tab) as Sucesso,
				SUM(Cpc_tab) As Cpc
			FROM
				fichas INNER JOIN Pessoas ON IdPes_Ficha = Id_Pes
				LEFT JOIN Historico ON Id_Pes = IdPes_hist AND Id_Ficha = idficha_hist AND idtab_hist != 0
				LEFT JOIN tabulacao ON IdTab_hist = id_tab 
			WHERE
				IdCart_Ficha = {$_POST['Carteira']}			
			GROUP BY
				Nome_Pes,
				CpfCnpj_Pes,
				ArqInc_Ficha,
				DtUltAcio_Ficha,
				DtProxAcio_Ficha,
				UltTab_Ficha
			";
		
		$Read->FullRead($Query);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		//$Tabela = "<table class='table table-sm table-bordered'>";
		$Arq = "AnaliseMailing".date("YmdHis").".csv";
		$from = fopen($Arq, 'w+');
		
		
		$THead = "\"Nome\";\"Cpf / Cnpj\";\"Mailing\";\"Data Ult Acionamento\";\"Data Prox Acionamento\";\"Ult Tabulacao\";\"Qtd Tabulacoes\";\"Tab Operador\";\"Tab Discador\";\"Sucesso\";\"Cpc\"";
		
		fwrite($from, $THead.PHP_EOL);
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				fwrite($from, '"'.implode('";"',  $Value).'"'.PHP_EOL);
				// $TBody .= $Value['Nome_Pes'].";";
				// $TBody .= $Value['CpfCnpj_Pes'].";";
				// $TBody .= $Value['ArqInc_Ficha'].";";
				// $TBody .= str_replace(".000", "", $Check->Data($Value['DtUltAcio_Ficha'])).";";
				// $TBody .= str_replace(".000", "", $Check->Data($Value['DtProxAcio_Ficha'])).";";
				// $TBody .= (!empty($Value['UltTab_Ficha'])) ? $Value['UltTab_Ficha'].";" : "(Virgem);";
				// $TBody .= $Value['Tabulacoes'].";";
				// $TBody .= $Value['TabOperador'].";";
				// $TBody .= $Value['TabDiscador'].";";
				// $TBody .= (!empty($Value['Sucesso'])) ? $Value['Sucesso'].";" : "0;";
				// $TBody .= (!empty($Value['Cpc'])) ? $Value['Cpc'].";" : "0;";
				// $TBody .= "\r\n";
			}
		}

		// $Tabela = $THead.$TBody;
	
		fclose($from);
	}
	
	$Read->ExeRead('carteira');
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h4>Relatório de Analise de Mailing</h4>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Carteiras</label>
				<select class='form-control' name='Carteira' required>
					<option selected disabled value=0 >Selecione</option>
					<?php
						if(!empty($Carteiras)){
							foreach($Carteiras as $Value){
								$Selected = (!empty($_POST['Carteira']) AND $_POST['Carteira'] == $Value['Id_Cart']) ? 'selected' : '';
								if($_SESSION['Usuario']['Nivel_user'] != '5'){
									echo "<option $Selected value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
								}else if($Value['Id_Cart'] == 21){
									echo "<option $Selected value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
								}
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label class='text-white'>.</label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body'>
		<form method='POST'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm '>
					<input type='email' class="form-control"  name='email' placeholder='Digite seu email para receber o relatório'>
				</div>
				
				<div class='form-group col-sm-3'>
					<button class='btn btn-primary form-control ml-2 mr-2 col-sm' type="submit" name="Enviar" value="<?php echo $Arq?>"><span class="oi oi-document"></span> Enviar</button>
				</div>
			</div>
		</form>
	</div>
</div>
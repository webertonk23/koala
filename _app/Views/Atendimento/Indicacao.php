<?php
	$Check = new Check;
	$Read = new Read;
	$Create = new Create;
	
	
	if(!empty($_POST['CpfCnpj_Pes']) AND !empty($_POST['Nome_Pes'])){
	
		$Pessoa['Nome_Pes'] = $Check->Name($_POST['Nome_Pes']);
		$Pessoa['CpfCnpj_Pes'] = $Check->CpfCnpj($_POST['CpfCnpj_Pes']);
		$Pessoa['tipo_Pes'] = $Check->ValidaTipoPessoa($_POST['CpfCnpj_Pes']);
		$Pessoa['Sexo_Pes'] = $Check->Name($_POST['Sexo_Pes']);
		$Pessoa['DtNasc_Pes'] = $_POST['DtNasc_pes'];
		
		$Read->ExeRead("pessoas", "WHERE cpfcnpj_pes = :cpf", "cpf={$Pessoa['CpfCnpj_Pes']}");
		
		if($Read->GetRowCount() > 0){
			$Fichas['idpes_ficha'] = $Read->GetResult()[0]['Id_Pes'];
		}else{
			$Create->ExeCreate("Pessoas", $Pessoa);
			$Fichas['idpes_ficha'] = $Create->GetResult();
		}
		
		$Fichas['Contrato_ficha'] = $_POST['Contrato_ficha'];
		$Fichas['idcart_ficha'] = $_POST['Id_Cart'];
		$Fichas['arqinc_ficha'] = 'Indicacao';
		
		if(!empty($Fichas['idpes_ficha'])){
			$Read->ExeRead(
				"fichas",
				"WHERE contrato_ficha = :contrato AND idpes_ficha = :idpes AND idcart_ficha = :idcart",
				"contrato={$Fichas['Contrato_ficha']}&idpes={$Fichas['idpes_ficha']}&idcart={$Fichas['idcart_ficha']}"
			);
			
			if(empty($Read->GetResult())){
				$Create->ExeCreate("fichas", $Fichas);
				$Fichas['id_ficha'] = $Create->GetResult();
			}else{
				$Fichas['id_ficha'] = $Read->GetResult()[0]['Id_Ficha'];
			}
		}
		
		echo "<script> window.location.replace('?p=Atendimento/Acionamento&Id=".$Fichas['idpes_ficha']."-".$Fichas['id_ficha']."&Tipo=I') </script>";
	}
	
	$Read->ExeRead("carteira", "WHERE Ativo_cart = 1", "");
	$Carteiras = $Read->GetResult();

?>

<div class="card mb-3">
	<form method='POST'>
		<div class="card-body">
			<h4>Indicação</h4>

			<div class="form-row my-3">
				<div class="form-goup col-sm">
					<label for="Nome">Nome Completo</label>
					<input type="text" class="form-control" Name="Nome_Pes" placeholder="Nome Completo" >
				</div>
			
				<div class="form-goup col-sm">
					<label for="CpfCnpj">CPF / CNPJ</label>
					<input type="text" class="form-control" Name='CpfCnpj_Pes' placeholder="CPF / CNPJ (Apenas Números)" >
				</div>
			</div>
			
			<div class='form-row'>
				<div class="form-group col-sm-4">
					<label>Contrato</label>
					<input type='text' class="form-control" name='Contrato_ficha'>
				</div>
				
				<div class="form-group col-sm">
					<label>Data Nascimento</label>
					<input type='date' class="form-control" name='DtNasc_pes'>
				</div>
				
				<div class="form-group col-sm">
					<label>Sexo</label>
					<select class="form-control" name='Sexo_Pes'>
						<option value='F'>Feminino</option>
						<option Value='M'>Masculino</option>
					</select>
				</div>
				
				<div class="form-group col-sm">
					<label>Carteira</label>
					<select class="form-control" name='Id_Cart'>
						<?php
							if(!empty($Carteiras)){
								foreach($Carteiras as $V){
									echo "<option value='{$V['Id_Cart']}'>{$V['Desc_Cart']}</option>";
								}
							}
						?>
					</select>
				</div>				
			</div>
			
			<div class='form-row'>
				<input class='form-control btn btn-success' type='submit' value='salvar'>
			
			</div>
		</div>
	</form>
</div>
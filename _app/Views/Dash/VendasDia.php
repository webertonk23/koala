<?php

	$Read = new Read;
	$Read->FullRead("SELECT * FROM usuarios WHERE nivel_user = 2 AND ativo_user = 1");
	if($Read->GetRowCount()>0){
		$Sup = $Read->GetResult();
	}
	
	$Read = new Read;
	$Read->ExeRead("equipe");
	if($Read->GetRowCount()>0){
		$Eq = $Read->GetResult();
	}

?>
	<form  method='POST'>
		<h4>Vendas por Operador por dia</h4>
		<div class='form-row mb-2'>
			<div class='form-group mr-2'>
				<label>Supervisor</label>
				<select class='form-control col-sm' name='Supervisor' Id='Supervisor'>
					<option value='0'>Todos</option>
					<?php
						if(!empty($Sup)){
							foreach($Sup as $Value){
								$Selected = (!empty($_POST['Supervisor']) AND $_POST['Supervisor'] == $Value['Id_user']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id_user']}'>{$Value['Nome_user']}</option>";
							}
						}
					?>
				</select>
			</div>

			<div class='form-group '>
				<label>Equipe</label>
				<select class='form-control col-sm' name='Equipe' Id='Equipe'>
					<option value='0'>Todos</option>
					<?php
						if(!empty($Eq)){
							
							
							foreach($Eq as $Value){
								$Selected = (!empty($_POST['Equipe']) AND $_POST['Equipe'] == $Value['id_prod']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['id_equipe']}'>{$Value['desc_equipe']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group'>
				<label class=''>Recarrega em:<span id="Time"> 0:00:00</span></label>
				<input class='btn btn-primary form-control ml-2 mr-2 col-sm' type="button" name="btnPesquisar" value="Exibir" onclick="getDados();"/>
			</div>
			
			<div class='form-group mx-2'>
				<label class='' id="Resultado"></label>
				<button class='btn btn-primary form-control ml-2 mr-2 col-sm' type="button" name="Ext" value="" onclick="PostExt();" >
					<span class='fa fa-file-excel-o'></span>
				</button>
			</div>
		</div>
	</form>
	
	<div class='' id='TabVendas'></div>
	
	
	
	<script type="text/javascript" src="./js/VendasDia.js"></script>
	<script type="text/javascript" src="./js/Export.js"></script>
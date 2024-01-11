<?php

	$Read = new Read;
	$Read->ExeRead("Produto");
	if($Read->GetRowCount()>0){
		$Prod = $Read->GetResult();
	}

?>

	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/charts.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
	<script src="https://www.amcharts.com/lib/4/maps.js"></script>
	<script src="https://www.amcharts.com/lib/4/geodata/data/countries2.js"></script>
	
	<form  method='POST'>
		<h4>Perfil de vendas</h4>
		<div class='form-row mb-2'>
			<div class='form-group '>
				<label>Produto</label>
				<select class='form-control col-sm' name='Produto' Id='Produto'>
					<option value='0'>Todos</option>
					<?php
						if(!empty($Prod)){
							foreach($Prod as $Value){
								$Selected = (!empty($_POST['Produto']) AND $_POST['Produto'] == $Value['id_prod']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['id_prod']}'>{$Value['desc_prod']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group ml-2'>
				<label>De</label>
				<input class='form-control' type='date' name='DataDe' id='DataDe' value='<?php echo date("Y-m-d")?>'>
			</div>
			
			<div class='form-group ml-2'>
				<label>Até</label>
				<input class='form-control' type='date' name='DataAte' id='DataAte' value='<?php echo date("Y-m-d")?>'>
			</div>
			
			<div class='form-group mr-2'>
				<label class=''>Recarrega em:<span id="Time"> 0:00:00</span></label>
				<input class='btn btn-primary form-control ml-2 mr-2 col-sm' type="button" name="btnPesquisar" value="Exibir" onclick="getDados();"/>
			</div>
			
			<div class='col-sm-3' id="Resultado"></div>
		</div>
	</form>
	
	<div class='card-deck'>
		<div class='card'>
			<div class='card-header bg-white'><span>Por estado</span></div>
			<div class='card-body'  id='Uf' style='height: 90%;'></div>
		</div>
		<div class='col'>
			<div class='card'>
				<div class='card-header bg-white'><span>Por Sexo</span></div>
				<div class='card-body'  id='Sexo' style='height: 30%;'></div>
			</div>
			<div class='card mt-2'>
				<div class='card-header bg-white'><span>Por Idade</span></div>
				<div class='card-body'  id='Idade' style='height: 60%;'></div>			
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="./js/VendasPerfil.js"></script>
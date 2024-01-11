
<?php
	$Read = new Read;
	$Read->ExeRead('carteira');
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
?>
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/charts.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
	
	<form class='form-row mb-2' method='POST'>
		<select class='form-control col-sm' name='Carteira' Id='Carteira'>
			<option value='0' selected disabled >Selecione a carteira</option>
			<?php
				if(!empty($Carteiras)){
					foreach($Carteiras as $Value){
						$Selected = (!empty($_POST['Carteira']) AND $_POST['Carteira'] == $Value['Id_Cart']) ? 'selected' : '';
						echo "<option $Selected value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
					}
				}
			?>
		</select>
		
		<input class='btn btn-primary form-control ml-2 mr-2 col-sm' type="button" name="btnPesquisar" value="Exibir" onclick="getDados();"/>

		<div class='col-sm-3' id="Resultado"></div>
		<div class='col-sm-3'>Recarrega em:<span id="Time"> 0:00:00</span></div>
	</form>
	
	<div class='card-group mb-2'>
		<div class='card col-sm-3 mr-1 border-0'>
			<div class='card-body' id='Funil'></div>
		</div>
		
		<div class='card col-sm  mr-1 border-0' style='height: 576px; width: 100%;'>
			<div ><h4>Ocorrencias de Discador</h4></div>
			<div class='card-body' id='Discador' ></div>
		</div>
		
		<div class='card col-sm border-0' style='height: 576px; width: 100%;'>
			<div ><h4>Ocorrencias de Operador</h4></div>
			<div class='card-body' id='Operador' ></div>
		</div>
	</div>

	<script type="text/javascript" src="./js/atendimento.js"></script>



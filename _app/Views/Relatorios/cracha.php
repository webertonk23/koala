<?php
	
	$Read->FullRead("SELECT nomeCompleto, cpf, cargo, matricula, login FROM funcionarios WHERE Status != 'desligado' AND matricula > 0 ORDER BY matricula", " ");
	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}
	
	//ob_start();
	
	if(!empty($Lista)){
		
?>
	<style>
		@media print {
			.pagebreak {
				clear: both;
				page-break-after: always;
			}
		}
		
		.back{
			background-image: url("./img/logo_asa_50.png");
			background-repeat: no-repeat;
		}
		
		.mold{
			width: 310px;
			height: 518px;
		}
	</style>

	<?php 
		$i = 1;
		foreach($Lista as $k => $v){
		
		$nome = explode(" ", $v['nomeCompleto']);
		
		$nome = $nome[0]." ".end($nome);
		
		if($i == 1) {
			echo "<div class='row pagebreak justify-content-md-center'>";
		}
	?>
	
	<div class='card-deck m-1'>
		<div class='card text-center m-1 border back mold' >
			<div class='card-body'>
				<br>
				<h4>
					<img src='./img/logo_asa.png'  width='50px' height='50px'/>
				</h4>
				
				<img class='border border-dark' src='./img/fotos/<?php echo $v['matricula']?>.jpeg' width='150px' height='200px' >
				
				<br>
				
				<div class='lead my-2 rounded-pill text-white' style="background-color: rgba(5, 36, 83, 1); white-space: nowrap;"><?php echo strtoupper(utf8_encode($nome))?></div>
				<div class='lead my-2 rounded-pill text-white' style="background-color: rgba(5, 36, 83, 1); white-space: nowrap;"><?php echo $v['cargo']?></div>
				
			</div>
		</div>
		
		<div class='card text-center m-1 border back mold' >
			<div class='card-body'>
				<h4>
					<img src='./img/logo_asa.png'  width='50px' height='50px'/>
					<div class='lead'>
						ASA COBRANCA LTDA<br>18.144.038/0001-01
					</div>
				</h4>
				
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				
				<div class='lead' style='white-space: nowrap;'><?php echo substr($v['cpf'], 0, 3).".".substr($v['cpf'], 3, 3).".".substr($v['cpf'], 6, 3)."-".substr($v['cpf'], 9, 2)?></div>
				<div class='lead'> <?php echo str_pad($v['matricula'], 4, "0", STR_PAD_LEFT)?></div>
				
			</div>
		</div>
	</div>
	<?php 
		if($i > 5) {
			echo "</div>";
			$i = 1;
		}else{
			$i++;
		}
	}
	
	?>

<?php
	}
	//ob_get_clean();
?>
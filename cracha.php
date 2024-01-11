<?php
	require('./_app/Config.inc.php');
	
	$Read = new Read;
	
	if(!empty($_GET['mat'])){
		$Read->FullRead("SELECT nomeCompleto, cpf, cargo, matricula, login FROM funcionarios WHERE Status = 'Ativo' AND matricula = {$_GET['mat']}", " ");
	}else{
		$Read->FullRead("SELECT nomeCompleto, cpf, cargo, matricula, login FROM funcionarios WHERE Status = 'Ativo' AND matricula > 0 ORDER BY matricula", " ");
	}
	
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
			background-size: 150%;
		}
		
		.bg-azul{
			color: #FFF;
			background-color: rgba(5, 36, 83, 1);
		}
		
		.text-center{
			text-align: center;
		}
		
		div{
			margin: 4px;
		}
		
		.rounded-pill {
			border-radius: 50rem !important;
		}
		
		.row {
		  display: -ms-flexbox;
		  display: flex;
		  -ms-flex-wrap: wrap;
		  flex-wrap: wrap;
		  /*margin-right: -15px;
		  margin-left: -15px;*/
		}
		
		.lead {
			font-size: 100%;
			font-weight: 300;
		}
		
		.border {
			border: 1px solid #dee2e6 !important;
			border-radius: 0.2rem !important;
		}
		
		.mold{
			width: 195px;
			height: 311px;
		}
	</style>

	<?php 
		$i = 1;
		foreach($Lista as $k => $v){
		
		$nome = explode(" ", $v['nomeCompleto']);
		
		$nome = $nome[0]." ".end($nome);
		
		if($i == 1) {
			echo "<div class='pagebreak'>";
		}
	?>
	
	<div class='row '>
		<div class='text-center border back mold' >
			<br>
			<h4>
				<img src='./img/logo_asa.png'  width='30px' height='30px'/>
			</h4>
			
			<img class='' src='./img/fotos/<?php echo $v['matricula']?>.png' width='108px' height='133px' style='margin-bottom: 10px;'>
			
			
			<div class='bg-azul rounded-pill lead' ><?php echo strtoupper(utf8_encode($nome))?></div>
			<div class='bg-azul rounded-pill lead' ><?php echo $v['cargo']?></div>
			
		</div>
		
		<div class='text-center back mold border' >
			<br>
			<h4>
				<img src='./img/logo_asa.png'  width='30px' height='30px'/>
				<div class='lead'>
					<small>ASA COBRANCA LTDA</small><br>18.144.038/0001-01
				</div>
			</h4>
			
			<br>
			<br>
			<br>
			<br>
			<br>
			
			<div class='lead' style='white-space: nowrap;'>CPF: <?php echo substr($v['cpf'], 0, 3).".".substr($v['cpf'], 3, 3).".".substr($v['cpf'], 6, 3)."-".substr($v['cpf'], 9, 2)?></div>
			<div class='lead'>MATRICULA: <?php echo str_pad($v['matricula'], 4, "0", STR_PAD_LEFT)?></div>
		</div>
	</div>
	<?php 
		if($i > 2) {
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
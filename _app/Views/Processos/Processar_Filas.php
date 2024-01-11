<?php
	$Read = new read();
	$Update = new Update;
	$ProcessarFila = new ProcessarFila;
	
	if(!empty($_POST['igSim'])){
		$Update->ExeUpdate("FilaDiscador", array('status_filad' => 'cancelled'), "WHERE status_filad IS NULL AND DescFila_filad = :fila", "fila={$_POST['igSim']}");
		if($Update->GetResult()){
			$Include = new Create();
			$Include->ExeCreate('log', array("texto_log" => "Usuario: {$_SESSION['Usuario']['Nome_user']} resetou a fila de id_discador: {$_POST['igSim']} iginorando seus retornos!"));
		
			echo "<script> window.location.replace('?p=Processos/Processar_Filas') </script>";
		
		}
	}
?>

<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Processar Filas</h3>
			<form class="form-inline" name="" method="POST">	
				<button class='btn btn-outline-primary mr-sm-2' role="button" title="" name='Processar'><span class="fa fa-cogs"></span> Processar</button>
			</form>
		</div>
	</div>

<?php
	
	if(isset($_POST['Processar'])){
		echo "<div class='card'><div class='card-body'>";
		$ProcessarFila->Proc();
		echo "<a href='?p=Processos/Processar_Filas'>Click para voltar...</a>";
		echo "</div></div>";
	}else{
		if(!empty($_POST['ig'])){
			Erro("Comfirmar esta ação iginora os retornos do discador.
				Esta ação desconsidera a renitencia, uma vez que os não foram lidos os retornos.
				<br><STRONG> PODE ACARRETAR EM LIGAÇÕES REPETIDAS PARA CLIENTES EM CURTOS INTERVALOS DE TEMPO</STRONG>
				<br> Tem certeza que desejá realizar esta ação?
				<form method='POST'>
					<div class='form-row'>
						<div class='form-group col-sm'>
							<button class='btn btn-danger col-sm-1' name='igSim' value='{$_POST['ig']}'>sim</button>
							<button class='btn btn-success col-sm-3'>NÃO</button>
						</div>
					</div>
				</form>
				",
				ALERTA
			);
		}
		
		$Read->FullRead("
			SELECT 
				Id_fila,
				Desc_fila,
				Seq_fila,
				COUNT(IdFila_ficha) as Qtd,
				SUM(CASE Final_ficha WHEN 1 THEN 1 ELSE 0 END) as Finalizadas,
				iddisc_fila,
				Disc = (SELECT COUNT(*) FROM FilaDiscador WHERE DescFila_filad = iddisc_fila AND Status_filad IS NULL)
			FROM
				fila LEFT JOIN fichas ON Id_fila = IdFila_ficha
			WHERE
				Ativo_fila = 1
			GROUP BY
				Id_fila, Desc_fila, Seq_fila, iddisc_fila
			ORDER BY
				Seq_fila ASC
		");

		if($Read->GetRowCount()>0){
			$Fila = $Read->GetResult();
		}

?>

	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm text-center'>
				<thead>
					<tr>
						<th>#Id</th>
						<th>Sequência</th>
						<th>Fila</th>
						<th>Qtd</th>
						<th>Finalizadas</th>
						<th>Aguardando Retorno</th>
						<!--<th>Ignorar Retorno</th>-->
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Fila)){
								foreach ($Fila as $key => $value){
									echo "<tr><td>".$value['Id_fila']."</td>";
									echo "<td>".$value['Seq_fila']."</td>";
									echo "<td>".$value['Desc_fila']."</td>";
									echo "<td>".number_format($value['Qtd'], 0, ',', '.')."</td>";
									echo "<td>".number_format($value['Finalizadas'], 0, ',', '.')."</td>";
									echo "<td>".number_format($value['Disc'], 0, ',', '.')."</td>";
									echo "</tr>";
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
	<?php } ?>
</div>

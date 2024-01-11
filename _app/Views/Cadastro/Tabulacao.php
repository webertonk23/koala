<?php
	$Read = new read();
	
	$Read->ExeRead('tabulacao', 'ORDER BY Tabulacao_tab ASC');
	if($Read->GetRowCount()>0){
		$Tabulacao = $Read->GetResult();
	}
	
?>
<div class="">
	<div class='card mb-2'>
		<div class='card-body'>
			<h3 class='card-title'>Tabulação</h3>
			<form class="form-inline" name="" method="POST">	
				<input class='form-control mr-sm-2 col-sm' type='search' name='Criterio' Placeholder='Bucar Tabulação'>
				<button class='btn btn-success mr-sm-2' role="button" title="" name='Buscar'><span class="fa fa-search"></span></button>
				<span class='mr-sm-2'>|</span>
				<a class='btn btn-primary' href='?p=Cadastro/Criar_tabulacao' role="button" title="Criar"><span class="fa fa-plus"></span></a>
			</form>
		</div>
	</div>
	
	<div class='card'>
		<div class='card-body'>
			<table class='table table-hover table-sm table-striped'>
				<thead>
					<tr >
						<th>#Id</th>
						<th>Tabulação</th>
						<th>Origem</th>
						<th class='text-center'>Agendamento (SEC)</th>
						<th>Ação</th>
					</tr>
				</thead>
				
				<tbody>
					<form method='POST'>
						<?php
							if(!empty($Tabulacao)){
								foreach ($Tabulacao as $key => $value){
									echo "<tr><td>".$value['Id_tab']."</td>";
									echo "<td>".$value['Tabulacao_tab']."</td>";
									echo "<td>".$value['Origem_tab']."</td>";
									echo "<td class='text-center'>".$value['Agendamento_tab']."</td>";
									echo "<td><a class='btn btn-info btn-sm' href='?p=Cadastro/Editar_Tabulacao&Id=".$value['Id_tab']."'><span class='fa fa-pencil-square-o'></span></button></td></tr>";
									
								}
							};	
						?>
					</form>
				</tbody>
			</table>
		</div>
	</div>
</div>

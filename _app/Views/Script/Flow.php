<?php
	
	$PostForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

	$Read = new read;
	
	$Read->ExeRead("Flow");

	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}
	
?>

<div class='card mb-2 text-center'>
	<div class='card-body'>
		<h3 class='card-title'>Flow</h3>
	</div>
</div>

<div class='card mb-2'>
	<div class='card-body'>
		<form class="form-inline" name="" method="POST">
			<a class="btn btn-outline-info mr-2" href='?p=<?php echo base64_encode('Flow/Conexao')?>' title="Buscar"><span class="fa fa-hdd-o"></span> Conexões</a>
			<a class="btn btn-outline-success mr-2" href="?p=<?php echo base64_encode('Flow/Criar_Flow'); ?>" role="button" title="Novo" ><span class="fa fa-sitemap"></span> Novo Fluxo</a>
			<a class="btn btn-outline-dark" href="?p=<?php echo base64_encode('Exec_Flow'); ?>" role="button" title="Novo" ><span class="fa fa-play"></span> Executar</a>
		</form>
	</div>
</div>

<div class='card col-sm'>
	<div class='card-body'>
		<table class='table table-hover table-sm table-responsive table-striped'>
			<thead class="thead-light">
				<tr>
					<th scope="col">#ID</th>
					<th scope="col">Descricão</th>
					<th scope="col">Rotina</th>
					<th scope="col">ult Execução</th>
					<th scope="col">Prox Execução</th>
					<th scope="col">Evento</th>
					<th scope="col">Ação</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					if(!empty($Lista)){		
						foreach ($Lista as $key => $value){
							echo "<tr >";
							echo "<td scope='row' >{$value['Id_Flow']}</td>";
							echo "<td>".$value['Descricao_Flow']."</td>";
							echo "<td>".$value['Rotina_Flow']."</td>";
							echo "<td>".$value['UltExec_Flow']."</td>";
							echo "<td>".$value['ProxExec_Flow']."</td>";
							echo "<td>".$value['Evento_Flow']."</td>";
							echo "<td>";
							echo "<a href='?p=".base64_encode("Cadastro/Editar_Pessoa")."&Id=".base64_encode($value['Id_Flow'])."' class='btn btn-outline-primary btn-sm mr-2' name='Editar' title='Editar'><span class='fa fa-pencil'></span></a>";
							echo "<a href='?p=Fichas/Remover&Id={$value['Id_Flow']}' class='btn btn-outline-danger btn-sm' name='Remover' title='Remover'><span class='fa fa-trash-o'></span></a>";
							echo "</td></tr>";
						}
					}else{
						Erro("Pesquisa não retornou resultados", INFO);
					}
				?>
				</form>
			</tbody>
		</table>
	</div>
</div>
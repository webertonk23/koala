<?php

	if(!empty($_GET['Id'])){
		$Id = base64_decode($_GET['Id']);
		
		$Read = new Read;
		$Query = "
			SELECT
				Nome_Av,
				NomeCompleto as Operador,
				MonitoriaRealizada.*,
				MonitoriaPerguntas.pergunta,
				CASE MonitoriaPerguntas.resposta when 1 then 'SIM' else 'NÃO' end as 'Resp Certa',
				CASE MonitoriaRespostas.resposta when 1 then 'SIM' else 'NÃO' end as 'Resp Feita'
			FROM
				MonitoriaRealizada LEFT JOIN Monitoria on MonitoriaRealizada.Id_Av = Monitoria.Id_Av
				INNER JOIN Funcionarios on Id_Func = funcionarios.Id
				INNER JOIN MonitoriaPerguntas ON Monitoria.Id_Av = MonitoriaPerguntas.Id_Avaliacao
				INNER JOIN MonitoriaRespostas ON MonitoriaRealizada.id_r = MonitoriaRespostas.id_realizado AND MonitoriaPerguntas.id_Itens = MonitoriaRespostas.id_pergunta
			WHERE Id_R = :Id_R";
		$Pleaces = "Id_R={$Id}";
	
		$Read->FullRead($Query, $Pleaces);
			
		$Avaliacao = ($Read->GetRowCount() > 0) ? $Read->GetResult() : Null;
		
		if(isset($_POST['Aplicar'])){
			$Update = new Update;
					$Dados['Feedback'] = 1;
					$Update->ExeUpdate('MonitoriaRealizada', $Dados, "WHERE Id_R = :Id_R", "Id_R={$Id}");
					
					Erro("Confirmado com sucesso!", SUCESSO);
		}
	}
	
?>

<div class='card col mb-2'>
	<form method='POST'>
		<div class='card-body'>
			<button id="btn" class='btn'><span class="fa fa-print"></span> Imprimir</button>
			<button id="" type='submit' class='btn btn-success' name='Aplicar'><span class="oi oi-check"></span>Aplicar Feedback</button>
			<a href='?p=<?php echo base64_encode("Monitoria"); ?>' class='btn btn-danger-outline' name='Voltar'>Voltar</a>
		</div>
	</form>
</div>

<div class='card col mb-2' id='Imprimir'>
	<div class='card_body'>
		<br>
		<h4 class='card-title'>Feedback de monitoria <?php echo ($Avaliacao[0]['Feedback'] == 1) ? " - Aplicado" : "" ?></h4>
		<hr>
		<table class='table border-0'>
			<tr>
				<th>Avaliação</th>
				<td><?php echo $Avaliacao[0]['Nome_Av'] ?></td>				
				<th>Data: </th>
				<td><?php echo date("d/m/Y", strtotime($Avaliacao[0]['Data'])) ?></td>
				<th>Id Chamada: </th>
				<td><?php echo $Avaliacao[0]['Id_Chamada'] ?></td>
			</tr>
			
			<tr>
				<th>Operador:</th>
				<td><?php echo $Avaliacao[0]['Operador'] ?></td>
				<th>Avaliador:</th>
				<td><?php echo $Avaliacao[0]['Avaliador'] ?></td>
				<th>Nota:</th>
				<td><?php echo number_format($Avaliacao[0]['Nota'], 2, ',', '') ?>%</td>
			</tr>
		</table>
		
		<hr>
		
		<div class='form-group row'>
			<div class='col-sm'>
				<label><b>Obs:</b></label>
				<span>
					<?php echo ($Avaliacao[0]['Obs']); ?>
				</span>
			</div>
		</div>
		
		<hr>
		
		<table class='table table-hover table-condensed table-striped'>
			<thead>
				<tr>
					<th class=''>Pergunta</th>
					<th class=''>Resp Certa</th>
					<th class=''>Resp Feita</th>				
				</tr>
			</thead>
			
			<tbody>
				<?php
					foreach ($Avaliacao as $key => $value){
						echo "</tr><td>{$value['pergunta']}</td>";
						echo "<td>{$value['Resp Certa']}</td>";
						echo "<td>{$value['Resp Feita']}</td>";
						$v = ($value['Resp Certa'] == $value['Resp Feita']) ? '&#10004;' : 'X';
						echo "<td>$v</td></tr>";
					}
				?>
			</tbody>
		</table>
		
		<hr>
		
		<div class='text-center' style='text-align: center;'>
			<br>
			Local: <u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u>
			<u>&ensp;&ensp;&ensp;/&ensp;&ensp;&ensp;/&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u> <br><br>
			 <u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u><br>
			<?php echo $Avaliacao[0]['Operador'] ?> <br><br>
			 <u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u><br>
			<?php echo $Avaliacao[0]['Avaliador'] ?>
		</div>
	</div>
</div>

<br>

<script>
	document.getElementById('btn').onclick = function() {
		var conteudo = document.getElementById('Imprimir').innerHTML,
		tela_impressao = window.open('about:blank');
		tela_impressao.document.write(conteudo);
		tela_impressao.window.print();
		tela_impressao.window.close();
	};
</script>
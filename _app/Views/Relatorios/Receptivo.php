<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		$Query = "Select receptivo.*, tabulacao.Tabulacao, produtos.Produto, obs, data, DataAgenda, Usuarios.nome As Usuario, Nome_Grupo, Obs From Receptivo LEFT JOIN produtos ON Receptivo.IdProduto = produtos.Id LEFT JOIN Usuarios ON Receptivo.IdUsuario = usuarios.Id LEFT JOIN Tabulacao ON Receptivo.IdTabulacao = Tabulacao.Id LEFT  JOIN Grupo_Tabulacao ON tabulacao.id_Grupo = Grupo_Tabulacao.id";
		
		$Termos = ($_POST['Criterio'] == 'Oco') ? " WHERE Receptivo.Data BETWEEN :DataDe AND :DataAte" : " WHERE Receptivo.DataAgenda BETWEEN :DataDe AND :DataAte";
		
		$_POST['DataDe'] = ($_POST['Criterio'] == 'Oco') ? $_POST['DataDe'].' 00:00:00' : $_POST['DataDe'];
		$_POST['DataAte'] = ($_POST['Criterio'] == 'Oco') ? $_POST['DataAte'].' 23:59:59' : $_POST['DataAte'];
		
		$Places = "DataDe={$_POST['DataDe']}&DataAte={$_POST['DataAte']}";
		
		$Query .= $Termos;
		
		$Read->FullRead($Query, $Places);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		$Tabela = "<table class='table'>";
		
		$THead = "<thead><tr><th>Telefone</th><th>Nome</th><th>Data</th><th>Produto</th><th>Tabulacao</th><th>Data Agenda</th><th>Operador</th><th>Obs</th></tr></thead>";
		
		$TBody = "<tbody><tr class='align-middle'>";
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				$TBody .= "<td>".$Value['Telefone']."</td>";
				$TBody .= "<td>{$Value['Nome']}</td>";
				$TBody .= "<td>".date('d/m/Y H:i:s', strtotime($Value['Data']))."</td>";
				$TBody .= "<td>{$Value['Produto']}</td>";
				$TBody .= "<td>{$Value['Nome_Grupo']} - {$Value['Tabulacao']}</td>";
				$TBody .= ($Value['DataAgenda'] != NULL) ? "<td>".$Check->Data($Value['DataAgenda'])."</td>" : "<td></td>";
				$TBody .= "<td>{$Value['Usuario']}</td>";
				$TBody .= "<td>{$Value['Obs']}</td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	}
	
	$Read->ExeRead('carteira', "WHERE perfil='Agenda'");
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
	
	$Read->FullRead('SELECT Produtos.Id, Produtos.Produto, Carteira.Carteira FROM Produtos LEFT JOIN Carteira ON Produtos.id_Carteira = Carteira.id');
	if($Read->GetRowCount()>0){
		$Produtos = $Read->GetResult();
	}

?>

<h4>Relatório de Agendamentos</h4>

<div class='card mb-2'>
	<div class='card-body'>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Critério</label>
				<div class="form-check">
					<label class="form-check-label" for="exampleRadios1">
						<input class="form-check-input" type="radio" name="Criterio" value="Oco" checked>
						Data Ocorrência
					</label>
				</div>
				<div class="form-check">
					<label class="form-check-label">
						<input class="form-check-input" type="radio" name="Criterio" value="Age">
						Data Agenda
					</label>
				</div>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='DataDe' required value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='DataAte' required value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '';?>'>
			</div>

			<div class='form-group col-sm'>
				<label></label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<?php if(!empty($Tabela)){ ?>
		<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Relatorio_de_Agendamentos'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Período de: </label>
					<span><?php echo $Check->Data($_POST['DataDe'])?></span>
					<label class='font-weight-bold'>Até: </label>
					<span><?php echo $Check->Data($_POST['DataAte'])?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo (!empty($Lista)) ? Count($Lista) : 0;?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
					<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
				</div>
			</div>
		</form>
		
		
		<?php
			echo $Tabela;
		}
		?>
	</div>
</div>
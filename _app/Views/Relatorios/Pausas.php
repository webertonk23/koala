<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		$Query = "Select Nome, Pausa1, Pausa2, Pausa3 From Usuarios ";
		
		$Termos = "WHERE";
		
		$Places = "DataDe={$_POST['DataDe']}&DataAte={$_POST['DataAte']}";
		
		if($_POST['Carteira'] != 0){
			$Termos .= " AND Produtos.Id_Carteira = :Id_Carteira";
			$Places .= "&Id_Carteira={$_POST['Carteira']}";
		}
		
		$Query .= $Termos;
		
		$Read->FullRead($Query, $Places);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		$Tabela = "<table class='table'>";
		
		$THead = "<thead><tr><th>ID</th><th>Data</th><th>Cliente</th><th>CPF / CNPJ</th><th>Produto</th><th>Operador</th><th>Valor</th></tr></thead>";
		
		$TBody = "<tbody><tr class='align-middle'>";
		
		$VTotal = 0;
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				
				$VTotal += $Value['Valor'];
				
				$TBody .= "<td>".$Value['Id']."</td>";
				$TBody .= "<td>".$Check->Data($Value['Data'])."</td>";
				$TBody .= "<td>{$Value['Cliente']}</td>";
				$TBody .= "<td>&nbsp;{$Value['CpfCnpj']}</td>";
				$TBody .= "<td>{$Value['Produto']}</td>";
				$TBody .= "<td>{$Value['Operador']}</td>";
				$TBody .= "<td>".number_format($Value['Valor'], 2, ',', '.')."</td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	}
	
	$Read->ExeRead('carteira', "WHERE perfil='Vendas'");
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
	
	$Read->FullRead('SELECT Produtos.Id, Produtos.Produto, Carteira.Carteira FROM Produtos LEFT JOIN Carteira ON Produtos.id_Carteira = Carteira.id');
	if($Read->GetRowCount()>0){
		$Produtos = $Read->GetResult();
	}

?>
<h4>Relatório de Vendas</h4>

<div class='card mb-2'>
	<div class='card-body'>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='DataDe' required value='<?php echo (!empty($_POST['DataDe'])) ? $_POST['DataDe'] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='DataAte' required value='<?php echo (!empty($_POST['DataAte'])) ? $_POST['DataAte'] : '';?>'>
			</div>
		
			<div class='form-group col-sm'>
				<label>Carteiras</label>
				<select class='form-control' name='Carteira'>
					<option value='0' <?php echo (!empty($_POST['Carteira']) AND $_POST['Carteira'] == 0) ? 'selected' : '';?> >Todas</option>
					<?php
						if(!empty($Carteiras)){
							foreach($Carteiras as $Value){
								$Selected = (!empty($_POST['Carteira']) AND $_POST['Carteira'] == $Value['Id']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id']}'>{$Value['Carteira']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Produto</label>
				<select class='form-control' name='Produto'>
					<option value='0' <?php echo (!empty($_POST['Produto']) AND $_POST['Produto'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!empty($Produtos)){
							foreach($Produtos as $Value){
								$Selected = (!empty($_POST['Produto']) AND $_POST['Produto'] == $Value['Id']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id']}'>{$Value['Carteira']} -> {$Value['Produto']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label> </label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<?php if(!empty($Tabela)){ ?>
		<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Relatorio_de_Vendas'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Período de: </label>
					<span><?php echo $Check->Data($_POST['DataDe'])?></span>
					<label class='font-weight-bold'>Até: </label>
					<span><?php echo $Check->Data($_POST['DataAte'])?></span>
				</div>
				
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo (!empty($Lista)) ? Count($Lista) : 0;?></span>
				</div>
				
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Valor Total: </label>
					<span><?php echo number_format($VTotal, 2, ',', '.');?></span>
				</div>
				
				<div class='form-group col-sm'>
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
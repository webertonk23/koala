<?php
	$Read = new Read;
	
	$Produtos = new Produtos;	
	$Produtos->Listar();
	
	$Carteira = new Carteira;	
	$Carteira->Listar();
	
	$Vendas = new Vendas;
	
	if(!empty($_POST)){
		$Vendas->Listar($_POST);
		
		if(!$Vendas->GetErro()){
			$Listar = $Vendas->GetResult();
		}else{
			Erro($Vendas->GetErro()[0], $Vendas->GetErro()[1]);
		}
	}
	
	$Tabela = "<table class='table'>";
		
	$THead = "<thead><tr><th>Data</th><th>Cliente</th><th>CPF / CNPJ</th><th>Carteira</th><th>Nº Venda</th><th>Produto</th><th>Usuario</th><th>Valor</th><th>Status</th></tr></thead>";
	
	$TBody = "<tbody><tr class='align-middle'>";
	
	$VTotal = 0;
	if(!empty($Listar)){
		foreach($Listar as $Key => $Value){
			
			$VTotal += $Value['valor_venda'];
			
			$TBody .= "<td>".explode('.', $Check->Data($Value['dtvenda_venda']))[0]."</td>";
			$TBody .= "<td>{$Value['Nome_Pes']}</td>";
			$TBody .= "<td>&nbsp;{$Value['Cpfcnpj_pes']}</td>";
			$TBody .= "<td>{$Value['Desc_Cart']}</td>";
			$TBody .= "<td>{$Value['numero_venda']}</td>";
			$TBody .= "<td>{$Value['desc_prod']}</td>";
			$TBody .= "<td>{$Value['Nome_user']}</td>";
			$TBody .= "<td>".number_format($Value['valor_venda'], 2, ',', '.')."</td>";
			$TBody .= "<td>".$Value['status_venda']."</td></tr>";
		}
	}

	$Tabela .= $THead.$TBody."</tbody></table>";

?>


<div class='card mb-2'>
	<div class='card-body'>
		<h4>Relatório de Vendas</h4>
		<form class='form-row' method='POST'>
			<div class='form-group col-sm'>
				<label>Data Ate:</label>
				<input class='form-control' type='date' name='Data[]' required value='<?php echo (!empty($_POST['Data'][0])) ? $_POST['Data'][0] : '';?>'>
			</div>
			
			<div class='form-group col-sm'>
				<label>Data Até:</label>
				<input class='form-control' type='date' name='Data[]' required value='<?php echo (!empty($_POST['Data'][1])) ? $_POST['Data'][1] : '';?>'>
			</div>
		
			<div class='form-group col-sm'>
				<label>Carteiras</label>
				<select class='form-control' name='Id_Cart'>
					<option value='0' <?php echo (!empty($_POST['Id_Cart']) AND $_POST['Id_Cart'] == 0) ? 'selected' : '';?> >Todas</option>
					<?php
						if(!$Carteira->GetErro()){
							foreach($Carteira->GetResult() as $Value){
								$Selected = (!empty($_POST['Id_Cart']) AND $_POST['Id_Cart'] == $Value['Id_Cart']) ? 'selected' : '';
								echo "<option {$Selected} value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Produto</label>
				<select class='form-control' name='Id_prod'>
					<option value='0' <?php echo (!empty($_POST['Id_prod']) AND $_POST['Id_prod'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!$Produtos->GetErro()){
							foreach($Produtos->GetResult() as $Value){
								$Selected = (!empty($_POST['Id_prod']) AND $_POST['Id_prod'] == $Value['Id_prod']) ? 'selected' : '';
								echo "<option {$Selected} value='{$Value['id_prod']}'>{$Value['desc_prod']}</option>";
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
					<span><?php echo (!empty($_POST['Data'][0])) ? date("d/m/Y", strtotime($_POST['Data'][0])) : "00/00/0000"?></span>
					<label class='font-weight-bold'>Até: </label>
					<span><?php echo (!empty($_POST['Data'][1])) ? date("d/m/Y", strtotime($_POST['Data'][1])) : "00/00/0000"?></span>
				</div>
				
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo (!empty($Listar)) ? Count($Listar) : 0;?></span>
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
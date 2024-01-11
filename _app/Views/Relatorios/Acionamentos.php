<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		$Query = "SELECT usuarios.Nome_user, historico.*, tabulacao.*, pessoas.*, telefones.* FROM Historico WITH (NOLOCK) INNER JOIN tabulacao ON idtab_hist = id_tab INNER JOIN usuarios on IdUser_hist = Id_user LEFT JOIN fichas ON idficha_hist = id_ficha INNER JOIN pessoas ON idpes_hist = id_pes LEFT JOIN telefones ON idtel_hist = id_tel LEFT JOIN funcionarios ON nome_user = nomecompleto ";
		
		$Termos = "WHERE DtOco_hist BETWEEN '{$_POST['DataDe']} 00:00:00' AND '{$_POST['DataAte']} 23:59:59' AND Origem_tab = 'Operador'";
		
		if($_POST['Carteira'] != 0){
			$Termos .= " AND IdCart_ficha = {$_POST['Carteira']}";
		}
		
		if($_POST['Operador'] != 0){
			$Termos .= " AND iduser_hist = {$_POST['Operador']}";
		}
		
		if($_POST['Operador'] != 0){
			$Termos .= " AND iduser_hist = {$_POST['Operador']}";
		}
		
		if($_POST["Produto"] != '0'){
			$Termos .= " AND Produto = '{$_POST['Produto']}'";
		}
		
		if($_POST['SubProduto'] != '0'){
			$Termos .= " AND SubProduto = '{$_POST['SubProduto']}'";
		}
		
		
		
		$Query .= $Termos;
		//echo $Query;
		$Read->FullRead($Query);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		$Tabela = "<table class='table table-sm table-bordered'>";
		
		$THead = "<thead><tr><th>Nome</th><th>Cpf / Cnpj</th><th>Data</th><th>Tabulacao</th><th>Obs</th><th>Fone</th><th>Operador</th><th>IdDicador</th></tr></thead>";
		
		$TBody = "<tbody><tr>";
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				$TBody .= "<td>".$Value['Nome_Pes']."</td>";
				$TBody .= "<td>".$Value['CpfCnpj_Pes']."</td>";
				$TBody .= "<td>".str_replace(".000", "", $Check->Data($Value['DtOco_hist']))."</td>";
				$TBody .= "<td>{$Value['Tabulacao_tab']}</td>";
				$TBody .= "<td>{$Value['Obs_hist']}</td>";
				$TBody .= "<td>({$Value['ddd_tel']}){$Value['Telefone_tel']}</td>";
				$TBody .= "<td>{$Value['Nome_user']}</td>";
				$TBody .= "<td>{$Value['IdDiscFila_hist']}</td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	}
	
	$Read->ExeRead('carteira');
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}
	
	$Read->ExeRead('Usuarios', "WHERE Nivel_user = 1");
	if($Read->GetRowCount()>0){
		$Operador = $Read->GetResult();
	}
	
	$Read->FullRead("SELECT DISTINCT produto FROM Funcionarios WHERE status = 'ativo'","");
	if($Read->GetRowCount()>0){
		$Produto = $Read->GetResult();
	}
	
	$Read->FullRead("SELECT DISTINCT subproduto FROM Funcionarios WHERE status = 'ativo'","");
	if($Read->GetRowCount()>0){
		$SubProduto = $Read->GetResult();
	}
?>

<div class='card mb-2'>
	<div class='card-body'>
		<h4>Relatório de Acionamentos de operador</h4>
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
								$Selected = (!empty($_POST['Carteira']) AND $_POST['Carteira'] == $Value['Id_Cart']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id_Cart']}'>{$Value['Desc_Cart']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Produto do func</label>
				<select class='form-control' name='Produto'>
					<option value='0' <?php echo (!empty($_POST['Produto']) AND $_POST['Produto'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!empty($Produto)){
							foreach($Produto as $Value){
								$Selected = (!empty($_POST['Produto']) AND $_POST['Produto'] == $Value['produto']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['produto']}'>{$Value['produto']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Sub Produto do func</label>
				<select class='form-control' name='SubProduto'>
					<option value='0' <?php echo (!empty($_POST['SubProduto']) AND $_POST['SubProduto'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!empty($SubProduto)){
							foreach($SubProduto as $Value){
								$Selected = (!empty($_POST['SubProduto']) AND $_POST['SubProduto'] == $Value['subproduto']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['subproduto']}'>{$Value['subproduto']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Operador</label>
				<select class='form-control' name='Operador'>
					<option value='0' <?php echo (!empty($_POST['Operador']) AND $_POST['Operador'] == 0) ? 'selected' : '';?> >Todos</option>
					<?php
						if(!empty($Operador)){
							foreach($Operador as $Value){
								$Selected = (!empty($_POST['Operador']) AND $_POST['Operador'] == $Value['Id_User']) ? 'selected' : '';
								echo "<option $Selected value='{$Value['Id_user']}'>{$Value['Nome_user']}</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label class='text-white'>.</label>
				<button class='form-control btn btn-primary' name='Aplicar'>Aplicar</button>
			</div>
		</form>
	</div>
</div>
	
<div class='card'>
	<div class='card-body' id='Tabela'>
		<?php if(!empty($Tabela)){ ?>
		<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Relatorio_de_Acionamentos'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Período de: </label>
					<span><?php echo $Check->Data($_POST['DataDe'])?></span>
				</div>	
				
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Período Até: </label>
					<span><?php echo $Check->Data($_POST['DataAte'])?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo number_format((!empty($Lista)) ? Count($Lista) : 0, 0,',','.');?></span>
				</div>
				
				<div class='form-group col-sm-3'>
					<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
					<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
				</div>
			</div>
		</form>
		
		<div class='table-responsive-xl'>
		<?php
			echo $Tabela;
		}
		?>
		</div>
	</div>
</div>
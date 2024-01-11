<?php
	$Read = new Read;
	
	if(!empty($_POST)){
		$Query = "
			SELECT DISTINCT fichas.Id, margem as Titulo, Nome, GROUP_CONCAT(fichas_fone.Fone) as 'Fones'
			FROM fichas INNER JOIN FICHAS_FONE ON fichas.id = fichas_fone.Id_Ficha
		";
		
		$Termos = "WHERE IdCarteira = :IdCarteira AND fichas_fone.Fone != -1";
		
		$Places = "IdCarteira={$_POST['Carteira']}";
		
		if($_POST['Acionado'] == 0){
			$Termos .= " AND UltTabulacao IS NULL";
		}
		
		if($_POST['Margem'] == 1){
			$Termos .= " AND Margem IS NOT NULL";
		}
		
		$Query .= $Termos . " GROUP BY fichas.Id ORDER BY Margem";
		
		$Read->FullRead($Query, $Places);
		if($Read->GetRowCount()>0){
			$Lista = $Read->GetResult();
		}
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Values){
				$Lista[$Key]['Tel1'] = (!empty(explode(',',$Values['Fones'])[0])) ? explode(',',$Values['Fones'])[0] : NULL;
				$Lista[$Key]['Tel2'] = (!empty(explode(',',$Values['Fones'])[1])) ? explode(',',$Values['Fones'])[1] : NULL;
				$Lista[$Key]['Tel3'] = (!empty(explode(',',$Values['Fones'])[2])) ? explode(',',$Values['Fones'])[2] : NULL;
				$Lista[$Key]['Tel4'] = (!empty(explode(',',$Values['Fones'])[3])) ? explode(',',$Values['Fones'])[3] : NULL;
				$Lista[$Key]['Tel5'] = (!empty(explode(',',$Values['Fones'])[4])) ? explode(',',$Values['Fones'])[4] : NULL;
				$Lista[$Key]['Tel6'] = (!empty(explode(',',$Values['Fones'])[5])) ? explode(',',$Values['Fones'])[5] : NULL;
				$Lista[$Key]['Tel7'] = (!empty(explode(',',$Values['Fones'])[6])) ? explode(',',$Values['Fones'])[6] : NULL;
				$Lista[$Key]['Tel8'] = (!empty(explode(',',$Values['Fones'])[7])) ? explode(',',$Values['Fones'])[7] : NULL;
				$Lista[$Key]['Tel9'] = (!empty(explode(',',$Values['Fones'])[8])) ? explode(',',$Values['Fones'])[8] : NULL;
				$Lista[$Key]['Tel10'] = (!empty(explode(',',$Values['Fones'])[9])) ? explode(',',$Values['Fones'])[9] : NULL;
				$Lista[$Key]['Tel11'] = (!empty(explode(',',$Values['Fones'])[10])) ? explode(',',$Values['Fones'])[10] : NULL;
				$Lista[$Key]['Tel12'] = (!empty(explode(',',$Values['Fones'])[11])) ? explode(',',$Values['Fones'])[11] : NULL;
				$Lista[$Key]['Tel13'] = (!empty(explode(',',$Values['Fones'])[12])) ? explode(',',$Values['Fones'])[12] : NULL;
				$Lista[$Key]['Tel14'] = (!empty(explode(',',$Values['Fones'])[13])) ? explode(',',$Values['Fones'])[13] : NULL;
				$Lista[$Key]['Tel15'] = (!empty(explode(',',$Values['Fones'])[14])) ? explode(',',$Values['Fones'])[14] : NULL;
				$Lista[$Key]['Tel16'] = (!empty(explode(',',$Values['Fones'])[15])) ? explode(',',$Values['Fones'])[15] : NULL;
				$Lista[$Key]['Tel17'] = (!empty(explode(',',$Values['Fones'])[16])) ? explode(',',$Values['Fones'])[16] : NULL;
				$Lista[$Key]['Tel18'] = (!empty(explode(',',$Values['Fones'])[17])) ? explode(',',$Values['Fones'])[17] : NULL;
				$Lista[$Key]['Tel19'] = (!empty(explode(',',$Values['Fones'])[18])) ? explode(',',$Values['Fones'])[18] : NULL;
				$Lista[$Key]['Tel20'] = (!empty(explode(',',$Values['Fones'])[19])) ? explode(',',$Values['Fones'])[19] : NULL;
			}
			unset($Lista['Fones']);
		}
		
		$Tabela = "<table class='table'>";
		
		$THead = "<thead>
					<tr>
						<th>Id</th>
						<th>Titulo</th>
						<th>Nome</th>
						<th>Tel1</th>
						<th>Tel2</th>
						<th>Tel3</th>
						<th>Tel4</th>
						<th>Tel5</th>
						<th>Tel6</th>
						<th>Tel7</th>
						<th>Tel8</th>
						<th>Tel9</th>
						<th>Tel10</th>
						<th>Tel11</th>
						<th>Tel12</th>
						<th>Tel13</th>
						<th>Tel14</th>
						<th>Tel15</th>
						<th>Tel16</th>
						<th>Tel17</th>
						<th>Tel18</th>
						<th>Tel19</th>
						<th>Tel20</th>
					</tr>
				</thead>";
		$TBody = "<tbody><tr class='align-middle'>";
		
		if(!empty($Lista)){
			foreach($Lista as $Key => $Value){
				
				$TBody .= "<td>{$Value['Id']}</td>";
				$TBody .= "<td>".number_format($Value['Titulo'],2,',','')."</td>";
				$TBody .= "<td>{$Value['Nome']}</td>";
				$TBody .= "<td>{$Value['Tel1']}</td>";
				$TBody .= "<td>{$Value['Tel2']}</td>";
				$TBody .= "<td>{$Value['Tel3']}</td>";
				$TBody .= "<td>{$Value['Tel4']}</td>";
				$TBody .= "<td>{$Value['Tel5']}</td>";
				$TBody .= "<td>{$Value['Tel6']}</td>";
				$TBody .= "<td>{$Value['Tel7']}</td>";
				$TBody .= "<td>{$Value['Tel8']}</td>";
				$TBody .= "<td>{$Value['Tel9']}</td>";
				$TBody .= "<td>{$Value['Tel10']}</td>";
				$TBody .= "<td>{$Value['Tel11']}</td>";
				$TBody .= "<td>{$Value['Tel12']}</td>";
				$TBody .= "<td>{$Value['Tel13']}</td>";
				$TBody .= "<td>{$Value['Tel14']}</td>";
				$TBody .= "<td>{$Value['Tel15']}</td>";
				$TBody .= "<td>{$Value['Tel16']}</td>";
				$TBody .= "<td>{$Value['Tel17']}</td>";
				$TBody .= "<td>{$Value['Tel18']}</td>";
				$TBody .= "<td>{$Value['Tel19']}</td>";
				$TBody .= "<td>{$Value['Tel20']}</td></tr>";
			}
		}

		$Tabela .= $THead.$TBody."</tbody></table>";
	}
	
	$Read->ExeRead("carteira");
	if($Read->GetRowCount()>0){
		$Carteiras = $Read->GetResult();
	}

?>
<h4>Mailing</h4>

<div class='card mb-2'>
	<div class='card-body'>
		<form class='form-row' method='POST'>
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
				<label>Exportar Ficha com acionamento?</label>
				<select class='form-control' name='Acionado'>
					<option value='0' <?php echo (!empty($_POST['Acionado']) AND $_POST['Acionado'] == 0) ? 'selected' : '';?> >Não</option>
					<option value='1' <?php echo (!empty($_POST['Acionado']) AND $_POST['Acionado'] == 1) ? 'selected' : '';?> >Sim</option>
				</select>
			</div>
			
			<div class='form-group col-sm'>
				<label>Somente Ficha com Margem?</label>
				<select class='form-control' name='Margem'>
					<option value='0' <?php echo (!empty($_POST['Margem']) AND $_POST['Margem'] == 0) ? 'selected' : '';?> >Não</option>
					<option value='1' <?php echo (!empty($_POST['Margem']) AND $_POST['Margem'] == 1) ? 'selected' : '';?> >Sim</option>
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
			<form method='POST' action='/KoalaCRM/_app/views/Relatorios/Exportar.php/?r=Mailing'>
				<div class='form-row justify-content-between'>
					<div class='form-group col-sm'>
						<label class='font-weight-bold'>Quantidade: </label>
						<span><?php echo (!empty($Lista)) ? Count($Lista) : 0;?> Clientes</span>
					</div>
					
					<div class='form-group col-sm'>
						<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
						<input type='submit' class='form btn btn-success form-control' name='Exportar' value="Exportar"/>
					</div>
				</div>
			</form>
			<?php
				//echo $Tabela;
		}
		?>
	</div>
</div>
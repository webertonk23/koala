<?php
	$Read = new Read;
	
	$Query = "Select * From funcionarios";
	
	$Termos = "";
	$Places = "";
	
	$Query .= $Termos;
	
	$Read->FullRead($Query, $Places);
	if($Read->GetRowCount()>0){
		$Lista = $Read->GetResult();
	}
	
	$Tabela = "<table style='border: 1px solid'>";

	$THead = "
		<thead>
			<tr>
				<th>Id</th>
				<th>Nome Completo</th>
				<th>Dt Nascimento</th>
				<th>Dt Admissão</th>
				<th>Cargo</th>
				<th>Carga Horária</th>
				<th>Entrada</th>
				<th>Saída</th>
				<th>Sabados</th>
				<th>Entrada Sab</th>
				<th>Saída Sab</th>
				<th>Status</th>
				<th>1º Pausa</th>
				<th>2º Pausa</th>
				<th>3º Pausa</th>
				<th>1º Pausa Sab</th>
				<th>2º Pausa Sab</th>
				<th>3º Pausa Sab</th>
				<th>CPF</th>
				<th>Fone</th>
				<th>E-mail</th>
				<th>Id Sistema</th>
				<th>Supervisor</th>
				<th>Contrato</th>
				<th>Login</th>
				<th>Produto</th>
				<th>Sub Produto</th>
				<th>Endereço</th>
				<th>Complemento</th>
				<th>Bairro</th>
				<th>Cidade</th>
				<th>Cep</th>
				<th>Nome da Mãe</th>
				<th>Estado Civil</th>
				<th>Escolaridade</th>
				<th>Sexo</th>
				<th>Vale Trasnporte</th>
				<th>Pis</th>
				<th>RG</th>
				<th>Setor</th>
				<th>Experiência</th>
				<th>Obs</th>
				<th>Desligamento</th>
			</tr>
		</thead>";
	
	$TBody = "<tbody><tr class='align-middle '>";
	
	if(!empty($Lista)){
		foreach($Lista as $Key => $Value){
			
			$TBody .= "<td>'".str_pad($Value['Id'], 4, "0", STR_PAD_LEFT)."</td>";
			$TBody .= "<td>".$Value['NomeCompleto']."</td>";
			$TBody .= "<td>".$Value['DataNasc']."</td>";
			$TBody .= "<td>".$Value['DataAdm']."</td>";
			$TBody .= "<td>".$Value['Cargo']."</td>";
			$TBody .= "<td>".substr($Value['Horario'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['HorarioEntrada'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['HorarioSaida'], 0, 8)."</td>";
			$TBody .= ($Value['Sabado']) ? '<td>Sim</td>' : '<td>Não</td>';
			$TBody .= "<td>".substr($Value['HorarioEntradaSabado'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['HorarioSaidaSabado'], 0, 8)."</td>";
			$TBody .= "<td>".$Value['Status']."</td>";
			$TBody .= "<td>".substr($Value['Pausa1'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['Pausa2'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['Pausa3'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['Pausa1S'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['Pausa2S'], 0, 8)."</td>";
			$TBody .= "<td>".substr($Value['Pausa3S'], 0, 8)."</td>";
			$TBody .= "<td>".$Value['Cpf']."</td>";
			$TBody .= "<td>".$Value['Fone']."</td>";
			$TBody .= "<td>".$Value['Email']."</td>";
			$TBody .= "<td>".$Value['IdSistema']."</td>";
			$TBody .= "<td>".$Value['Supervisor']."</td>";
			$TBody .= "<td>".$Value['Contrato']."</td>";
			$TBody .= "<td>".$Value['Login']."</td>";
			$TBody .= "<td>".$Value['Produto']."</td>";
			$TBody .= "<td>".$Value['SubProduto']."</td>";
			$TBody .= "<td>{$Value['Rua']}, {$Value['Numero']}</td>";
			$TBody .= "<td>".$Value['Complemento']."</td>";
			$TBody .= "<td>".$Value['Bairro']."</td>";
			$TBody .= "<td>".$Value['Cidade']."</td>";
			$TBody .= "<td>".$Value['Cep']."</td>";
			$TBody .= "<td>".$Value['Mae']."</td>";
			$TBody .= "<td>".$Value['EstadoCivil']."</td>";
			$TBody .= "<td>".$Value['Escolaridade']."</td>";
			$TBody .= "<td>".$Value['Sexo']."</td>";
			$TBody .= "<td>".$Value['ValeTransporte']."</td>";
			$TBody .= "<td>".$Value['Pis']."</td>";
			$TBody .= "<td>".$Value['Rg']."</td>";
			$TBody .= "<td>".$Value['Setor']."</td>";
			$TBody .= "<td>".$Value['RegimeExperiencia']."</td>";
			$TBody .= "<td>".$Value['Obs']."</td>";
			$TBody .= "<td>".$Value['DtDeslig']."</td></tr>";
		}
	}

	$Tabela .= $THead.$TBody."</tbody></table>";
?>
<div class='card mb-2'>
	<div class='card-body' id='Tabela'>
		<h4 class='card-title'>Relatório Corpo de Funcionarios</h4>
		<form method='POST' action='_app/Views/Relatorios/Exportar.php/?r=Corpo_de_funcionarios'>
			<div class='form-row justify-content-between'>
				<div class='form-group col-sm'>
					<label class='font-weight-bold'>Quantidade: </label>
					<span><?php echo (!empty($Lista)) ? Count($Lista) : 0;?></span>
				</div>
				
				<div class='form-group col-sm'>
					<input type='hidden' value="<?php echo $Tabela; ?>" name='Tabela'/>
					<button type='submit' class='form btn btn-success form-control' name='Exportar'><span class="oi oi-document"></span> Exportar</button>
				</div>
			</div>
		</form>
		
		<table class='table table-striped table-sm col-sm'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Nome Completo</th>
					<th>Cargo</th>
					<th>Status</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					if(!empty($Lista)){
						foreach($Lista as $Values){
							if($Values['Status'] == 'Ativo'){
								echo "<tr><td>{$Values['Id']}</td><td>{$Values['NomeCompleto']}</td><td>{$Values['Cargo']}</td><td>{$Values['Status']}</td>";
							}
						}
					}
				
				?>
			</tbody>
		</table>
	</div>
</div>
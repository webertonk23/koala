<?php
	if(isset($_GET['Id'])){
		$Busca = new Read;
		
		$Busca->ExeRead("Funcionarios", "WHERE Id = :Id", "Id={$_GET['Id']}");
		
		$Funcionario = ($Busca->GetRowCount() > 0) ? $Busca->GetResult()[0] : null;

	}

?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Weberton Kaic">
		
		
		<!-- Bootstrap core CSS -->
		<link href="bootstrap-4.0/css/bootstrap.min.css" rel="stylesheet">
		
		<!--external css-->
		<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
		
		<!-- Custom styles for this template -->
		<link href="css/style2.css" rel="stylesheet">
		
		<title>Koala CRM - Grupo Asa</title>
	</head>
	
	<body>

		<div class='card col mb-2'>
			<form method='POST'>
				<div class='card-body'>
					<button id="btn" class='btn'><span class="fa fa-print"></span> Imprimir</button>
					<a href='?p=<?php echo base64_encode("Cadastro/Funcionarios"); ?>' class='btn btn-danger-outline' name='Voltar'>Voltar</a>
				</div>
			</form>
		</div>

		<div class='card col mb-2' id='Imprimir'>
			<div class='card_body'>
				<br>
				<h1 class='card-title'>Ficha de Funcionario</h1>
				<hr>
				
				<table width='100%'>
					<tr>
						<td width='30%'><strong >Empresa:</strong></td>
						<td><u>Asa Cobranca LTDA ME</u></td>
					</tr>
				</table>
				
				<table width='100%'>
					<tr >
						<td width='30%'><strong >Nome do Empregado:</strong></td>
						<td><u><?php echo $Funcionario['NomeCompleto'] ?></u></td>
					</tr>
				</table>
				
				<table width='100%'>
					<tr>
						<td width='30%'><strong>E-mail do Empregado:</strong></td>
						<td><label><u><?php echo $Funcionario['Email'] ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>
					<tr>
						<td width='30%'><strong>Horário de Trabalho: Inicio </strong></td></td>
						<td width='10%'><label><u><?php echo date("H:i:s", strtotime($Funcionario['HorarioEntrada'])) ?></u></label></td>
						<td width='25%'><strong>Intervalo </strong><label><u><?php echo date("H:i:s", strtotime($Funcionario['Pausa2'])) ?></u></label>
						<td width='15%'><strong>às </strong><label><u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u></label></td>
						<td><strong>término </strong><label><u><?php echo date("H:i:s", strtotime($Funcionario['HorarioSaida'])) ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Horário de Trabalho Sábado: Inicio </strong></td>
						<td width='10%'><label><u><?php echo date("H:i:s", strtotime($Funcionario['HorarioEntradaSabado'])) ?></u></label></td>
						<td width='25%'><strong>Intervalo </strong><label><u><?php echo date("H:i:s", strtotime($Funcionario['Pausa2S'])) ?></u></label></td>
						<td width='15%'><strong>às </strong><label><u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u></label></td>
						<td><strong>término </strong><label><u><?php echo date("H:i:s", strtotime($Funcionario['HorarioSaidaSabado'])) ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Contato: </strong></td>
						<td width='20%'><label><u><?php echo $Funcionario['Fone'] ?></u></label></td>
						<td width='20%'><strong> Estado Civil: </strong></td>
						<td><label><u><?php echo $Funcionario['EstadoCivil'] ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Data da Admissão: </strong></td>
						<td><label><u><?php echo date("d/m/Y", strtotime($Funcionario['DataAdm'])) ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Remuneração: </strong></td>
						<td><label><u>R$ <?php echo number_format($Funcionario['Remuneracao'], 2, ',', '.') ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Cargo: </strong></td>
						<td><label><u><?php echo $Funcionario['Cargo'] ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Contrato de experiência: </strong></td>
						<td><label><u><?php echo $Funcionario['RegimeExperiencia'] ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Vale transporte: </strong></td>
						<td width='10%'><label><u><?php echo ($Funcionario['ValeTransporte']) ? 'Sim' : 'Não' ?></u></label></td>
						<td><strong> Qtd por dia </strong><label><u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u></label></td>
					</tr>
				</table>
				
				<table width='100%'>	
					<tr>
						<td width='30%'><strong>Grau de Instrução: </strong>
						<td><label><u><?php echo $Funcionario['Escolaridade'] ?></u></label></td>
					</tr>
				</table>
				
				<table width='100%'>				
					<tr class='text-center' style='text-align: center;'>
						<td colspan='5'>
							<br>
							<br>
							<br>
							Local: <u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u>
							<u>&ensp;&ensp;&ensp;&ensp;/&ensp;&ensp;&ensp;&ensp;/&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u> <br><br>
							 <u>&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;</u><br>
							<?php echo  $Funcionario['NomeCompleto']  ?> <br><br>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>

	<script>
		document.getElementById('btn').onclick = function() {
			var conteudo = document.getElementById('Imprimir').innerHTML,
			tela_impressao = window.open('about:blank');
			tela_impressao.document.write(conteudo);
			tela_impressao.window.print();
			tela_impressao.window.close();
		};
	</script>
</html>
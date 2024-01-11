<?php
	if($_SESSION['Usuario']['Nivel_user'] == 1){
		$Usuario = $_SESSION['Usuario']['Id_user'];
		$Data = array ('De' => date("Y-m-d 00:00:00"), 'Ate' => date("Y-m-d 23:59:59"));
		
		$Read = new Read;
		
		$Read->FullRead(
			"SELECT COUNT(*) as Qtd, SUM(cpc_tab) as Cpc FROM historico INNER JOIN tabulacao ON idtab_hist = id_tab WHERE iduser_hist = :user AND dtOco_hist BETWEEN :datade AND :dataate",
			"user={$Usuario}&datade={$Data['De']}&dataate={$Data['Ate']}"
		);
		
		$Valor = new stdClass();
		$Valor->At = (!empty($Read->GetResult()[0]['Qtd'])) ? (int) $Read->GetResult()[0]['Qtd'] : 0;
		$Valor->Cpc = (!empty($Read->GetResult()[0]['Cpc'])) ? (int) $Read->GetResult()[0]['Cpc'] : 0;
		
		$Read->FullRead(
			"SELECT COUNT(*) as Qtd, SUM(valor_venda) as valor FROM vendas WHERE iduser_venda = :user AND dtvenda_venda BETWEEN :datade AND :dataate",
			"user={$Usuario}&datade={$Data['De']}&dataate={$Data['Ate']}"
		);
		
		$Valor->Vendas = (!empty($Read->GetResult()[0]['Qtd'])) ? (int) $Read->GetResult()[0]['Qtd'] : 0;
		$Valor->valor = (!empty($Read->GetResult()[0]['valor'])) ? (int) $Read->GetResult()[0]['valor'] : 0;
		
		$Read->FullRead(
			"
			SELECT
				COUNT (*) AS Ag,
				SUM (CASE WHEN Data_Ret <= GETDATE() THEN 1 ELSE 0 END) AS AgAt,
				SUM (CASE WHEN DATEPART(HOUR, Data_Ret) = DATEPART(HOUR, GETDATE()) THEN 1 ELSE 0 END) AS AgH

			FROM
				Retornos
			WHERE
				Feito_Ret = 0
				AND CONVERT(DATE, Data_Ret, 103) =  CONVERT(DATE, GETDATE(), 103)
				AND IdUser_Ret = :user
			",
			"user={$Usuario}"
		);
		
		$Agendamentos = new stdClass();
		$Agendamentos->Ag = (!empty($Read->GetResult()[0]['Ag'])) ? (int) $Read->GetResult()[0]['Ag'] : 0;
		$Agendamentos->AgAt = (!empty($Read->GetResult()[0]['AgAt'])) ? (int) $Read->GetResult()[0]['AgAt'] : 0;
		$Agendamentos->AgH = (!empty($Read->GetResult()[0]['AgH'])) ? (int) $Read->GetResult()[0]['AgH'] : 0;
		
		$Read->FullRead("
			SELECT
				ROUND(SUM(valor_com), 2) as ValorComReal
			FROM
				vendas INNER JOIN comissaobmg ON numero_venda = ade_com
			WHERE
				iduser_venda = :idUser1
				AND YEAR (dtpag_com) = YEAR (GETDATE())
				AND MONTH (dtpag_com) = MONTH (GETDATE())
				
			UNION
			
			SELECT
				ROUND(SUM(vlcom_excom * status_excom), 2) as ValorComReal 
			FROM
				vendas INNER JOIN extratocomissao ON numero_venda = ade_excom 
			WHERE
				iduser_venda = :idUser2
				AND YEAR (dtpag_excom) = YEAR (GETDATE()) 
				AND MONTH (dtpag_excom) = MONTH (GETDATE())
		", "idUser1={$_SESSION['Usuario']['Id_user']}&idUser2={$_SESSION['Usuario']['Id_user']}");
		
		$pontos = ($Read->GetRowCount() > 0) ? array_sum(array_column($Read->GetResult(), "ValorComReal")) : 0;
	}
?>

<script>
	agent = <?php echo (!empty($_SESSION['Usuario'])) ? $_SESSION['Usuario']['Agent_user'] : "";?>;
			
	if(agent > 0){
		window.onload = function() {
			vonix = new Vonix('http://10.20.10.220', agent);
			var Page = <?php echo "'".$_SERVER['QUERY_STRING']."'"; ?>;
			
			if(Page == 'p=Atendimento/Ativo'){
				vonix.onReceive(function(call_id, date, queue, from, to, callfilename, contact_name, action_id, additional_data) {
					if(action_id != undefined){
						window.location.replace("?p=Atendimento/Acionamento&Id=" + action_id + "&Tipo=A&Fone=" + from + "&Fila=" + queue + "&Call_Id=" + call_id);
						//output.innerHTML += "(Receive) Dados: call_id: " + call_id + " date: " + date + " queue: " + queue + " from: " + from + " to: " + to + " callfilename: " + callfilename + " contact_name: " + contact_name + " action_id: " + action_id + " additional_data: " + JSON.stringify(additional_data) + "<br/>";
					}
				});
			}
		}
	}
</script>

<nav class='navbar navbar-expand navbar-dark bg-dark justify-content-between'>
	<!-- Tenha certeza de deixar a marca se você quer que ela seja mostrada -->
	<a class="navbar-brand" href="?p=Inicio"><img class='' src='./img/logo.png' width="30" height="30"> Koala - CRM</a>
 
	<ul class="navbar-nav">
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Atendimento
			</a>
			
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<?php /* if($_SESSION['Usuario']['Nivel_user'] == 1 ){?>
				<a class="dropdown-item" href="?p=Atendimento/Ativo">Ativo</a>
				<?php }*/?>
				<a class="dropdown-item" href="?p=Atendimento/Ativo">Ativo</a>
				<a class="dropdown-item" href="?p=Atendimento/Indicacao">Indicação</a>
				<a class="dropdown-item" href="?p=Atendimento/Receptivo">Receptivo</a>
				<a class="dropdown-item" href="?p=Atendimento/Retornos">Retornos</a>
			</div>
		</li>
		
		
		<?php if($_SESSION['Usuario']['Nivel_user'] >= 2 AND $_SESSION['Usuario']['Nivel_user'] <= 4){?>
		<?php //if(2 <= $_SESSION['Usuario']['Nivel_user'] >= 4){?>
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Cadastro
			</a>
			
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<?php if($_SESSION['Usuario']['Nivel_user'] >= 3 ){?>
				<a class="dropdown-item" href="?p=Cadastro/Carteira">Carteira</a>
				<a class="dropdown-item" href="?p=Cadastro/Filas">Filas</a>
				<a class="dropdown-item"  href="?p=Cadastro/Funcionarios">Funcionarios</a>
				<a class="dropdown-item" href="?p=Cadastro/Ativos">Inventario</a>
				<?php }?>
				<a class="dropdown-item" href="?p=Cadastro/Pessoas">Pessoas</a>
				<?php if($_SESSION['Usuario']['Nivel_user'] >= 3 ){?>
				<a class="dropdown-item" href="?p=Cadastro/Produtos">Produtos</a>
				<a class="dropdown-item"  href="?p=Cadastro/Tabulacao">Tabulação</a>
				<a class="dropdown-item"  href="?p=Cadastro/Usuarios">Usuarios</a>
				<?php }?>
			</div>
		</li>
		<?php }?>
		<?php if($_SESSION['Usuario']['Nivel_user'] >= 2){?>
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Relatórios</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="?p=Relatorios/Acionamentos">Acionamentos</a>
				<a class="dropdown-item" href="?p=Relatorios/AnaliseMailing">Analise De Mailing</a>
				<a class="dropdown-item" href="?p=Relatorios/demonstrativoPausas">Extrato de Pausas</a>
				<a class="dropdown-item" href="?p=Relatorios/login">Login</a>
				<?php if($_SESSION['Usuario']['Nivel_user'] >= 3  AND $_SESSION['Usuario']['Nivel_user'] <= 4){?>
				<a class="dropdown-item" href="?p=Relatorios/funcionarios">Corpo de Funcionarios</a>
				<a class="dropdown-item" href="?p=Relatorios/Inventario">Inventario</a>
				<a class="dropdown-item" href="?p=Relatorios/Financeiro/consolidadoextano">Consolidado Ext Ano</a>
				<a class="dropdown-item" href="?p=Relatorios/Financeiro/consolidperiodo">Consolidado Ext por periodo</a>
				<a class="dropdown-item" href="?p=Relatorios/Financeiro/consolidextprod">Consolidado Ext por produto</a>
				<?php }?>
				<a class="dropdown-item" href="?p=Relatorios/Vendas">Vendas</a>
				<?php if($_SESSION['Usuario']['Nivel_user'] >= 3  AND $_SESSION['Usuario']['Nivel_user'] <= 4){?>
				<a class="dropdown-item" href="?p=Relatorios/Comissao_Vendas">Vendas c/ Comissão</a>
				<a class="dropdown-item" href="?p=Relatorios/Comissao_VendasBancos">Vendas c/ Comissão Bancos</a>
				<?php }?>
			</div>
		</li>
		<?php }?>
		<?php if($_SESSION['Usuario']['Nivel_user'] >= 2 AND $_SESSION['Usuario']['Nivel_user'] <= 4){?>
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dash</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="?p=Dash/Atendimento">Atendimento</a>
				<a class="dropdown-item" href="?p=Dash/VendasPerfil">Perfil de vendas</a>
				<a class="dropdown-item" href="?p=Dash/VendasDia">Vendas Por Dia</a>
				<a class="dropdown-item" href="?p=Dash/Vendashora">Vendas Por Hora</a>
			</div>
		</li>
		<?php }?>
		<?php if($_SESSION['Usuario']['Nivel_user'] >= 3  AND $_SESSION['Usuario']['Nivel_user'] <= 4){?>
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Processos</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="?p=Processos/Importacao">Importador</a>
				<a class="dropdown-item" href="?p=Processos/ImportacaoBordero">Importador Bordero</a>
				<a class="dropdown-item" href="?p=Processos/ImportacaoExtrato">Importador Extrato BMG</a>
				<a class="dropdown-item" href="?p=Processos/extratoComBancos">Importador Extrato Comissão Bancos</a>
				<a class="dropdown-item" href="?p=Processos/ImportacaoPausasVonix">Importador Pausas vonix</a>
				<a class="dropdown-item" href="?p=Processos/Manutencaovendas">Manuteção de vendas</a>
				<a class="dropdown-item" href="?p=Processos/MedAdm/Med">Medida Administrativa</a>
				<a class="dropdown-item" href="?p=Processos/Monitor_logins">Monitor de logins</a>
				<a class="dropdown-item" href="?p=Processos/importbmg">Processar arquivos com BMG</a>
				<a class="dropdown-item" href="?p=Processos/Processar_Filas">Processar filas</a>
			</div>
		</li>

		<?php }?>
		
	
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?PHP echo (!empty($_SESSION['Usuario']['Usuario_user'])) ? $_SESSION['Usuario']['Usuario_user'] : "Usuario"; ?></a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="?p=Sair">Sair</a>
				<a class="dropdown-item" href="#TrocarSenha">Trocar Senha</a>
			</div>
		</li>
		<?php if($_SESSION['Usuario']['Nivel_user'] == 1 ){
			$Read->ExeRead('pausas', " ", " ");
			
		?>
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-pause" aria-hidden="true"></i></a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="#" onclick='vonix.doUnpause()'>Despausar</a>
				<hr>
				<?php 
					if($Read->GetRowCount() > 0){
						foreach($Read->GetResult() As $values){
							echo "<a class='dropdown-item' href='#' onclick='vonix.doPause({$values['cod_pausa']})'>{$values['desc_pausa']}</a>";
						}
					}
				
				
				?>
			</div>
		</li>
		
		
		<li class="nav-item dropdown">
			<a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-thermometer-half" aria-hidden="true"></i></a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="#" ><span class="fa fa-calendar mx-1"> Agendamentos para hoje <?php echo $Agendamentos->Ag?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-calendar-times-o mx-1"> Agendamentos para hoje atrasados <?php echo $Agendamentos->AgAt?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-clock-o mx-1"> Agendamentos para esta hora <?php echo $Agendamentos->AgH?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-volume-control-phone mx-1"> Atendimentos <?php echo $Valor->At?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-comments-o mx-1"> CPC <?php echo $Valor->Cpc?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-handshake-o mx-1"> Vendas <?php echo $Valor->Vendas?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-money mx-1"> Valor de vendas R$ <?php echo number_format($Valor->valor, 2, ',', '.')?></span></a>
				<a class="dropdown-item" href="#" ><span class="fa fa-check-square-o mx-1"> Conversão <?php echo ($Valor->Cpc>0) ? number_format(($Valor->Vendas/$Valor->Cpc)*100, 2, ',', '.') : "0,00"?>%</span></a>
				<a class="dropdown-item" href="?p=Relatorios/Comissao_VendasBancos" ><span class="fa fa-star mx-1"> Pontuação do mês <?php echo floor($pontos) ?></span></a>
			</div>
		</li>
		
		<?php } ?>
	</ul>
	
	
	
	
	<label class="navbar-nav ml-auto text-white">
		<?php if($_SESSION['Usuario']['Nivel_user'] == 1 ){?>
		<!--<h5 title='Agendamentos para hoje'><span class="fa fa-calendar mx-1"> <?php echo $Agendamentos->Ag?></span></h5>
		<h5 title='Agendamentos para hoje atrasados'><span class="fa fa-calendar-times-o mx-1"> <?php echo $Agendamentos->AgAt?></span></h5>
		<h5 title='Agendamentos para esta hora'><span class="fa fa-clock-o mx-1"> <?php echo $Agendamentos->AgH?></span></h5>
		<h5 class='border-left pl-1'><span class="fa fa-volume-control-phone mx-1"> <?php echo $Valor->At?></span></h5>
		<h5><span class="fa fa-comments-o mx-1"> <?php echo $Valor->Cpc?></span></h5>
		<h5><span class="fa fa-handshake-o mx-1"> <?php echo $Valor->Vendas?></span></h5>
		<h5><span class="fa fa-money mx-1"> R$ <?php echo number_format($Valor->valor, 2, ',', '.')?></span></h5>
		<h5><span class="fa fa-check-square-o mx-1"> <?php echo ($Valor->Cpc>0) ? number_format(($Valor->Vendas/$Valor->Cpc)*100, 2, ',', '.') : "0,00"?>%</span></h5>-->
		<?php } ?>
	</label>
	
	<label class="navbar-nav text-white border-left pl-1"> Logout em: <span class='ml-2' id="Time">0:12:00<span></label>
</nav>

<script>
	var tempo = 719;
	var label = document.getElementById("Time");
	window.setInterval(function(){
	  
	  var min = parseInt(tempo/60);
	  var sec = tempo%60;
	  
		if(min < 10){
			min = "0"+min;
			min = min.substr(0, 2);
		}
		
		if(sec <=9){
			sec = "0"+sec;
		}
		
		label.innerHTML = " 0:" + min + ":" + sec;
	  
		if(tempo <= 0){
			// window.location.replace('?p=Sair');
		}
		
		if(tempo > 0){
			tempo--;
		}
	},1000);
</script>
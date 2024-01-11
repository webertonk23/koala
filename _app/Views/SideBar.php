<aside>
	<div id="sidebar" class="nav-collapse ">
		<ul class="sidebar-menu" id="nav-accordion">
			<li class="sub-menu">
				<a>
					<i class="fa fa-plus-square"></i>
					<span>Cadastro</span>
				</a>
				
				<ul class="" style='padding-inline-start: 10px;'>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Ativos'); ?>">Ativos</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Carteira'); ?>">Carteira</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Filas'); ?>">Filas</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Pessoas'); ?>">Pessoas</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Tabulacao'); ?>">Tabulação</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Funcionarios'); ?>">Funcionarios</a></li>
					<li><a href="?p=<?php echo base64_encode('Cadastro/Usuarios'); ?>">Usuarios</a></li>
				</ul>
			</li>
			
			<li class="sub-menu">
				<a>
					<i class="fa fa-phone-square"></i>
					<span>Atendimento</span>
				</a>
				
				<ul class="" style='padding-inline-start: 10px;'>
					<li><a href="?p=<?php echo base64_encode('Atendimento/Ativo'); ?>">Ativo</a></li>
					<li><a href="?p=<?php echo base64_encode('Atendimento/Receptivo'); ?>">Receptivo</a></li>
				</ul>
			</li>
			
			<li class="sub-menu">
				<a href="?p=<?php echo base64_encode('Monitoria'); ?>">
					<i class="fa fa-headphones"></i>
					<span>Monitoria</span>
				</a>
			</li>
			
			<li class="sub-menu">
				<a >
					<i class="fa fa-tasks"></i>
					<span>Processos</span>
				</a>
				
				<ul class="" style='padding-inline-start: 10px;'>
					<li><a href="?p=<?php echo base64_encode('Flow');?>">Flow</a></li>
					<li><a href="?p=<?php echo base64_encode('AvaliacaoPerfil');?>">Avaliação Perfil</a></li>
					<li><a href="?p=<?php echo base64_encode('AvPerfilComport');?>">Avaliação Comportamental</a></li>
					<li><a href="#">Importação</a></li>
					<li><a href="#">Medidas Administrativas</a></li>
					<li><a href="#">Manutenção de vendas</a></li>
					
					
				</ul>
			</li>
			
			<li class="sub-menu">
				<a >
					<i class="fa fa-file-text-o"></i>
					<span>Relatórios</span>
				</a>
				
				<ul class="" style='padding-inline-start: 10px;'>
					<li><a href="?p=">Acionamentos</a></li>
					<li><a href="?p=">Agendamentos</a></li>
					<li><a href="?p=">Corpo de funcionarios</a></li>
					<li><a href="?p=">Mailing</a></li>
					<li><a href="?p=">Receptivo</a></li>
					<li><a href="?p=">Vendas</a></li>
					<li><a href="?p=">Vendas c/ comissão</a></li>
				</ul>
			</li>
		</ul>
	</div>
</aside>

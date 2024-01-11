<?php
	require('../Config.inc.php');
	
	$Read = new Read;
	
	$prod = (!empty($_GET['p'])) ? " AND produto = '".$_GET['p']."'" : "";
	
	$Read->FullRead("
		SELECT 
			usuarios.usuario_user, usuarios.agent_user, funcionarios.produto, funcionarios.subproduto
		FROM
			session INNER JOIN usuarios ON Iduser_sess = Id_user
			INNER JOIN funcionarios ON Nome_user = NomeCompleto
			AND Nivel_user = 1
		WHERE
			dtlogout_sess IS NULL
			{$prod}
			AND status = 'Ativo'
		ORDER BY
			produto, subproduto, usuario_user
	");

	if($Read->GetRowCount()>0){
		$Usuarios = $Read->GetResult();
	
		foreach($Usuarios as $v){
			$Vonix->GetStatusAgent($v['agent_user']);
			$resp = json_decode($Vonix->Result);
			$h = time() - strtotime($resp->since);
			$d = "<span class='col-sm fa fa-clock-o btn' > ".substr(ToHora(($h>0) ? $h : 0),2)."</span>" ;
			
			switch($resp->status){
				case 'ONLINE':
					$css = 'bg-success';
					$status = '<span class="col-sm fa fa-user-o btn"></span>';
					$d = "";
				break;
				
				case 'OFFLINE':
					$css = 'bg-white';
					$status = 'Offline';
					$d = "";
				break;
				
				case 'PAUSED':
					$css = 'bg-danger';
					$status = '<span class="col-sm fa fa-pause btn"></span>';
				break;
				
				case 'UNAVAILABLE':
				
				break;
				
				case 'RINGING':
					$css = 'bg-warning';
					$status = '<span class="col-sm fa fa-volume-control-phone btn"></span>';
				break;

				case 'ONTHEPHONE':
					$css = 'bg-warning';
					$status = '<span class="col-sm fa fa-comments-o btn"></span>';
				break;
				
			}
			
			// $d = strtotime(date("Y-m-d H:i:s")) - strtotime(str_replace("T", " ", $resp->since));
			
			
			
			echo "<div class='col-sm-4 mb-2'>";
			echo "<div class='card {$css}'>";
			echo "<div class='card-body'>";
			echo "<span class='row justify-content-between'><span class='col-sm'>{$v['usuario_user']}</span>{$status} {$d} <span class='fa fa-phone-square btn' > {$resp->location}</span></span>";
			echo "</div></div></div>";
		}
		
	}
	
	



?>
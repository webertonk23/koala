<?php
	$Read = new read();
	$Update = new Update;
	$ProcessarFila = new ProcessarFila;
	$Check = new Check;
	
	if(!empty($_POST['Logout'])){
		$LogOut['dtlogout_sess'] = date("Y-m-d H:i:s");
		$Update->ExeUpdate('session', $LogOut, "WHERE id_sess = :id", "id={$_POST['Logout']}");
		
		if($Update->GetRowCount()>0){
			ERRO("Usuario deslogado com sucesso!", SUCESSO);
		}
	}
?>

<div class="">
	<div class='card my-1'>
		<div class='card-body'>
			<h3 class='card-title'>Usuarios logados</h3>
		</div>
	</div>

<?php
	
	$Read->FullRead("
		SELECT 
			*
		FROM
			session INNER JOIN usuarios ON Iduser_sess = Id_user
		WHERE
			dtlogout_sess IS NULL
	");
			
	if($Read->GetRowCount()>0){
		$Usuarios = $Read->GetResult();
	}

?>

	<div class='card  border-0'>
		<div class="row row-cols-3 row-cols-md-4">
			<?php
				if(!empty($Usuarios)){
					$Nivel = array(1 => 0, 2 => 0, 3 => 0, 4 => 0);
					foreach ($Usuarios as $key => $value){
						echo "<div class='col-sm-4 mb-2'>";
						echo "	<div class='card'>";
						echo "		<form method='POST'>";
						echo "			<div class='card-body'>";
						echo "				<h5 class='card-title'>{$value['Usuario_user']}</h5>";
						echo "				<p class='card-text'>Inicio Sessão: ".Date("d/m/Y H:i:s", strtotime($value['dtlogin_sess']))."</p>";
						echo "				<p class='card-text'>Ultima Ação: ".Date("d/m/Y H:i:s", strtotime($value['ultacao_sess']))."</p>";
						echo "				<p class='card-text'>Tempo de sessão: ".$Check->ToTime(time() - strtotime($value['dtlogin_sess']))."</p>";
						echo "				<button name='Logout' value='{$value['id_sess']}'class='btn btn-danger'><span class='fa fa-sign-out'></span> Deslogar</button>";
						echo "				<a href='?{$value['pag_sess']}'class='btn btn-info'><span class='fa fa-sitemap'></span> Ver pagina</a>";
						echo "			</div>";
						echo "		</form>";
						echo "	</div>";
						echo "</div>";
						
						$Nivel[$value['Nivel_user']] += 1;
					}
				}
			?>
		</div>
	</div>
	
	<div class='card px-2'>
		<div class='card-body row'>
			<label class='col-sm'>Operador</label> <span class="badge badge-pill badge-primary"><?php echo $Nivel[1];?></span>
			<label class='col-sm'>Supervisor</label> <span class="badge badge-pill badge-primary"><?php echo $Nivel[2];?></span>
			<label class='col-sm'>Gerente</label> <span class="badge badge-pill badge-primary"><?php echo $Nivel[3];?></span>
			<label class='col-sm'>Administrador</label> <span class="badge badge-pill badge-primary"><?php echo $Nivel[4];?></span>
		</div>
	</div>
</div>

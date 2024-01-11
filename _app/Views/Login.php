<?php
	$login = new Login;
	
	$DataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	if(isset($DataLogin['Login'])){
		// var_dump($DataLogin);
		
		$login->ExeLogin($DataLogin);
		
		if(!$login->GetResult()){
			$Erro = $login->GetError();
		}else{
			if($SESSION['Usuario']['Nivel_user'] == 4){
				
				exec("arp -a {$_SERVER['REMOTE_ADDR']}", $output);
				$IpMac = explode(" ", trim($output[3]));
				
				$Vonix->LogarAgent(str_replace("-", "", $IpMac[10]));
			}
			
			header("location: ?p=Inicio");
		}
	}
?>


<div id="login-page">
	<div class="container">
		<form class="form-login" action="" method="POST">
			<h2 class="form-login-heading">Acesso restrito</h2>
			
			<div class="login-wrap box-shadow">
				<input type="text" class="form-control" placeholder="Usuario" autofocus name='Usuario'>
				
				<br>
				
				<input type="password" class="form-control mb-2" placeholder="Senha" name='Senha'>
				
				<hr>
				
				<button class="btn btn-theme btn-block" type="submit" Name='Login'><i class="fa fa-lock"></i> Entrar</button>
			</div>
			
			<?php 
				if(isset($Erro)){
					Erro($Erro[0], $Erro[1]);
				}
			?>
		</form>
	</div>
</div>
<?php

	//include_once("./_app/PHPExcel/PHPExcel.php");
	
	//Define Horario padão do servidor com o horario de brasilia
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Fortaleza');

	error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
	
	//ini_set('memory_limit', "8192MB");
	
	//error_reporting (0);
	//ini_set("display_errors", 0 );
	
	//Configuração Banco de Dados
	define('HOST','localhost\SSQLSERVER');
	define('USER','Sa');
	define('PASS','Sa123456');
	define('DB','KoalaCrm_teste');
	
	//include_once(__DIR__."\\PHPMailer\\")
	
	//Auto Load
	function autoload($Class){
		
		$CDir = ['conn', 'control', 'models', 'helpers', 'views', 'PHPMailer']; 	//Configuração de Diretorio
		$IDir = null; 		//Inclusão de Diretorio
		
		foreach($CDir as $DirName):
			if(!$IDir && file_exists(__DIR__."\\{$DirName}\\{$Class}.class.php") && !is_dir(__DIR__."\\{$DirName}\\{$Class}.class.php")):
				include_once(__DIR__."\\{$DirName}\\{$Class}.class.php");
				$IDir = true;
			endif;
		endforeach;
		
		if(!$IDir):
			trigger_error("Arquivo {$Class}.class.php, Não carregado", E_USER_ERROR);
			Die;
		endif;
	
	}
	
	spl_autoload_register('autoload');
	
	function Debug($Var){
		echo "<div class='card mb-2 mt-2'>";
		echo "<div class='card-header'>";
		echo "<h4 class='card-title'>Card Debug</h4>";
		echo "</div>";
		echo "<div class='card-body'>";
		echo "<pre>";
		print_r($Var);
		echo "</pre></div></div>";
		
	}
	
	function ToHora($sec){
		$horas = floor($sec / 3600);
		$minutos = floor(($sec - ($horas * 3600)) / 60);
		$segundos = floor($sec % 60);
		
		return str_pad($horas, 2, 0, STR_PAD_LEFT) . ":" . str_pad($minutos, 2, '0', STR_PAD_LEFT) . ":" . str_pad($segundos, 2, '0', STR_PAD_LEFT);
	}
	
	//Tratamento de Erros
	define('SUCESSO','success');
	define('ERRO','danger');
	define('ALERTA','warning');
	define('INFO','info');
	
	function Erro($ErrMsg, $ErrNo, $ErrDie = null){
		$CssClass = ($ErrNo == E_USER_NOTICE ? INFO : ($ErrNo == E_USER_WARNING ? ALERTA : ($ErrNo == E_USER_ERROR ? ERRO : $ErrNo)));
		echo "
			<div class='alert alert-{$CssClass}'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				<span class='oi oi-'></span> $ErrMsg 
			</div>";
			
		if($ErrDie){
			Die;
		}
	}
	
	function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine){
		$CssClass = ($ErrNo == E_USER_NOTICE ? INFO : ($ErrNo == E_USER_WARNING ? ALERTA : ($ErrNo == E_USER_ERROR ? ERRO : $ErrNo)));
		echo "
			<div class='alert alert-danger'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				<b>Erro na linha #{$ErrLine} :: </b>$ErrMsg<br>
				<small>{$ErrFile}</small>
			</div>";
			
		if($ErrNo == E_USER_ERROR){
			Die;
		}
	}
	
	function Redirect ($Link) {
		header("location: {$Link}");
	}
	
	set_error_handler('PHPErro');
	
	$Check = new Check;
	$Vonix = new Vonix;
	$Vonix->SetItens();
	
	session_start();
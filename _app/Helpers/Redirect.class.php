<?php class Redirect{
	
	public static function __construct ($Link) {
		header("location: {$Link}");
	}

	//'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª'
	//'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 '	
	
	public static function Name($Name){
		self::$Format = array();
		self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:,\\\'<>°ºª';
		self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                ';
		
		$Name = str_replace("´", "", $Name);
		
		self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
		self::$Data = strip_tags(trim(self::$Data));
		self::$Data = str_replace(array('-----','----','---','--'),'-', self::$Data);
		
		return ucwords(strtolower(utf8_encode(self::$Data)));
	}

	
	
	public static function Data($Data){
		self::$Format = explode(' ', $Data);
		self::$Data = explode('-', self::$Format[0]);
		
		if(empty(self::$Format['1'])):
			self::$Format['1'] = "00:00:00" ;//date('H:i:s');
		endif;
		
		// self::$Data = self::$Data[2].'/'.self::$Data[1].'/'.self::$Data[0];				//Retorna apenas data no formato basileiro 
		self::$Data = self::$Data[2].'/'.self::$Data[1].'/'.self::$Data[0].' '.self::$Format[1];
		return self::$Data;
	}
	
	public static function DataI($Data){
		// self::$Format = explode(' ', $Data);
		// self::$Data = explode('/', self::$Format[0]);
		
		// if(empty(self::$Format['1'])):
			// self::$Format['1'] = "00:00:00"; //date('H:i:s');
		// endif;
		
		// self::$Data = self::$Data[2].'/'.self::$Data[1].'/'.self::$Data[0];				//Retorna apenas data no formato basileiro 
		// self::$Data = self::$Data[2].'-'.self::$Data[1].'-'.self::$Data[0].' '.self::$Format[1];
		
		
		return date("Y-m-d H:i:s", strtotime($Data)); //self::$Data;
	}
	
	public static function DataI2($Data){
		self::$Format = explode(' ', $Data);
		self::$Data = explode('/', self::$Format[0]);
		
		if(empty(self::$Format['1'])):
			self::$Format['1'] = "00:00:00"; //date('H:i:s');
		endif;
		
		//self::$Data = self::$Data[2].'/'.self::$Data[1].'/'.self::$Data[0]; //Retorna apenas data no formato basileiro 
		self::$Data = self::$Data[2].'-'.self::$Data[1].'-'.self::$Data[0].' '.self::$Format[1];
		
		return self::$Data;
		// return date("Y-m-d H:i:s", strtotime($Data)); //self::$Data;
	}
	
	public static function ValidaTelefone($Tel){
		$TelF = '';
		
		if(strlen($Tel)==8){
			$TelF .= (substr($Tel, 0, 1)>5) ? "38".$Tel : "389".$Tel;
		}else if(strlen($Tel)==9){
			$TelF .= "38".$Tel;
		}else if(strlen($Tel)==10){
			$TelF .= (substr($Tel, 2, 1)<5) ? $Tel : substr($Tel, 0, 2)."9".substr($Tel, 2, 8);
		}else if(strlen($Tel)==11){
			$TelF = $Tel;
		}
		
		$a['Fone'] = $TelF;
		
		if(strlen($TelF)==10){
			$a['Tipo'] = 'f';
		}elseif(strlen($TelF)==11){
			$a['Tipo'] = 'c';
		}
		
		return $a;
	}
	
	public static function ValidaTipoPessoa($CpfCnpj){
		$tipo = (strlen($CpfCnpj) > 11) ? 'j' : 'f';
		
		return $tipo;
	}
	
	public static function CpfCnpj($CpfCnpj){
		$CpfCnpj = str_replace('-', '', $CpfCnpj);
		$CpfCnpj = str_replace('.', '', $CpfCnpj);
		$CpfCnpj = str_replace('/', '', $CpfCnpj);
		$CpfCnpj = (strlen($CpfCnpj) > 11) ? str_pad($CpfCnpj, 14, 0, STR_PAD_LEFT) : str_pad($CpfCnpj, 11, 0, STR_PAD_LEFT);
		
		return $CpfCnpj;
	}
	
	//Converte Segundos no padrão 00:00:00
	public function ToTime($sec){
		$horas = floor($sec / 3600);
		$minutos = floor(($sec - ($horas * 3600)) / 60);
		$segundos = floor($sec % 60);
		
		return $horas . ":" . str_pad($minutos, 2, '0', STR_PAD_LEFT) . ":" . str_pad($segundos, 2, '0', STR_PAD_LEFT);
	}
}
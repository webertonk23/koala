<?php
	class ValidaFicha {
		
		public $Result;
		public $Erro;
		public $Dados;
		
		
		public function ValidaCpfCnpj ($CpfCnpj){
			$Check = new Check;
			$Dados = str_replace(' .,-', '', $Check->Name($CpfCnpj));
			
			if(strlen($Dados) <  11 OR strlen($Dados) > 14){
				Erro('CPF / CNPJ Inválido', ALERTA);
			}else{
				return $Dados;				
			}			
		}
		
		public function ValidaData () {
			
		}
		
	
	
	}
?>
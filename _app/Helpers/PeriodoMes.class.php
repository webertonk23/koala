<?php
	class PeriodoMes {
		
		public $Result;
		public $Erro;
		public $Dados;
		
		
		public function UltimoDia($ano,$mes){ 
			if(((fmod($ano,4)==0) and (fmod($ano,100)!=0)) or (fmod($ano,400)==0)) { 
				$dias_fevereiro = 29; 
			}else { 
				$dias_fevereiro = 28; 
			}
		
			switch($mes) { 
				case '01': return 31; break; 
				case '02': return $dias_fevereiro; break;
				case '03': return 31; break;
				case '04': return 30; break;
				case '05': return 31; break;
				case '06': return 30; break;
				case '07': return 31; break; 
				case '08': return 31; break; 
				case '09': return 30; break; 
				case '10': return 31; break; 
				case '11': return 30; break;
				case '12': return 31; break;
			} 
		} 
	}
?>
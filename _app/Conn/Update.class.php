<?php
	class Update extends Conn {
		
		private $Tabela;
		private $Dados;
		private $Termos;
		private $Places;
		private $Resultado;
		
		private $Update;
		
		private $Conn;
		
		
		public function ExeUpdate($Tabela, array $Dados, $Termos, $ParseString){
			$this->Tabela = (string) $Tabela;
			$this->Dados = $Dados;
			$this->Termos = $Termos;
			
			parse_str($ParseString, $this->Places);
			
			$this->GetSintax();
			$this->Execute();
		}
		
		public function GetResult(){
			return $this->Resultado;
		}
		
		public function GetRowCount(){
			return $this->Update->rowCount();  
		}
		
		public function SetPlaces($ParseString){
			parse_str($ParseString, $this->Places);
			$this->GetSintax();
			$this->Execute();
		}

		//Metodos Privados
		
		private function Connect(){
			$this->Conn = parent::GetConn();
			$this->Update = $this->Conn->prepare($this->Update);
			//$this->Read->setFetchMode(PDO::FETCH_ASSOC);
		}
		
		private function GetSintax(){
			foreach($this->Dados as $Key => $Value):
				$Places[] = $Key.' = :'.$Key;
			endforeach;
			
			$Places = implode(', ', $Places);
			$this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";	
		}
		
		private function Execute(){
			$this->Connect();
			
			try{
				$this->Update->execute(array_merge($this->Dados, $this->Places));
				$this->Resultado = True;
				
			}catch (PDOException $ex){
				PHPErro($ex->getCode(), $ex->getMessage(), $ex->getFile(), $ex->getLine());			
			}
		}
	}

?>
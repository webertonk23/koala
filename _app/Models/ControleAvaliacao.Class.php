<?php
	
	class ControleAvaliacao {
	
		Private $Resultado;
		private $Chave;
		private $Dados;
		private $Tabela = "Avaliacao";
		
		public function ValidaDados(array $Dados){
			$this->Dados = $Dados;
						
			$this->Chave['Nome_Av'] = $Dados['Nome_Av'];
		}
		
		public function Existe(){
			$Termos = "";
			$Places = "";
			
			foreach(array_keys($this->Chave) as $key){
				$Termos .= "{$key} = :".$key." AND ";
				$Places .= "{$key}=".$this->Chave[$key]."&";
			}
			
			$Termos = substr($Termos, 0, -4);
			$Places = substr($Places, 0, -1);
						
			$Busca = new Read;
			$Busca->ExeRead($this->Tabela, "WHERE $Termos", $Places);
			
			if($Busca->GetRowCount()<1){
				return true;
			}	
		
		}
		
		private function SetResult ($Tipo, $Msg){
			$this->Resultado = "<div class='alert alert-$Tipo alert-dismissible text-center' role='alert'>
									<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
										<span aria-hidden='true'>&times;</span>
									</button>
									$Msg
								</div>";
		}
		
		Public function GetResult (){
			return $this->Resultado;
		}
	
		public function Criar (array $Dados){
			$this->ValidaDados($Dados);
		
			if($this->Existe()){
				
				$Insere = new Create;
				$Insere->ExeCreate($this->Tabela, $Dados);
				
				if($Insere->GetResult()>0){
					$this->SetResult("success","A Avaliação <b>{$Dados['Nome_Av']}</b> cadastrado com sucesso! No #Id <b>{$Insere->GetResult()}</b>");
				}
			}else{
				$this->SetResult("danger", "A Avaliação '<b>{$Dados['Nome_Av']}</b>' já está cadastrada nesta categoria!");
			}
		}
		
		public function Editar (array $Dados){
			$this->ValidaDados($Dados);
	
			$Id = $Dados['Id'];
			unset($Dados['Id']);
			
			$Editar = new Update;
			$Editar->ExeUpdate($this->Tabela, $Dados, "WHERE Id_Av = :Id", "Id={$Id}");
			
			if($Editar->GetRowCount()>0){
				$this->SetResult("success", "Registo <b>{$Id}</b> alterado com sucesso!");
			}
		}
		
		public function Apagar ($Id){
			$Delete = new Delete;
			$Delete->ExeDelete($this->Tabela, "WHERE Id_Av = :Id", "Id={$Id}");
		
			if($Delete->GetResult()){
				$this->SetResult("success", "Registo <b>{$Id}</b> Deletado com sucesso!");
			}
		}
		
		
	}
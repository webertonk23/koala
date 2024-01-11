<?php
	
	class ControleUsuarios {
	
		Private $Resultado;
		private $Chave;
		private $Dados;
		private $Tabela = "Usuarios";
		
		public function ValidaDados(array $Dados){
			$this->Dados = $Dados;
			$this->Chave['Usuario'] = $Dados['Usuario'];
		}
		
		public function Existe(){
			$Termos = '';
			$Places = '';
			
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
			}else{
				return false;
			}
		
		}
		
		private function SetResult ($Tipo, $Msg){
			$this->Resultado = "<div class='alert alert-$Tipo alert-dismissible' role='alert'>
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
					$this->SetResult("success","Operador <b>{$Dados['Usuario']}</b> Cadastrado com sucesso! No #Id <b>{$Insere->GetResult()}</b>");
				}
			}else{
				$this->SetResult("danger", "Usuario <b>{$Dados['Usuario']}</b> já Cadastrado!");
			}
		}
		
		public function Editar (array $Dados){
			$Id = $Dados['Id'];
			
			unset($Dados['Id']);
			
			$Editar = new Update;
			$Editar->ExeUpdate($this->Tabela, $Dados, "WHERE Id = :Id", "Id={$Id}");
			
			if($Editar->GetResult()>0){
				$this->SetResult("success", "Registo {$Id} alterado com sucesso!");
			}
		}
		
		public function Apagar ($Id_U){
			
			$Dados['Ativo'] = 0;
	
			$Editar = new Update;
			$Editar->ExeUpdate($this->Tabela, $Dados, "WHERE Id = :Id", "Id={$Id_U}");
			
			if($Editar->GetResult()){
				$this->SetResult("success", "O Usuario foi inativado");
			}
			
		}
		
		
	}
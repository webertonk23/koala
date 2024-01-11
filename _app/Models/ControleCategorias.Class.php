<?php
	
	class ControleCategorias {
	
		Private $Resultado;
		private $Chave;
		private $Dados;
		private $Tabela = "Categorias";
		
		public function ValidaDados(array $Dados){
			$this->Dados = $Dados;
			$this->Chave['Nome_Cat'] = $Dados['Nome_Cat'];
		}
		
		public function Existe(){
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
					$this->SetResult("success","A Categoria <b>{$Dados['Nome_Cat']}</b> Cadastrado com sucesso! No #Id <b>{$Insere->GetResult()}</b>");
				}
			}else{
				$this->SetResult("danger", "A Categoria <b>{$Dados['Nome_Cat']}</b> já Cadastrado!");
			}
		}
		
		public function Editar (array $Dados){
			$this->ValidaDados($Dados);
			
			if($this->Existe()){
				
				$Id = $Dados['Id_Cat'];
				unset($Dados['Id_Cat']);
				
				$Editar = new Update;
				$Editar->ExeUpdate($this->Tabela, $Dados, "WHERE Id_Cat = :Id_Cat", "Id_Cat={$Id}");
				
				if($Editar->GetResult()>0){
					$this->SetResult("success", "Registo <b>{$Dados['Id_Cat']}</b> alterado com sucesso!}");
				}
			}else{
				$this->SetResult("danger", "Categoria <b>{$Dados['Nome_Cat']}</b> já Cadastrado!");
			}
		}
		
		public function Apagar ($Id){
			$Delete = new Delete;
			$Delete->ExeDelete($this->Tabela, "WHERE Id_Cat = :Id", "Id={$Id}");
		
			if($Delete->GetResult()){
				$this->SetResult("success", "Registo {$Id} Deletado com sucesso!");
			}
		}
		
		
	}
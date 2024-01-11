<?php
	
	class ControleGerenciaAvaliacao {
	
		Private $Resultado;
		private $Chave;
		private $Dados;
		private $Tabela = "Avaliacao_Itens";
		
		public function ValidaDados(array $Dados){
			$this->Dados = $Dados;
			$this->Chave['Id_Avaliacao'] = $Dados['Id_Avaliacao'];			
			$this->Chave['Pergunta'] = $Dados['Pergunta'];
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
					$this->SetResult("success","A pergunta <b>{$Dados['Pergunta']}</b> foi inclusa com sucesso!");
				}
			}else{
				$this->SetResult("danger", "A pergunta '<b>{$Dados['Pergunta']}</b>' já está cadastrada nesta avaliação e não pode ser inclusa novamente!");
			}
		}
		
		public function Editar (array $Dados){
			//$this->ValidaDados($Dados);
			
			$Verifica = new Read;
			$Verifica->ExeRead($this->Tabela, "WHERE Id_Avaliacao = :Id_Avaliacao AND Pergunta = :Pergunta AND Id_Itens <> :Id", "Id_Avaliacao={$Dados['Id_Avaliacao']} & Pergunta={$Dados['Pergunta']} & Id={$Dados['Id_Itens']}");
			if($Verifica->GetRowCount()>0){
				$this->SetResult("danger", "A pergunta '<b>{$Dados['Pergunta']}</b>' já está cadastrada nesta avaliação e não pode ser inclusa novamente!");
			}else{
				
				$Id = $Dados['Id_Itens'];
				unset($Dados['Id_Itens']);
			
				$Editar = new Update;
				$Editar->ExeUpdate($this->Tabela, $Dados, "WHERE Id_Itens = :Id", "Id={$Id}");
				
				if($Editar->GetRowCount()>0){
					$this->SetResult("success", "Registo <b>{$Id}</b> alterado com sucesso!");
				}
			}
		}
		
		public function Apagar ($Id){
			$Delete = new Update;
			
			$Dados['Ativo'] = 0;
			$Delete->ExeUpdate($this->Tabela, $Dados, "WHERE Id_Itens = :Id", "Id={$Id}");
		
			if($Delete->GetResult()){
				$this->SetResult("success", "Registo <b>{$Id}</b> Deletado com sucesso!");
			}
		}
		
		
	}
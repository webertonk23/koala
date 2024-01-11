<?php
	
	class Import_{
		
		Private $Dados;
		Private $Carteira;
		Private $Layout;
		Private $Arquivo;
		private $Result;
		private $Erro;
		
		function __Construct($Dados = array(), $Cart = int, $Layout = int, $Arq = null){
			$this->Dados = (object) $Dados;
			$this->Carteira = $Cart;
			$this->Layout['Colunas'] = explode(";",$this->GetLayout($Layout)['Colunas_lay']);
			$this->Layout['Tipo'] = explode(";", strtolower($this->GetLayout($Layout)['Tipo_lay']));
			$this->Arquivo = $Arq;
		}
		
		private function GetLayout($Id_Lay){
			$Read = new Read;
			$Read->ExeRead('Layout', "WHERE Id_Lay = :Id", "Id={$Id_Lay}");
			
			return ($Read->GetRowCount()) ? $Read->GetResult()[0] : null;
		}
		
		public function ProcImport(){
			if(!empty($this->Dados) AND is_array($this->Dados)){	
				foreach($this->Dados as $Chave => $Valores){
					$i = 0;
					foreach($this->Layout['Tipo'] as $Key => $Values){
						if(preg_match("/_pes/", $Values)){
							$Registros['Pessoal'][$Values] = $Valores[$this->Layout['Colunas'][$Key]];
						}else if(preg_match("/_tel/", $Values)){
								$Registros['Telefones'][$i][$Values] = $Valores[$this->Layout['Colunas'][$Key]];
								$i++;
						}else if(preg_match("/_ficha/", $Values)){
							$Registros['Fichas'][$Values] = $Valores[$this->Layout['Colunas'][$Key]];
						}
					}
					
					$Registros = (object) $Registros;
					
					$this->IncPes($this->ValidaDados($Registros));
				}
			}else{
				$Erro = "Dados importantes não foram passados";
			}
		}
		
		private function IncPes($Dados = array()){
			
			$Read = new Read;
			$Create = new Create;
			
			
			$Read->ExeRead("Pessoas", "WHERE cpfcnpj_pes = :cpfcnpj_pes", "cpfcnpj_pes={$Dados['Pessoal']['cpfcnpj_pes']}");
			$Pessoa = ($Read->GetRowCount() > 0) ? $Read->GetResult()[0]['Id_Pes'] : null;
			
			if($Pessoa){
				if(!empty($Dados['Telefones'])){	
					foreach($Dados['Telefones'] as $T){
						$Read->ExeRead("Telefones", "WHERE idPes_tel = :IdPes AND CONCAT(ddd_tel, telefone_tel) = :Telefone", "IdPes={$Pessoa}&Telefone={$T['telefone_tel']}");
						
						if($Read->GetRowCount() == 0){
							$T['ddd_tel'] = substr($T['telefone_tel'], 0, 2);
							$T['telefone_tel'] = substr($T['telefone_tel'], 2, strlen($T['telefone_tel']));
							$T['Origem_tel'] = 'Importacao';
							$T['IdPes_tel'] = $Pessoa;
							
							//$Create->ExeCreate('Telefones', $T);
						}
					}
				}
				
				$Dados['Fichas']['idpes_ficha'] = $Pessoa;
				
				$Read->ExeRead("Fichas", "WHERE idPes_ficha = :idPes_ficha AND contrato_ficha = :Contrato AND IdCart_ficha = :IdCart_ficha", "idPes_ficha={$Pessoa}&Contrato={$Dados['Fichas']['contrato_ficha']}&IdCart_ficha={$Dados['Fichas']['IdCart_ficha']}");
				
				if($Read->GetRowCount() == 0){
					//$Create->ExeCreate('Fichas', $Dados['Fichas']);
				}
				
			}else{
				//$Create->ExeCreate('Pessoas', $Dados['Pessoal']);
				
				$Pessoa = $Create->GetResult();
				
				if(!empty($Dados['Telefones'])){
					foreach($Dados['Telefones'] as $T){
						$Read->ExeRead("Telefones", "WHERE idPes_tel = :IdPes AND CONCAT(ddd_tel, telefone_tel) = :Telefone", "IdPes={$Pessoa}&Telefone={$T['telefone_tel']}");
						
						if($Read->GetRowCount() == 0){
							$T['ddd_tel'] = substr($T['telefone_tel'], 0, 2);
							$T['telefone_tel'] = substr($T['telefone_tel'], 2, strlen($T['telefone_tel']));
							$T['Origem_tel'] = 'Importacao';
							$T['IdPes_tel'] = $Pessoa;
							
							$Create->ExeCreate('Telefones', $T);
						}
					}
				}
				
				$Dados['Fichas']['idpes_ficha'] = $Pessoa;
				
				$Read->ExeRead("Fichas", "WHERE idPes_ficha = :idPes_ficha AND contrato_ficha = :Contrato AND IdCart_ficha = :IdCart_ficha", "idPes_ficha={$Pessoa}&Contrato={$Dados['Fichas']['contrato_ficha']}&IdCart_ficha={$Dados['Fichas']['IdCart_ficha']}");
				
				if($Read->GetRowCount() == 0){
					$Create->ExeCreate('Fichas', $Dados['Fichas']);
				}	
			}
		}
		
		private function ValidaDados($Dados){
			$Check = new Check;
			
			$Dados['Pessoal']['cpfcnpj_pes'] = $Check->CpfCnpj($Dados['Pessoal']['cpfcnpj_pes']);
			$Dados['Pessoal']['tipo_pes'] = $Check->ValidaTipoPessoa($Dados['Pessoal']['cpfcnpj_pes']);
			$Dados['Pessoal']['nome_pes'] = $Check->Name($Dados['Pessoal']['nome_pes']);
			
			if(!empty($Dados['Pessoal']['nomemae_pes'])){
				$Dados['Pessoal']['nomemae_pes'] = $Check->Name($Dados['Pessoal']['nomemae_pes']);
			}else if(isset($Dados['Pessoal']['nomemae_pes'])){
				unset($Dados['Pessoal']['nomemae_pes']);
			}
			
			if(!empty($Dados['Pessoal']['dtnasc_pes'])){
				$Dados['Pessoal']['dtnasc_pes'] = $Check->DataI2($Dados['Pessoal']['dtnasc_pes']);
			}else if(isset($Dados['Pessoal']['dtnasc_pes'])){
				unset($Dados['Pessoal']['dtnasc_pes']);
			}
			
			if(!empty($Dados['Pessoal']['sexo_pes'])){
				$Dados['Pessoal']['sexo_pes'] = substr($Dados['Pessoal']['sexo_pes'], 0, 1);
				$Dados['Pessoal']['sexo_pes'] = ($Dados['Pessoal']['sexo_pes'] == 'F' OR $Dados['Pessoal']['sexo_pes'] == 'M') ? $Dados['Pessoal']['sexo_pes'] : 'I';
			}else if(isset($Dados['Pessoal']['sexo_pes'])){
				unset($Dados['Pessoal']['sexo_pes']);
			}
			
			if(!empty($Dados['Pessoal']['logradouro_pes'])){
				$Dados['Pessoal']['logradouro_pes'] = $Check->Name($Dados['Pessoal']['logradouro_pes']);
			}else if(isset($Dados['Pessoal']['logradouro_pes'])){
				unset($Dados['Pessoal']['logradouro_pes']);
			}
			
			if(!empty($Dados['Pessoal']['numero_pes'])){
				$Dados['Pessoal']['numero_pes'] = (int) $Dados['Pessoal']['numero_pes'];
			}else if(isset($Dados['Pessoal']['numero_pes'])){
				unset($Dados['Pessoal']['numero_pes']);
			}
			
			if(!empty($Dados['Pessoal']['complemento_pes'])){
				$Dados['Pessoal']['complemento_pes'] = $Check->Name($Dados['Pessoal']['complemento_pes']);
			}else if(isset($Dados['Pessoal']['complemento_pes'])){
				unset($Dados['Pessoal']['complemento_pes']);
			}
			
			if(!empty($Dados['Pessoal']['bairro_pes'])){
				$Dados['Pessoal']['bairro_pes'] = $Check->Name($Dados['Pessoal']['bairro_pes']);
			}else if(isset($Dados['Pessoal']['bairro_pes'])){
				unset($Dados['Pessoal']['bairro_pes']);
			}
			
			if(!empty($Dados['Pessoal']['cidade_pes'])){
				$Dados['Pessoal']['cidade_pes'] = $Check->Name($Dados['Pessoal']['cidade_pes']);
			}else if(isset($Dados['Pessoal']['cidade_pes'])){
				unset($Dados['Pessoal']['cidade_pes']);
			}
			
			if(!empty($Dados['Pessoal']['estado_pes'])){
				$Dados['Pessoal']['estado_pes'] = $Check->Name($Dados['Pessoal']['estado_pes']);
			}else if(isset($Dados['Pessoal']['estado_pes'])){
				unset($Dados['Pessoal']['estado_pes']);
			}
			
			if(!empty($Dados['Pessoal']['cep_pes'])){
				$Dados['Pessoal']['cep_pes'] = $Check->Name($Dados['Pessoal']['cep_pes']);
			}else if(isset($Dados['Pessoal']['cep_pes'])){
				unset($Dados['Pessoal']['cep_pes']);
			}
			
			if(!empty($Dados['Pessoal']['rg_pes'])){
				$Dados['Pessoal']['rg_pes'] = $Check->Name($Dados['Pessoal']['rg_pes']);
			}else if(isset($Dados['Pessoal']['rg_pes'])){
				unset($Dados['Pessoal']['rg_pes']);
			}
			
			if(!empty($Dados['Pessoal']['orgaorg_pes'])){
				$Dados['Pessoal']['orgaorg_pes'] = $Check->Name($Dados['Pessoal']['orgaorg_pes']);
			}else if(isset($Dados['Pessoal']['orgaorg_pes'])){
				unset($Dados['Pessoal']['orgaorg_pes']);
			}
			
			if(!empty($Dados['Pessoal']['ufrg_pes'])){
				$Dados['Pessoal']['ufrg_pes'] = $Check->Name($Dados['Pessoal']['ufrg_pes']);
			}else if(isset($Dados['Pessoal']['ufrg_pes'])){
				unset($Dados['Pessoal']['ufrg_pes']);
			}
			
			if(!empty($Dados['Pessoal']['dtemissaorg_pes'])){
				$Dados['Pessoal']['dtemissaorg_pes'] = $Check->DataI($Dados['Pessoal']['dtemissaorg_pes']);
			}else if(isset($Dados['Pessoal']['dtemissaorg_pes'])){
				unset($Dados['Pessoal']['dtemissaorg_pes']);
			}			
			
			if(!empty($Dados['Telefones'])){
				foreach($Dados['Telefones'] as $K => $V){
					$a = $Check->ValidaTelefone($V['telefone_tel']);
					
					if($a['Fone'] != 0){
						$Dados['Telefones'][$K]['telefone_tel'] = $a['Fone'];
						$Dados['Telefones'][$K]['Tipo_tel'] = $a['Tipo'];
					}else{
						unset($Dados['Telefones'][$K]);
					}
				}
			}else{
				$Dados['Telefones'] = null;
			}
			
			
			$Dados['Fichas']['IdCart_ficha'] = $this->Carteira;
			$Dados['Fichas']['contrato_ficha'] = (!empty($Dados['Fichas']['contrato_ficha'])) ? $Dados['Fichas']['contrato_ficha'] : '';
			$Dados['Fichas']['ArqInc_ficha'] = $this->Arquivo;
			
			if(!empty($Dados['Fichas']['codesp_ficha'])){
				$Dados['Fichas']['codesp_ficha'] = (int) $Dados['Fichas']['codesp_ficha'];
			}else if(isset($Dados['Fichas']['codesp_ficha'])){
				unset($Dados['Fichas']['codesp_ficha']);
			}
			
			if(!empty($Dados['Fichas']['especie_ficha'])){
				$Dados['Fichas']['especie_ficha'] = $Check->Name($Dados['Fichas']['especie_ficha']);
			}else if(isset($Dados['Fichas']['especie_ficha'])){
				unset($Dados['Fichas']['especie_ficha']);
			}
			
			if(!empty($Dados['Fichas']['meiopgt_ficha'])){
				$Dados['Fichas']['meiopgt_ficha'] = (int) $Dados['Fichas']['meiopgt_ficha'];
			}else if(isset($Dados['Fichas']['meiopgt_ficha'])){
				unset($Dados['Fichas']['meiopgt_ficha']);
			}
			
			if(!empty($Dados['Fichas']['meiopgtdesc_ficha'])){
				$Dados['Fichas']['meiopgtdesc_ficha'] = $Check->Name($Dados['Fichas']['meiopgtdesc_ficha']);
			}else if(isset($Dados['Fichas']['meiopgtdesc_ficha'])){
				unset($Dados['Fichas']['meiopgtdesc_ficha']);
			}
			
			if(!empty($Dados['Fichas']['banco_ficha'])){
				$Dados['Fichas']['banco_ficha'] = (int) $Dados['Fichas']['banco_ficha'];
			}else if(isset($Dados['Fichas']['banco_ficha'])){
				unset($Dados['Fichas']['banco_ficha']);
			}
			
			if(!empty($Dados['Fichas']['agencia_ficha'])){
				$Dados['Fichas']['agencia_ficha'] = (int) $Dados['Fichas']['agencia_ficha'];
			}else if(isset($Dados['Fichas']['agencia_ficha'])){
				unset($Dados['Fichas']['agencia_ficha']);
			}
			
			if(!empty($Dados['Fichas']['cc_ficha'])){
				$Dados['Fichas']['cc_ficha'] = (int) $Dados['Fichas']['cc_ficha'];
			}else if(isset($Dados['Fichas']['cc_ficha'])){
				unset($Dados['Fichas']['cc_ficha']);
			}
			
			if(!empty($Dados['Fichas']['ccdv_ficha'])){
				$Dados['Fichas']['ccdv_ficha'] = (int) $Dados['Fichas']['ccdv_ficha'];
			}else if(isset($Dados['Fichas']['ccdv_ficha'])){
				unset($Dados['Fichas']['ccdv_ficha']);
			}
			
			if(!empty($Dados['Fichas']['ufatual_ficha'])){
				$Dados['Fichas']['ufatual_ficha'] = $Check->Name($Dados['Fichas']['ufatual_ficha']);
			}else if(isset($Dados['Fichas']['ufatual_ficha'])){
				unset($Dados['Fichas']['ufatual_ficha']);
			}
			
			if(!empty($Dados['Fichas']['salario_ficha'])){
				$Dados['Fichas']['salario_ficha'] = (float) str_replace(",", ".", str_replace(".", "", $Dados['Fichas']['salario_ficha']));
			}else if(isset($Dados['Fichas']['salario_ficha'])){
				unset($Dados['Fichas']['salario_ficha']);
			}
			
			if(!empty($Dados['Fichas']['margem_ficha'])){
				$Dados['Fichas']['margem_ficha'] = (float) str_replace(",", ".", str_replace(".", "", $Dados['Fichas']['margem_ficha']));
			}else if(isset($Dados['Fichas']['margem_ficha'])){
				unset($Dados['Fichas']['margem_ficha']);
			}
			
			if(!empty($Dados['Fichas']['limite_ficha'])){
				$Dados['Fichas']['limite_ficha'] = (float) str_replace(",", ".", str_replace(".", "", $Dados['Fichas']['limite_ficha']));
			}else if(isset($Dados['Fichas']['limite_ficha'])){
				unset($Dados['Fichas']['limite_ficha']);
			}
			
			if(!empty($Dados['Fichas']['valorop_ficha'])){
				$Dados['Fichas']['valorop_ficha'] = (float) str_replace(",", ".", str_replace(".", "", $Dados['Fichas']['valorop_ficha']));
			}else if(isset($Dados['Fichas']['valorop_ficha'])){
				unset($Dados['Fichas']['valorop_ficha']);
			}
			
			if(!empty($Dados['Fichas']['somaparc_ficha'])){
				$Dados['Fichas']['somaparc_ficha'] = $Dados['Fichas']['somaparc_ficha'];
			}else if(isset($Dados['Fichas']['somaparc_ficha'])){
				unset($Dados['Fichas']['somaparc_ficha']);
			}
			
			if(!empty($Dados['Fichas']['qtdemp_ficha'])){
				$Dados['Fichas']['qtdemp_ficha'] = $Dados['Fichas']['qtdemp_ficha'];
			}else if(isset($Dados['Fichas']['qtdemp_ficha'])){
				unset($Dados['Fichas']['qtdemp_ficha']);
			}
			
			if(!empty($Dados['Fichas']['desent_ficha'])){
				$Dados['Fichas']['desent_ficha'] = $Check->Name($Dados['Fichas']['desent_ficha']);
			}else if(isset($Dados['Fichas']['desent_ficha'])){
				unset($Dados['Fichas']['desent_ficha']);
			}
			
			if(!empty($Dados['Fichas']['ent_ficha'])){
				$Dados['Fichas']['ent_ficha'] = (int) $Dados['Fichas']['ent_ficha'];
			}else if(isset($Dados['Fichas']['ent_ficha'])){
				unset($Dados['Fichas']['ent_ficha']);
			}
			
			if(!empty($Dados['Fichas']['limitesaque_ficha'])){
				$Dados['Fichas']['limitesaque_ficha'] = (float) str_replace(",", ".", str_replace(".", "", $Dados['Fichas']['limitesaque_ficha']));
			}else if(isset($Dados['Fichas']['limitesaque_ficha'])){
				unset($Dados['Fichas']['limitesaque_ficha']);
			}

			return $Dados;
		}
		
		
	}
	

?>
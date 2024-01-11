<?php
	
	class AvaliacaoPerfil {
		
		Private $Respostas;
		Private $Erro = false;
		Private $Perfil;
		Private $Tempo;
		Private $Result;
		
		public function SetItens($Respostas = array(), $Time){
			
			$this->Respostas = $Respostas;
			$this->Tempo =  time() - $Time;
			$this->Perfil = array(
				'Persuasao' => 0,
				'Afirmacao' => 0,
				'Ligacao' => 0,
				'Atracao' => 0,
				'Recuo' => 0
			);
			
			$this->ProcessaResposta();
		}
		
		public function GetResult(){
			if(!$this->Erro){
				return Erro("<strong class='h6'>Perfil: ".$this->Result['Desc']."</strong><br><p>".$this->Result['Obs']."</p>" , INFO);
			}else{
				return Erro($this->Erro, ERRO);
				
			}	
		}	
		
		private function ProcessaResposta(){
			if(!empty($this->Respostas)){
				$q = '';
				foreach($this->Respostas as $key => $Values){
					
					$this->Perfil['Persuasao'] += $Values['Persuasao'];
					$this->Perfil['Afirmacao'] += $Values['Afirmacao'];
					$this->Perfil['Ligacao'] += $Values['Ligacao'];
					$this->Perfil['Atracao'] += $Values['Atracao'];
					$this->Perfil['Recuo'] += $Values['Recuo'];
					
					$q .= (array_sum($Values) != 15) ? $key." " : "";
				}
				
				if(array_sum($this->Perfil) != 180){
					$this->Erro = "Gentilez revisar respostas, alguma situação possui respostas repetidas nas situações $q.";
				}else{
					$this->Erro = false;
					arsort($this->Perfil);
					
					if(array_keys($this->Perfil)[0] == 'Persuasao'){
						$this->Result['Desc'] = 'PERSUASÃO';
						$this->Result['Obs'] = '<strong>Características:</strong> consiste em levar os outros a aceitarem suas ideias. Preocupação com argumentos racionais e insistentes.<br>';
						$this->Result['Obs'] .= '<strong>Comportamentos típicos:</strong> fazer sugestões e proposições, argumentar, raciocinar e justificar antes de chegar à conclusão ou proposta.<br>';
						$this->Result['Obs'] .= '<strong>Distorções:</strong> Dispersão. Pode insistir demais nos argumentos, sem fazer propostas concretas.';
					}else if(array_keys($this->Perfil)[0] == 'Afirmacao'){
						$this->Result['Desc'] = 'AFIRMAÇÃO';
						$this->Result['Obs'] = '<strong>Característica:</strong> consiste em se impor e julgar os outros. Exposição enfática de posições e opiniões.<br>';
						$this->Result['Obs'] .= '<strong>Comportamentos típicos:</strong> demonstrar claramente seus desejos, exigências, normas, pontos de vistas; avaliar os outros e a si mesmo, punir ou oferecer recompensas.<br>';
						$this->Result['Obs'] .= '<strong>Distorções:</strong> autoritarismo. Pressiona para que suas idéias sejam aceitas sem discussão.';
					}else if(array_keys($this->Perfil)[0] == 'Ligacao'){
						$this->Result['Desc'] = 'LIGAÇÃO';
						$this->Result['Obs'] = '<strong>Característica:</strong> consiste em se impor e julgar os outros. Exposição enfática de posições e opiniões.<br>';
						$this->Result['Obs'] .= '<strong>Comportamentos típicos:</strong> demonstrar claramente seus desejos, exigências, normas, pontos de vistas; avaliar os outros e a si mesmo, punir ou oferecer recompensas.<br>';
						$this->Result['Obs'] .= '<strong>Distorções:</strong> autoritarismo. Pressiona para que suas idéias sejam aceitas sem discussão.';
					}else if(array_keys($this->Perfil)[0] == 'Atracao'){
						$this->Result['Desc'] = 'ATRAÇÃO';
						$this->Result['Obs'] = '<strong>Características:</strong> consiste em se abrir ao outro e buscar dominá-lo. Envolvimento do interlocutor através de empatia e sedução.<br>';
						$this->Result['Obs'] .= '<strong>Comportamento típico:</strong> estimular os outros, atrair, seduzir, manifestar seus atributos; contaminar os outros através do seu próprio comportamento. Partilha informações, reconhece seus erros e dúvidas e busca aproximação emocional e pessoal.<br>';
						$this->Result['Obs'] .= '<strong>Distorções:</strong> falsidade. Levantam falhas e dificuldades inexistentes. Usa excessivamente o lado emocional.';
					}else if(array_keys($this->Perfil)[0] == 'Recuo'){
						$this->Result['Desc'] = 'ATRAÇÃO';
						$this->Result['Obs'] = '<strong>Características:</strong> consiste em se afastar, transferir as situações bloqueadas. Vacila diante de situação difíceis e conflitivas.<br>';
						$this->Result['Obs'] .= '<strong>Comportamentos típicos:</strong> reduzir conflitos, usar o recuo em situação de bloqueio. Adia a negociação, muda de assunto quando surgem grandes dificuldades e usa o humor para amenizar os problemas.<br>';
						$this->Result['Obs'] .= '<strong>Distorções:</strong> fuga. Evita controvérsias e mantém distância de situações mais complexas.';
					}
				}
			}
		}
	}

?>
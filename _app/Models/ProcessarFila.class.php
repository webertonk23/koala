<?php
	class ProcessarFila{
		
		public $Result;
		public $Erro;
		
		public function Proc(){			
			$Filas = $this->GetFilas();
			
			$Limpa = $this->SetFilas();
			
			Erro("<b>{$Limpa}</b> fichas tiveram suas filas resetadas!", INFO);
			Erro("Iniciando processamento de filas para as fichas", INFO);
			
			if($Filas){
				foreach($Filas as $Values){
					$Alt = $this->SetFilas($Values);
					Erro("<b>{$Alt}</b> fichas entraram para a fila <b>{$Values['Desc_fila']}</b>!", INFO);
				}
				//Debug($Filas);
			}

		}
		
		private function GetFilas(){
			$Read = new Read;
			$Read->FullRead("
				SELECT 
					Id_fila,
					Desc_fila,
					Seq_fila,
					Cart_fila,
					IdadeDe_fila,
					IdadeAte_fila,
					Sexo_fila,
					Cidades_fila,
					Mailing_fila,
					Estado_fila,
					MargemDe_fila,
					MargemAte_fila,
					LimiteDe_fila,
					LimiteAte_fila,
					SalarioDe_fila,
					SalarioAte_fila,
					QtdConDe_fila,
					QtdConAte_fila,
					ScoreDe_fila,
					ScoreAte_fila,
					DtAtuDe_fila,
					DtAtuAte_fila,
					especie_fila,
					entidade_fila,
					convenio_fila
				FROM
					fila
				WHERE
					Ativo_fila = 1
				ORDER BY
					Seq_fila ASC
			");
			
			if($Read->GetRowCount()>0){
				$Fila = $Read->GetResult();
			}
			
			return ($Read->GetRowCount() > 0) ? $Read->GetResult() : null;
		}
		
		private function SetFilas($IdFila = null){
			$Update = new Update;
			
			if($IdFila==null){
				$Fila['IdFila_ficha'] = '0';
				
				$Update->ExeUpdate('fichas', $Fila, "WHERE IdFila_ficha != 0", "");
			}else{
				$Fila['IdFila_ficha'] = $IdFila['Id_fila'];
				
				$Cidade = (!empty($IdFila['Cidades_fila'])) ? "AND Cidade_Pes IN (".$IdFila['Cidades_fila'].")" : '';
				$Estado = (!empty($IdFila['Estado_fila'])) ? "AND Estado_Pes IN (".$IdFila['Estado_fila'].")" : '';
				$Sexo = (!empty($IdFila['Sexo_fila'])) ? "AND Sexo_Pes IN (".$IdFila['Sexo_fila'].")" : '';
				$Mailing = (!empty($IdFila['Mailing_fila'])) ? "AND ArqInc_Ficha IN (".$IdFila['Mailing_fila'].")" : '';
				$Especie = (!empty($IdFila['especie_fila'])) ? "AND codesp_ficha IN (".$IdFila['especie_fila'].")" : '';
				$Entidade = (!empty($IdFila['entidade_fila'])) ? "AND Ent_ficha IN (".$IdFila['entidade_fila'].")" : '';
				$Convenio = (!empty($IdFila['convenio_fila'])) ? "AND convenio_ficha IN (".$IdFila['convenio_fila'].")" : '';
				
				$Update->ExeUpdate(
					'fichas',
					$Fila,
					"WHERE
						IdFila_ficha = 0
						AND IdCart_ficha IN (".$IdFila['Cart_fila'].")
						{$Mailing}
						{$Especie}
						{$Entidade}
						{$Convenio}
						AND Margem_ficha BETWEEN '".$IdFila['MargemDe_fila']."' AND '".$IdFila['MargemAte_fila']."'
						AND LimiteSaque_ficha BETWEEN '".$IdFila['LimiteDe_fila']."' AND '".$IdFila['LimiteAte_fila']."'
						AND Salario_ficha BETWEEN '".$IdFila['SalarioDe_fila']."' AND '".$IdFila['SalarioAte_fila']."'
						AND QtdEmp_ficha BETWEEN '".$IdFila['QtdConDe_fila']."' AND '".$IdFila['QtdConAte_fila']."'
						AND DtAtu_ficha BETWEEN '".$IdFila['DtAtuDe_fila']."' AND '".$IdFila['DtAtuAte_fila']."'
						AND IdPes_Ficha IN (
							SELECT Id_Pes FROM Pessoas
							WHERE
								DATEDIFF(YEAR, DtNasc_Pes, GETDATE()) BETWEEN '".$IdFila['IdadeDe_fila']."' AND '".$IdFila['IdadeAte_fila']."'
								{$Cidade}
								{$Sexo}
								{$Estado}
								AND Score_Pes BETWEEN '".$IdFila['ScoreDe_fila']."' AND '".$IdFila['ScoreAte_fila']."'
						)",
					"");
					
					//Debug($Update);
			}
			
			return $Update->GetRowCount();
		}
	}


?>
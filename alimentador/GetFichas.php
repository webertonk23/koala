
<?php
	set_time_limit(6000);
	require('../_app/Config.inc.php');
	
	$Read = new Read;

	$Fila =  json_decode(file_get_contents('php://input'));
	
	$Query = "
		SELECT
			DISTINCT TOP 1000 CONCAT(id_pes,'-',Id_ficha) as id,
			Nome_Pes as contact_name,
			Telefones_Vw as 'to'
		FROM
			pessoas WITH (NOLOCK) INNER JOIN fichas WITH (NOLOCK) ON Id_Pes = IdPes_Ficha
			INNER JOIN Vw_Telefones ON Id_pes = IdPes_Vw
			LEFT JOIN FilaDiscador WITH (NOLOCK) ON Id_Pes = IdPes_filad AND DescFila_filad = '{$Fila->iddisc_fila}' AND Status_filad IS NULL
		WHERE
			IdCart_ficha IN ({$Fila->Cart_fila}) 
			AND ArqInc_Ficha IN ({$Fila->Mailing_fila}) 
			AND DATEDIFF( YEAR, DtNasc_Pes, GETDATE()) BETWEEN '{$Fila->IdadeDe_fila}' AND '{$Fila->IdadeAte_fila}' 
			AND Margem_ficha BETWEEN '{$Fila->MargemDe_fila}' AND '{$Fila->MargemAte_fila}' 
			AND LimiteSaque_ficha BETWEEN '{$Fila->LimiteDe_fila}' AND '{$Fila->LimiteAte_fila}' 
			AND Salario_ficha BETWEEN '{$Fila->SalarioDe_fila}' AND '{$Fila->SalarioAte_fila}'
			AND QtdEmp_ficha BETWEEN '{$Fila->QtdConDe_fila}' AND '{$Fila->QtdConAte_fila}'
			AND Score_Pes BETWEEN '{$Fila->ScoreDe_fila}' AND '{$Fila->ScoreAte_fila}'
			AND Sexo_Pes IN ({$Fila->Sexo_fila}) 
			AND Estado_Pes IN ({$Fila->Estado_fila})
			AND Telefones_Vw IS NOT NULL
			AND Final_ficha = 0
			AND DtProxAcio_Ficha <= GETDATE()
			AND IdPes_filad IS NULL
	";
	
	$Read->FullRead( $Query);
	
	echo ($Read->GetRowCount() > 0) ? json_encode($Read->GetResult()) : null;
	
?>
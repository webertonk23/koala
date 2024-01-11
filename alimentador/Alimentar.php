
<?php
	set_time_limit(6000);
	require('../_app/Config.inc.php');
	
	$Read = new Read;
	
	$IgDDD = (!empty($Value['IgnoraDDD_fila'])) ? explode(",",$Value['IgnoraDDD_fila']) : null;
	
	// $IdDisc = $_POST[''] ;
	
	$Query = "
		SELECT
			DISTINCT TOP 1000 CONCAT(id_pes,'-',Id_ficha) as id,
			Nome_Pes as contact_name,
			Telefones_Vw as 'to',
			DtProxAcio_Ficha
		FROM
			pessoas WITH (NOLOCK) INNER JOIN fichas WITH (NOLOCK) ON Id_Pes = IdPes_Ficha
			INNER JOIN Vw_Telefones ON Id_pes = IdPes_Vw
			LEFT JOIN FilaDiscador WITH (NOLOCK) ON Id_Pes = IdPes_filad AND DescFila_filad = 'pesquisa04' AND Status_filad IS NULL
		WHERE
			IdCart_ficha IN ('16') 
			AND ArqInc_Ficha IN ('2020-07-16 CABECEIRA GRANDE.csv', '2020-07-13 CABECEIRA GRANDE.csv' ) 
			AND DATEDIFF( YEAR, DtNasc_Pes, GETDATE()) BETWEEN '0' AND '9999' 
			AND Margem_ficha BETWEEN '0.0' AND '99999.0' 
			AND LimiteSaque_ficha BETWEEN '0.0' AND '99999.0' 
			AND Sexo_Pes IN ( 'M', 'F', 'I' ) 
			AND Estado_Pes IN ( 'Mg' )
			AND Telefones_Vw IS NOT NULL
			AND Final_ficha = 0
			AND DtProxAcio_Ficha <= GETDATE()
		ORDER BY
			DtProxAcio_Ficha ASC
	";
	
	echo $Query;
	
?>
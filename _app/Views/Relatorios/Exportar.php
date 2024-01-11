<?php
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	
	if(isset($_POST['Exportar'])){
		header("Content-type: application/vnd.ms-excel");   // Determina que o arquivo é uma planilha do Excel
		header("Content-type: application/force-download");   // Força o download do arquivo
		header("Content-Disposition: attachment; filename={$_GET['r']} - ".date('Y-m-d His').".xls");
		header("Pragma: no-cache"); // Imprime o conteúdo da nossa tabela no arquivo que será gerado

		echo utf8_decode($_POST['Tabela']);
	}

?>
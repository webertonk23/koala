<!DOCTYPE html>
<?php
	require('./_app/Config.inc.php');
	
	if(isset($_GET['p'])){
		if($_GET['p'] == 'Sair'){
			include("./_app/Views/Sair.php");
		}else if($_GET['p'] == 'Submit'){
			include("./_app/Views/Submit.php");
		}
	}
?>

<html lang="pt-br" style='height : 100%'>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Weberton Kaic">
		
		
		<!-- Bootstrap core CSS -->
		<link href="bootstrap-4.5.2/css/bootstrap.min.css" rel="stylesheet">
		
		<!--external css-->
		<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
		
		<!-- Custom styles for this template -->
		<link href="css/style2.css" rel="stylesheet">
		
		
		<script src="lib/vonix-1.6.min.js"></script>
		
		<link href="css/switch.css" rel="stylesheet" media="screen">
		
		<title>Koala CRM - Grupo Asa</title>
	</head>
	
	<body style='height : 100%'>
		<div  style='height : 100%'>
			<?php
				$Read = new Read;
				$sess = session_id();
				$Read->ExeRead('session', "WHERE session_sess = :sess AND dtlogout_sess IS NULL", "sess={$sess}");
				$Update = new Update;
				if($Read->GetRowCount()==0){
					session_regenerate_id();
					include_once("./_app/Views/Login.php");
				}else if(isset($_SESSION['Usuario'])){
					if(isset($_GET['p'])){
						$p = (strcasecmp($_GET['p'], 'Login') == 0) ? "Inicio" : $_GET['p'];
					}else{
						$p='Inicio';
					}
					include("./_app/Views/Cabecalho.php");
					
					$sessison['ultacao_sess'] = date("Y-m-d H:i:s");
					$sessison['pag_sess'] = $_SERVER['QUERY_STRING'];
		
					
					$Update->ExeUpdate('session', $sessison, "WHERE session_sess = :sess", "sess={$sess}");			
			?>		
			
			<div class='container col mt-3' style='height : 86%'>
			
				<?php
						$Dir = "./_app/Views/".$p.".php";
						
						if(file_exists($Dir)){
							include($Dir);
						}else{
							include("./_app/Views/404_error.php");//echo "A pagina: ".$get.".php não existe";
						}
					}else{
						include_once("./_app/Views/Login.php");
					}
				?>
			</div>
		</div>
		
		<script src="lib/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="lib/jquery.backstretch.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="./bootstrap-4.5.2/js/bootstrap.min.js" ></script>
	
	
		<script>
			$.backstretch("img/asa.jpg", {
			  speed: 500
			});
			
			// $.backstretch("img/img01.png", {
			  // speed: 500
			// });
		</script>
	</body>
</html>
<?php
	$Read = new Read;
	$Read->FullRead("
		SELECT 
			*
		FROM
			session INNER JOIN usuarios ON Iduser_sess = Id_user
		WHERE
			dtlogout_sess IS NULL
	");
			
	if($Read->GetRowCount()>0){
		$Usuarios = $Read->GetResult();
	}
	
?>

<div class='card' style='height : 100%'>
	<div class='card-body'>
		<div class='row' style='height : 100%'>
			<div class='col-sm-3'>
				<?php
					if(!empty($Usuarios)){
						foreach ($Usuarios as $key => $value){
							echo "<div class='card border-0'>";
							echo "	<div class='card-body'>";
							echo "		<a>{$value['Usuario_user']}</a>";
							echo "	</div>";
							echo "</div>";
						}
					}
				?>
			</div>
			
			<div class='col-sm'>
				<div class='card' style='height : 100%'>
					<div class='card-body'>
						
					</div>
					<div class='card-footer'>
						<form>
							<div class='form-group'>
								<textarea class='form-control border-0 border-radius' rows=1 style='outline:none; resize:none;' placeholder='Converse...'></textarea>
							</form>
						</form>
					</div>
				</div>
			</div>
		</div>
			
		</div>
	</div>
</div> 
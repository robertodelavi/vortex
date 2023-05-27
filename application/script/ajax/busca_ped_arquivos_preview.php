<?php	
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 
	//
	$data = new DataManipulation();
	//	
	if($_GET['ped_codigo'] != ''){
		$sql = "SELECT a.*, p.ped_numero, p.ped_empresa
				FROM pedido_arquivo AS a
				 	LEFT JOIN pedido AS p ON (p.ped_codigo = a.ped_codigo)
				WHERE a.ped_codigo = ".$_GET['ped_codigo']."
				ORDER BY a.par_nome ASC";
		$result = $data->find('dynamic', $sql);
		
		//
		if(count($result) > 0){
			echo '
			<div class="row form-group" >
				<div class="col-md-12">
					<h3 style="margin:0;"><b>'.$result[0]['ped_numero'].' - '.$result[0]['ped_empresa'].'</b></h3>
				</div>
			</div>
			<hr />';

			for ($i=0; $i < count($result); $i++) { 
				echo '<div class="row form-group">
					<div class="col-md-12">
						<a href="'.$result[$i]['par_arquivo'].'" target="_blank"> - '.$result[0]['par_nome'].'</a>
					</div>
				</div>';
			}
		}
	}	
?>
<?php	
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 
	//
	$data = new DataManipulation();
	//	
	if($_GET['fin_codigo'] != ''){
		$sql = "SELECT *
				FROM financeiro_cliente
				WHERE fin_codigo = ".$_GET['fin_codigo'];
		$result = $data->find('dynamic', $sql);
		
		//
		if(count($result) > 0){
			echo '
			<div class="row form-group">
				<div class="col-md-12">
					<h3 style="margin:0;"><b>Pedido: '.$result[0]['fin_nro_pedido'].' - Parcela: '.$result[0]['fin_nro_parcela'].'</b></h3>
				</div>
			</div>
			<hr />';
			
			if($result[0]['fin_txt_faturamento']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
						<pre>'.$result[0]['fin_txt_faturamento'].'</pre>
					</div>
				</div>';
			}

			if($result[0]['fin_arq_faturamento']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
						<pre><a href="'.$result[0]['fin_arq_faturamento'].'" target="_blank"><i class="fa fa-paperclip"></i> FATURA EM ANEXO</a></pre>
					</div>
				</div>';
			}


		}
	}	
?>
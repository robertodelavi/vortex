<?php	
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 
	//
	$data = new DataManipulation();
	//	
	if($_GET['prc_codigo'] != ''){
		$sql = "SELECT *
				FROM producao_cliente
				WHERE prc_codigo = ".$_GET['prc_codigo'];
		$result = $data->find('dynamic', $sql);
		
		//
		if(count($result) > 0){
			echo '
			<div class="row form-group">
				<div class="col-md-12">
					<h3 style="margin:0;"><b>Pedido: '.$result[0]['prc_nro_pedido'].' - Modelo: '.$result[0]['prc_modelo'].'</b></h3>
				</div>
			</div>
			<hr />';
			
			if($result[0]['prc_arq_projeto']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
					 	<label>Projeto:</label>
						<pre><a href="'.$result[0]['prc_arq_projeto'].'" target="_blank"><i class="fa fa-paperclip"></i> PROJETO</a></pre>
					</div>
				</div>';
			}

			if($result[0]['prc_arq_manual']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
					 	<label>Manual:</label>
						<pre><a href="'.$result[0]['prc_arq_manual'].'" target="_blank"><i class="fa fa-paperclip"></i> MANUAL</a></pre>
					</div>
				</div>';
			}

			if($result[0]['prc_nfe']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
					 	<label>NF-e:</label>
						<pre><a href="'.$result[0]['prc_nfe'].'" target="_blank"><i class="fa fa-paperclip"></i> NOTA FISCAL</a></pre>
					</div>
				</div>';
			}

			if($result[0]['prc_pdf_pedido']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
					 	<label>PEDIDO:</label>
						<pre><a href="'.$result[0]['prc_pdf_pedido'].'" target="_blank"><i class="fa fa-paperclip"></i> PEDIDO PDF</a></pre>
					</div>
				</div>';
			}

			if($result[0]['prc_pedido_assinado']){
				echo '
				<div class="row form-group">
					<div class="col-md-12">
					 	<label>PEDIDO ASSINADO:</label>
						<pre><a href="'.$result[0]['prc_pedido_assinado'].'" target="_blank"><i class="fa fa-paperclip"></i> PEDIDO ASSINADO</a></pre>
					</div>
				</div>';
			}
		}
	}	
?>
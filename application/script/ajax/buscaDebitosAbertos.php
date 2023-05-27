<?php
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 	
	$data = new DataManipulation();

	if(($_GET['tipo'] != 'undefined')&&($_GET['tipo'] != '')){
		$where = ' AND tmf_codigo ='.$_GET['tipo'];
	}else{
		$where = '';
	}
	
	if($_GET['id'] != 'undefined'){
		$consulta = "SELECT *
					FROM sge_aluno_mov_financeira
					WHERE
						amf_tipo = 0 AND
						amf_situacao = 1 AND
						amf_codigo_mf IS NULL AND
						alu_codigo = '".$_GET['id']."' ".$where."
					ORDER BY amf_data ASC";
		$result = $data->find('dynamic', $consulta);
	}

	echo '
	<div class="row form-group">
        <div class="col-sm-12" > 
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Débitos em aberto</h3>
                </div>
                
                <div class="panel-body">
                    <table class="table"> 
                       <tbody>';

	for($i=0; $i<count($result); $i++){			
		echo '
			<tr>
				<td>
					<input type="checkbox" name="debito[]" id="debito'.$i.'" value="'.$result[$i]['amf_codigo'].'" onclick="calcular('.$i.')" />
				</td>
				<td>
					<span id="desc'.$i.'">'.$result[$i]['amf_descricao'].'</span>
				</td>
				<td>
					<span id="desc1'.$i.'">R$'.number_format($result[$i]['amf_valor'],2,',','.').'</span>
					<input type="hidden" name="valor'.$i.'" id="valor'.$i.'" value="'.$result[$i]['amf_valor'].'" />
				</td>
			</tr>';	
	}
	echo '</table>';
?>
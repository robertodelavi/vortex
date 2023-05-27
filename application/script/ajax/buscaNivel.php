<?php
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 	
	$data = new DataManipulation();
	
	if($_GET['id'] != 'undefined'){
		$consulta = "SELECT *
					FROM sge_curso_nivel
					WHERE cur_codigo = '".$_GET['id']."'
					ORDER BY cni_descricao ASC";
		$result = $data->find('dynamic', $consulta);
	}

	echo '<option value="">SELECIONE UM NÍVEL</option>';
	for($i=0; $i<count($result); $i++){			
		echo '<option value="'.$result[$i]['cni_codigo'].'">'.$result[$i]['cni_descricao'].'</option>';					
	}
?>
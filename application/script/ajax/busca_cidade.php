<?php
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 
	//
	$data = new DataManipulation();
	//
	if($_GET["est_codigo"] != ""){
		$consulta = "SELECT * 
					 FROM cidade 
					 WHERE est_uf = '".$_GET["est_codigo"]."' ";
		$result = $data->find('dynamic', $consulta);
		//
		if(count($result) > 0){
			for($i=0; $i< count($result); $i++){
				if ($_GET["cid_codigo"] == $result[$i]['cid_codigo'])
					echo '<option value="'.$result[$i]['cid_codigo'].'" selected>'.$result[$i]['cid_nome'].'</option>'; 
				else
                	echo '<option value="'.$result[$i]['cid_codigo'].'">'.$result[$i]['cid_nome'].'</option>';    
            }		
		}
	}	
?>
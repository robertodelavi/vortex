<?php
	switch($_GET['acao']){
		case 'deleta_principal':
			$data->tabela = 'clientes';
			$data->delete($_POST['param_0']);
			echo '<body onload="nextPage(\'?module=principal&acao=lista_principal&ms=1\', \'\' )"></body>';
		break;
	}
?>
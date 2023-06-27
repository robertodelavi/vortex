<?php
	switch($_GET['acao']){
		case 'update_pretendente':

			echo 'chegou: '.$_POST['nome'];

			// $data->tabela = 'clientes';
			// $data->delete($_POST['param_0']);
			// echo '<body onload="nextPage(\'?module=principal&acao=lista_principal&ms=1\', \'\' )"></body>';
		break;

		case 'deleta_pretendente':
			$data->tabela = 'clientes';
			$data->delete($_POST['param_0']);
			echo '<body onload="nextPage(\'?module=principal&acao=lista_principal&ms=1\', \'\' )"></body>';
		break;
	}
?>
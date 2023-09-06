<?php
	$temp = explode('_', $_GET['acao']);
	$action = $temp[0];
	$module = $temp[1];

	switch ($_GET['acao']) {
        //* PRETENDENTE
		case 'lista_pretendente':
			require_once 'application/pretendente/view/list/index.php';
		break;		
		case 'edita_pretendente':
			require_once 'application/pretendente/view/formEdit.php';
		break;		
		case 'visualiza_pretendente':
			require_once 'application/pretendente/view/formView.php';
		break;
		case 'deleta_pretendente':
		case 'deletadados_pretendente':		
		case 'grava_pretendente':
		case 'gravahistorico_pretendente':
		case 'gravavisita_pretendente':
		case 'updatevisita_pretendente':
		case 'gravadados_pretendente':		
		case 'update_pretendente':
		case 'updatehistorico_pretendente':
		case 'updatedados_pretendente':		
		case 'ativar_pretendente':
		case 'inativar_pretendente':
		case 'excluir_pretendente':
			require_once 'application/pretendente/view/dataControls.inc.php';
		break;
	}
?>
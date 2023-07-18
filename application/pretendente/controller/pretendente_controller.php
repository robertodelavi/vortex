<?php
	$temp = explode('_', $_GET['acao']);
	$action = $temp[0];
	$module = $temp[1];

	switch ($action) {
		case 'lista':
			require_once 'application/'.$module.'/view/lista.php';
		break;
		
		// case 'novo':
		case 'edita':
			require_once 'application/'.$module.'/view/formEdit.php';
		break;
		
		case 'visualiza':
			require_once 'application/'.$module.'/view/formView.php';
		break;

		case 'deleta':
		case 'deletadados':
		
		case 'grava':
		case 'gravahistorico':
		case 'gravadados':
		
		case 'update':
		case 'updatehistorico':
		case 'updatedados':
		
		case 'ativar':
		case 'inativar':
		case 'excluir':
			require_once 'application/'.$module.'/view/dataControls.inc.php';
		break;
	}
?>
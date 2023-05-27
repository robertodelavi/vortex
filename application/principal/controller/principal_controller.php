<?php
	$tela = explode('_', $_GET['acao']);
	switch ($tela[0]) {
		case 'lista':
			require_once 'application/principal/view/lista.inc.php';
		break;

		case 'listacliente':
			require_once 'application/principal/view/listaCliente.inc.php';
		break;
		
		case 'novo':
			require_once 'application/principal/view/frmCadastro.inc.php';
		break;

		case 'edita':
			require_once 'application/principal/view/frmEdicao.inc.php';
		break;		
		
		case 'visualiza':
			require_once 'application/principal/view/frmVisualiza.inc.php';
		break;

		case 'visualizaEmpCargo':
			require_once 'application/principal/view/frmVisualizaEmpCargo.inc.php';
		break;

		case 'deleta':
		case 'grava':
		case 'update':
		case 'ativar':
		case 'inativar':
		case 'excluir':
			require_once 'application/principal/view/dataControls.inc.php';
		break;
	}
?>
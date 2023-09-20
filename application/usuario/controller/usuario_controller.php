<?php
	$tela = explode('_', $_GET['acao']);

	switch ($tela[0]) {
		case 'lista':
			if($_SESSION['v_usu_nivel'] == 1){
				require_once 'application/usuario/view/lista.inc.php';
			}
		break;
		
		case 'novo':
			if($_SESSION['v_usu_nivel'] == 1){
				require_once 'application/usuario/view/frmCadastro.inc.php';
			}
		break;

		case 'edita':
			require_once 'application/usuario/view/frmEdicao.inc.php';
		break;		
		
		case 'visualiza':
			require_once 'application/usuario/view/frmVisualiza.inc.php';
		break;

		case 'visualizaEmpCargo':
			require_once 'application/usuario/view/frmVisualizaEmpCargo.inc.php';
		break;

		case 'deleta':
		case 'deletaarea':
		case 'grava':
		case 'gravaarea':
		case 'update':
		case 'ativar':
		case 'inativar':
		case 'excluir':
			require_once 'application/usuario/view/dataControls.inc.php';
		break;
	}
?>
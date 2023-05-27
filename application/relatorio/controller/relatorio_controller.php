<?php
	$tela = explode('_', $_GET['acao']);

	switch($tela[0]){
		case 'filtro': // Acesso
			require_once 'application/relatorio/view/'.$tela[1].'/frmFiltro.inc.php';
		break;
	}
?>
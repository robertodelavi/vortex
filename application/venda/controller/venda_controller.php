<?php
	$temp = explode('_', $_GET['acao']);
	$action = $temp[0];
	$module = $temp[1];

	switch ($_GET['acao']) {
        //* IMÓVEL
		case 'lista_imovel':
			require_once 'application/venda/view/imovel/list/index.php';
		break;		
		case 'edita_imovel':
			require_once 'application/venda/view/imovel/edit/index.php';
		break;
		// Geral		
		case 'update_imovel':
			require_once 'application/venda/view/imovel/edit/geral/dataControls.inc.php';
		break;
        // Agenciamento
        case 'update_agenciamento_imovel':		
            require_once 'application/venda/view/imovel/edit/agenciamento/dataControls.inc.php';
        break;
		// Valores
		case 'update_valores_imovel':
			require_once 'application/venda/view/imovel/edit/valores/dataControls.inc.php';
		break;
		// Observações
		case 'update_observacoes_imovel':
			require_once 'application/venda/view/imovel/edit/observacoes/dataControls.inc.php';
		break;
	}
?>
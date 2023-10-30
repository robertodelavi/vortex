
<?php
	switch($_GET['acao']){
		case 'update_valores_imovel':
            if(isset($_POST['imv_codigo']) && $_POST['imv_codigo'] > 0){

                $_POST['imv_valor'] = moneyToFloat($_POST['imv_valor']);
                $_POST['imv_valorcomissao'] = moneyToFloat($_POST['imv_valorcomissao']);
                $_POST['imv_podefinanciar'] = $_POST['imv_podefinanciar'] == 's' ? 's' : 'n';
                $_POST['imv_financiado'] = $_POST['imv_financiado'] == 's' ? 's' : 'n';
                $_POST['imv_valoraluguel'] = moneyToFloat($_POST['imv_valoraluguel']);
                
                $data->tabela = 'imovelvenda';
                $data->update($_POST);
                echo '<body onload="nextPage(\'?module=venda&acao=edita_imovel&tab=3\', \''.$_POST['imv_codigo'].'\' )"></body>';
                exit;
            }
        break;
    }
?>
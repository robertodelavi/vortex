
<?php
	switch($_GET['acao']){

        case 'envia_fotos_imovel':
            echo 'Chegou....';

            

        break;

		case 'update_fotos_imovel':
            if(isset($_POST['imv_codigo']) && $_POST['imv_codigo'] > 0){

                // $_POST['imv_valor'] = moneyToFloat($_POST['imv_valor']);
                // $_POST['imv_valorcomissao'] = moneyToFloat($_POST['imv_valorcomissao']);
                // $_POST['imv_valoriptu'] = moneyToFloat($_POST['imv_valoriptu']);
                // $_POST['imv_valorpoupanca'] = moneyToFloat($_POST['imv_valorpoupanca']);
                // $_POST['imv_valorparcela'] = moneyToFloat($_POST['imv_valorparcela']);
                // $_POST['imv_valorsaldo'] = moneyToFloat($_POST['imv_valorsaldo']);
                // $_POST['imv_podefinanciar'] = $_POST['imv_podefinanciar'] == 's' ? 's' : 'n';
                // $_POST['imv_valoraluguel'] = moneyToFloat($_POST['imv_valoraluguel']);
                
                $_POST['imv_web'] = $_POST['imv_web'] == 's' ? 's' : 'n';
                
                $data->tabela = 'imovelvenda';
                // $data->update($_POST);
                echo '<body onload="nextPage(\'?module=venda&acao=edita_imovel&tab=5\', \''.$_POST['imv_codigo'].'\' )"></body>';
                exit;
            }
        break;
    }
?>
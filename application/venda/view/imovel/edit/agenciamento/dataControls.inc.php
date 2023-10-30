
<?php
	switch($_GET['acao']){
		case 'update_agenciamento_imovel':
            if(isset($_POST['imo_codigo']) && $_POST['imo_codigo'] > 0){

                // imovelvenda
                $imovelVenda['imv_codigo'] = $_POST['imo_codigo'];
                $imovelVenda['imv_numerochave'] = $_POST['imv_numerochave'];
                $imovelVenda['imv_localchave'] = $_POST['imv_localchave'];
                $imovelVenda['imv_corretor'] = $_POST['imv_corretor'];
                $imovelVenda['imv_placa'] = $_POST['imv_placa'] == 's' ? 's' : 'n';
                $imovelVenda['imv_autorizainternet'] = $_POST['imv_autorizainternet'] == 's' ? 's' : 'n';
                $imovelVenda['imv_autorizafotos'] = $_POST['imv_autorizafotos'] == 's' ? 's' : 'n';
                $imovelVenda['imv_autorizaimprensa'] = $_POST['imv_autorizaimprensa'] == 's' ? 's' : 'n';
                $imovelVenda['imv_exclusividade'] = $_POST['imv_exclusividade'] == 's' ? 's' : 'n';
                $imovelVenda['imv_responsavelagenciamento'] = $_POST['imv_responsavelagenciamento'];
                $imovelVenda['imv_tipoautorizacao'] = $_POST['imv_tipoautorizacao'];
                $imovelVenda['imv_dataagenciamento'] = str_replace('-', '', $_POST['imv_dataagenciamento']);
                $imovelVenda['imv_datarenovacao'] = str_replace('-', '', $_POST['imv_datarenovacao']);
                $imovelVenda['imv_datavalidade'] = str_replace('-', '', $_POST['imv_datavalidade']);
                $data->tabela = 'imovelvenda';
                $data->update($imovelVenda);
                unset($_POST['imv_numerochave']);
                unset($_POST['imv_localchave']);
                unset($_POST['imv_corretor']);
                unset($_POST['imv_responsavelagenciamento']);
                unset($_POST['imv_tipoautorizacao']);
                unset($_POST['imv_dataagenciamento']);
                unset($_POST['imv_datarenovacao']);
                unset($_POST['imv_datavalidade']);
                unset($_POST['imv_placa']);
                unset($_POST['imv_autorizainternet']);
                unset($_POST['imv_autorizafotos']);
                unset($_POST['imv_autorizaimprensa']);
                unset($_POST['imv_exclusividade']);

                // imoveis
                $data->tabela = 'imoveis';
                $data->update($_POST);
                echo '<body onload="nextPage(\'?module=venda&acao=edita_imovel&tab=2\', \''.$_POST['imo_codigo'].'\' )"></body>';
                exit;
            }
        break;
    }
?>
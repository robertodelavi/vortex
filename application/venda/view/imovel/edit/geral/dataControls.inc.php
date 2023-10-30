
<?php
	switch($_GET['acao']){
		case 'update_imovel':
            if(isset($_POST['imo_codigo']) && $_POST['imo_codigo'] > 0){
                // Composição
                $_POST['imo_cozinha'] = $_POST['imo_cozinha'] == 's' ? 's' : 'n';
                $_POST['imo_salajantar'] = $_POST['imo_salajantar'] == 's' ? 's' : 'n';
                $_POST['imo_salaestar'] = $_POST['imo_salaestar'] == 's' ? 's' : 'n';
                $_POST['imo_salatv'] = $_POST['imo_salatv'] == 's' ? 's' : 'n';
                $_POST['imo_lareira'] = $_POST['imo_lareira'] == 's' ? 's' : 'n';
                $_POST['imo_areadeservico'] = $_POST['imo_areadeservico'] == 's' ? 's' : 'n';
                $_POST['imo_playground'] = $_POST['imo_playground'] == 's' ? 's' : 'n';
                $_POST['imo_gascentral'] = $_POST['imo_gascentral'] == 's' ? 's' : 'n';
                $_POST['imo_dependenciaempregada'] = $_POST['imo_dependenciaempregada'] == 's' ? 's' : 'n';
                $_POST['imo_lavabo'] = $_POST['imo_lavabo'] == 's' ? 's' : 'n';
                $_POST['imo_churrasqueira'] = $_POST['imo_churrasqueira'] == 's' ? 's' : 'n';
                $_POST['imo_salaofestas'] = $_POST['imo_salaofestas'] == 's' ? 's' : 'n';
                $_POST['imo_sacada'] = $_POST['imo_sacada'] == 's' ? 's' : 'n';
                $_POST['imo_portaoeletronico'] = $_POST['imo_portaoeletronico'] == 's' ? 's' : 'n';
                $_POST['imo_hobbybox'] = $_POST['imo_hobbybox'] == 's' ? 's' : 'n';
                $_POST['imo_arealazer'] = $_POST['imo_arealazer'] == 's' ? 's' : 'n';
                $_POST['imo_pocoartesiano'] = $_POST['imo_pocoartesiano'] == 's' ? 's' : 'n';
                $_POST['imo_condominiofechado'] = $_POST['imo_condominiofechado'] == 's' ? 's' : 'n';
                $_POST['imo_piscina'] = $_POST['imo_piscina'] == 's' ? 's' : 'n';
                $_POST['imo_terraco'] = $_POST['imo_terraco'] == 's' ? 's' : 'n';
                //
                $data->tabela = 'imoveis';
                $data->update($_POST);
                echo '<body onload="nextPage(\'?module=venda&acao=edita_imovel&tab=1\', \''.$_POST['imo_codigo'].'\' )"></body>';
                exit;
            }
        break;
    }
?>
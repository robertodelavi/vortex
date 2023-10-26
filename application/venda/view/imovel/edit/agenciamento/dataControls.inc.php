
<?php
	switch($_GET['acao']){
		case 'update_agenciamento_imovel':
            if(isset($_POST['imo_codigo']) && $_POST['imo_codigo'] > 0){
                $data->tabela = 'imoveis';
                $data->update($_POST);
                echo '<body onload="nextPage(\'?module=venda&acao=edita_imovel&tab=1\', \''.$_POST['imo_codigo'].'\' )"></body>';
                exit;
            }
        break;
    }
?>
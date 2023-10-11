
<?php
	switch($_GET['acao']){
		case 'grava_visitas':
			if(isset($_POST['prv_pretendente']) && isset($_POST['prv_imovel'])){
				$_POST['prv_acompanhantepretendente'] = addslashes($_POST['prv_acompanhantepretendente']);
				// Converter data
				$_POST['prv_dataini'] = str_replace('-', '', $_POST['prv_dataini']);
				$_POST['prv_datafim'] = str_replace('-', '', $_POST['prv_datafim']);
				// Converter hora (remover :)
				$_POST['prv_horaini'] = str_replace(':', '', $_POST['prv_horaini']);
				$_POST['prv_horafim'] = str_replace(':', '', $_POST['prv_horafim']);
				$_POST['prv_obs'] = addslashes($_POST['prv_obs']);
				//
				$data->tabela = 'pretendentesvisitas';
				$data->add($_POST);
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=4\', \''.$_POST['prv_pretendente'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}
		break;
		
        case 'update_visitas':
			if(isset($_POST['prv_pretendente']) && isset($_POST['prv_codigo'])){

                echo 'chegou...'.$_POST['prv_pretendente'].' - '.$_POST['prv_codigo'];

				$_POST['prv_acompanhantepretendente'] = addslashes($_POST['prv_acompanhantepretendente']);
				// Converter data
				$_POST['prv_dataini'] = str_replace('-', '', $_POST['prv_dataini']);
				$_POST['prv_datafim'] = str_replace('-', '', $_POST['prv_datafim']);
				// Converter hora (remover :)
				$_POST['prv_horaini'] = str_replace(':', '', $_POST['prv_horaini']);
				$_POST['prv_horafim'] = str_replace(':', '', $_POST['prv_horafim']);
				$_POST['prv_obs'] = addslashes($_POST['prv_obs']);
				//
				$data->tabela = 'pretendentesvisitas';
				$data->update($_POST);
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_visitas&status=1\', \''.$_POST['prv_pretendente'].'-'.$_POST['prv_codigo'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}
		break;
	}
?>
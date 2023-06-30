
<?php
	switch($_GET['acao']){
		case 'grava_pretendente':
			if(isset($_POST['ppf_pretendente']) && $_POST['ppf_pretendente'] > 0){
				// Converte moeda pra float
				$_POST['ppf_valorini'] = moneyToFloat($_POST['ppf_valorini']);
				$_POST['ppf_valorfim'] = moneyToFloat($_POST['ppf_valorfim']);
								
				$data->tabela = 'pretendentesperfil';
				$data->add($_POST);
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=2\', \''.$_POST['ppf_pretendente'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}
		break;
		
		case 'update_pretendente':
			if(isset($_POST['ppf_pretendente']) && isset($_POST['ppf_codigo']) && $_POST['ppf_pretendente'] > 0 && $_POST['ppf_codigo'] > 0){
				// Converte moeda pra float
				$_POST['ppf_valorini'] = moneyToFloat($_POST['ppf_valorini']);
				$_POST['ppf_valorfim'] = moneyToFloat($_POST['ppf_valorfim']);
								
				$data->tabela = 'pretendentesperfil';
				$data->update($_POST);
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=2\', \''.$_POST['ppf_pretendente'].'\' )"></body>';
				exit;

			}else{
				// Erro post..
			}
		break;

		case 'deleta_pretendente':
			$data->tabela = 'pretendentesperfil';
			$sql = 'DELETE FROM pretendentesperfil WHERE ppf_pretendente = '.$_POST['param_0'].' AND ppf_codigo = '.$_POST['param_1'];
			$data->executaSQL($sql);
			echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=2\', \''.$_POST['param_0'].'\' )"></body>';
		break;
	}
?>
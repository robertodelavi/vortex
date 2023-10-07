
<?php
	switch($_GET['acao']){

		//* DADOS DO PRETENDENTE
		case 'gravadados_pretendente':
			$_POST['prw_valorprospeccao'] = moneyToFloat($_POST['prw_valorprospeccao']);
			$data->tabela = 'pretendentes';
			$_POST['prw_dataatual'] = date('Ymd');
			$data->add($_POST);
			$prw_codigo = $data->MaxValue('prw_codigo', 'pretendentes');

            //? Grava o histórico
            $historico['prh_pretendente'] = $prw_codigo;
            $historico['prh_data'] = date('Ymd');
            $historico['prh_contato'] = $_POST['prw_contato'];
            $historico['prh_descricao'] = addslashes($_POST['prw_obs']);
			$historico['prh_datacad'] = date('Ymd');
            $historico['prh_horacad'] = date('Hi');
            $historico['prh_usuario'] = $_SESSION['v_usu_codigo'];
            $historico['prh_avisar'] = 'n';                       
            $data->tabela = 'pretendenteshistorico';
            $data->add($historico);

			echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=1\', \''.$prw_codigo.'\' )"></body>';
		break;

		case 'updatedados_pretendente':
			if(isset($_POST['prw_codigo']) && $_POST['prw_codigo'] > 0){
				// Converte moeda pra float
				$_POST['prw_valorprospeccao'] = moneyToFloat($_POST['prw_valorprospeccao']);
				$_POST['prw_dataatual'] = date('Ymd');
												
				$data->tabela = 'pretendentes';
				$data->update($_POST);
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=1\', \''.$_POST['prw_codigo'].'\' )"></body>';
				exit;

			}else{
				// Erro post..
			}
		break;

		case 'deletadados_pretendente':
			if(isset($_POST['param_0']) && $_POST['param_0'] > 0){				
				// Pretendente
				$sql = 'DELETE FROM pretendentes WHERE prw_codigo = '.$_POST['param_0'];
				$data->executaSQL($sql);
				// Histórico
				$sql = 'DELETE FROM pretendenteshistorico WHERE prh_pretendente = '.$_POST['param_0'];
				$data->executaSQL($sql);
				// Perfil
				$sql = 'DELETE FROM pretendentesperfil WHERE ppf_pretendente = '.$_POST['param_0'];
				$data->executaSQL($sql);
				// Visitas
				$sql = 'DELETE FROM pretendentesvisitas WHERE prv_pretendente = '.$_POST['param_0'];
				$data->executaSQL($sql);
				// Imóveis
				$sql = 'DELETE FROM pretendentesimoveis WHERE pwi_pretendente = '.$_POST['param_0'];
				$data->executaSQL($sql);
				$res = 1;
			}
			echo '<body onload="nextPage(\'?module=pretendente&acao=lista_pretendente&res='.$res.'\', \'\' )"></body>';
			
		break;

		//* PERFIS DE BUSCA
		case 'grava_pretendente':
			if(isset($_POST['ppf_pretendente']) && $_POST['ppf_pretendente'] > 0){
				// Converte moeda pra float
				$_POST['ppf_valorini'] = moneyToFloat($_POST['ppf_valorini']);
				$_POST['ppf_valorfim'] = moneyToFloat($_POST['ppf_valorfim']);
				$_POST['prw_dataatual'] = date('Ymd');
								
				$data->tabela = 'pretendentesperfil';
				$data->add($_POST);

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['ppf_pretendente'];
				$data->executaSQL($sql);

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

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['ppf_pretendente'];
				$data->executaSQL($sql);

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

		//* HISTÓRICO DE ATENDIMENTOS 
		case 'gravahistorico_pretendente':
			if(isset($_POST['prh_pretendente'])){
				// Converter data
				$_POST['prh_data'] = str_replace('-', '', $_POST['prh_data']);
				$_POST['prh_avisar'] = $_POST['prh_avisar'] ? $_POST['prh_avisar'] : 'n';
				$_POST['prh_datacad'] = date('Ymd');
				$_POST['prh_horacad'] = date('Hi');
								
				$data->tabela = 'pretendenteshistorico';
				$data->add($_POST);

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['prh_pretendente'];
				$data->executaSQL($sql);

				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=3\', \''.$_POST['prh_pretendente'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}
		break;

		case 'updatehistorico_pretendente':
			if(isset($_POST['prh_pretendente']) && $_POST['prh_codigo'] > 0){
				// Converter data
				$_POST['prh_data'] = str_replace('-', '', $_POST['prh_data']);
				$_POST['prh_avisar'] = $_POST['prh_avisar'] ? $_POST['prh_avisar'] : 'n';
				
				$data->tabela = 'pretendenteshistorico';
				$data->update($_POST);

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['prh_pretendente'];
				$data->executaSQL($sql);

				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=3&contato='.$_POST['prh_contato'].'\', \''.$_POST['prh_pretendente'].'\' )"></body>';
				exit;

			}else{
				// Erro post..
			}
		break;

		//* VISITAS
		case 'gravavisita_pretendente':
            if(isset($_POST['prv_pretendente']) && isset($_POST['prv_imovel'])){
                echo var_dump($_POST);
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

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['prv_pretendente'];
				$data->executaSQL($sql);

				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=4\', \''.$_POST['prv_pretendente'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}
		break;

        case 'updatevisita_pretendente':
            if(isset($_POST['prv_pretendente']) && isset($_POST['prv_codigo'])){
                echo var_dump($_POST);

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

				$sql = 'UPDATE pretendentes SET prw_dataatual = "'.date('Ymd').'" WHERE prw_codigo = '.$_POST['prv_pretendente'];
				$data->executaSQL($sql);

				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=5\', \''.$_POST['prv_pretendente'].'\' )"></body>';
				exit;
			}else{
				// Erro post..
			}	

        break;
	}
?>
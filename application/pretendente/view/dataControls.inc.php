
<?php
	switch($_GET['acao']){

		//* DADOS DO PRETENDENTE
		case 'gravadados_pretendente':
			$_POST['prw_valorprospeccao'] = moneyToFloat($_POST['prw_valorprospeccao']);
			$data->tabela = 'pretendentes';
			$data->add($_POST);

			$prw_codigo = $data->MaxValue('prw_codigo', 'pretendentes');

			echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=1\', \''.$prw_codigo.'\' )"></body>';
		break;

		case 'updatedados_pretendente':
			if(isset($_POST['prw_codigo']) && $_POST['prw_codigo'] > 0){
				// Converte moeda pra float
				$_POST['prw_valorprospeccao'] = moneyToFloat($_POST['prw_valorprospeccao']);
												
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

                //? Atualiza os imóveis indicados pro pretendente de acordo com os seus perfis de busca
                setaImoveis($_POST, $data);

				// echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=2\', \''.$_POST['ppf_pretendente'].'\' )"></body>';
				// exit;

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
				echo '<body onload="nextPage(\'?module=pretendente&acao=edita_pretendente&tab=3&contato='.$_POST['prh_contato'].'\', \''.$_POST['prh_pretendente'].'\' )"></body>';
				exit;

			}else{
				// Erro post..
			}
		break;
	}

    //? Função que seta os imóveis indicados pro pretendente baseado nos perfis de busca
    function setaImoveis($values, $data){
        $filters = getFilters($values['ppf_pretendente'], $values['ppf_codigo'], $data); //? Extrai os filtros relevantes do perfil (que possuem valor)
        
        if($filters){
            // Monta SQL com imoveis que atendem os filtros
            $sql = 'SELECT * FROM imoveis WHERE ';
            $filters = json_decode($filters);
            foreach($filters as $key => $value){
                if($value->campo != 'ppf_valorini' && $value->campo != 'ppf_valorfim'){
                    $sql .= $value->campo_.' = '.$value->valor.' AND ';
                }
            }
            $sql = substr($sql, 0, -4);
            $sql .= ' ORDER BY imo_codigo DESC';

            echo $sql;

        }
        
    }

    //? Extrai os filtros relevantes do perfil (que possuem valor)
    function getFilters($ppf_pretendente, $ppf_codigo, $data){
        if($ppf_pretendente == '' || $ppf_codigo == ''){
            return false;
        }

        // Busca perfil
        $sql = 'SELECT * FROM pretendentesperfil WHERE ppf_pretendente = '.$ppf_pretendente.' AND ppf_codigo = '.$ppf_codigo;
        $result = $data->find('dynamic', $sql);    

        // Busca filtros 
        $filtros = array();
        foreach($result as $key => $value){            
            foreach($value as $k => $v){
                if($v != '' && $v != 0 && $k != 'ppf_nome' && $k != 'ppf_pretendente' && $k != 'ppf_codigo'){
                    $filtros[] = array(
                        'campo' => $k,
                        'campo_' => getCampoTabelaImoveis($k),
                        'valor' => $v
                    );
                }
            }
        }

        return json_encode($filtros);        
    }

    function getCampoTabelaImoveis($field){
        $arrayFields = array(
            'ppf_tipoimovel' => 'imo_tipoimovel',
            'ppf_quartosini' => 'imo_quartos',
            'ppf_quartosfim' => 'imo_quartos',
            'ppf_garagem' => 'imo_garagem',
            // 'ppf_valorini' => '??',
            // 'ppf_valorfim' => '??',
        );

        return $arrayFields[$field];
    }
?>
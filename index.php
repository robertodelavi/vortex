<?php
	session_start();

	function meu_autoloader($nomeClasse) {
		
		// Caso não esteja atualizado um cookie, todos são atualizados com o valor atual da variável de sessão
		if(($_SESSION['v_userSession'] != $_COOKIE['v_userSession']) 	  ||
		($_SESSION['v_usu_codigo'] != $_COOKIE['v_usu_codigo'])	  ||
		($_SESSION['v_usu_nome'] != $_COOKIE['v_usu_nome']) ||
		($_SESSION['wf_idSession'] != $_COOKIE['wf_idSession']) || 
		($_SESSION['wf_userPermissao'] != $_COOKIE['wf_userPermissao']) || 
		($_SESSION['wf_userEmail'] != $_COOKIE['wf_userEmail'])){
			setcookie('v_userSession', $_SESSION['v_userSession'], $tempo_cookie);	
			setcookie('v_usu_codigo', $_SESSION['v_usu_codigo'], $tempo_cookie);	
			setcookie('v_usu_nome', $_SESSION['v_usu_nome'], $tempo_cookie);	
			setcookie('wf_session', $_SESSION['wf_session'], $tempo_cookie);	
			setcookie('wf_idSession', $_SESSION['wf_idSession'], $tempo_cookie);	
			setcookie('wf_userPermissao', $_SESSION['wf_userPermissao'], $tempo_cookie);	
			setcookie('wf_userEmail', $_SESSION['wf_userEmail'], $tempo_cookie);	
		}

		if(!$_SESSION['v_userSession']){
		    // Para não perder sessão
		    $_SESSION['v_usu_codigo']         = $_COOKIE['v_usu_codigo'];
			$_SESSION['v_usu_nome']       = $_COOKIE['v_usu_nome'];
			$_SESSION['v_userSession']    = $_COOKIE['v_userSession'];
			$_SESSION['wf_userPermissao']  = $_COOKIE['wf_userPermissao'];
			$_SESSION['wf_userEmail']  	   = $_COOKIE['wf_userEmail'];
			$_SESSION['wf_idSession']      = $_COOKIE['wf_idSession'];
		}
		require_once 'library/'.implode('/',explode('_',$nomeClasse)).'.php';
	}

	spl_autoload_register('meu_autoloader');

	try {
	    $factory = new Command_Factory();
	    $factory->createCommand()->execute();
	} catch (Exception_Pagenotfound $ep) {
	    echo '<h1>ERRO 404 - Página não encontrada</h1>';
	} catch (Exception $e) {
	    echo '<h1>ERRO 500 - Erro na execução</h1>';
	}
?>
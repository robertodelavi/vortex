<?php
class Login{
	private $lembrarTempo = 6000;
	private $cookiePath = '/';
	private $prefixoChaves = 'usuario_';
	
	var $table;
	
	function validateUser($params, $session){
		if(!isset($_SESSION)){
			session_start();
    	}
		$db = new MySql();
		
		$i = 0;
		foreach($params as $key => $valor){
			if($i == 0){
				$conditions = $key." = '".$valor."'";
				$i++;
			}else{
				$conditions .= " AND ".$key." = '".$valor."'";
			}  
		}

		$sql = "SELECT * FROM ".$this->table." WHERE usu_situacao = 1 AND ".$conditions;
		$result = $db->executeQuery($sql,false);
		if ($db->countLines($result) > 0){
			for ($i=0;$i<$db->countLines($result);$i++){
				$_SESSION['wf_userId'] 			= $db->result($result, $i,'usu_codigo');
				$_SESSION['wf_userName'] 		= $db->result($result, $i,'usu_nome');	
				$_SESSION['wf_userEmail'] 		= $db->result($result, $i,'usu_email');									
				$_SESSION['wf_userPermissao'] 	= $db->result($result, $i,'upe_codigo');
				$_SESSION['wf_userCliente'] 	= $db->result($result, $i,'cli_codigo');
				$_SESSION['wf_userSession'] 	= $session;

				$retorno['login'] 	 = 'Logado';
				$retorno['nome'] 	 = $db->result($result, $i,'usu_nome');
				$retorno['mensagem'] = "Logado com Sucesso";

				$sql = 'INSERT INTO usuario_acesso(usu_codigo) VALUES ('.$_SESSION['wf_userId'].')';
				$result = $db->executeQuery($sql,false);
				
				// Cria um cookie com o usuário
				$tempo_cookie = strtotime("+2 day", time());
				setcookie('wf_userId', $_SESSION['wf_userId'], $tempo_cookie, "/");			
				setcookie('wf_userName', $_SESSION['wf_userName'], $tempo_cookie, "/");			
				setcookie('wf_userEmail', $_SESSION['wf_userEmail'], $tempo_cookie, "/");
				setcookie('wf_userPermissao', $_SESSION['wf_userPermissao'], $tempo_cookie, "/");
				setcookie('wf_userCliente', $_SESSION['wf_userCliente'], $tempo_cookie, "/");
				setcookie('wf_userSession', $_SESSION['wf_userSession'], $tempo_cookie, "/");				
				setcookie('wf_idSession', $_SESSION['wf_idSession'], $tempo_cookie, "/");	
			}
		}else{
			$retorno['login'] 	 = "falha";
			$retorno['mensagem'] = "Senha e/ou login invalido";				
		}
		return $retorno;			
	}

	function logout(){
		/*unset($_SESSION['wf_userName']);
		unset($_SESSION['wf_userEmail']);
		unset($_SESSION['wf_userPermissao']);
		unset($_SESSION['wf_userCliente']);*/
	}
	
	function getLogin(){
		if ((isset($_SESSION['wf_idSession']))&&($_SESSION['wf_idSession'] == $_SESSION['wf_userSession'])){
			$retorno['logged'] = "yes";
		}else{
			$retorno['logged'] = "no";
		}
		return $retorno;			
	}	
}

?>
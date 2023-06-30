<?php
class Login{
	private $lembrarTempo = 6000;
	private $cookiePath = '/';
	private $prefixoChaves = 'usuario_';
	
	var $tableAuth;
	var $table;

	// Acessa banco de autenticação
	function authenticateUser($params, $session){
		$dbAuth = new MySql();
		$dbAuth->connOpen('localhost','vortex__autenticacao','root', '');
		
		$i = 0;
		foreach($params as $key => $valor){
			if($i == 0){
				$conditions = $key." = '".$valor."'";
				$i++;
			}else{
				$conditions .= " AND ".$key." = '".$valor."'";
			}  
		}

		$sql = "SELECT 
					ue.uem_codigo, 
					e.emp_bd, 
					e.emp_bd_host, 
					e.emp_bd_user, 
					e.emp_bd_pass, 
					e.emp_nome, 
					e.emp_cidade, 
					e.emp_estado
        		FROM sisusuarios_sisempresas AS ue 
            		JOIN sisusuarios AS u ON (ue.usu_codigo = u.usu_codigo)
            		JOIN sisempresas AS e ON (ue.emp_codigo = e.emp_codigo)
        		WHERE 
					u.usu_email = '".$params['usu_email']."' AND 
					u.usu_senha = '".$params['usu_senha']."' AND 
					ue.uem_ativado = 's' AND 
					u.usu_ativado = 's' AND 
					e.emp_ativado = 's' ";
		$result = $dbAuth->executeQuery($sql, false);

		if ($dbAuth->countLines($result) > 0){
			for ($i=0;$i<$dbAuth->countLines($result);$i++){
				$retorno['login'] = 'Autenticado';
				$retorno['emp_bd'] = $dbAuth->result($result, $i, 'emp_bd');
				$retorno['emp_bd_host'] = $dbAuth->result($result, $i, 'emp_bd_host');
				$retorno['emp_bd_user'] = $dbAuth->result($result, $i, 'emp_bd_user');
				$retorno['emp_bd_pass'] = $dbAuth->result($result, $i, 'emp_bd_pass');
				$retorno['emp_nome'] = $dbAuth->result($result, $i, 'emp_nome');
				$retorno['emp_cidade'] = $dbAuth->result($result, $i, 'emp_cidade');
				$retorno['emp_estado'] = $dbAuth->result($result, $i, 'emp_estado');
				$retorno['mensagem'] = "Autenticado com Sucesso";
			}
		}else{
			$retorno['login'] 	 = "falha";
			$retorno['mensagem'] = "Senha e/ou login invalido";				
		}
		return $retorno;			
	}
	
	// Loga no banco da imobiliária
	function validateUser($authData, $params, $session){
		if(!isset($_SESSION)){
			session_start();
    	}

		if(!isset($authData['emp_bd'])){
			return false;
		}			

		$db = new MySql();
		$db->connOpen($authData['emp_bd_host'], $authData['emp_bd'], $authData['emp_bd_user'], $authData['emp_bd_pass']);
		
		$i = 0;
		foreach($params as $key => $valor){
			if($i == 0){
				$conditions = $key." = '".$valor."'";
				$i++;
			}else{
				$conditions .= " AND ".$key." = '".$valor."'";
			}  
		}

		$sql = "SELECT * FROM ".$this->table." WHERE usu_ativado = 's' AND ".$conditions;
		$result = $db->executeQuery($sql,false);
		if ($db->countLines($result) > 0){
			for ($i=0;$i<$db->countLines($result);$i++){
				$_SESSION['v_usu_codigo'] 		= $db->result($result, $i,'usu_codigo');
				$_SESSION['database'] 			= $authData['emp_bd'];
				$_SESSION['database_host'] 		= $authData['emp_bd_host'];
				$_SESSION['database_user'] 		= $authData['emp_bd_user'];
				$_SESSION['database_pass'] 		= $authData['emp_bd_pass'];
				$_SESSION['unidade'] 			= $authData['emp_nome'];
				$_SESSION['unidadeCidade'] 		= $authData['emp_cidade'].'/'.$authData['emp_estado'];
				//
				$_SESSION['wf_userId'] 			= $db->result($result, $i,'usu_codigo');
				$_SESSION['wf_userName'] 		= $db->result($result, $i,'usu_nome');	
				$_SESSION['wf_userEmail'] 		= $db->result($result, $i,'usu_email');									
				$_SESSION['wf_userPermissao'] 	= 1;
				$_SESSION['wf_userCliente'] 	= 1;
				$_SESSION['wf_userSession'] 	= $session;

				$retorno['login'] 	 = 'Logado';
				$retorno['nome'] 	 = $db->result($result, $i,'usu_nome');
				$retorno['mensagem'] = "Logado com Sucesso";

				// Cria um cookie com o usu�rio
				$tempo_cookie = strtotime("+2 day", time());
				setcookie('v_usu_codigo', $_SESSION['v_usu_codigo'], $tempo_cookie, "/");
				setcookie('database', $_SESSION['database'], $tempo_cookie, "/");
				setcookie('database_host', $_SESSION['database'], $tempo_cookie, "/");
				setcookie('database_user', $_SESSION['database'], $tempo_cookie, "/");
				setcookie('database_pass', $_SESSION['database'], $tempo_cookie, "/");
				setcookie('unidade', $_SESSION['unidade'], $tempo_cookie, "/");
				setcookie('unidadeCidade', $_SESSION['unidadeCidade'], $tempo_cookie, "/");
				//
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
		unset($_SESSION);
		/*unset($_SESSION['wf_userName']);
		unset($_SESSION['wf_userEmail']);
		unset($_SESSION['wf_userPermissao']);
		unset($_SESSION['wf_userCliente']);*/
	}
}

?>
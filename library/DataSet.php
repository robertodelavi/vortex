<?php
	require_once 'MySql.php';	
    class DataSet{	
		function executeRecord($sql){
			$database = new MySql();
			$database->connOpen($_SESSION['database_host'], $_SESSION['database'], $_SESSION['database_user'], $_SESSION['database_pass']);
			$database->executeQuery($sql);   		
    	}
		
		function listRecord($sql){
			$database = new MySql();	
			$database->connOpen($_SESSION['database_host'], $_SESSION['database'], $_SESSION['database_user'], $_SESSION['database_pass']);
			$result = $database->executeQuery($sql);
	
			for($i = 0;$i < $database->countFields($result);$i++){		
				$campo = $database->fieldName($result,$i);	
				$array[$campo->name] = $campo->name;		
			}
			
			for($i = 0;$i < $database->countLines($result);$i++){
				foreach($array as $lista){
					$retorno[$i][$lista] = $database->result($result, $i,$lista);
				}
			}
			return $retorno;
		}
				
		function lastId($sql){
			$database = new MySql();
			$database->connOpen($_SESSION['database_host'], $_SESSION['database'], $_SESSION['database_user'], $_SESSION['database_pass']);
			$result = $database->executeQuery($sql,true);
			return $result;			
		}
    }
?>

<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    // Header default
    session_start();
    require_once('../../../library/DataManipulation.php');
    require_once('../../../library/MySql.php');
    $data = new DataManipulation();
    $conn = new MySql();

    //* Autenticação
	$conn->connOpen('localhost','vortex__autenticacao','root', '');

    $sql = 'SELECT * FROM sisempresas WHERE emp_codigo = '.$_GET['emp'].' AND emp_ativado = "s"';
    $resultAuth = $conn->executeQuery($sql);

    $emp_bd = null;
    if ($conn->countLines($resultAuth) > 0){
        for ($i=0; $i< $conn->countLines($resultAuth); $i++){
            $emp_host = $conn->result($resultAuth, $i, 'emp_bd_host');
            $emp_bd = $conn->result($resultAuth, $i, 'emp_bd');
            $emp_user = $conn->result($resultAuth, $i, 'emp_bd_user');
            $emp_pass = $conn->result($resultAuth, $i, 'emp_bd_pass');
        }
    }

    if(!$emp_bd){
        echo json_encode(array('error' => 'Empresa não encontrada'));
        exit;
    }

    //* Banco de dados do cliente
    $conn->connOpen($emp_host, $emp_bd, $emp_user, $emp_pass);

    $sql = 'SELECT * FROM imoveis WHERE imo_codigo = '.$_GET['id'];
    $result = $conn->executeQuery($sql);

    $res = [];
    if ($conn->countLines($result) > 0){
        for ($i=0; $i< $conn->countLines($result); $i++){
            $res[] = array(
                'rua' => $conn->result($result, $i, 'imo_rua'),
                'numero' => $conn->result($result, $i, 'imo_numero')
            );
            
        }
    }

    echo json_encode($res);

<?php
// Header default
session_start();
require_once('../../../../../library/DataManipulation.php');
require_once('../../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    
    $result[0] = array(
        'value' => 1, 
        'text' => "Apartamento"
    );
    $result[1] = array(
        'value' => 2, 
        'text' => "Casa"
    );
    $result[2] = array(
        'value' => 3, 
        'text' => "Casa de Condomínio"
    );
    $result[3] = array(
        'value' => 4, 
        'text' => "Casa de Vila"
    );
    // Retorna resposta
    echo json_encode($result);
    exit;
}
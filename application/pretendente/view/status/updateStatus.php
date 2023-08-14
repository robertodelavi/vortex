<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['id']) && $value['id'] > 0 && isset($value['status']) && $value['status'] > 0) {
       
        $sql = 'UPDATE pretendentes SET prw_psa_codigo = '.$value['status'].' WHERE prw_codigo = '.$value['id'];
        $data->executaSQL($sql);

        // SQL buscar as etapas/status 
        $sql = '
        SELECT psa_descricao
        FROM pretendentesstatusatendimento
        WHERE psa_codigo = '.$value['status'];
        $status = $data->find('dynamic', $sql);

        // Retorna resposta
        echo json_encode(array(
            'status' => 'success', 
            'message' => 'Status atualizado para '.$status[0]['psa_descricao'].'!'
        ));
        exit;
    }
}
<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['id']) && $value['id'] > 0) {

        // SQL buscar o pretendente
        $sql = '
        SELECT p.prw_codigo, p.prw_nome, p.prw_status, p.prw_email
        FROM pretendentes AS p 
        WHERE p.prw_codigo = '.$value['id'];
        $result = $data->find('dynamic', $sql);

        // SQL buscar as etapas/status 
        $sql = '
        SELECT prs_codigo, prs_nome
        FROM pretendentesstatus
        WHERE prs_ativo = "s"
        ORDER BY prs_ordem ASC';
        $status = $data->find('dynamic', $sql);

        // Cards com todas as etapas
        $cards = [];
        foreach($status as $key => $value) {
            $cards[] = array(
                'id' => $value['prs_codigo'],
                'title' => $value['prs_nome'],
                'tasks' =>  []
            );
        }

        foreach($cards as $key => $card) {
            if($result[0]['prw_status'] == $card['id']) {
                $cards[$key]['tasks'] = [
                    array(
                        'projectId' => $card['id'],
                        'id' => 1,
                        'title' => $result[0]['prw_nome'],
                        'description' => $result[0]['prw_email'],
                        'image' => true,
                        'date' => date('d/m/Y H:i'),
                        'tags' => ['designing'],    
                    )
                ];
            }
        }       

        // Retorna resposta
        echo json_encode($cards);
        exit;
    }
}
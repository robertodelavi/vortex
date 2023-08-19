<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if(isset($value['pretendente']) && isset($value['id']) && $value['pretendente'] > 0 && $value['id'] > 0){
        $statusFavorite = $value['action'] ? 1 : 0;

        // Verifica se existe o registro ou não
        $sql = 'SELECT * FROM pretendentesimoveis WHERE pwi_pretendente = '.$value['pretendente'].' AND pwi_imovel = '.$value['id'];
        $result = $data->find('dynamic', $sql);

        if($result && count($result) > 0){
            $sql = 'UPDATE pretendentesimoveis SET pwi_favorito = '.$statusFavorite.' WHERE pwi_pretendente = '.$value['pretendente'].' AND pwi_imovel = '.$value['id'];
            $data->executaSQL($sql);
        }else{
            $sql = 'INSERT INTO pretendentesimoveis (pwi_pretendente, pwi_imovel, pwi_favorito) VALUES ('.$value['pretendente'].', '.$value['id'].', '.$statusFavorite.')';
            $data->executaSQL($sql);
        }

        $response = array(
            'success' => true,
            'data' => []
        );

        // Retorna os dados filtrados em formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

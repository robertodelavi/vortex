<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if(isset($value['pretendente']) && $value['pretendente'] > 0){
        
        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = '.$value['pretendente'].' AND p.pwi_favorito = 1';
        $resultFavoritos = $data->find('dynamic', $sql);

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = '.$value['pretendente'].' AND p.pwi_favorito = 0';
        $resultImoveis = $data->find('dynamic', $sql);

        $response = array(
            'success' => true,
            'data' => array(
                'favoritos' => $resultFavoritos ? $resultFavoritos : [],
                'imoveis' => $resultImoveis ? $resultImoveis : []
            )
        );

        // Retorna os dados filtrados em formato JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

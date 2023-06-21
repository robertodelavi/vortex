<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['ppf_pretendente']) && isset($value['ppf_codigo'])) {

        $sql = "
        SELECT * 
        FROM pretendentesperfil AS pp
            LEFT JOIN tipoimovel AS ti ON (ti.tpi_codigo = pp.ppf_tipoimovel)
        WHERE pp.ppf_pretendente = " . $value['ppf_pretendente']." AND pp.ppf_codigo = ".$value['ppf_codigo'];
        $result = $data->find('dynamic', $sql);

        // Exemplo de dados do perfil
        $resultData = array(
            'nome' => $result[0]['ppf_nome'],
            'tipoImovel' => $result[0]['tpi_descricao'],
            // 'faixaValor' => '1000 to 2000'
        );

        $response = array(
            'success' => true,
            'data' => $resultData
        );

        // Retorna os dados filtrados em formato JSON
        header('Content-Type: application/json');

        echo json_encode($response);
        exit;
    }
}
<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['id']) && $value['id'] > 0) {

        $sql = '
        SELECT *
        FROM imovelfoto AS ft
        WHERE ft.imf_imovel = ' . $value['id'].' 
        ORDER BY ft.imf_principal DESC';
        $result = $data->find('dynamic', $sql);

        $res = array();
        if($result && count($result) > 0){
            foreach ($result as $key => $value) {
                $res[] = array(
                    'src' => 'application/images/clientes/1/imoveis/'.$value['imf_arquivo'],
                    'title' => $value['imf_descricao'] ? $value['imf_descricao'] : 'Imagem '.($key+1), 
                    'description' => $value['imf_descricao'] ? $value['imf_descricao'] : 'Sem descrição'
                );
            }
        }

        // Retorna resposta
        echo json_encode($res);
        exit;
    }
}
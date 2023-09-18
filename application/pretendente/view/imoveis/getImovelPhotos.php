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
        WHERE ft.imf_imovel = ' . $value['id'].' AND ft.imf_web = "s"
        ORDER BY ft.imf_principal DESC';
        $result = $data->find('dynamic', $sql);

        $BASE_URL_IMAGENS = $_SESSION['BASE_URL_IMAGENS'];

        $res = array();
        if($result && count($result) > 0){
            foreach ($result as $key => $value) {
                $foto = $value['imf_arquivo'] ? $BASE_URL_IMAGENS.$value['imf_imovel'].'-'.$value['imf_arquivo'] : 'application/images/no-image-transparent.png';
                $res[] = array(
                    'src' => $foto,
                    'title' => $value['imf_descricao'] ? $value['imf_descricao'] : 'Imagem '.($key+1), 
                    'description' => $value['imf_descricao'] ? $value['imf_descricao'] : 'Sem descrição'
                );
            }
        }else{
            $res[0] = array(
                'src' => 'application/images/no-image-transparent.png',
                'title' => 'Sem imagem', 
                'description' => ''
            );
        }

        // Retorna resposta
        echo json_encode($res);
        exit;
    }
}
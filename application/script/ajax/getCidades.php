<?php
// Header default
session_start();
require_once('../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    
    if (isset($value['uf']) && $value['uf'] != '') {
        $sql = '
        SELECT cid_codigo, cid_descricao
        FROM cidades 
        WHERE cid_uf = "'.$value['uf'].'" 
        GROUP BY cid_descricao 
        ORDER BY cid_descricao ASC';
        $result = $data->find('dynamic', $sql);
        
        $html = '';
        if($result && count($result) > 0){
            foreach($result as $key => $value) {
                $html .= '<option value="'.$value['cid_codigo'].'">'.$value['cid_descricao'].'</option>';
            }
        }                
    }
    
    // Retorna resposta
    echo json_encode($html ? $html : '<option value="">-- Selecione o Estado --</option>');
    exit;
    
}
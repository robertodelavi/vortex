<?php
// Header default
session_start();
require_once('../../../../../library/DataManipulation.php');
require_once('../../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    
    $sql = '
    SELECT 
        i.imo_codigo, 
        ti.tpi_descricao,
        i.imo_rua, 
        b.bai_descricao, 
        i.imo_areaconstruida, 
        i.imo_quartos, 
        i.imo_banheiros, 
        i.imo_garagem,
        ((iv.imv_valor*m.moe_valor)/100) AS imv_valor
    FROM imoveis AS i
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
        JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
    WHERE i.imo_codigo > 0 AND  (
        i.imo_codigo = "' . $value . '" OR
        ti.tpi_descricao LIKE "%' . $value . '%" OR
        i.imo_rua LIKE "%' . $value . '%" OR
        b.bai_descricao LIKE "%' . $value . '%" OR
        c.cid_descricao LIKE "%' . $value . '%" OR
        i.imo_edificio LIKE "%' . $value . '%" OR
        i.imo_pontoreferencia LIKE "%' . $value . '%"
    )
    ORDER BY i.imo_codigo DESC
    LIMIT 10';
    $result = $data->find('dynamic', $sql);

    $res = [];
    foreach ($result as $key => $value) {         
        $res[] = array(
            'value' => $value['imo_codigo'],
            'text' => $value['imo_codigo'] . ' - ' . $value['tpi_descricao'] . ' - ' . $value['bai_descricao']
        );        
    }

    // Retorna resposta
    echo json_encode($res);
    exit;
}
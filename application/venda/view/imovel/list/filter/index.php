<?php
// Header default
session_start();
require_once('../../../../../../library/DataManipulation.php');
require_once('../../../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $req = json_decode(file_get_contents('php://input'), true);
    $values = $req['filters'];
    
    $sql = '
    SELECT 
        i.imo_codigo, 
        p.pes_nome1 AS proprietario,
        ti.tpi_descricao,
        b.bai_descricao,

        i.imo_quartos,
        i.imo_suites,
        i.imo_banheiros,
        i.imo_garagem,

        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor
    FROM imoveis AS i 
        JOIN pessoas AS p ON (i.imo_proprietario = p.pes_codigo)
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
    WHERE i.imo_codigo > 0 ';

    //? Filtros
    if($values){
        if($values['codigo']) $sql .= ' AND i.imo_codigo = "'.$values['codigo'].'" ';
        if($values['valorIni']) $sql .= ' AND (((iv.imv_valor*m.moe_valor)/100)/100) >= "'.moneyToFloat($values['valorIni']).'" ';
        if($values['valorFin']) $sql .= ' AND (((iv.imv_valor*m.moe_valor)/100)/100) <= "'.moneyToFloat($values['valorFin']).'" ';
        if($values['bairro']) $sql .= ' AND b.bai_descricao LIKE \'%'.$values['bairro'].'%\' ';
        if($values['dormitoriosIni']) $sql .= ' AND i.imo_quartos >= "'.$values['dormitoriosIni'].'" ';
        if($values['dormitoriosFin']) $sql .= ' AND i.imo_quartos <= "'.$values['dormitoriosFin'].'" ';
        if($values['suitesIni']) $sql .= ' AND i.imo_suites >= "'.$values['suitesIni'].'" ';
        if($values['suitesFin']) $sql .= ' AND i.imo_suites <= "'.$values['suitesFin'].'" ';
        if($values['garagem']) $sql .= ' AND i.imo_garagem = "'.$values['garagem'].'" ';
        if($values['tipoImovel']) $sql .= ' AND ti.tpi_codigo = "'.$values['tipoImovel'].'" ';
    }

    $sql .= ' 
    LIMIT 60';
    $result = $data->find('dynamic', $sql);

    $tableResult = [];
    foreach ($result as $row) {
        $arrRow = [];
        array_push($arrRow, $row['imo_codigo']);    
        array_push($arrRow, trim($row['proprietario']));   
        array_push($arrRow, $row['tpi_descricao']);
        array_push($arrRow, $row['bai_descricao']);
        array_push($arrRow, $row['imo_quartos']);
        array_push($arrRow, $row['imo_suites']);
        array_push($arrRow, $row['imo_banheiros']);         
        array_push($arrRow, $row['imo_garagem']);
        array_push($arrRow, 'R$ '.number_format($row['imv_valor'], 2, ',', '.'));
        array_push($arrRow, $row['prw_codigo']);
        //
        array_push($tableResult, $arrRow);
    }
    
    // Retorna os dados filtrados em formato JSON
    header('Content-Type: application/json');    
    echo json_encode($tableResult);
}
?>
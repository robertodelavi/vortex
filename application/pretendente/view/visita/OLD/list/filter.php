<?php
// Header default
session_start();
require_once('../../../../../library/DataManipulation.php');
require_once('../../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os valores do formulário
    $formData = $_POST;
    $values = json_decode($formData['values'], true);
    
    $sql = '
    SELECT 
        pv.prv_codigo,
        p.prw_nome AS pretendente, 
        CONCAT(ti.tpi_descricao, " - ", b.bai_descricao, " - ", c.cid_descricao, "/", c.cid_uf) AS imovel, 
        DATE_FORMAT(pv.prv_dataini, "%d/%m/%Y") AS dataIni,           
        IF(pv.prv_horaini <> "", CONCAT(SUBSTRING(pv.prv_horaini, 1, 2), ":", SUBSTRING(pv.prv_horaini, 3, 2)), "--") AS horaIni,
        DATE_FORMAT(pv.prv_datafim, "%d/%m/%Y") AS dataFim,
        IF(pv.prv_horafim <> "", CONCAT(SUBSTRING(pv.prv_horafim, 1, 2), ":", SUBSTRING(pv.prv_horafim, 3, 2)), "--") AS horaFim,        
        u.usu_nome AS entreguePor
    FROM pretendentesvisitas AS pv
        LEFT JOIN pretendentes AS p ON (pv.prv_pretendente = p.prw_codigo)
        LEFT JOIN imoveis AS i ON (pv.prv_imovel = i.imo_codigo)
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)    
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
        LEFT JOIN sisusuarios AS u ON (pv.prv_entreguepor = u.usu_codigo)
    WHERE pv.prv_codigo > 0 ';    
    
    if($values){
        //? Nome
        if($values['nome']) $sql .= ' AND p.prw_nome LIKE "%'.$values['nome'].'%" ';
        //? Período
        if($values['periodoIni'] && $values['periodoFim']) $sql .= ' AND STR_TO_DATE(pv.prv_dataini, "%Y%m%d") BETWEEN "'.$values['periodoIni'].'" AND "'.$values['periodoFim'].'" ';
        //? Tipo de imóvel
        if($values['tipoimovel']) $sql .= ' AND ti.tpi_codigo = "'.$values['tipoimovel'].'" ';
        //? Bairro 
        if($values['bairro']) $sql .= ' AND b.bai_descricao LIKE "%'.$values['bairro'].'%" ';
        //? Cidade
        if($values['cidade']) $sql .= ' AND c.cid_descricao LIKE "%'.$values['cidade'].'%" ';
        //? Observação 
        if($values['obs']) $sql .= ' AND pv.prv_obs LIKE "%'.$values['obs'].'%" ';
        //? Entregue por
        if($values['entreguePor']) $sql .= ' AND pv.prv_entreguepor = "'.$values['entreguePor'].'" ';        
    }
    
    $sql .= '
    ORDER BY pv.prv_dataini DESC, pv.prv_horaini DESC
    LIMIT 100';
    $result = $data->find('dynamic', $sql);    

    $filteredData = [];
    if (count($result) > 0){
        foreach($result as $row){
            $arrRow = [];
            array_push($arrRow, trim($row['pretendente']));    
            array_push($arrRow, trim($row['imovel'] ? $row['imovel'] : '--'));
            array_push($arrRow, trim($row['entreguePor'] ? $row['entreguePor'] : '--'));        
            array_push($arrRow, trim($row['dataIni'] ? $row['dataIni'] : '--'));
            array_push($arrRow, trim($row['horaIni'] ? $row['horaIni'] : '--'));
            array_push($arrRow, trim($row['dataFim'] ? $row['dataFim'] : '--'));
            array_push($arrRow, trim($row['horaFim'] ? $row['horaFim'] : '--'));
            array_push($arrRow, $row['prv_codigo']);
            //
            array_push($filteredData, $arrRow);
        }
    }
    
    // Retorna os dados filtrados em formato JSON
    header('Content-Type: application/json');
    
    echo json_encode($filteredData);
}

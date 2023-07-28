<?php
// Header default
session_start();
require_once('../../../library/DataManipulation.php');
require_once('../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os valores do formulário
    $formData = $_POST;
    $values = json_decode($formData['values'], true);
    
    $sql = '
    SELECT p.prw_codigo, p.prw_nome, p.prw_status, ps.prs_nome AS statusNome, ps.prs_cor
    FROM pretendentes AS p
        JOIN pretendentesstatus AS ps ON (p.prw_status = ps.prs_codigo)
    WHERE p.prw_nome LIKE "%'.$values['name'].'%" 
    LIMIT 100 ';
    $result = $data->find('dynamic', $sql);    

    // Obtém o total de etapas/status do pretendente pra calcular a % de progresso 
    $sql = '
    SELECT COUNT(*) AS qtd
    FROM pretendentesstatus
    WHERE prs_ativo = "s" ';
    $totalEtapas = $data->find('dynamic', $sql);

    function getProgressPercent($totalEtapas, $row){
        if(!$totalEtapas) $totalEtapas = 1;
        $percent = ($row['prw_status'] * 100)/$totalEtapas;
        return $percent;
    }
    
    $filteredData = [];
    if (count($result) > 0){
        foreach($result as $row){
            $arrRow = [];
            array_push($arrRow, trim($row['prw_nome']));
            array_push($arrRow, '<div class="h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:'.getProgressPercent($totalEtapas[0]['qtd'], $row).'%; background-color: '.$row['prs_cor'].'; "></div>');
            array_push($arrRow, 'Tozzo');
            array_push($arrRow, '2023-01-08');
            array_push($arrRow, 'r@gmail.com');
            array_push($arrRow, '3352-4671');
            array_push($arrRow, $row['prw_codigo']);
            //
            array_push($filteredData, $arrRow);
        }
    }
    
    // Retorna os dados filtrados em formato JSON
    header('Content-Type: application/json');
    
    echo json_encode($filteredData);

}

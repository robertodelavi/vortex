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
    SELECT p.prw_codigo, p.prw_nome, p.prw_email, p.prw_psa_codigo, u.usu_nome, p.prw_telefones, DATE_FORMAT(p.prw_datacad, "%d/%m/%Y") AS primeiroCadastro, ps.psa_descricao AS statusNome, ps.psa_cor,
        (SELECT DATE_FORMAT(ph.prh_datacad, "%d/%m/%Y")
        FROM pretendenteshistorico AS ph 
        WHERE ph.prh_pretendente = p.prw_codigo
        ORDER BY ph.prh_datacad DESC
        LIMIT 1) AS ultimoCadastro
    FROM pretendentes AS p
        LEFT JOIN sisusuarios AS u ON (p.prw_usuario = u.usu_codigo)
        LEFT JOIN pretendentesstatusatendimento AS ps ON (p.prw_psa_codigo = ps.psa_codigo)
    WHERE p.prw_nome LIKE "%'.$values['name'].'%" 
    LIMIT 100 ';
    $result = $data->find('dynamic', $sql);    

    // Obtém o total de etapas/status do pretendente pra calcular a % de progresso 
    $sql = '
    SELECT COUNT(*) AS qtd
    FROM pretendentesstatusatendimento';
    $totalEtapas = $data->find('dynamic', $sql);

    function getProgressPercent($totalEtapas, $row){
        if(!$totalEtapas) $totalEtapas = 1;
        $percent = ($row['prw_psa_codigo'] * 100)/$totalEtapas;
        return $percent;
    }
    
    $filteredData = [];
    if (count($result) > 0){
        foreach($result as $row){
            $arrRow = [];
            array_push($arrRow, trim($row['prw_nome']));    
            array_push($arrRow, '<div class="h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:'.getProgressPercent($totalEtapas[0]['qtd'], $row).'%; background-color: '.$row['psa_cor'].'; "></div>');
            array_push($arrRow, trim($row['usu_nome'] ? $row['usu_nome'] : '--'));
            array_push($arrRow, trim($row['prw_telefones'] ? $row['prw_telefones'] : '--'));
            array_push($arrRow, trim($row['primeiroCadastro']).' a '.trim($row['ultimoCadastro']));
            array_push($arrRow, trim($row['prw_email'] ? $row['prw_email'] : '--'));   
            array_push($arrRow, $row['prw_codigo']);
            //
            array_push($filteredData, $arrRow);
        }
    }
    
    // Retorna os dados filtrados em formato JSON
    header('Content-Type: application/json');
    
    echo json_encode($filteredData);

}

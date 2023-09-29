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
    SELECT 
        IF((p.prw_usuario = '.$_SESSION['v_usu_codigo'].' OR u.usu_nivel < '.$_SESSION['v_usu_nivel'].'), p.prw_codigo, 0) AS prw_codigo, 
        p.prw_nome, 
        p.prw_email,     
        p.prw_psa_codigo, 
        u.usu_nome, 
        p.prw_telefones, 
        ps.psa_descricao AS statusNome, 
        ps.psa_cor,
        
        (SELECT IF(ph.prh_datacad <> "", DATE_FORMAT(ph.prh_datacad, "%d/%m/%y"), "--")
        FROM pretendenteshistorico AS ph 
        WHERE ph.prh_pretendente = p.prw_codigo
        ORDER BY ph.prh_datacad ASC
        LIMIT 1) AS primeiroCadastro,

        (SELECT IF(ph.prh_datacad <> "", DATE_FORMAT(ph.prh_datacad, "%d/%m/%y"), "--")
        FROM pretendenteshistorico AS ph 
        WHERE ph.prh_pretendente = p.prw_codigo
        ORDER BY ph.prh_datacad DESC
        LIMIT 1) AS ultimoCadastro
    FROM pretendentes AS p
        LEFT JOIN sisusuarios AS u ON (p.prw_usuario = u.usu_codigo)
        LEFT JOIN pretendentesstatusatendimento AS ps ON (p.prw_psa_codigo = ps.psa_codigo)
    WHERE prw_codigo > 0 ';

    //? Usuário logado só ve pretententes que foram cadastrados por ele mesmo e com niveis menores ao dele
    if($_SESSION['v_usu_nivel']){
        $sql .= ' AND (u.usu_codigo = '.$_SESSION['v_usu_codigo'].' OR u.usu_nivel <= '.$_SESSION['v_usu_nivel'].')';
    }

    //? Usuário logado tem permisão de ver somente os atendimentos dele
    if($_SESSION['v_somente_atendimentos_meu'] == "s"){
        $sql .= ' AND p.prw_usuario = "'.$_SESSION['v_usu_codigo'].'" ';
    }
    
    if($values){
        //? Nome
        if($values['nome']) $sql .= ' AND p.prw_nome LIKE "%'.$values['nome'].'%" ';
        //? Situação 
        if($values['situacao']) $sql .= ' AND p.prw_concluido = "'.$values['situacao'].'" ';
        //? E-mail
        if($values['email']) $sql .= ' AND p.prw_email LIKE "%'.$values['email'].'%" ';
        //? Telefones
        if($values['telefones']) $sql .= ' AND p.prw_telefones LIKE "%'.$values['telefones'].'%" ';
        //? Status do negócio
        if($values['prw_psn_codigo']) $sql .= ' AND p.prw_psn_codigo = "'.$values['prw_psn_codigo'].'" ';
        //? Perfil do cliente 
        if($values['prw_perfilcliente']) $sql .= ' AND p.prw_perfilcliente = "'.$values['prw_perfilcliente'].'" ';
        //? Observação 
        if($values['prw_obs']) $sql .= ' AND p.prw_obs LIKE "%'.$values['prw_obs'].'%" ';
        //? Status do atendimento
        if($values['prw_psa_codigo']) $sql .= ' AND p.prw_psa_codigo = "'.$values['prw_psa_codigo'].'" ';
        //? Objetivo
        if($values['prw_objetivo']) $sql .= ' AND p.prw_objetivo = "'.$values['prw_objetivo'].'" ';
        //? Origem 
        if($values['prw_origem']) $sql .= ' AND p.prw_origem = "'.$values['prw_origem'].'" ';
        //? Usuário
        if($values['prw_usuario']) $sql .= ' AND p.prw_usuario = "'.$values['prw_usuario'].'" ';
        //? Atendimentos
        if($values['atendimentos'] == 'meus') $sql .= ' AND p.prw_usuario = "'.$_SESSION['v_usu_codigo'].'" ';
    }
    
    $sql .= '
    LIMIT 100';
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
            array_push($arrRow, trim($row['primeiroCadastro']));
            array_push($arrRow, trim($row['ultimoCadastro']));
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

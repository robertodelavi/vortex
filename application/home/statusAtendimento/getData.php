<?php 
    $sql = '
    SELECT usu_codigo, usu_nivel
    FROM sisusuarios
    WHERE usu_codigo = '.$_SESSION['v_usu_codigo'];
    $usuario = $data->find('dynamic', $sql);

    $result = null;
    $sql = '
    SELECT ps.psa_codigo, ps.psa_descricao, ps.psa_cor,
        (
            SELECT COUNT(p.prw_codigo)
            FROM pretendentes p
                JOIN sisusuarios u ON (p.prw_usuario = u.usu_codigo)
            WHERE p.prw_usuario = '.$usuario[0]['usu_codigo'].' AND p.prw_psa_codigo = ps.psa_codigo AND p.prw_concluido = "n"
        ) AS total
    FROM pretendentesstatusatendimento ps
    ORDER BY ps.psa_ordem ASC';
    $result = $data->find('dynamic', $sql);

    $totalPretendentes = 0;
    if($result && count($result) > 0){
        foreach ($result as $key => $value) {
            // converter pra inteiro e somar
            $totalPretendentes += (int) $value['total'];
        }
    }     
?>
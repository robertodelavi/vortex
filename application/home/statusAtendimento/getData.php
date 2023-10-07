<?php 
    $result = null;
    $sql = '
    SELECT ps.psa_codigo, ps.psa_descricao, ps.psa_cor,
        (
            SELECT COUNT(p.prw_codigo)
            FROM pretendentes p
            WHERE p.prw_psa_codigo = ps.psa_codigo
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
<?php 
    $sql = '
    SELECT p.prw_codigo, p.prw_nome 
    FROM pretendentes AS p 
    WHERE p.prw_usuario = '.$_SESSION['v_usu_codigo'].' 
    ORDER BY p.prw_nome ASC';
    $pretendente = $data->find('dynamic', $sql);

    $result = [];    
    if($pretendente && count($pretendente) > 0){
        foreach ($pretendente as $key => $value) { // Cada pretendente
            // echo '<br><br>pretendente: '.$value['prw_nome'];
            // Perfis do pretendente
            $sql = '
            SELECT * 
            FROM pretendentesperfil AS pp 
            WHERE pp.ppf_pretendente = '.$value['prw_codigo'];
            $pretendentePerfil = $data->find('dynamic', $sql);
    
            $arrayImoveis = [];
            if($pretendentePerfil && count($pretendentePerfil) > 0){
                foreach ($pretendentePerfil as $keyPerfil => $valuePerfil) { // Cada perfil do pretendente
                    $sql = '
                    SELECT 
                        i.imo_codigo, 
                        ti.tpi_descricao, 
                        b.bai_descricao, 
                        ((iv.imv_valor*m.moe_valor)/100) AS imv_valor,
                        i.imo_datacad,
                        (SELECT DATEDIFF(NOW(), i.imo_datacad)) AS diasCadastro
                    FROM imoveis AS i 
                        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
                        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
                        LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s" AND ft.imf_web = "s")
                        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
                        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
                    WHERE i.imo_datacad > ( 
                        SELECT p.prw_dataatual 
                        FROM pretendentes AS p 
                        WHERE p.prw_codigo = '.$value['prw_codigo'].'
                    )
                        -- Perfil do pretendente
                        AND i.imo_quartos > 0';
                    $imoveisPerfil = $data->find('dynamic', $sql);
                        
                    // echo '<br>perfil ('.$valuePerfil['ppf_nome'].') do pretendente '.$value['prw_nome'];

                    // Insere imoveis no arrayImoveis, sem repetir o imo_codigo
                    if($imoveisPerfil && count($imoveisPerfil) > 0){
                        foreach ($imoveisPerfil as $keyImovel => $valueImovel) {
                            if (!in_array($valueImovel['imo_codigo'], $arrayImoveis)) { // Não repetir imóvel para este pretendente
                                $arrayImoveis[] = $valueImovel;                                
                            }
                        }
                    }
                } 
                
                if($arrayImoveis && count($arrayImoveis) > 0){ // Encontrou pelo menos 1 imóvel novo pro pretendente atual, insere no array $result
                    foreach ($arrayImoveis as $keyImovel => $valueImovel) {
                        $result[] = array(
                            'prw_codigo' => $value['prw_codigo'],
                            'pretendente' => $value['prw_nome'],
                            'imovel' => $valueImovel['imo_codigo'].' - '.$valueImovel['tpi_descricao'].' - '.$valueImovel['bai_descricao'],
                            'valor' => 'R$ '.number_format(($valueImovel['imv_valor']/100), 2, ',', '.'),
                            'diasCadastro' => $valueImovel['diasCadastro']
                        );
                    }                    
                }
            }
        }
    }
?>
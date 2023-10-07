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
                        (SELECT DATEDIFF(NOW(), i.imo_datacad)) AS diasCadastro,
                        ft.imf_imovel,
                        ft.imf_arquivo
                    FROM imoveis AS i 
                        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
                        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
                        LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s" AND ft.imf_web = "s")
                        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
                        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
                        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
                    WHERE i.imo_datacad > ( 
                        SELECT p.prw_dataatual 
                        FROM pretendentes AS p 
                        WHERE p.prw_codigo = '.$value['prw_codigo'].'
                    ) ';
                    
                    // Perfil do pretendente
                    if($valuePerfil['ppf_tipoimovel'] && $valuePerfil['ppf_tipoimovel'] > 0){ $sql .= ' AND i.imo_tipoimovel = '.$valuePerfil['ppf_tipoimovel']; }
                    if($valuePerfil['ppf_utilizacao'] && $valuePerfil['ppf_utilizacao'] > 0){ $sql .= ' AND i.imo_utilizacao = '.$valuePerfil['ppf_utilizacao']; }
                    if($valuePerfil['ppf_quartosini'] && $valuePerfil['ppf_quartosini'] > 0){ $sql .= ' AND i.imo_quartos >= '.$valuePerfil['ppf_quartosini']; }
                    if($valuePerfil['ppf_quartosfim'] && $valuePerfil['ppf_quartosfim'] > 0){ $sql .= ' AND i.imo_quartos <= '.$valuePerfil['ppf_quartosfim']; }
                    if($valuePerfil['ppf_suitesini'] && $valuePerfil['ppf_suitesini'] > 0){ $sql .= ' AND i.imo_suites >= '.$valuePerfil['ppf_suitesini']; }
                    if($valuePerfil['ppf_suitesfim'] && $valuePerfil['ppf_suitesfim'] > 0){ $sql .= ' AND i.imo_suites <= '.$valuePerfil['ppf_suitesfim']; }
                    if($valuePerfil['ppf_garagem'] && $valuePerfil['ppf_garagem'] > 0){ $sql .= ' AND i.imo_garagem = '.$valuePerfil['ppf_garagem']; }
                    if($valuePerfil['ppf_valorini'] && $valuePerfil['ppf_valorini'] > 0){ $sql .= ' AND (((iv.imv_valor*m.moe_valor)/100)/100) >= '.$valuePerfil['ppf_valorini']; }
                    if($valuePerfil['ppf_valorfim'] && $valuePerfil['ppf_valorfim'] > 0){ $sql .= ' AND (((iv.imv_valor*m.moe_valor)/100)/100) <= '.$valuePerfil['ppf_valorfim']; }                    
                    if($valuePerfil['ppf_areaterrenoini'] && $valuePerfil['ppf_areaterrenoini'] > 0){ $sql .= ' AND i.imo_areaterreno >= '.$valuePerfil['ppf_areaterrenoini']; }
                    if($valuePerfil['ppf_areaterrenofim'] && $valuePerfil['ppf_areaterrenofim'] > 0){ $sql .= ' AND i.imo_areaterreno <= '.$valuePerfil['ppf_areaterrenofim']; }
                    if($valuePerfil['ppf_areaconstruidaini'] && $valuePerfil['ppf_areaconstruidaini'] > 0){ $sql .= ' AND i.imo_areaconstruida >= '.$valuePerfil['ppf_areaconstruidaini']; }
                    if($valuePerfil['ppf_areaconstruidafim'] && $valuePerfil['ppf_areaconstruidafim'] > 0){ $sql .= ' AND i.imo_areaconstruida <= '.$valuePerfil['ppf_areaconstruidafim']; }
                    if($valuePerfil['ppf_cidade'] && $valuePerfil['ppf_cidade'] != ''){ $sql .= ' AND c.cid_descricao LIKE "%'.$valuePerfil['ppf_cidade'].'%"'; }  
                    if($valuePerfil['ppf_pontoreferencia'] && $valuePerfil['ppf_pontoreferencia'] != ''){ $sql .= ' AND i.imo_pontoreferencia LIKE "%'.$valuePerfil['ppf_pontoreferencia'].'%"'; }
                    if($valuePerfil['ppf_edificio'] && $valuePerfil['ppf_edificio'] != ''){ $sql .= ' AND i.imo_edificio LIKE "%'.$valuePerfil['ppf_edificio'].'%"'; }
                    if($valuePerfil['ppf_rua'] && $valuePerfil['ppf_rua'] != ''){ $sql .= ' AND i.imo_rua LIKE "%'.$valuePerfil['ppf_rua'].'%"'; }
                    if($valuePerfil['ppf_bairro'] && $valuePerfil['ppf_bairro'] != ''){ $sql .= ' AND b.bai_descricao LIKE "%'.$valuePerfil['ppf_bairro'].'%"'; }
                    if($valuePerfil['ppf_empreendimento'] && $valuePerfil['ppf_empreendimento'] > 0){ $sql .= ' AND i.imo_empreendimento = '.$valuePerfil['ppf_empreendimento']; }
                    
                    // Executa SQL
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
                        $foto = $valueImovel['imf_arquivo'] ? $_SESSION['BASE_URL_IMAGENS'].$valueImovel['imf_imovel'].'-'.$valueImovel['imf_arquivo'] : 'application/images/no-image-transparent.png';

                        $result[] = array(
                            'prw_codigo' => $value['prw_codigo'],
                            'pretendente' => $value['prw_nome'],
                            'foto' => $foto, 
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
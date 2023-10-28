<?php 
    $sql = '
    SELECT 
        i.*,
        DATE_FORMAT(i.imo_datacad, "%d/%m/%Y") AS imo_datacad,
        DATE_FORMAT(i.imo_dataatual, "%d/%m/%Y") AS imo_dataatual
    FROM imoveis AS i 
    WHERE i.imo_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);

    // Proprietário
    $sql = '
    SELECT 
        p.pes_codigo, 
        CONCAT(p.pes_nome1, " (", p.pes_cpfcnpj, ")") AS nome        
    FROM pessoas AS p
    ORDER BY p.pes_nome1 ASC
    LIMIT 20';
    $proprietario = $data->find('dynamic', $sql);

    // Tipo de imóvel
    $sql = '
    SELECT 
        ti.tpi_codigo, 
        ti.tpi_descricao
    FROM tipoimovel AS ti
    ORDER BY ti.tpi_descricao ASC';
    $tipoImovel = $data->find('dynamic', $sql);

    // Tipo de construção
    $sql = '
    SELECT 
        tc.tcn_codigo, 
        tc.tcn_descricao
    FROM tipoconstrucao AS tc
    ORDER BY tc.tcn_descricao ASC';
    $tipoConstrucao = $data->find('dynamic', $sql);

    // Utilização
    $sql = '
    SELECT 
        u.uti_codigo, 
        u.uti_descricao
    FROM utilizacao AS u
    ORDER BY u.uti_descricao ASC';
    $tipoUtilizacao = $data->find('dynamic', $sql);

    // Situação (situacaovenda)
    $sql = '
    SELECT 
        s.stv_codigo, 
        s.stv_descricao
    FROM situacaovenda AS s
    ORDER BY s.stv_descricao ASC';
    $situacaoVenda = $data->find('dynamic', $sql);

    // empreendimentos
    $sql = '
    SELECT 
        e.epr_codigo, 
        e.epr_descricao
    FROM empreendimentos AS e
    ORDER BY e.epr_descricao ASC';
    $empreendimentos = $data->find('dynamic', $sql);

    // Ocupação
    $sql = '
    SELECT 
        o.ocp_codigo, 
        o.ocp_descricao
    FROM ocupacao AS o
    ORDER BY o.ocp_descricao ASC';
    $ocupacao = $data->find('dynamic', $sql);

    // Filial
    $sql = '
    SELECT 
        f.fil_codigo, 
        f.fil_descricao
    FROM filiais AS f
    ORDER BY f.fil_descricao ASC';
    $filial = $data->find('dynamic', $sql);

    // Perfil imóvel
    $sql = '
    SELECT 
        ip.ipl_codigo, 
        ip.ipl_descricao
    FROM imovelperfil AS ip
    ORDER BY ip.ipl_codigo ASC';
    $perfilImovel = $data->find('dynamic', $sql);

    // Tipo de vaga de garagem 
    $sql = '
    SELECT 
        tv.tvg_codigo, 
        tv.tvg_descricao
    FROM tipovagagaragem AS tv
    ORDER BY tv.tvg_descricao ASC';
    $tipoVagaGaragem = $data->find('dynamic', $sql);

    // Tipo de piso
    $sql = '
    SELECT 
        tp.tpp_codigo, 
        tp.tpp_descricao
    FROM tipopiso AS tp
    ORDER BY tp.tpp_descricao ASC';
    $tipoPiso = $data->find('dynamic', $sql);

    // Tipo de forro
    $sql = '
    SELECT 
        tf.tpf_codigo, 
        tf.tpf_descricao
    FROM tipoforro AS tf
    ORDER BY tf.tpf_descricao ASC';
    $tipoForro = $data->find('dynamic', $sql);

    // Tipo de mobília
    $sql = '
    SELECT 
        tm.tpm_codigo, 
        tm.tpm_descricao
    FROM tipomobilia AS tm
    ORDER BY tm.tpm_descricao ASC';
    $tipoMobilia = $data->find('dynamic', $sql);   
?>

<form method="POST" action="?module=venda&acao=update_imovel" >
    <input type="hidden" name="imo_codigo" value="<?php echo $_POST['param_0']; ?>" />

    <div class="flex flex-col gap-3">
        <!-- GERAL -->
        <div class="panel">
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
                <div>
                    <h5 class="text-lg font-semibold">Geral</h5>
                </div>    
                <div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>            
            </div>   
            
            <!-- Dados -->
            <div class="flex flex-col sm:flex-row" >
                <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <!-- Proprietário -->
                    <div>
                        <label for="name">Proprietário</label>
                        <select name="imo_proprietario" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($proprietario as $row){
                                    $selected = $result[0]['imo_proprietario'] == $row['pes_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['pes_codigo'].'" '.$selected.' >
                                        '.$row['nome'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Tipo de imóvel -->
                    <div>
                        <label for="name">Tipo de imóvel</label>
                        <select name="imo_tipoimovel" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoImovel as $row){
                                    $selected = $result[0]['imo_tipoimovel'] == $row['tpi_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tpi_codigo'].'" '.$selected.' >
                                        '.$row['tpi_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Tipo de construção -->
                    <div>
                        <label for="name">Tipo de construção</label>
                        <select name="imo_tipoconstrucao" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoConstrucao as $row){
                                    $selected = $result[0]['imo_tipoconstrucao'] == $row['tcn_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tcn_codigo'].'" '.$selected.' >
                                        '.$row['tcn_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Utilização -->
                    <div>
                        <label for="name">Utilização</label>
                        <select name="imo_utilizacao" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoUtilizacao as $row){
                                    $selected = $result[0]['imo_utilizacao'] == $row['uti_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['uti_codigo'].'" '.$selected.' >
                                        '.$row['uti_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Situação -->
                    <div>
                        <label for="name">Situação (?)</label>
                        <select class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($situacaoVenda as $row){
                                    $selected = $result[0]['imo_situacao'] == $row['stv_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['stv_codigo'].'" '.$selected.' >
                                        '.$row['stv_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Motivo -->
                    <div>
                        <label>Motivo (?)</label>
                        <input type="text" placeholder="" class="form-input" value="<?php echo $result[0]['motivo']; ?>" />
                    </div>
                    
                    <!-- Data -->
                    <div>
                        <label>Data (?)</label>
                        <input type="date" placeholder="" class="form-input" value="<?php echo $result[0]['data']; ?>" />
                    </div>
                    
                    <!-- CEP -->
                    <div>
                        <label>CEP</label>
                        <input name="imo_cep" type="text" placeholder="00000000" maxlength="8" class="form-input" value="<?php echo $result[0]['imo_cep']; ?>" />
                    </div>
    
                    <!-- Cidade -->
                    <div>
                        <label>Cidade (temp)</label>
                        <input type="text" placeholder="" class="form-input" value="<?php echo $result[0]['xxxx']; ?>" />
                    </div>
    
                    <!-- Endereço -->
                    <div>
                        <label>Endereço</label>
                        <input name="imo_rua" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_rua']; ?>" />
                    </div>
    
                    <!-- Nº -->
                    <div>
                        <label>Nº</label>
                        <input name="imo_numero" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_numero']; ?>" />
                    </div>
    
                    <!-- Complemento -->
                    <div>
                        <label>Complemento</label>
                        <input name="imo_complemento" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_complemento']; ?>" />
                    </div>
                    
                    <!-- Edifício/Loteamento -->
                    <div>
                        <label>Edifício/Loteamento</label>
                        <input name="imo_edificio" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_edificio']; ?>" />
                    </div>
    
                    <!-- Bairro -->
                    <div>
                        <label>Bairro (temp)</label>
                        <input name="imo_bairro" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_bairro']; ?>" />
                    </div>
    
                    <!-- Ponto de referência -->
                    <div>
                        <label>Ponto de referência</label>
                        <input name="imo_pontoreferencia" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_pontoreferencia']; ?>" />
                    </div>
    
                    <!-- Empreendimento -->
                    <div>
                        <label>Empreendimento</label>
                        <select name="imo_empreendimento" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($empreendimentos as $row){
                                    $selected = $result[0]['imo_empreendimento'] == $row['epr_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['epr_codigo'].'" '.$selected.' >
                                        '.$row['epr_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Longitude -->
                    <div>
                        <label>Longitude</label>
                        <input name="imo_longitude" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_longitude']; ?>" />
                    </div>
    
                    <!-- Latitude -->
                    <div>
                        <label>Latitude</label>
                        <input name="imo_latitude" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_latitude']; ?>" />
                    </div>
    
                    <!-- Quadra -->
                    <div>
                        <label>Quadra</label>
                        <input name="imo_quadra" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_quadra']; ?>" />
                    </div>
    
                    <!-- Lote -->
                    <div>
                        <label>Lote</label>
                        <input name="imo_lote" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_lote']; ?>" />
                    </div>
                    
                    <!-- Ocupação -->
                    <div>
                        <label>Ocupação</label>
                        <select name="imo_ocupacao" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($ocupacao as $row){
                                    $selected = $result[0]['imo_ocupacao'] == $row['ocp_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['ocp_codigo'].'" '.$selected.' >
                                        '.$row['ocp_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Horário de visitação -->
                    <div>
                        <label>Horário de visitação</label>
                        <input name="imo_horariovisitacao" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_horariovisitacao']; ?>" />
                    </div>
    
                    <!-- Filial -->
                    <div>
                        <label>Filial</label>
                        <select name="imo_filial" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($filial as $row){
                                    $selected = $result[0]['imo_filial'] == $row['fil_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['fil_codigo'].'" '.$selected.' >
                                        '.$row['fil_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>
    
                    <!-- Perfil imóvel -->
                    <div>
                        <label>Perfil imóvel (?)</label>
                        <select class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($perfilImovel as $row){
                                    $selected = $result[0]['imo_perfilimovel'] == $row['ipl_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['ipl_codigo'].'" '.$selected.' >
                                        '.$row['ipl_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>  
                    
                    <!-- Informações datas -->
                    <div class="flex gap-6">
                        <div class="text-xs">
                            <p>Data de cadastro</p>
                            <p><?php echo $result[0]['imo_datacad']; ?></p>
                        </div>
                        <div class="text-xs">
                            <p>Última atualização</p>
                            <p><?php echo $result[0]['imo_dataatual']; ?></p>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    
        <!-- CARACTERÍSTICAS -->
        <div class="panel">
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
                <div>
                    <h5 class="text-lg font-semibold">Características</h5>
                </div>    
            </div>   
            
            <!-- Dados -->
            <div class="flex flex-col sm:flex-row mb-4" >
                <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <!-- Posição/Orientação solar -->
                    <div>
                        <label>Posição/Orientação solar</label>
                        <input name="imo_posicao" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_posicao']; ?>" />
                    </div>

                    <!-- Topografia -->
                    <div>
                        <label for="name">Topografia</label>
                        <input name="imo_topografia" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_topografia']; ?>" />
                    </div>

                    <!-- Viabilidade -->
                    <div>
                        <label for="name">Viabilidade</label>
                        <input name="imo_viabilidade" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_viabilidade']; ?>" />
                    </div>

                    <!-- Ano de construção -->
                    <div>
                        <label>Ano de construção</label>
                        <input name="imo_anoconstrucao" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_anoconstrucao']; ?>" />
                    </div>

                    <!-- Nº andares -->
                    <div>
                        <label>Nº andares</label>
                        <input name="imo_andares" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_andares']; ?>" />
                    </div>

                    <!-- Nº unidades por andar -->
                    <div>
                        <label>Nº unidades por andar</label>
                        <input name="imo_unidadesandar" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_unidadesandar']; ?>" />
                    </div>

                    <!-- Nº de elevadores -->
                    <div>
                        <label>Nº de elevadores</label>
                        <input name="imo_elevadores" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_elevadores']; ?>" />
                    </div>

                    <!-- Dimensões -->
                    <div>
                        <label>Dimensões</label>
                        <input name="imo_dimensoes" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_dimensoes']; ?>" />
                    </div>
                    
                    <!-- Área do terreno (m²) -->
                    <div>
                        <label>Área do terreno (m²)</label>
                        <input name="imo_areaterreno" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areaterreno']; ?>" />
                    </div>

                    <!-- Área construída (m²) -->
                    <div>
                        <label>Área construída (m²)</label>
                        <input name="imo_areaconstruida" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areaconstruida']; ?>" />
                    </div>

                    <!-- Área privativa (m²) -->
                    <div>
                        <label>Área privativa (m²)</label>
                        <input name="imo_areaprivativa" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areaprivativa']; ?>" />
                    </div>

                    <!-- Área útil (m²) -->
                    <div>
                        <label>Área útil (m²)</label>
                        <input name="imo_areautil" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areautil']; ?>" />
                    </div>

                    <!-- Área comum (m²) -->
                    <div>
                        <label>Área comum (m²)</label>
                        <input name="imo_areacomum" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areacomum']; ?>" />
                    </div>

                    <!-- Área da garagem (m²) -->
                    <div>
                        <label>Área da garagem (m²)</label>
                        <input name="imo_areagaragem" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_areagaragem']; ?>" />
                    </div>

                    <!-- Nº dormitórios -->
                    <div>
                        <label>Nº dormitórios</label>
                        <input name="imo_quartos" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_quartos']; ?>" />
                    </div>

                    <!-- Sendo Nº suítes -->
                    <div>
                        <label>Sendo Nº suítes</label>
                        <input name="imo_suites" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_suites']; ?>" />
                    </div>

                    <!-- Nº banheiro social -->
                    <div>
                        <label>Nº banheiro social</label>
                        <input name="imo_banheiros" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_banheiros']; ?>" />
                    </div>

                    <!-- Nº de vagas de garagem -->
                    <div>
                        <label>Nº de vagas de garagem</label>
                        <input name="imo_garagem" type="number" placeholder="" class="form-input" value="<?php echo $result[0]['imo_garagem']; ?>" />
                    </div>

                    <!-- Tipo de vaga de garagem -->
                    <div>
                        <label>Tipo de vaga de garagem</label>
                        <select name="imo_tipovagagaragem" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoVagaGaragem as $row){
                                    $selected = $result[0]['imo_tipovagagaragem'] == $row['tvg_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tvg_codigo'].'" '.$selected.' >
                                        '.$row['tvg_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Nº das garagens -->
                    <div>
                        <label>Nº das garagens</label>
                        <input name="imo_numerodagaragem" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_numerodagaragem']; ?>" />
                    </div>

                    <!-- Nº do depósito -->
                    <div>
                        <label>Nº do depósito</label>
                        <input name="imo_numerododeposito" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_numerododeposito']; ?>" />
                    </div>

                    <!-- Tipo de piso -->
                    <div>
                        <label>Tipo de piso</label>
                        <select name="imo_tipopiso" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoPiso as $row){
                                    $selected = $result[0]['imo_tipopiso'] == $row['tpp_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tpp_codigo'].'" '.$selected.' >
                                        '.$row['tpp_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Construtora -->
                    <div>
                        <label>Construtora</label>
                        <input name="imo_construtora" type="text" placeholder="" class="form-input" value="<?php echo $result[0]['imo_construtora']; ?>" />
                    </div>

                    <!-- Tipo de forro -->
                    <div>
                        <label>Tipo de forro</label>
                        <select name="imo_tipoforro" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoForro as $row){
                                    $selected = $result[0]['imo_tipoforro'] == $row['tpf_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tpf_codigo'].'" '.$selected.' >
                                        '.$row['tpf_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Tipo de mobília -->
                    <div>
                        <label>Tipo de mobília</label>
                        <select name="imo_tipomobilia" class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoMobilia as $row){
                                    $selected = $result[0]['imo_tipomobilia'] == $row['tpm_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['tpm_codigo'].'" '.$selected.' >
                                        '.$row['tpm_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>    
                </div>
            </div>

            <!-- Informações adicionais do imóvel -->
            <div class="flex-1 flex-row">
                <div>
                    <label>Informações adicionais do imóvel</label>
                    <textarea name="imo_detalhes" class="form-input" rows="10"><?php echo $result[0]['imo_detalhes']; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</form>
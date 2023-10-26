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
   
?>

<div class="panel">
    <form method="POST" action="?module=venda&acao=update_imovel" >
        <input type="hidden" name="imo_codigo" value="<?php echo $_POST['param_0']; ?>" />

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
    </form>
</div>
<?php 
    $sql = '
    SELECT 
        i.*,
        DATE_FORMAT(i.imo_datacad, "%d/%m/%Y") AS imo_datacad,
        DATE_FORMAT(i.imo_dataatual, "%d/%m/%Y") AS imo_dataatual,

        iv.imv_placa,
        iv.imv_autorizainternet,
        iv.imv_autorizaimprensa,
        iv.imv_autorizafotos,
        iv.imv_exclusividade,

        iv.imv_numerochave,
        iv.imv_localchave,
        iv.imv_corretor,
        iv.imv_responsavelagenciamento,
        iv.imv_tipoautorizacao,
        DATE_FORMAT(iv.imv_dataagenciamento, "%Y-%m-%d") AS imv_dataagenciamento,        
        DATE_FORMAT(iv.imv_datarenovacao, "%Y-%m-%d") AS imv_datarenovacao,
        DATE_FORMAT(iv.imv_datavalidade, "%Y-%m-%d") AS imv_datavalidade,
        (
            SELECT DATEDIFF(iv.imv_datavalidade, NOW())
            FROM imovelvenda AS iv
            WHERE iv.imv_codigo = i.imo_codigo
        ) AS validadeDias
    FROM imoveis AS i 
        LEFT JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
    WHERE i.imo_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);

    // Corretor
    $sql = '
    SELECT p.pes_codigo, p.pes_nome1 AS pes_nome
    FROM pessoas AS p
    WHERE p.pes_corretor = "s" AND p.pes_corretorativo = "s" 
    ORDER BY p.pes_nome1 ASC';
    $corretor = $data->find('dynamic', $sql);

    // Tipo de autorização
    $sql = '
    SELECT 
        ta.tpa_codigo, 
        ta.tpa_descricao
    FROM tipoautorizacao AS ta
    ORDER BY ta.tpa_descricao ASC';
    $tipoAutorizacao = $data->find('dynamic', $sql);
?>

<div class="panel">
    <form method="POST" action="?module=venda&acao=update_agenciamento_imovel" >
        <input type="hidden" name="imo_codigo" value="<?php echo $_POST['param_0']; ?>" />

        <!-- Cabeçalho -->
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="text-lg font-semibold">Agenciamento</h5>
            </div>    
            <div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>            
        </div>   

        <!-- Tabela imoveis:        
            imo_proprietario
            imo_tipoimovel
            imo_tipoconstrucao
            imo_tiposala
            imo_utilizacao
            imo_cidade
            imo_rua
            imo_numero
            imo_bairro
            imo_cep
            imo_complemento
            imo_edificio
            imo_pontoreferencia
            imo_condominio
            imo_posicao
            imo_longitude
            imo_latitude
            imo_quadra
            imo_lote
            imo_horariovisitacao
            imo_valorcondominio
            imo_obscondominio
            imo_ocupacao
            imo_dimensoes
            imo_areaterreno
            imo_areaconstruida
            imo_areaprivativa
            imo_areautil
            imo_areacomum
            imo_areagaragem
            imo_andares
            imo_unidadesandar
            imo_elevadores
            imo_anoconstrucao
            imo_confrontacao
            imo_titulopropriedade
            imo_inscricaomunicipal
            imo_cartorio
            imo_matriculacartorio
            imo_registroagua
            imo_numerohidrometro
            imo_registroenergia
            imo_tipopiso
            imo_construtora
            imo_tipoforro
            imo_tipomobilia
            imo_quartos
            imo_suites
            imo_garagem
            imo_tipovagagaragem
            imo_salajantar
            imo_salaestar
            imo_salatv
            imo_lareira
            imo_cozinha
            imo_banheiros
            imo_areadeservico
            imo_dependenciaempregada
            imo_gascentral
            imo_playground
            imo_lavabo
            imo_churrasqueira
            imo_salaofestas
            imo_sacada
            imo_portaoeletronico
            imo_pocoartesiano
            imo_condominiofechado
            imo_detalhes
            imo_fotos
            imo_principal
            imo_habitese
            imo_filial
            imo_numerodagaragem
            imo_numerododeposito
            imo_hobbybox
            imo_arealazer
            imo_topografia
            imo_viabilidade
            imo_empreendimento
            imo_permiteanimais
            imo_tipoestrutura
            imo_fornecimentoeletrico
            imo_pavimentacao
            imo_urlvideo
            imo_urltour
            imo_urldescricao
            imo_empresa 
            imo_usuario
            imo_excluido
            imo_datacad
            imo_dataatual
            imo_onibus
            imo_ondepegar
            imo_ondedescer
            imo_entreruaa
            imo_entreruab
            imo_chavedisponivel
            imo_itinerario
            imo_codigocasasoft
            imo_admcondominio
            imo_ocupadoatedata
            imo_tipoofertaportal
            imo_piscina
            imo_terraco
            imo_ordemprincipal -->
        
        <!-- Dados -->
        <div class="flex flex-col gap-5" >
            <div class="flex-1 flex-row">
                <div>
                    <!-- Confrontações -->
                    <label>Confrontações</label>
                    <textarea name="imo_confrontacao" class="form-input" rows="5" placeholder=""><?php echo $result[0]['imo_confrontacao']; ?></textarea>
                </div>
            </div>

            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Título propriedade -->
                <div>
                    <label>Título propriedade</label>
                    <input name="imo_titulopropriedade" class="form-input" type="text" value="<?php echo $result[0]['imo_titulopropriedade']; ?>" />
                </div>

                <!-- Inscrição municipal -->
                <div>
                    <label>Inscrição municipal</label>
                    <input name="imo_inscricaomunicipal" class="form-input" type="text" value="<?php echo $result[0]['imo_inscricaomunicipal']; ?>" />
                </div>

                <!-- Cartório -->
                <div>
                    <label>Cartório</label>
                    <input name="imo_cartorio" class="form-input" type="text" value="<?php echo $result[0]['imo_cartorio']; ?>" />
                </div>

                <!-- Matrícula registro imóveis -->
                <div>
                    <label>Matrícula registro imóveis</label>
                    <input name="imo_matriculacartorio" class="form-input" type="text" value="<?php echo $result[0]['imo_matriculacartorio']; ?>" />
                </div>

                <!-- Número da chave -->
                <div>
                    <label>Número da chave</label>
                    <input name="imv_numerochave" class="form-input" type="text" value="<?php echo $result[0]['imv_numerochave']; ?>" />
                </div>

                <!-- Local da chave -->
                <div>
                    <label>Local da chave</label>
                    <input name="imv_localchave" class="form-input" type="text" value="<?php echo $result[0]['imv_localchave']; ?>" />
                </div>
            </div>

            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Corretor -->
                <div>
                    <label>Corretor</label>
                    <select name="imv_corretor" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($corretor as $row){
                                $selected = $result[0]['imv_corretor'] == $row['pes_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['pes_codigo'].'" '.$selected.' >
                                    '.$row['pes_nome'].'
                                </option>';
                            }
                        ?>
                    </select>
                </div>

                <!-- Responsável -->
                <div>
                    <label>Responsável</label>
                    <input name="imv_responsavelagenciamento" class="form-input" type="text" value="<?php echo $result[0]['imv_responsavelagenciamento']; ?>" />
                </div>

                <!-- Tipo de autorização -->
                <div>
                    <label>Tipo de autorização</label>
                    <select name="imv_tipoautorizacao" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($tipoAutorizacao as $row){
                                $selected = $result[0]['imv_tipoautorizacao'] == $row['tpa_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['tpa_codigo'].'" '.$selected.' >
                                    '.$row['tpa_descricao'].'
                                </option>';
                            }
                        ?>
                    </select>
                </div>

                <!-- Data de agenciamento -->
                <div>
                    <label>Data de agenciamento</label>
                    <input name="imv_dataagenciamento" class="form-input" type="date" value="<?php echo $result[0]['imv_dataagenciamento']; ?>" />
                </div>

                <!-- Data de renovação -->
                <div>
                    <label>Data de renovação</label>
                    <input name="imv_datarenovacao" class="form-input" type="date" value="<?php echo $result[0]['imv_datarenovacao']; ?>" />
                </div>

                <!-- Validade (em dias) -->
                <div>
                    <label>Validade (em dias) (temp)</label>
                    <input disabled class="form-input" type="text" value="<?php echo $result[0]['validadeDias']; ?>" disabled />
                </div>

                <!-- Data de validade -->
                <div>
                    <label>Data de validade</label>
                    <input name="imv_datavalidade" class="form-input" type="date" value="<?php echo $result[0]['imv_datavalidade']; ?>" />
                </div>
            </div>
            
            <!-- Checkbox's -->
            <div class="flex flex-col sm:flex-row gap-7 mt-3">
                <!-- Placa -->
                <label class="inline-flex">
                    <?php $checked = $result[0]['imv_placa'] == 's' ? 'checked' : ''; ?>
                    <input name="imv_placa" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                    <span class="cursor-pointer">Placa</span>
                </label>

                <!-- Autoriza Internet -->
                <label class="inline-flex">
                    <?php $checked = $result[0]['imv_autorizainternet'] == 's' ? 'checked' : ''; ?>
                    <input name="imv_autorizainternet" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                    <span class="cursor-pointer">Autoriza Internet</span>
                </label>

                <!-- Autoriza Fotos -->
                <label class="inline-flex">
                    <?php $checked = $result[0]['imv_autorizafotos'] == 's' ? 'checked' : ''; ?>
                    <input name="imv_autorizafotos" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                    <span class="cursor-pointer">Autoriza Fotos</span>
                </label>

                <!-- Autoriza Jornal -->
                <label class="inline-flex">
                    <?php $checked = $result[0]['imv_autorizaimprensa'] == 's' ? 'checked' : ''; ?>
                    <input name="imv_autorizaimprensa" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                    <span class="cursor-pointer">Autoriza Jornal</span>
                </label>

                <!-- Exclusividade -->
                <label class="inline-flex">
                    <?php $checked = $result[0]['imv_exclusividade'] == 's' ? 'checked' : ''; ?>
                    <input name="imv_exclusividade" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                    <span class="cursor-pointer">Exclusividade</span>
                </label>
            </div>
        </div>
    </form>
</div>
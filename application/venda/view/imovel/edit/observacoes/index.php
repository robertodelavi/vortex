<?php 
    $sql = '
    SELECT 
        iv.*,
        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor
    FROM imoveis AS i 
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)        
    WHERE i.imo_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);

    // Tipo Oferta Portal
    $sql = '
    SELECT top.top_codigo, top.top_descricao
    FROM tipoofertaportal AS top
    ORDER BY top.top_descricao ASC';
    $tipoOfertaPortal = $data->find('dynamic', $sql);
?>

<!-- Tabela imovelvenda:
    imv_controle
    imv_corretor
    imv_numerochave
    imv_localchave
    imv_perfil
    imv_situacao
    imv_motivosituacao
    imv_datasituacao
    imv_reservadocorretor
    imv_inicioreserva
    imv_fimreserva
    imv_autorizainternet
    imv_autorizaimprensa
    imv_autorizafotos
    imv_exclusividade
    imv_placa
    imv_dataagenciamento
    imv_datarenovacao
    imv_datavalidade
    imv_tipoautorizacao
    imv_valoraluguel
    imv_valoriptu
    imv_valor
    imv_moeda
    imv_valorcomissao
    imv_percentualcomissao
    imv_condicaopagamento
    imv_programahabitacional
    imv_permuta
    imv_estagioobra
    imv_podefinanciar
    imv_financiado
    imv_banco
    imv_valorpoupanca
    imv_quantidadeparcelas
    imv_parcelasrestantes
    imv_valorparcela
    imv_valorsaldo
    imv_obsfinanciamento
    imv_obsformapagamento
    imv_classificacao
    imv_web
    imv_destaqueweb
    imv_anunciotexto
    imv_responsavelagenciamento -->

<form method="POST" action="?module=venda&acao=update_observacoes_imovel" >
    <div class="flex flex-col gap-3"  >
        <div class="panel">
            <input type="hidden" name="imv_codigo" value="<?php echo $_POST['param_0']; ?>" />
    
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
                <div>
                    <h5 class="text-lg font-semibold">Observações</h5>
                </div>    
                <div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>            
            </div>       
            
            <!-- Dados -->        
            <div class="flex flex-col gap-3">
                <!-- Observações da venda -->
                <div>
                    <label>Observações da venda</label>
                    <textarea name="imv_obsformapagamento" placeholder="Observações da venda" rows="6" class="form-input" ><?php echo $result[0]['imv_obsformapagamento']; ?></textarea>
                </div>

                <!-- Texto anúncio veículo de comunicação -->
                <div>
                    <label>Texto anúncio veículo de comunicação</label>
                    <textarea name="imv_anunciotexto" placeholder="Observações da venda" rows="4" class="form-input" ><?php echo $result[0]['imv_anunciotexto']; ?></textarea>                    
                </div> 
                
                <!-- Texto destaque internet -->
                <div>
                    <label>Texto destaque internet</label>
                    <textarea name="imv_destaqueweb" placeholder="Observações da venda" rows="4" class="form-input" ><?php echo $result[0]['imv_destaqueweb']; ?></textarea>
                </div>

                <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                    <!-- Apresentar este imóvel na página inicial -->
                    <label class="inline-flex cursor-pointer mt-7">
                        <?php $checked = $result[0]['imv_web'] == 's' ? 'checked' : ''; ?>
                        <input type="checkbox" name="imv_web" value="s" <?php echo $checked; ?> class="form-checkbox" />
                        <span class="ml-2">Apresentar este imóvel na página inicial</span>
                    </label>

                    <!-- Nº ordem página inicial -->
                    <div>
                        <label>Nº ordem página inicial (?)</label>
                        <input type="text" value="<?php echo $result[0]['imv_ordemweb']; ?>" class="form-input" />
                    </div>

                    <!-- URL vídeo internet -->
                    <div>
                        <label>URL Vídeo Internet (?)</label>
                        <input type="text" value="<?php echo $result[0]['imv_urlvideo']; ?>" class="form-input" />
                    </div>
                        
                    <!-- URL Tour 360º Internet (?) -->
                    <div>
                        <label>URL Tour 360º Internet (?)</label>
                        <input type="text" value="<?php echo $result[0]['imv_urltour360']; ?>" class="form-input" />
                    </div>
                    
                    <!-- Tipo de oferta no portal -->
                    <div>
                        <label>Tipo de oferta no portal (?)</label>
                        <select class="form-select text-white-dark">
                            <option selected="">-- Selecione --</option>
                            <?php 
                                foreach($tipoOfertaPortal as $row){
                                    $selected = $result[0]['imv_tipoofertaportal'] == $row['top_codigo'] ? 'selected' : '';
                                    echo '
                                    <option value="'.$row['top_codigo'].'" '.$selected.' >
                                        '.$row['top_descricao'].'
                                    </option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Descrição para mostrar na URL do site (?) -->
                    <div>
                        <label>Descrição para mostrar na URL do site (?)</label>
                        <input type="text" value="<?php echo $result[0]['imv_descricaourl']; ?>" class="form-input" />
                    </div>
                </div>
            </div>        
        </div>
    </div>    
</form>
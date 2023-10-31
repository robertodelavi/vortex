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

    // Moeda
    $sql = '
    SELECT 
        m.moe_codigo,
        m.moe_descricao,
        m.moe_simbolo,
        m.moe_valor,
        m.moe_web,
        m.moe_referencia
    FROM moedas AS m    
    ORDER BY m.moe_descricao ASC';
    $moeda = $data->find('dynamic', $sql);

    // Programa habitacional
    $sql = '
    SELECT iph.iph_codigo, iph.iph_descricao
    FROM imovelplanohabitacao AS iph
    ORDER BY iph.iph_descricao ASC';
    $programaHabitacional = $data->find('dynamic', $sql);

    // Permuta
    $sql = '
    SELECT ip.ipe_codigo, ip.ipe_descricao
    FROM imovelpermuta AS ip
    ORDER BY ip.ipe_descricao ASC';
    $permuta = $data->find('dynamic', $sql);

    // Estágio da obra
    $sql = '
    SELECT eo.eso_codigo, eo.eso_descricao
    FROM estagioobra AS eo
    ORDER BY eo.eso_descricao ASC';
    $estagioObra = $data->find('dynamic', $sql);    

    // Bancos
    $sql = '
    SELECT b.ban_codigo, b.ban_numero, b.ban_descricao
    FROM bancos AS b
    ORDER BY b.ban_descricao ASC';
    $bancos = $data->find('dynamic', $sql);
?>

<form method="POST" action="?module=venda&acao=update_valores_imovel" >
    <div class="flex flex-col gap-3"  >
        <div class="panel">
            <input type="hidden" name="imv_codigo" value="<?php echo $_POST['param_0']; ?>" />
    
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
                <div>
                    <h5 class="text-lg font-semibold">Valores</h5>
                </div>    
                <div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>            
            </div>       
            
            <!-- Dados -->        
            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Valor -->
                <div>
                    <label>Valor</label>
                    <input name="imv_valor" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valor']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Moeda -->
                <div>
                    <label>Moeda</label>
                    <select name="imv_moeda" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($moeda as $row){
                                $selected = $result[0]['imv_moeda'] == $row['moe_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['moe_codigo'].'" '.$selected.' >
                                    '.$row['moe_descricao'].' ('.$row['moe_simbolo'].' '.number_format($row['moe_valor'], 2, ',', '.').')
                                </option>';
                            }
                        ?>
                    </select>
                </div>
    
                <!-- Valor resultante da multiplicação valor * moeda -->
                <div>
                    <label>Valor (temp)</label>
                    <input class="form-input" type="text" value="<?php echo (floatval($result[0]['imv_valor']) * floatval($result[0]['moe_valor'])); ?>" disabled />
                </div>
    
                <!-- Honorário (%) -->
                <div>
                    <label>Honorário (%)</label>
                    <input name="imv_percentualcomissao" type="text" class="form-input" value="<?php echo $result[0]['imv_percentualcomissao']; ?>" />
                </div>
    
                <!-- Valor do honorário -->
                <div>
                    <label>Valor do Honorário</label>
                    <input name="imv_valorcomissao" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valorcomissao']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Condição de Pagamento -->
                <div>
                    <label>Condição de Pagamento</label>
                    <input type="text" class="form-input" value="<?php echo $result[0]['imv_condicaopagamento']; ?>" />
                </div>
    
                <!-- Programa Habitacional -->
                <div>
                    <label>Programa Habitacional</label>
                    <select name="imv_programahabitacional" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($programaHabitacional as $row){
                                $selected = $result[0]['imv_programahabitacional'] == $row['iph_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['iph_codigo'].'" '.$selected.' >
                                    '.$row['iph_descricao'].'
                                </option>';
                            }
                        ?>
                    </select>
                </div>
    
                <!-- Permuta -->
                <div>
                    <label>Permuta</label>
                    <select name="imv_permuta" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($permuta as $row){
                                $selected = $result[0]['imv_permuta'] == $row['ipe_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['ipe_codigo'].'" '.$selected.' >
                                    '.$row['ipe_descricao'].'
                                </option>';
                            }
                        ?>
                    </select>
                </div>
    
                <!-- Estágio da obra -->
                <div>
                    <label>Estágio da obra</label>
                    <select name="imv_estagioobra" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($estagioObra as $row){
                                $selected = $result[0]['imv_estagioobra'] == $row['eso_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['eso_codigo'].'" '.$selected.' >
                                    '.$row['eso_descricao'].'
                                </option>';
                            }
                        ?>
                    </select>
                </div>
    
                <div class="flex items-center mt-7 gap-5" >
                    <!-- Pode ser financiado -->
                    <label class="inline-flex">
                        <?php $checked = $result[0]['imv_podefinanciar'] == 's' ? 'checked' : ''; ?>
                        <input name="imv_podefinanciar" type="checkbox" class="form-checkbox" value="s" <?php echo $checked; ?> />
                        <span class="cursor-pointer">Pode ser financiado</span>
                    </label>
    
                    <!-- Financiamento -->
                    <label class="inline-flex">
                        <?php $checked = $result[0]['imv_financiado'] == 's' ? 'checked' : ''; ?>
                        <input name="imv_financiado" type="checkbox" @click="setFinanciamento" class="form-checkbox" value="s" <?php echo $checked; ?> />
                        <span class="cursor-pointer">Financiamento</span>
                    </label>
                </div>  
            </div>        
        </div>
    
        <div class="panel">                
            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Banco -->
                <div>
                    <label>Banco</label>
                    <select :disabled="!editFinanciamento" name="imv_banco" class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <?php 
                            foreach($bancos as $row){
                                $selected = $result[0]['imv_banco'] == $row['ban_codigo'] ? 'selected' : '';
                                echo '
                                <option value="'.$row['ban_codigo'].'" '.$selected.' >
                                '.$row['ban_descricao'].' ('.$row['ban_numero'].')
                                </option>';
                            }
                        ?>
                    </select>
                </div>
                
                <!-- Valor Poupança -->
                <div>
                    <label>Valor Poupança</label>
                    <input :disabled="!editFinanciamento" name="imv_valorpoupanca" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valorpoupanca']); ?>" onkeyup="formatCurrency(this)" />                    
                </div>
    
                <!-- Quantidade de Parcelas -->
                <div>
                    <label>Quantidade de Parcelas</label>
                    <input :disabled="!editFinanciamento" name="imv_quantidadeparcelas" type="text" class="form-input" value="<?php echo $result[0]['imv_quantidadeparcelas']; ?>" />
                </div>
    
                <!-- Parcelas Restantes -->
                <div>
                    <label>Parcelas Restantes</label>
                    <input :disabled="!editFinanciamento" name="imv_parcelasrestantes" type="text" class="form-input" value="<?php echo $result[0]['imv_parcelasrestantes']; ?>" />
                </div>
    
                <!-- Valor Parcela -->
                <div>
                    <label>Valor Parcela</label>
                    <input :disabled="!editFinanciamento" name="imv_valorparcela" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valorparcela']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Valor Saldo -->
                <div>
                    <label>Saldo</label>
                    <input :disabled="!editFinanciamento" name="imv_valorsaldo" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valorsaldo']); ?>" onkeyup="formatCurrency(this)" />
                </div>
            </div>
                
            <!-- Observações -->
            <div class="mt-4">
                <label>Observações</label>
                <textarea :disabled="!editFinanciamento" name="imv_obsfinanciamento" placeholder="Observações do financiamento" class="form-input" ><?php echo $result[0]['imv_obsfinanciamento']; ?></textarea>
            </div>        
        </div>
    
        <div class="panel">                        
            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Valor Aluguel -->
                <div>
                    <label>Valor Aluguel</label>
                    <input name="imv_valoraluguel" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valoraluguel']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Valor condomínio -->
                <div>
                    <label>Valor condomínio (?)</label>
                    <input type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valorcondominio']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Próprio (select com sim ou não) -->
                <div>
                    <label>Próprio (?)</label>
                    <select class="form-select text-white-dark">
                        <option selected="">-- Selecione --</option>
                        <option value="s">Sim</option>
                        <option value="n">Não</option>
                    </select>
                </div>
    
                <!-- Valor IPTU -->
                <div>
                    <label>Valor IPTU</label>
                    <input name="imv_valoriptu" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['imv_valoriptu']); ?>" onkeyup="formatCurrency(this)" />
                </div>
    
                <!-- Valor m² terreno (visualização) -->
                <div>
                    <label>Valor m² Terreno (temp)</label>
                    <p>R$ 300,00</p>
                </div>
                
                <!-- Valor m² Construção (visualização) -->
                <div>
                    <label>Valor m² Construção (temp)</label>
                    <p>R$ 300,00</p>
                </div>
                
                <!-- Valor m² Privativa (visualização) -->
                <div>
                    <label>Valor m² Privativa (temp)</label>
                    <p>R$ 300,00</p>
                </div>
            </div>            
        </div>
    </div>    
</form>
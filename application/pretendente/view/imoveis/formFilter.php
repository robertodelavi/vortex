<?php 
    $sql = '
    SELECT * 
    FROM tipoimovel AS ti
    ORDER BY ti.tpi_descricao ASC';
    $tipoImovel = $data->find('dynamic', $sql);
?>

<div class="flex-1" >
    <form x-on:submit="submitForm($event)" id="formFilter" class="space-y-4">
        <div>
            <label for="name">Código</label>
            <input name="codigo" type="text" placeholder="Código" class="form-input" />
        </div>
        <!-- Faixa de valor (R$) -->
        <div class="flex flex-col justify-between gap-4">
            <div>
                <label class="text-success">Valor inicial (R$)</label>
                <input name="valorIni" type="text" maxlength="16" onkeyup="formatCurrency(this)" placeholder="R$ 0,00" class="form-input" />
            </div>
            <div>
                <label class="text-success">Valor final (R$)</label>
                <input name="valorFin" type="text" maxlength="16" onkeyup="formatCurrency(this)" placeholder="R$ 0,00" class="form-input" />
            </div>            
        </div>
        <div>
            <label>Bairro</label>
            <input name="bairro" type="text" class="form-input" />
        </div>
        <div>
            <label>Dormitórios</label>
            <div class="flex items-center justify-between gap-2">
                <div>
                    <input type="text" name="dormitoriosIni" class="form-input" />
                </div>
                <p>até</p>
                <div>
                    <input type="text" name="dormitoriosFin" class="form-input" />
                </div>                
            </div>
        </div>
        <div>
            <label>Suítes</label>
            <div id="slider"></div>
            <div class="flex items-center justify-between gap-2">
                <div>
                    <input type="text" name="suitesIni" class="form-input" />
                </div>
                <p>até</p>
                <div>
                    <input type="text" name="suitesFin" class="form-input" />
                </div>                
            </div>
        </div>
        <div>
            <label for="name">Vagas de garagem</label>
            <input name="garagem" type="text" class="form-input" />
        </div>
        <div>
            <label>Tipo de imóvel</label>
            <select name="tipoImovel" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($tipoImovel as $key => $value) { ?>
                    <option value="<?php echo $value['tpi_codigo'] ?>"><?php echo $value['tpi_descricao']; ?></option>
                <?php } ?>
            </select>
        </div>                
        <!-- Botões de ação -->
        <div class="flex gap-2 pt-4">
            <div class="">
                <button type="submit" class="btn btn-primary">Aplicar</button>
            </div>
            <div class="">
                <button type="button" class="btn btn-secondary" x-on:click="limpaFiltros()">Limpar</button>
            </div>
        </div>
    </form>
</div>
<?php 
    $sql = '
    SELECT *
    FROM tipoimovel';
    $tipoImovel = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM sisusuarios
    WHERE usu_ativado = "s"
    ORDER BY usu_nome ASC';
    $usuarios = $data->find('dynamic', $sql);
?>

<div class="flex-1 ">
    <form x-on:submit="submitForm($event)" id="formFilter" class="space-y-4">
        <div>
            <label>Nome do Pretendente</label>
            <input name="nome" type="text" placeholder="Júlio César" class="form-input" />
        </div>        
        <div>
            <label for="address">Período do atendimento</label>
            <div class="flex gap-2">
                <input type="date" name="periodoIni" class="form-input" />
                <input type="date" name="periodoFim" class="form-input" />
            </div>
        </div>
        <div>
            <label>Tipo de Imóvel</label>
            <select name="tipoimovel" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($tipoImovel as $key => $value) { ?>
                    <option value="<?php echo $value['tpi_codigo'] ?>"><?php echo $value['tpi_descricao']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label>Bairro</label>
            <input name="bairro" type="text" placeholder="Centro" class="form-input" />
        </div>
        <div>
            <label>Cidade</label>
            <input name="cidade" type="text" placeholder="Chapecó" class="form-input" />            
        </div>
        <div>
            <label>Palavra chave (observação)</label>
            <input name="obs" type="text" placeholder="" class="form-input" />
        </div>
        <div>
            <label>Entregue por</label>
            <select name="entreguePor" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($usuarios as $key => $value) { ?>
                    <option value="<?php echo $value['usu_codigo'] ?>"><?php echo $value['usu_nome']; ?></option>
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
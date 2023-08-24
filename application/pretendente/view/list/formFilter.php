<?php 
    $sql = '
    SELECT * 
    FROM situacaovenda';
    $situacaoVenda = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM pretendentesstatusnegocio';
    $statusNegocio = $data->find('dynamic', $sql);

    $sql = '
    SELECT * 
    FROM pretendentesstatusatendimento
    ORDER BY psa_ordem ASC';
    $statusAtendimento = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM pretendentesperfilcliente';
    $perfilCliente = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM pretendentesobjetivo';
    $objetivo = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM pretendentesorigem';
    $origem = $data->find('dynamic', $sql);

    $sql = '
    SELECT *
    FROM sisusuarios
    WHERE usu_ativado = "s"
    ORDER BY usu_nome ASC';
    $usuarios = $data->find('dynamic', $sql);

    $solicitacao = array(
        array('codigo' => 'indiferente', 'descricao' => 'Indiferente'),
        array('codigo' => 'empresa', 'descricao' => 'Empresa'),
        array('codigo' => 'web', 'descricao' => 'Web')
    );
?>

<div class="flex-1 ">
    <form x-on:submit="submitForm($event)" id="formFilter" class="space-y-4">
        <div>
            <label>Nome</label>
            <input name="nome" type="text" placeholder="Ed. Fiorentin" class="form-input" />
        </div>
        <div>
            <label>E-mail</label>
            <input type="text" name="email" placeholder="" class="form-input" />
        </div>
        <div>
            <label>Telefones</label>
            <input name="telefones" type="text" placeholder="" class="form-input" />
        </div>
        <div>
            <label>Atendimentos</label>
            <select name="atendimentos" class="form-select text-white-dark">
                <option value="todos">Todos</option>
                <option value="meus" >Somente meus</option>
            </select>
        </div>
        <div>
            <label>Situação</label>
            <select name="situacao" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($situacaoVenda as $key => $value) { ?>
                    <option value="<?php echo $value['stv_codigo'] ?>"><?php echo $value['stv_descricao']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label>Status do negócio</label>
            <select name="prw_psn_codigo" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($statusNegocio as $key => $value) { ?>
                    <option value="<?php echo $value['psn_codigo'] ?>"><?php echo $value['psn_descricao']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label for="address">Período do atendimento</label>
            <div class="flex gap-2">
                <input type="date" name="periodoIni" class="form-input" />
                <input type="date" name="periodoFim" class="form-input" />
            </div>
        </div>
        <div>
            <label>Perfil do cliente</label>
            <select name="prw_perfilcliente" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($perfilCliente as $key => $value) { ?>
                    <option value="<?php echo $value['ppc_codigo'] ?>"><?php echo $value['ppc_descricao']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label>Palavra chave (observação)</label>
            <input name="prw_obs" type="text" placeholder="" class="form-input" />
        </div>
        <div>
            <label>Status do atendimento</label>
            <select name="prw_psa_codigo" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($statusAtendimento as $key => $value) { ?>
                    <option value="<?php echo $value['psa_codigo'] ?>"><?php echo $value['psa_descricao']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label>Objetivo do atendimento</label>
            <select name="prw_objetivo" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($objetivo as $key => $value) { ?>
                    <option value="<?php echo $value['pob_codigo'] ?>"><?php echo $value['pob_descricao']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label>Origem do atendimento</label>
            <select name="prw_origem" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($origem as $key => $value) { ?>
                    <option value="<?php echo $value['por_codigo'] ?>"><?php echo $value['por_descricao']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label>Sem atendimento a mais de</label>
            <div class="flex gap-2 items-center">
                <input name="diasSemAtendimento" type="number" placeholder="30" class="form-input" />
                <p>dias</p>
            </div>
        </div>
        <div>
            <label>Corretor/Usuário</label>
            <select name="prw_usuario" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($usuarios as $key => $value) { ?>
                    <option value="<?php echo $value['usu_codigo'] ?>"><?php echo $value['usu_nome']; ?></option>
                <?php } ?>                
            </select>
        </div>
        <div>
            <label>Solicitado via</label>
            <select name="solicitacao" class="form-select text-white-dark">
                <option value="">-- Todos --</option>
                <?php foreach ($solicitacao as $key => $value) { ?>
                    <option value="<?php echo $value['codigo'] ?>"><?php echo $value['descricao']; ?></option>
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
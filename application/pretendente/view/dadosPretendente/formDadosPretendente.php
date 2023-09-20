<?php 
    $result = [];
    if(isset($_POST['param_0']) && $_POST['param_0'] > 0){
        $sql = '
        SELECT * 
        FROM pretendentes AS p 
            LEFT JOIN cidades AS c ON (p.prw_cidadeorigem = c.cid_codigo)
        WHERE p.prw_codigo = '.$_POST['param_0'];
        $result = $data->find('dynamic', $sql);

        // Buscar as cidades iniciais, antes do carregamento via ajax
        $sql = '
        SELECT * 
        FROM cidades
        WHERE cid_uf = "'.$result[0]['cid_uf'].'" AND cid_uf <> "" AND cid_descricao <> ""  
        GROUP BY cid_descricao
        ORDER BY cid_descricao ASC';
        $cidadesIniciais = $data->find('dynamic', $sql);
    }

    $sexo = array(
        'm' => 'Masculino',
        'f' => 'Feminino'
    );

    $sql = '
    SELECT * 
    FROM cidades
    WHERE cid_uf <> ""    
    GROUP BY cid_uf
    ORDER BY cid_uf ASC';
    $estados = $data->find('dynamic', $sql);    

    $sql = '
    SELECT * 
    FROM pretendentesstatusatendimento
    ORDER BY psa_ordem ASC';
    $statusAtendimento = $data->find('dynamic', $sql);

    $sql = '
    SELECT * 
    FROM pretendentescontato
    ORDER BY pco_descricao ASC';
    $formaContato = $data->find('dynamic', $sql);

    $sql = '
    SELECT * 
    FROM sisusuarios
    WHERE usu_ativado = "s"
    ORDER BY usu_nome ASC';
    $profissionais = $data->find('dynamic', $sql);

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
    FROM pretendentesorigem
    ORDER BY por_descricao ASC';
    $origem = $data->find('dynamic', $sql);
    
    $sql = '
    SELECT * 
    FROM tipoimovel
    ORDER BY tpi_descricao ASC';
    $tipoImovel = $data->find('dynamic', $sql);
    
    $sql = '
    SELECT * 
    FROM empreendimentos
    ORDER BY epr_descricao ASC';
    $empreendimento = $data->find('dynamic', $sql);
    
    $sql = '
    SELECT * 
    FROM pretendentesstatusnegocio';
    $statusNegocio = $data->find('dynamic', $sql);
?>

<div class="flex flex-col sm:flex-row" >
    <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
        <div>
            <label for="name">Nome do Pretendente</label>
            <input name="prw_nome" type="text" placeholder="João da Silva" class="form-input" value="<?php echo $result[0]['prw_nome']; ?>" />
        </div>

        <div>
            <label for="country">Status Atendimento</label>
            <select name="prw_psa_codigo" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($statusAtendimento as $row){
                        $selected = $result[0]['prw_psa_codigo'] == $row['psa_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['psa_codigo'].'" '.$selected.' >
                            '.$row['psa_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>

        <div>
            <label for="country">Sexo</label>
            <select name="prw_sexo" class="form-select text-white-dark">
                <option>-- Selecione --</option>
                <?php 
                    foreach($sexo as $key => $row){
                        $selected = $result[0]['prw_sexo'] == $key ? 'selected' : '';
                        echo '
                        <option value="'.$key.'" '.$selected.' >
                            '.$row.'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="email">Ano de Nascimento</label>
            <input name="prw_anonascimento" type="number" class="form-input" value="<?php echo $result[0]['prw_anonascimento']; ?>" />
        </div>
        <div>
            <label for="country">Forma de Contato</label>
            <select name="prw_contato" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($formaContato as $row){
                        $selected = $result[0]['prw_contato'] == $row['pco_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['pco_codigo'].'" '.$selected.' >
                            '.$row['pco_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="address">Telefones</label>
            <input name="prw_telefones" type="text" placeholder="(49) 99999-9999" class="form-input" value="<?php echo $result[0]['prw_telefones']; ?>" />
        </div>
        <div>
            <label for="email">E-mail</label>
            <input name="prw_email" type="email" placeholder="fulano@email.com" class="form-input" value="<?php echo $result[0]['prw_email']; ?>" />
        </div>
        <div>
            <label for="country">Atendido por</label>
            <select name="prw_usuario" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($profissionais as $row){
                        $selected = $result[0]['prw_usuario'] == $row['usu_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['usu_codigo'].'" '.$selected.' >
                            '.$row['usu_nome'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="phone">Estado</label>
            <select class="form-select text-white-dark" onchange="selectUf(this.value)" >
                <option value="">-- Selecione --</option>
                <?php 
                    foreach($estados as $row){
                        $selected = $result[0]['cid_uf'] == $row['cid_uf'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['cid_uf'].'" '.$selected.' >
                            '.$row['cid_uf'].'
                        </option>';
                    }
                ?>
            </select>            
        </div>
        <div>
            <!-- Vindo via ajax -->
            <label for="phone">Cidade</label>
            <select id="resulAjaxCidades" name="prw_cidadeorigem" class="form-select text-white-dark">
                <option value="">-- Selecione o Estado --</option>
                <?php 
                    foreach($cidadesIniciais as $row){
                        $selected = $result[0]['prw_cidadeorigem'] == $row['cid_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['cid_codigo'].'" '.$selected.' >
                            '.$row['cid_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        
        <div>
            <label for="country">Perfil do Cliente</label>
            <select name="prw_perfilcliente" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($perfilCliente as $row){
                        $selected = $result[0]['prw_perfilcliente'] == $row['ppc_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['ppc_codigo'].'" '.$selected.' >
                            '.$row['ppc_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="country">Objetivo do Atendimento</label>
            <select name="prw_objetivo" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($objetivo as $row){
                        $selected = $result[0]['prw_objetivo'] == $row['pob_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['pob_codigo'].'" '.$selected.' >
                            '.$row['pob_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="country">Origem do Atendimento</label>
            <select name="prw_origem" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($origem as $row){
                        $selected = $result[0]['prw_origem'] == $row['por_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['por_codigo'].'" '.$selected.' >
                            '.$row['por_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="country">Tipo Imóvel Principal</label>
            <select name="prw_tipoimovelprincipal" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($tipoImovel as $row){
                        $selected = $result[0]['prw_tipoimovelprincipal'] == $row['tpi_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['tpi_codigo'].'" '.$selected.' >
                            '.$row['tpi_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="country">Empreendimento</label>
            <select name="prw_empreendimento" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($empreendimento as $row){
                        $selected = $result[0]['prw_empreendimento'] == $row['epr_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['epr_codigo'].'" '.$selected.' >
                            '.$row['epr_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="country">Status do Negócio</label>
            <select name="prw_psn_codigo" class="form-select text-white-dark">
                <option selected="">-- Selecione --</option>
                <?php 
                    foreach($statusNegocio as $row){
                        $selected = $result[0]['prw_psn_codigo'] == $row['psn_codigo'] ? 'selected' : '';
                        echo '
                        <option value="'.$row['psn_codigo'].'" '.$selected.' >
                            '.$row['psn_descricao'].'
                        </option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="phone" class="text-success" >Valor de Prospecção</label>
            <input name="prw_valorprospeccao" type="text" class="form-input" placeholder="R$ 0,00" value="<?php echo floatToMoney($result[0]['prw_valorprospeccao']); ?>" onkeyup="formatCurrency(this)" />
        </div>                
        <div class="flex items-center">
            <label class="cursor-pointer mt-6">
                <input type="checkbox" class="form-checkbox" />
                <span class="text-white-dark relative checked:bg-none">Atendimento Plantão</span>
            </label>
        </div>
    </div>
</div>

<div class="flex-1 mt-5">
    <div>
        <label for="web">Observações</label>
        <textarea name="prw_obs" class="form-input w-full" cols="4"><?php echo utf8_encode($result[0]['prw_obs']); ?></textarea>
    </div>
</div>  
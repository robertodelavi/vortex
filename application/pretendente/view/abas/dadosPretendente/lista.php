<?php 
    $sql = '
    SELECT * 
    FROM pretendentes AS p 
    WHERE p.prw_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);

    $sexo = array(
        'm' => 'Masculino',
        'f' => 'Feminino'
    );

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

<div>
    <form method="POST" action="?module=pretendente&acao=updatedados_pretendente" class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="text-lg font-semibold">Dados Gerais</h5>
            </div>    
            <div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>            
        </div>   
        
        <input type="hidden" name="prw_codigo" value="<?php echo $_POST['param_0']; ?>" />
        
        <div class="flex flex-col sm:flex-row">
            <div class="flex-1 grid md:grid-cols-4 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name">Nome do Pretendente</label>
                    <input name="prw_nome" type="text" placeholder="João da Silva" class="form-input" value="<?php echo $result[0]['prw_nome']; ?>" />
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
                    <label for="phone">Cidade</label>
                    <input name="prw_cidadeorigem" type="text" class="form-input" value="<?php echo $result[0]['prw_cidadeorigem']; ?>" />
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
                    <label for="phone">Valor de Prospecção</label>
                    <input name="prw_valorprospeccao" type="text" class="form-input" value="<?php echo $result[0]['prw_valorprospeccao']; ?>" />
                </div>
                <div>
                    <label for="web">Website</label>
                    <input id="web" type="text" placeholder="Enter URL" class="form-input" />
                </div>

                <div class="sm:col-span-3 md:col-span-4" >
                    <label for="web">Observações</label>
                    <textarea name="prw_obs" class="form-input"><?php echo $result[0]['prw_obs']; ?></textarea>
                </div>

                <!-- <div>
                    <div>
                        <label class="inline-flex cursor-pointer">
                            <input type="checkbox" class="form-checkbox" />
                            <span class="text-white-dark relative checked:bg-none">Make this my default
                                address</span>
                        </label>
                    </div>
                    <div class="sm:col-span-2 mt-3">
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </div> -->
            </div>
        </div>
    </form>
    <form class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 bg-white dark:bg-[#0e1726]">
        <h6 class="text-lg font-bold mb-5">Social</h6>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                        </path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path
                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                        </path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
            <div class="flex">
                <div
                    class="bg-[#eee] flex justify-center items-center rounded px-3 font-semibold dark:bg-[#1b2e4b] ltr:mr-2 rtl:ml-2">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
                        <path
                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                        </path>
                    </svg>
                </div>
                <input type="text" placeholder="jimmy_turner" class="form-input" />
            </div>
        </div>
    </form>
</div>
<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['action']) && isset($value['ppf_pretendente'])) {

        // Somente na edição
        if (isset($value['ppf_pretendente']) && isset($value['ppf_codigo'])) {
            // Dados do perfil
            $sql = "
            SELECT * 
            FROM pretendentesperfil AS pp
                LEFT JOIN tipoimovel AS ti ON (ti.tpi_codigo = pp.ppf_tipoimovel)
            WHERE pp.ppf_pretendente = " . $value['ppf_pretendente'] . " AND pp.ppf_codigo = ".$value['ppf_codigo'];
            $result = $data->find('dynamic', $sql);
        }

        // Tipo de imóvel
        $sql = '
        SELECT * 
        FROM tipoimovel AS ti
        ORDER BY ti.tpi_descricao ASC';
        $tipoImovel = $data->find('dynamic', $sql);

        // Utilização
        $sql = '
        SELECT *
        FROM utilizacao AS u
        ORDER BY u.uti_descricao ASC';
        $utilizacao = $data->find('dynamic', $sql);

        // Empreendimento 
        $sql = '
        SELECT *
        FROM empreendimentos AS e
        ORDER BY e.epr_descricao ASC';
        $empreendimento = $data->find('dynamic', $sql);

        // Permuta 
        $sql = '
        SELECT *
        FROM imovelpermuta AS p
        ORDER BY p.ipe_descricao ASC';
        $permuta = $data->find('dynamic', $sql);

        // Monta resposta
        $html = '
        <form method="POST" action="'.$value['action'].'" id="MyForm" name="MyForm" >
            <input type="hidden" name="ppf_pretendente" value="'.$value['ppf_pretendente'].'" />';
            // Somente na edição envia ppf_codigo
            if (isset($value['ppf_codigo'])) { $html .= '<input type="hidden" name="ppf_codigo" value="'.$value['ppf_codigo'].'" />'; }
            
            $html .= '
            <!-- Mensagem -->
            <div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
                <span class="ltr:pr-2 rtl:pl-2">Aqui, você tem a opção de configurar e nomear perfis de busca
                    que se adequem aos requisitos do pretendente. Esses perfis serão salvos para o pretendente e
                    é possível criar um ou mais perfis. O sistema irá então classificar os imóveis de acordo com
                    os perfis criados, para melhor atender às preferências do pretendente.</span>
            </div>

            <!-- Dados retornados do ajax -->
            <div class="mt-5" >
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Nome do Perfil -->
                        <div>
                            <label for="nome">Nome do Perfil</label>
                            <input name="ppf_nome" id="nome" type="text" value="'.$result[0]['ppf_nome'].'" placeholder="Apto 2 quartos, 1 vaga, 60m²"
                                class="form-input" />
                        </div>

                        <!-- Tipo de Imóvel -->
                        <div>
                            <label for="tipoImovel">Tipo de Imóvel</label>
                            <select name="ppf_tipoimovel" id="tipoImovel" class="form-select">
                                <option>-- Selecione --</option>';
                                foreach ($tipoImovel as $key => $value) {
                                    $selected = ($result[0]['ppf_tipoimovel'] == $value['tpi_codigo']) ? 'selected' : '';
                                    $html .= '<option value="' . $value['tpi_codigo'] . '" '.$selected.' >' . $value['tpi_descricao'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>

                        <!-- Utilização -->
                        <div>
                            <label for="utilizacao">Utilização</label>
                            <select name="ppf_utilizacao" id="utilizacao" class="form-select">
                                <option>-- Selecione --</option>';
                                foreach ($utilizacao as $key => $value) {
                                    $selected = ($result[0]['ppf_utilizacao'] == $value['uti_codigo']) ? 'selected' : '';
                                    $html .= '<option value="' . $value['uti_codigo'] . '" '.$selected.' >' . $value['uti_descricao'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>

                        <!-- Empreendimento -->
                        <div>
                            <label for="empreendimento">Empreendimento</label>
                            <select name="ppf_empreendimento" id="empreendimento" class="form-select">
                                <option>-- Selecione --</option>';
                                foreach ($empreendimento as $key => $value) {
                                    $selected = ($result[0]['ppf_empreendimento'] == $value['epr_codigo']) ? 'selected' : '';
                                    $html .= '<option value="' . $value['epr_codigo'] . '" '.$selected.' >' . $value['epr_descricao'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>

                        <!-- Dormitórios -->
                        <div>
                            <label for="dormitorios">Dormitórios</label>
                            <div class="flex w-full">
                                <div class="flex items-center w-full">
                                    <div class="w-full">
                                        <input name="ppf_quartosini" id="quartosIni" type="text" value="'.$result[0]['ppf_quartosini'].'" placeholder="0" class="form-input" />
                                    </div>
                                    <div class="px-3">até</div>
                                    <div class="w-full">
                                        <input name="ppf_quartosfim" id="quartosFim" type="text" value="'.$result[0]['ppf_quartosfim'].'" placeholder="0" class="form-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sendo Suítes -->
                        <div>
                            <label for="suites">Sendo Suítes</label>
                            <div class="flex w-full">
                                <div class="flex items-center w-full">
                                    <div class="w-full">
                                        <input name="ppf_suitesini" id="suitesIni" type="text" value="'.$result[0]['ppf_suitesini'].'" placeholder="0" class="form-input" />
                                    </div>
                                    <div class="px-3">até</div>
                                    <div class="w-full">
                                        <input name="ppf_suitesfim" id="suitesFim" type="text" value="'.$result[0]['ppf_suitesfim'].'" placeholder="0" class="form-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Garagem -->
                        <div>
                            <label for="garagem">Garagem</label>
                            <input name="ppf_garagem" id="garagem" type="text" value="'.$result[0]['ppf_garagem'].'" placeholder="0" class="form-input" />
                        </div>

                        <!-- Faixa de valor -->
                        <div>
                            <label for="faixaValor">Faixa de Valor</label>
                            <div class="flex w-full">
                                <div class="flex items-center w-full">
                                    <div class="w-full">
                                        <input name="ppf_valorini" id="valorIni" type="text" value="'.floatToMoney($result[0]['ppf_valorini']).'" onkeyup="formatCurrency(this)"
                                            placeholder="R$ 0,00" class="form-input" />
                                    </div>
                                    <div class="px-3">até</div>
                                    <div class="w-full">
                                        <input name="ppf_valorfim" id="valorFim" type="text" value="'.floatToMoney($result[0]['ppf_valorfim']).'" onkeyup="formatCurrency(this)"
                                            placeholder="R$ 0,00" class="form-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Área Terreno m² -->
                        <div>
                            <label for="areaTerreno">Área Terreno (m²)</label>
                            <div class="flex w-full">
                                <div class="flex items-center w-full">
                                    <div class="w-full">
                                        <input name="ppf_areaterrenoini" id="areaTerrenoIni" type="text" value="'.$result[0]['ppf_areaterrenoini'].'" placeholder="0,00" class="form-input" />
                                    </div>
                                    <div class="px-3">até</div>
                                    <div class="w-full">
                                        <input name="ppf_areaterrenofim" id="areaTerrenoFim" type="text" value="'.$result[0]['ppf_areaterrenofim'].'" placeholder="0,00" class="form-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Área Construída m² -->
                        <div>
                            <label for="faixaValor">Área Construída (m²)</label>
                            <div class="flex w-full">
                                <div class="flex items-center w-full">
                                    <div class="w-full">
                                        <input name="ppf_areaconstruidaini" id="areaConstruidaIni" type="text" value="'.$result[0]['ppf_areaconstruidaini'].'" placeholder="0,00" class="form-input" />
                                    </div>
                                    <div class="px-3">até</div>
                                    <div class="w-full">
                                        <input name="ppf_areaconstruidafim" id="areaConstruidaFim" type="text" value="'.$result[0]['ppf_areaconstruidafim'].'" placeholder="0,00" class="form-input" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cidade -->
                        <div>
                            <label for="cidade">Cidade</label>
                            <input name="ppf_cidade" id="cidade" type="text" value="'.$result[0]['ppf_cidade'].'" placeholder="Chapecó"
                                class="form-input" />
                        </div>

                        <!-- Ponto de Referência -->
                        <div>
                            <label for="pontoReferencia">Ponto de Referência</label>
                            <input name="ppf_pontoreferencia" id="pontoReferencia" type="text" value="'.$result[0]['ppf_pontoreferencia'].'"
                                placeholder="Ponto de Referência..." class="form-input" />
                        </div>

                        <!-- Edifício -->
                        <div>
                            <label for="edificio">Edifício</label>
                            <input name="ppf_edificio" id="edificio" type="text" value="'.$result[0]['ppf_edificio'].'" placeholder="Edifício..."
                                class="form-input" />
                        </div>

                        <!-- Rua -->
                        <div>
                            <label for="rua">Rua</label>
                            <input name="ppf_rua" id="rua" type="text" value="'.$result[0]['ppf_rua'].'" placeholder="Rua..."
                                class="form-input" />
                        </div>

                        <!-- Bairro -->
                        <div>
                            <label for="bairro">Bairro</label>
                            <input name="ppf_bairro" id="bairro" type="text" value="'.$result[0]['ppf_bairro'].'" placeholder="Bairro..."
                                class="form-input" />
                        </div>

                        <!-- Permuta -->
                        <div>
                            <label for="permuta">Permuta</label>
                            <select name="ppf_permuta" id="permuta" class="form-select">
                                <option>-- Selecione --</option>';
                                foreach ($permuta as $key => $value) {
                                    $selected = ($result[0]['ppf_permuta'] == $value['ipe_codigo']) ? 'selected' : '';
                                    $html .= '<option value="' . $value['ipe_codigo'] . '" '.$selected.' >' . $value['ipe_descricao'] . '</option>';
                                }
                            $html .= '
                            </select>                             
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="flex justify-end items-center mt-8">
                <button type="button" class="btn btn-outline-dark" @click="toggle">Cancelar</button>
                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Salvar</button>
            </div>
        </form>';

        // Retorna resposta
        echo json_encode($html);
        exit;
    }
}
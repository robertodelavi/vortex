<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['ppf_pretendente']) && isset($value['ppf_codigo'])) {
        // Dados do perfil
        $sql = "
        SELECT * 
        FROM pretendentesperfil AS pp
            LEFT JOIN tipoimovel AS ti ON (ti.tpi_codigo = pp.ppf_tipoimovel)
        WHERE pp.ppf_pretendente = " . $value['ppf_pretendente']." AND pp.ppf_codigo = ".$value['ppf_codigo'];
        $result = $data->find('dynamic', $sql);

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
        <!-- Mensagem -->
        <div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
            <span class="ltr:pr-2 rtl:pl-2">Aqui, você tem a opção de configurar e nomear perfis de busca
                que se adequem aos requisitos do pretendente. Esses perfis serão salvos para o pretendente e
                é possível criar um ou mais perfis. O sistema irá então classificar os imóveis de acordo com
                os perfis criados, para melhor atender às preferências do pretendente.</span>
        </div>

        <!-- Dados retornados do ajax -->
        <div class="mt-5" id="resultAjaxPerfil">
            <div class="flex flex-col sm:flex-row">

                <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Nome do Perfil -->
                    <div>
                        <label for="perfilBuscaNome">Nome do Perfil</label>
                        <input name="nome" id="perfilBuscaNome" type="text" value="'.$result[0]['ppf_nome'].'" placeholder="Jimmy Turner"
                            class="form-input" />
                    </div>

                    <!-- Tipo de Imóvel -->
                    <div>
                        <label>Tipo de Imóvel</label>
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
                        <label for="perfilBuscaUtilizacao">Utilização</label>
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
                        <label for="perfilBuscaEmpreendimento">Empreendimento</label>
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
                        <label for="perfilBuscaFaixaValor">Dormitórios</label>
                        <div class="flex w-full">
                            <div class="flex items-center w-full">
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                </div>
                                <div class="px-3">até</div>
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sendo Suítes -->
                    <div>
                        <label for="perfilBuscaFaixaValor">Sendo Suítes</label>
                        <div class="flex w-full">
                            <div class="flex items-center w-full">
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                </div>
                                <div class="px-3">até</div>
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0" class="form-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Garagem -->
                    <div>
                        <label for="perfilBuscaGaragem">Garagem</label>
                        <input name="nome" type="text" placeholder="0" class="form-input" />
                    </div>

                    <!-- Faixa de valor -->
                    <div>
                        <label for="perfilBuscaFaixaValor">Faixa de Valor</label>
                        <div class="flex w-full">
                            <div class="flex items-center w-full">
                                <div class="w-full">
                                    <input id="currencyMask1" type="text" onkeyup="formatCurrency(this)"
                                        placeholder="R$ 0,00" class="form-input" />
                                </div>
                                <div class="px-3">até</div>
                                <div class="w-full">
                                    <input id="currencyMask2" type="text" onkeyup="formatCurrency(this)"
                                        placeholder="R$ 0,00" class="form-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Área Terreno m² -->
                    <div>
                        <label for="perfilBuscaFaixaValor">Área Terreno (m²)</label>
                        <div class="flex w-full">
                            <div class="flex items-center w-full">
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                </div>
                                <div class="px-3">até</div>
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Área Construída m² -->
                    <div>
                        <label for="perfilBuscaFaixaValor">Área Construída (m²)</label>
                        <div class="flex w-full">
                            <div class="flex items-center w-full">
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                </div>
                                <div class="px-3">até</div>
                                <div class="w-full">
                                    <input id="xxxx" type="text" placeholder="0,00" class="form-input" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cidade -->
                    <div>
                        <label for="perfilBuscaCidade">Cidade</label>
                        <input name="nome" id="perfilBuscaCidade" type="text" placeholder="São Paulo"
                            class="form-input" />
                    </div>

                    <!-- Ponto de Referência -->
                    <div>
                        <label for="perfilBuscaPontoReferencia">Ponto de Referência</label>
                        <input name="nome" id="perfilBuscaPontoReferencia" type="text"
                            placeholder="Ponto de Referência..." class="form-input" />
                    </div>

                    <!-- Edifício -->
                    <div>
                        <label for="perfilBuscaEdificio">Edifício</label>
                        <input name="nome" id="perfilBuscaEdificio" type="text" placeholder="Edifício..."
                            class="form-input" />
                    </div>

                    <!-- Rua -->
                    <div>
                        <label for="perfilBuscaRua">Rua</label>
                        <input name="nome" id="perfilBuscaRua" type="text" placeholder="Rua..."
                            class="form-input" />
                    </div>

                    <!-- Bairro -->
                    <div>
                        <label for="perfilBuscaBairro">Bairro</label>
                        <input name="nome" id="perfilBuscaBairro" type="text" placeholder="Bairro..."
                            class="form-input" />
                    </div>

                    <!-- Permuta -->
                    <div>
                        <label for="perfilBuscaPermuta">Permuta</label>
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
        </div>';

        // Retorna resposta
        echo json_encode($html);
        exit;
    }
}
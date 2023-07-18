<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['action']) && isset($value['prh_pretendente'])) {

        // Somente na edição
        if (isset($value['prh_pretendente']) && isset($value['prh_codigo'])) {
            // Dados do histórico de atendimento
            $sql = '
            SELECT ph.prh_codigo, DATE_FORMAT(ph.prh_data, "%Y-%m-%d") AS prh_data, ph.prh_descricao, pc.pco_codigo, ph.prh_horacad, u.usu_nome, ph.prh_avisar 
            FROM pretendenteshistorico AS ph 
                JOIN pretendentes AS p ON (ph.prh_pretendente = p.prw_codigo)
                LEFT JOIN pretendentescontato AS pc ON (pc.pco_codigo = ph.prh_codigo)
                LEFT JOIN sisusuarios AS u ON (ph.prh_usuario = u.usu_codigo)
            WHERE ph.prh_pretendente = ' . $value['prh_pretendente'].' AND ph.prh_codigo = '.$value['prh_codigo'];
            $result = $data->find('dynamic', $sql);
        }

        // Forma de contato
        $sql = '
        SELECT * 
        FROM pretendentescontato AS pc
        ORDER BY pc.pco_descricao ASC';
        $formasContato = $data->find('dynamic', $sql);

        // Monta resposta
        $html = '
        <form method="POST" action="'.$value['action'].'" id="MyForm" name="MyForm" >';
            // Somente na edição envia prh_codigo
            if (isset($value['prh_codigo'])) { $html .= '<input type="hidden" name="prh_codigo" value="'.$value['prh_codigo'].'" />'; }
            
            $html .= '
            <input type="hidden" name="prh_pretendente" value="'.$value['prh_pretendente'].'" />

            <!-- Mensagem -->
            <div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
                <span class="ltr:pr-2 rtl:pl-2">Aqui contém o histórico dos atendimentos realizados pra este pretendente. É possível inserir uma observação e alterar informações referentes ao atendimento.</span>
            </div>

            <!-- Dados retornados do ajax -->
            <div class="mt-5" >
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="nome">Data do atendimento</label>
                            <input name="prh_data" type="date" value="'.$result[0]['prh_data'].'" placeholder="00/00/0000" class="form-input" />
                        </div>

                        <div>
                            <label for="formaContato">Forma de contato</label>
                            <select name="prh_contato" class="form-select">
                                <option>-- Selecione --</option>';
                                foreach ($formasContato as $key => $value) {
                                    $selected = ($result[0]['pco_codigo'] == $value['pco_codigo']) ? 'selected' : '';
                                    $html .= '<option value="' . $value['pco_codigo'] . '" '.$selected.' >' . $value['pco_descricao'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex-1 mt-5">
                    <div>
                        <label for="nome">Descrição</label>
                        <textarea name="prh_descricao" class="form-input" rows="3">'.$result[0]['prh_descricao'].'</textarea>                        
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
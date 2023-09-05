<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true); // Recebendo os dados do corpo da requisição
    if (isset($value['action']) && isset($value['prv_pretendente'])) {

        //? Somente na edição
        if (isset($value['prv_pretendente']) && isset($value['prv_codigo'])) {
            $sql = '            
            SELECT * 
            FROM pretendentesvisitas AS pv 
                LEFT JOIN pretendentes AS p ON (pv.prv_pretendente = p.prw_codigo)
                LEFT JOIN imoveis AS i ON (pv.prv_imovel = i.imo_codigo)
            WHERE pv.prv_pretendente = '.$value['prv_pretendente'].' AND pv.prv_codigo = '.$value['prv_codigo'];
            $result = $data->find('dynamic', $sql);
        }else{
            //? Vindo da aba imóveis
            $sql = '
            SELECT * 
            FROM imoveis AS i 
            WHERE i.imo_codigo = '.$xxxx;
            $result = $data->find('dynamic', $sql);
        }

        $sql = '
        SELECT * 
        FROM sisusuarios
        WHERE usu_ativado = "s"
        ORDER BY usu_nome ASC';
        $profissionais = $data->find('dynamic', $sql);

        // Monta resposta
        $html = '
        <form method="POST" action="'.$value['action'].'" id="MyForm" name="MyForm" >';
            // Somente na edição envia prh_codigo
            if (isset($value['prv_codigo'])) { $html .= '<input type="hidden" name="prv_codigo" value="'.$value['prv_codigo'].'" />'; }
            
            $html .= '
            <input type="hidden" name="prv_pretendente" value="'.$value['prv_pretendente'].'" />

            <!-- Mensagem -->
            <div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
                <span class="ltr:pr-2 rtl:pl-2">Aqui contém o histórico dos atendimentos realizados pra este pretendente. É possível inserir uma observação e alterar informações referentes ao atendimento.</span>
            </div>

            <div class="mt-5" >
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <input type="hidden" name="prv_empresa" value="'.$_SESSION['v_emp_codigo'].'" />

                        <div>
                            <label>Imóvel</label>
                            <input name="prv_imovel" type="text" class="form-input" value="'.$result[0]['prv_imovel'].'" />                 
                        </div>

                        <div>
                            <label for="nome">Acompanhante do pretendente</label>
                            <input name="prv_acompanhantepretendente" type="text" class="form-input" value="'.$result[0]['prv_acompanhantepretendente'].'" />                 
                        </div>

                        <div>
                            <label for="formaContato">Acompanhante da empresa</label>
                            <select name="prv_acompanhante" class="form-select">
                                <option>-- Selecione --</option>';                            
                                foreach ($profissionais as $key => $value) {
                                    $selected = $result[0]['prv_acompanhante'] == $value['usu_codigo'] ? 'selected' : '';
                                    $html .= '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>

                        <div>
                            <label for="nome">Início da visita</label>';                            
                            //? Converte varchar pra data yyyy-mm-dd
                            $formatedDataIni = $result[0]['prv_dataini'] ? substr($result[0]['prv_dataini'], 0, 4) . '-' . substr($result[0]['prv_dataini'], 4, 2) . '-' . substr($result[0]['prv_dataini'], 6, 2) : '';         
                            $dataIni = $formatedDataIni ? $formatedDataIni : date('Y-m-d');
                            //? Converte varchar pra hora hh:mm
                            $formatedHoraIni = $result[0]['prv_horaini'] ? substr($result[0]['prv_horaini'], 0, 2) . ':' . substr($result[0]['prv_horaini'], 2, 2) : '';
                            $horaIni = $formatedHoraIni ? $formatedHoraIni : '';
                            $html .= '
                            <div class="flex gap-4 ">
                                <input name="prv_dataini" type="date" class="form-input" value="<?php echo $dataIni; ?>" />
                                <input name="prv_horaini" type="time" class="form-input" value="<?php echo $horaIni; ?>" /> 
                            </div>
                        </div>

                        <div>
                            <label for="formaContato">Chave entregue por</label>
                            <select name="prv_entreguepor" class="form-select">
                                <option>-- Selecione --</option>';                                
                                $selected = $result[0]['prv_entreguepor'] == $value['usu_codigo'] ? 'selected' : '';
                                foreach ($profissionais as $key => $value) {
                                    $html .= '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>

                        <div>
                            <label for="nome">Fim da visita (entrega da chave)</label>';                        
                            //? Converte varchar pra data yyyy-mm-dd
                            $formatedDataFim = $result[0]['prv_datafim'] ? substr($result[0]['prv_datafim'], 0, 4) . '-' . substr($result[0]['prv_datafim'], 4, 2) . '-' . substr($result[0]['prv_datafim'], 6, 2) : '';
                            $dataFim = $formatedDataFim ? $formatedDataFim : date('Y-m-d');
                            //? Converte varchar pra hora hh:mm
                            $formatedHoraFim = $result[0]['prv_horafim'] ? substr($result[0]['prv_horafim'], 0, 2) . ':' . substr($result[0]['prv_horafim'], 2, 2) : '';
                            $horaFim = $formatedHoraFim ? $formatedHoraFim : '';
                            $html .= '
                            <div class="flex gap-4 ">
                                <input name="prv_datafim" type="date" class="form-input" value="'.$dataFim.'" />
                                <input name="prv_horafim" type="time" class="form-input" value="'.$horaFim.'" /> 
                            </div>
                        </div>

                        <div>
                            <label for="formaContato">Chave devolvida por</label>
                            <select name="prv_devolvidopor" class="form-select">
                                <option>-- Selecione --</option>';                            
                                $selected = $result[0]['prv_devolvidopor'] == $value['usu_codigo'] ? 'selected' : '';
                                foreach ($profissionais as $key => $value) {
                                    $html .= '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                }
                            $html .= '
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex-1 mt-5">
                    <div>
                        <label for="nome">Observação</label>
                        <textarea name="prv_obs" class="form-input" rows="3">'.$result[0]['prv_obs'].'</textarea>                    
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
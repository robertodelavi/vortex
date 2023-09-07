<?php 
    $sql = '
    SELECT ph.prh_codigo, DATE_FORMAT(ph.prh_data, "%d/%m/%Y") AS prh_data, pc.pco_descricao, ph.prh_descricao, DATE_FORMAT(ph.prh_datacad, "%d/%m/%Y") AS prh_datacad, ph.prh_horacad, ph.prh_usuario, u.usu_nome, ph.prh_contato, ph.prh_avisar
    FROM pretendenteshistorico AS ph 
        JOIN pretendentes AS p ON (ph.prh_pretendente = p.prw_codigo)
        LEFT JOIN pretendentescontato AS pc ON (pc.pco_codigo = ph.prh_contato)
        LEFT JOIN sisusuarios AS u ON (ph.prh_usuario = u.usu_codigo)
    WHERE ph.prh_pretendente = ' . $_POST['param_0'];
    $result = $data->find('dynamic', $sql);
?>

<div x-data="modal">
    <div class="panel">
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="font-semibold text-lg">Histórico de Atendimentos</h5>
            </div>
            <div>
                <button class="btn btn-primary" @click="toggle; openModalEditHistoricoAtendimento('<?php echo $_POST['param_0']; ?>', null);">Novo</button>    
            </div>
        </div>
        <div class="mb-5 overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Data Atendimento</th>
                        <th>Data Sistema</th>
                        <th>Profissional</th>
                        <th>Forma de Atendimento</th>
                        <th>Avisar</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result > 0) {
                        foreach ($result as $key => $row) {
                            $funilColor = $key < 2 ? 'bg-success' : ($key < 4 ? 'bg-warning' : 'bg-danger');
                            echo '
                            <tr>
                                <td>' . $row['prh_data'] . '</td>
                                <td>' . $row['prh_datacad'] . '</td>
                                <td>' . ($row['usu_nome'] ? $row['usu_nome'] : '--') . '</td>
                                <td>' . ($row['pco_descricao'] ? $row['pco_descricao'] : '--') . '</td>
                                <td>' . 
                                    ($row['prh_avisar'] == 's' ? 
                                    '<span class="badge whitespace-nowrap badge-outline-success">Avisar</span>' : 
                                    '<span class="badge whitespace-nowrap badge-outline-danger">Não avisar</span>'
                                    ) . 
                                '</td>
                                <td>     
                                    <button type="button" x-tooltip="Editar Histórico de Atendimento" data-placement="left" class="mr-2 hover:text-info" @click="toggle; openModalEditHistoricoAtendimento(\'' . $_POST['param_0'] . '\', \'' . $row['prh_codigo'] . '\');">
                                        '.file_get_contents('application/icons/edit.svg').'
                                    </button> 
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Nenhum resultado encontrado!</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>        
    </div>

    <!-- Modal editar -->
    <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open && '!block'">
        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
            <div x-show="open" x-transition x-transition.duration.300
                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    <h5 class="font-bold text-lg">Histórico de Atendimento</h5>
                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                        <?php echo file_get_contents('application/icons/close.svg'); ?>
                    </button>
                </div>
                <div class="p-5">
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                    
                        <!-- Histórico vindo do ajax -->
                        <div id="resulAjaxHistoricoAtendimento"></div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
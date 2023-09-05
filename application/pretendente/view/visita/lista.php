<?php 
    $sql = '
    SELECT 
        pv.prv_codigo,
        i.imo_codigo,
        pv.prv_pretendente,
        CONCAT(ti.tpi_descricao, " - ", b.bai_descricao, " - ", c.cid_descricao, "/", c.cid_uf) AS imovel, 
        DATE_FORMAT(pv.prv_dataini, "%d/%m/%Y") AS dataIni,           
        IF(pv.prv_horaini <> "", CONCAT(SUBSTRING(pv.prv_horaini, 1, 2), ":", SUBSTRING(pv.prv_horaini, 3, 2)), "--") AS horaIni,
        DATE_FORMAT(pv.prv_datafim, "%d/%m/%Y") AS dataFim,
        IF(pv.prv_horafim <> "", CONCAT(SUBSTRING(pv.prv_horafim, 1, 2), ":", SUBSTRING(pv.prv_horafim, 3, 2)), "--") AS horaFim,        
        u.usu_nome AS entreguePor
    FROM pretendentesvisitas AS pv
        LEFT JOIN imoveis AS i ON (pv.prv_imovel = i.imo_codigo)
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)    
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
        LEFT JOIN sisusuarios AS u ON (pv.prv_entreguepor = u.usu_codigo)
    WHERE pv.prv_pretendente = ' . $_POST['param_0'] . '
    ORDER BY pv.prv_dataini DESC, pv.prv_horaini DESC
    LIMIT 1';
    $result = $data->find('dynamic', $sql);
?>

<div>
    <div class="panel" >
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="font-semibold text-lg">Visitas</h5>
            </div>
            <div>
                <a href="javascript:;" class="text-primary hover:text-primary-dark/70" @click="tab='imoveis'">
                    <button type="button" class="btn btn-primary">
                        Novo
                    </button>                                        
                </a> 
            </div>
        </div>
        <div class="mb-5">
            <table>
                <thead>
                    <tr>
                        <th>Imóvel</th>
                        <th>Entregue por</th>
                        <th>Data Início</th>
                        <th>Hora Início</th>
                        <th>Data Fim</th>
                        <th>Hora Fim</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result > 0) {
                        foreach ($result as $key => $row) {
                            echo '
                            <tr>
                                <td>' . $row['imovel'] . '</td>
                                <td>' . ($row['entreguePor'] ? $row['entreguePor'] : '--') . '</td>
                                <td>' . ($row['dataIni'] ? $row['dataIni'] : '--') . '</td>
                                <td>' . ($row['horaIni'] ? $row['horaIni'] : '--') . '</td>
                                <td>' . ($row['dataFim'] ? $row['dataFim'] : '--') . '</td>
                                <td>' . ($row['horaFim'] ? $row['horaFim'] : '--') . '</td>
                                <td>     
                                    <button type="button" x-tooltip="Editar Histórico de Atendimento" data-placement="left" class="mr-2 hover:text-info" @click="toggle2; setVisit('.$result[$key]['prv_codigo'].', '.$result[$key]['imo_codigo'].', \''.$row['imovel'].'\');">
                                        '.file_get_contents('application/icons/edit.svg').'
                                    </button> 
                                </td>
                            </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">Nenhum resultado encontrado!</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>        
    </div>

    <!-- Modal editar -->
    <!-- <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open && '!block'">
        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
            <div x-show="open" x-transition x-transition.duration.300
                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    <h5 class="font-bold text-lg">Visita</h5>
                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                        <?php //echo file_get_contents('application/icons/close.svg'); ?>
                    </button>
                </div>
                <div class="p-5">
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                    
                        <div id="resulAjaxFormVisita"></div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>   -->

</div>
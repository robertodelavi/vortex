<div x-data="modal">
    <div class="panel">
        <div class="mb-5">
            <h5 class="font-semibold text-lg mb-4">Meus Perfis</h5>
        </div>
        <div class="mb-5">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Bairro</th>
                        <th>Tipo de Imóvel</th>
                        <th>Faixa de valor</th>
                        <th class="text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($perfis > 0) {
                        foreach ($perfis as $row) {
                            echo '
                            <tr>
                                <td>' . $row['ppf_nome'] . '</td>
                                <td>' . ($row['ppf_bairro'] ? $row['ppf_bairro'] : '--') . '</td>
                                <td>' . $row['tpi_descricao'] . '</td>
                                <td>' . number_format(($row['ppf_valorini'] / 100), 2, ',', '.') . ' a ' . number_format(($row['ppf_valorfim'] / 100), 2, ',', '.') . '</td>
                                <td>                                            
                                    <button class="btn btn-dark" @click="toggle; openModalEditPerfil(\'' . $row['ppf_pretendente'] . '\', \'' . $row['ppf_codigo'] . '\');">Editar</button>    
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

        <button class="btn btn-primary">Novo Perfil</button>
    </div>

    <!-- Modal editar perfil de busca -->
    <?php include_once('application/pretendente/view/abas/perfilBusca/modal.php'); ?>    
</div>
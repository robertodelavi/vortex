<div x-data="modal">
    <div class="panel">
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="font-semibold text-lg">Meus Perfis</h5>
            </div>
            <div>
                <button class="btn btn-primary" @click="toggle; openModalEditPerfil('<?php echo $_POST['param_0']; ?>', null);">Novo</button>    
            </div>
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
                                    <button type="button" x-tooltip="Editar Perfil de Busca" data-placement="left" class="mr-2 hover:text-info" @click="toggle; openModalEditPerfil(\'' . $row['ppf_pretendente'] . '\', \'' . $row['ppf_codigo'] . '\');">
                                        '.file_get_contents('application/icons/edit.svg').'
                                    </button> 

                                    <button type="button" x-tooltip="Excluir Perfil de Busca" data-placement="left" class="ml-2 hover:text-danger" @click="toggleDelete; setDeleteId(\'' . $row['ppf_pretendente'] . '\', \'' . $row['ppf_codigo'] . '\');" >
                                        '.file_get_contents('application/icons/delete.svg').'
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
                    <h5 class="font-bold text-lg">Perfil de Busca</h5>
                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                        <?php echo file_get_contents('application/icons/close.svg'); ?>
                    </button>
                </div>
                <div class="p-5">
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                    
                        <!-- Perfil vindo do ajax -->
                        <div id="resulAjaxPerfilBusca"></div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal delete -->
    <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="openDelete && '!block'">
        <div class="flex items-center justify-center min-h-screen px-4"  @click.self="openDelete = false">
            <div x-show="openDelete" x-transition x-transition.duration.300
                class="panel border-0 p-0 rounded-lg overflow-hidden md:w-full max-w-lg w-[90%] my-8">
                <button type="button"
                    class="absolute top-4 ltr:right-4 rtl:left-4 text-white-dark hover:text-dark"
                    @click="toggleDelete">
                    <?php echo file_get_contents('application/icons/close.svg'); ?>
                </button>
                <h3
                    class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                    Excluir</h3>
                <div class="p-5 text-center">
                    <div class="text-white bg-danger ring-4 ring-danger/30 p-4 rounded-full w-fit mx-auto">
                        <?php echo file_get_contents('application/icons/deleteRounded.svg'); ?>
                    </div>
                    <div class="sm:w-3/4 mx-auto mt-5">Tem certeza que deseja <b class="text-danger">excluir</b>
                        este item?</div>

                    <div class="flex justify-center items-center mt-8">
                        <button type="button" class="btn btn-danger" @click="deletePerfilBusca()">Excluir</button>
                        <button type="button" class="btn btn-outline-primary ltr:ml-4 rtl:mr-4"
                        @click="toggleDelete">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
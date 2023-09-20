<?php

$sql = '
SELECT 
    p.prw_codigo, 
    p.prw_nome, 
    p.prw_email,     
    p.prw_psa_codigo, 
    u.usu_nome, 
    p.prw_telefones, 
    ps.psa_descricao AS statusNome, 
    ps.psa_cor,
    p.prw_datacad AS primeiroCadastro,
    p.prw_dataatual AS ultimoCadastro
FROM pretendentes AS p
    LEFT JOIN sisusuarios AS u ON (p.prw_usuario = u.usu_codigo)
    LEFT JOIN pretendentesstatusatendimento AS ps ON (p.prw_psa_codigo = ps.psa_codigo)
WHERE prw_codigo > 0';

//? Usuário logado tem permisão de ver somente os atendimentos dele
if($_SESSION['v_somente_atendimentos_meu'] == "s"){
    $sql .= ' AND p.prw_usuario = "'.$_SESSION['v_usu_codigo'].'" ';
}

$sql .= '
ORDER BY 10 DESC, 2 ASC
LIMIT 100';
$result = $data->find('dynamic', $sql);

// Obtém o total de etapas/status do pretendente pra calcular a % de progresso 
$sql = '
SELECT COUNT(*) AS qtd
FROM pretendentesstatusatendimento';
$totalEtapas = $data->find('dynamic', $sql);

$sql = '
SELECT 0 AS psa_codigo, "Indefinido" AS psa_descricao, "" AS psa_cor, 0 AS psa_ordem
UNION ALL
(SELECT *
FROM pretendentesstatusatendimento
ORDER BY psa_ordem ASC)';
$etapas = $data->find('dynamic', $sql);

$tableResult = [];
foreach ($result as $row) {
    // Converte data yyyymmdd pra dd/mm/yyyy
    $row['primeiroCadastro'] = $row['primeiroCadastro'] ? date('d/m/Y', strtotime($row['primeiroCadastro'])) : '--';
    $row['ultimoCadastro'] = $row['ultimoCadastro'] ? date('d/m/Y', strtotime($row['ultimoCadastro'])) : '--';

    $arrRow = [];
    array_push($arrRow, trim($row['prw_nome']));    
    array_push($arrRow, '<div class="h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:'.getProgressPercent($totalEtapas[0]['qtd'], $row).'%; background-color: '.$row['psa_cor'].'; "></div>');
    array_push($arrRow, trim($row['usu_nome'] ? $row['usu_nome'] : '--'));
    array_push($arrRow, trim($row['prw_telefones'] ? $row['prw_telefones'] : '--'));
    array_push($arrRow, trim($row['primeiroCadastro']));
    array_push($arrRow, trim($row['ultimoCadastro']));
    array_push($arrRow, trim($row['prw_email'] ? $row['prw_email'] : '--'));   
    array_push($arrRow, $row['prw_codigo']);
    //
    array_push($tableResult, $arrRow);
}

function getProgressPercent($totalEtapas, $row){
    if(!$totalEtapas) $totalEtapas = 1;
    $percent = ($row['prw_psa_codigo'] * 100)/$totalEtapas;
    return $percent;
}

// TOASTS
if(isset($_GET['res'])){
    switch($_GET['res']){
        case 1:
            echo '
            <script>
                setTimeout(() => {
                    toast("Pretendente excluído com sucesso!", "success", 3000);
                }, 300);
            </script>';
        break;
    }
}
?>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/Sortable.min.js"></script>
<div x-data="modal">
    <div x-data="multipleTable">

        <!-- Filtros (mobile) -->   
        <div class="block sm:hidden overflow-y-auto mb-4" >
            <div class="panel space-y-4 " >
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-lg dark:text-white-light">Filtros</p>
                    <button class="btn btn-sm btn-outline-primary" @click="toggleFilter">
                        <?php echo file_get_contents('application/icons/filter.svg'); ?>
                    </button>
                </div>
                <!-- Abrir formulário com openFilter com efeito  -->
                <div x-show="openFilter" x-transition x-transition.duration.300 class="overflow-hidden">
                    <?php include('application/pretendente/view/list/formFilter.php'); ?>
                </div>
            </div>        
        </div>  

        <!-- Tela com filtro e tabela de listagem -->
        <div class="flex gap-4" style="height: 77vh;" >            
            <!-- Filtros (desktop) -->   
            <div class="hidden sm:block overflow-y-auto" >
                <div class="panel  " >
                    <h5 class="mt-2 mb-5 font-semibold text-lg dark:text-white-light">
                        Filtros
                    </h5>
                    <?php include('application/pretendente/view/list/formFilter.php'); ?>
                </div>        
            </div>      

            <!-- Listagem -->
            <div class="w-full overflow-x-auto">
                <div class="panel mt-0">
                    <div class="flex justify-between items-center ">
                        <h5 class="font-semibold text-lg dark:text-white-light">
                            Pretendentes
                        </h5>
                        <div>                    
                            <button id="searchButton" class="btn btn-primary" @click="toggle;" >Novo</button>                    
                        </div>
                    </div>                        
                    <table id="myTable2" class="tabela whitespace-nowrap"></table>            
                </div>
            </div>
        </div>    
        
        <!-- Modal delete -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden"
            :class="isAddEventModal && '!block'">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="isAddEventModal = false">
                <div x-show="isAddEventModal" x-transition x-transition.duration.300
                    class="panel border-0 p-0 rounded-lg overflow-hidden md:w-full max-w-lg w-[90%] my-8">
                    <button type="button"
                        class="absolute top-4 ltr:right-4 rtl:left-4 text-white-dark hover:text-dark"
                        @click="isAddEventModal = false">
                        <?php echo file_get_contents('application/icons/close.svg'); ?>
                    </button>
                    <h3
                        class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]">
                        Excluir</h3>
                    <div class="p-5 text-center">
                        <div class="text-white bg-danger ring-4 ring-danger/30 p-4 rounded-full w-fit mx-auto">
                            <?php echo file_get_contents('application/icons/deleteRounded.svg'); ?>
                        </div>
                        <div class="sm:w-3/4 mx-auto mt-5">
                            Excluir o(a) pretendente <b class="text-danger" x-text="nomeDelete"></b>?
                        </div>

                        <div class="flex justify-center items-center mt-8">
                            <button type="button" class="btn btn-danger" @click="deleteItem">Excluir</button>
                            <button type="button" class="btn btn-outline-primary ltr:ml-4 rtl:mr-4"
                                @click="isAddEventModal = false">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal novo pretendente -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open && '!block'">
            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300
                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Novo Pretendente</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <?php echo file_get_contents('application/icons/close.svg'); ?>
                        </button>
                    </div>
                    <div class="p-5">
                        <form method="POST" action="?module=pretendente&acao=gravadados_pretendente" >
                            <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]"> 
                                <!-- Formulário do pretendente  -->
                                <?php include_once('application/pretendente/view/dadosPretendente/formDadosPretendente.php'); ?>
                            </div>
                            
                            <div class="flex justify-end items-center mt-8">
                                <button type="button" class="btn btn-outline-dark" @click="toggle">Cancelar</button>
                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Status do Pretendente (scrumboard) -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open2 && '!block'">
            <div class="flex items-start justify-center px-4"  @click.self="open2 = false">
                <div x-show="open2" x-transition x-transition.duration.300
                    class="panel border-0 p-0 rounded-lg overflow-y-auto h-auto w-full max-w-3xl my-10">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Status do Pretendente</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle2">
                            <?php echo file_get_contents('application/icons/close.svg'); ?>
                        </button>
                    </div>
                    <?php require_once('application/pretendente/view/status/scrumBoard.php'); ?>
                </div>
            </div>
        </div>

    </div>    

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/simple-datatables.js"></script>
<script>
    const arrData = <?php echo json_encode($tableResult); ?>;
    const etapas = <?php echo json_encode($etapas); ?>;

    const selectUf = (uf) => {
        var data = {
            uf: uf
        };
        fetch('application/script/ajax/getCidades.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            document.getElementById('resulAjaxCidades').innerHTML = data     
        })        
    }
    
    document.addEventListener("alpine:init", () => {

        Alpine.data("multipleTable", () => ({
            datatable2: null,
            isAddEventModal: false,
            idDelete: null,
            nomeDelete: null,
            currentData: arrData,
            etapas: etapas,
            openFilter: false,

            toggleFilter() {
                this.openFilter = !this.openFilter;
            },

            init() {
                this.updateTableData(arrData);
                // Scrumboard 
                this.updateData(null);
                this.initializeSortable();
            },

            updateTableData(data) {
                if (this.datatable2) {
                    this.datatable2.destroy();
                }

                this.datatable2 = new simpleDatatables.DataTable('#myTable2', {
                    data: {
                        headings: ['Nome do Pretendente', 'Status', 'Atendido por', 'Telefones', 'P. Atendimento', 'U. Atendimento', 'E-mail', 'Ações'],
                        data: data
                    },
                    searchable: false,
                    perPage: 20,
                    perPageSelect: [10, 20, 30, 50, 100],
                    columns: [
                        {
                            select: 0,
                            render: (data, cell, row) => {
                                const id = row.cells[7].data
                                return `<div class="flex items-center w-max">
                                            <a href="#" onClick="nextPage('?module=pretendente&acao=edita_pretendente', '${id}');" class="hover:text-primary">${data}</a>
                                        </div>`;
                            }
                        },
                        {
                            select: 1,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[7].data
                                return `<div @click="toggle2; getStatusScrumBoard('${id}');" x-tooltip="Alterar o status do pretendente" data-placement="top" class="w-4/5 min-w-[100px] h-2.5 bg-[#ebedf2] dark:bg-dark/40 rounded-full flex cursor-pointer" >${data}</div>`;
                            },
                        },
                        {
                            select: 7,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[7].data
                                const nome = row.cells[0].data
                                
                                return `<div class="flex gap-4 items-center" >
                                            <a href="#" onClick="nextPage('?module=pretendente&acao=edita_pretendente', '${id}');" class="hover:text-info">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5">
                                                    <path
                                                        opacity="0.5"
                                                        d="M22 10.5V12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2H13.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    ></path>
                                                    <path
                                                        d="M17.3009 2.80624L16.652 3.45506L10.6872 9.41993C10.2832 9.82394 10.0812 10.0259 9.90743 10.2487C9.70249 10.5114 9.52679 10.7957 9.38344 11.0965C9.26191 11.3515 9.17157 11.6225 8.99089 12.1646L8.41242 13.9L8.03811 15.0229C7.9492 15.2897 8.01862 15.5837 8.21744 15.7826C8.41626 15.9814 8.71035 16.0508 8.97709 15.9619L10.1 15.5876L11.8354 15.0091C12.3775 14.8284 12.6485 14.7381 12.9035 14.6166C13.2043 14.4732 13.4886 14.2975 13.7513 14.0926C13.9741 13.9188 14.1761 13.7168 14.5801 13.3128L20.5449 7.34795L21.1938 6.69914C22.2687 5.62415 22.2687 3.88124 21.1938 2.80624C20.1188 1.73125 18.3759 1.73125 17.3009 2.80624Z"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></path>
                                                    <path
                                                        opacity="0.5"
                                                        d="M16.6522 3.45508C16.6522 3.45508 16.7333 4.83381 17.9499 6.05034C19.1664 7.26687 20.5451 7.34797 20.5451 7.34797M10.1002 15.5876L8.4126 13.9"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></path>
                                                </svg>
                                            </a>

                                            <button type="button" class="hover:text-danger"  @click="() => confirmDelete('${data}', '${nome}')">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                                    <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path
                                                        d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    ></path>
                                                    <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path opacity="0.5" d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                                    <path
                                                        opacity="0.5"
                                                        d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    ></path>
                                                </svg>
                                            </button>
                                        </div>`;
                            }
                        }
                    ],
                    firstLast: true,
                    firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    labels: {
                        perPage: "{select}"
                    },
                    layout: {
                        top: "{search}",
                        bottom: "{info}{select}{pager}",
                    },
                });
            },

            submitForm(event) {
                event.preventDefault();

                // Obtém os valores do formulário
                const formData = new FormData(event.target);
                this.setFormValues(formData);
                
                // Faz a requisição AJAX para o arquivo PHP
                fetch('application/pretendente/view/filter.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        // Atualiza os dados da tabela com os dados filtrados
                        this.currentData = data;
                        this.updateTableData(data);
                    })
                    .catch(error => {
                        console.error('Erro ao enviar o formulário:', error);
                    });
            },

            setFormValues(formData) {
                const formValues = {};
                for (let [key, value] of formData.entries()) {
                    formValues[key] = value;
                }
                // Adiciona os valores extras ao formData
                formData.append('values', JSON.stringify(formValues));
            },

            formatDate(date) {
                if (date) {
                    const dt = new Date(date);
                    const month = dt.getMonth() + 1 < 10 ? '0' + (dt.getMonth() + 1) : dt.getMonth() + 1;
                    const day = dt.getDate() < 10 ? '0' + dt.getDate() : dt.getDate();
                    return day + '/' + month + '/' + dt.getFullYear();
                }
                return '';
            },

            randomColor() {
                const color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info'];
                const random = Math.floor(Math.random() * color.length);
                return color[random];
            },

            randomStatus() {
                const status = ['PAID', 'APPROVED', 'FAILED', 'CANCEL', 'SUCCESS', 'PENDING', 'COMPLETE'];
                const random = Math.floor(Math.random() * status.length);
                return status[random];
            },

            limpaFiltros() {
                document.querySelectorAll('select').forEach((select) => {
                    select.selectedIndex = 0;
                })
                document.getElementById("formFilter").reset();
                this.updateTableData(arrData);
            },

            confirmDelete(id, nome) {
                this.isAddEventModal = true;
                this.idDelete = id;
                this.nomeDelete = nome;
            },

            deleteItem() {
                nextPage('?module=pretendente&acao=deletadados_pretendente', this.idDelete)
            },

            //? SCRUMBOARD
            pretendenteID: null,
            params: {
                id: null,
                title: ''
            },
            paramsTask: {
                projectId: null,
                id: null,
                title: '',
                description: '',
                tags: ''
            },
            selectedTask: null,
            isAddProjectModal: false,
            isAddTaskModal: false,
            isDeleteModal: false,
            projectList: [],
            
            updateData(scrumBoardData){
                console.log("🚀 ~ updateData ~ scrumBoardData:", scrumBoardData)
                this.projectList = scrumBoardData;
                this.initializeSortable();
            },
            
            // Função pra ser chamada após arrastar e soltar
            afterDrag(event) {
                const draggedCard = event.to;
                const projectId = draggedCard.getAttribute('data-id');
                if(projectId && this.pretendenteID && this.pretendenteID > 0){
                    // Atualiza status enviando projectId pro arquivo ajax do php 
                    fetch('application/pretendente/view/status/updateStatus.php', {
                        method: 'POST',
                        body: JSON.stringify({
                            id: this.pretendenteID,
                            status: projectId
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Atualiza os dados da tabela com os dados filtrados
                            if(data.status == 'success'){
                                toast(data.message, "success", 3000);

                                // Atualiza updateTableData 
                                const updatedDataStatus = this.updateDataStatus(projectId)
                                this.updateTableData(updatedDataStatus);   

                                console.log("🚀 ~ afterDrag ~ pretendente:", this.pretendenteID)
                                this.getStatusScrumBoard(this.pretendenteID)                                                        
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao enviar o formulário:', error);
                        });
                }                
            },

            // Função varre pretendentes e atualiza barra de status do pretendente e retorna array completo atualizado
            updateDataStatus(projectId){
                if(!this.currentData || this.currentData.length == 0){
                    return this.currentData
                }
                
                this.currentData.map((item) => { // varre pretendentes
                    if(item[7] == this.pretendenteID){
                        if(etapas.length == 0){
                            return this.currentData
                        }
                        
                        etapas.map((etapa) => { // varre etapas
                            if(etapa.psa_codigo == projectId){
                                // Remove opção "infefinido" do calculo de %
                                const percent = etapas.length > 1 ? (etapa.psa_ordem * 100)/(etapas.length-1) : 100;
                                item[1] = `
                                <div class="h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:${percent}%; background-color: ${etapa.psa_cor}; "></div>`;
                            }
                        })

                    }
                })

                return this.currentData
            },

            initializeSortable() {
                setTimeout(() => {
                    //sortable js
                    const sortable = document.querySelectorAll('.sortable-list');
                    for (let i = 0; i < sortable.length; i++) {
                        Sortable.create(sortable[i], {
                            animation: 200,
                            group: 'name',
                            ghostClass: "sortable-ghost",
                            dragClass: "sortable-drag",
                            onEnd: (event) => {
                                this.afterDrag(event); // Call the afterDrag function after a drag and drop operation
                            },
                        })
                    }
                });
            },

            addEditProject(project) {
                setTimeout(() => {
                    this.params = {
                        id: null,
                        title: ''
                    };
                    if (project) {
                        this.params = JSON.parse(JSON.stringify(project));
                    }

                    this.isAddProjectModal = true;
                });
            },

            saveProject() {
                if (!this.params.title) {
                    this.showMessage('Title is required.', 'error');
                    return false;
                }

                if (this.params.id) {
                    //update project
                    const project = this.projectList.find((d) => d.id === this.params.id);
                    project.title = this.params.title;

                } else {
                    //add project
                    const lastId = this.projectList.length ? this.projectList.reduce((max, obj) => (obj.id > max ? obj.id : max), this.projectList[0].id) : 0;

                    const project = {
                        id: lastId + 1,
                        title: this.params.title,
                        tasks: [],
                    };
                    this.projectList.push(project);
                }

                this.initializeSortable();
                this.showMessage('Project has been saved successfully.');
                this.isAddProjectModal = false;
            },

            deleteProject(project) {
                this.projectList = this.projectList.filter((d) => d.id != project.id);
                this.showMessage('Project has been deleted successfully.');
            },

            clearProjects(project) {
                project.tasks = [];
            },

            // task
            addEditTask(projectId, task) {
                this.paramsTask = {
                    projectId: null,
                    id: null,
                    title: '',
                    description: '',
                    tags: ''
                };
                if (task) {
                    this.paramsTask = JSON.parse(JSON.stringify(task));
                    this.paramsTask.tags = this.paramsTask.tags ? this.paramsTask.tags.toString() : '';
                }
                this.paramsTask.projectId = projectId;
                this.isAddTaskModal = true;
            },

            saveTask() {
                if (!this.paramsTask.title) {
                    this.showMessage('Title is required.', 'error');
                    return false;
                }

                const project = this.projectList.find((d) => d.id === this.paramsTask.projectId);
                if (this.paramsTask.id) {
                    //update task
                    const task = project.tasks.find((d) => d.id === this.paramsTask.id);
                    task.title = this.paramsTask.title;
                    task.description = this.paramsTask.description;
                    task.tags = this.paramsTask.tags?.length > 0 ? this.paramsTask.tags.split(',') : [];
                } else {
                    //add task
                    let maxid = 0;
                    if (project.tasks?.length) {
                        maxid = project.tasks.reduce((max, obj) => (obj.id > max ? obj.id : max), project.tasks[0].id);
                    }

                    const today = new Date();
                    const dd = String(today.getDate()).padStart(2, '0');
                    const mm = String(today.getMonth()); //January is 0!
                    const yyyy = today.getFullYear();
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                    const task = {
                        projectId: this.paramsTask.projectId,
                        id: maxid + 1,
                        title: this.paramsTask.title,
                        description: this.paramsTask.description,
                        date: dd + ' ' + monthNames[mm] + ', ' + yyyy,
                        tags: this.paramsTask.tags?.length > 0 ? this.paramsTask.tags.split(',') : [],
                    };

                    project.tasks.push(task);
                }

                this.showMessage('Task has been saved successfully.');
                this.isAddTaskModal = false;
            },

            deleteConfirmModal(projectId, task) {
                this.selectedTask = task;
                setTimeout(() => {
                    this.isDeleteModal = true;
                }, 10);
            },

            deleteTask() {
                let project = this.projectList.find((d) => d.id === this.selectedTask.projectId);
                project.tasks = project.tasks.filter((d) => d.id != this.selectedTask.id);

                this.showMessage('Task has been deleted successfully.');
                this.isDeleteModal = false;
            },

            showMessage(msg = '', type = 'success') {
                const toast = window.Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 3000,
                });
                toast.fire({
                    icon: type,
                    title: msg,
                    padding: '10px 20px',
                });
            },

            getStatusScrumBoard(id){
                this.pretendenteID = id;
                fetch('application/pretendente/view/status/getStatus.php', {
                    method: 'POST',
                    body: JSON.stringify({id: id})
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("🚀 ~ getStatusScrumBoard ~ data:", data)
                        // Atualiza os dados da tabela com os dados filtrados
                        this.updateData(data);
                    })
                    .catch(error => {
                        console.error('Erro ao enviar o formulário:', error);
                    });
            }
        }));

    });
</script>
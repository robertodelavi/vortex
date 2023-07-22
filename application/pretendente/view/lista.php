<?php

$sql = "SELECT prw_codigo, prw_nome FROM pretendentes LIMIT 100";
$result = $data->find('dynamic', $sql);

// echo '---> '.$_SESSION['database'];
// echo '---> '.$_SESSION['unidade'];
// echo '---> '.$_SESSION['unidadeCidade'];
// var_dump($result);

$tableResult = [];
foreach ($result as $row) {
    $arrRow = [];
    array_push($arrRow, trim($row['prw_nome']));
    array_push($arrRow, trim($row['prw_codigo'] + 60));
    array_push($arrRow, 'Tozzo');
    array_push($arrRow, '2023-01-08');
    array_push($arrRow, 'r@gmail.com');
    array_push($arrRow, '3352-4671');
    array_push($arrRow, $row['prw_codigo']);
    //
    array_push($tableResult, $arrRow);
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

<div x-data="modal">
    <div class="flex h-screen gap-6">
        <!-- Filtros -->
        <div class="w-1/3">
            <!-- Bloco dos filtros -->
            <div class="panel h-full">
                <h5 class="mt-2 mb-5 font-semibold text-lg dark:text-white-light">
                    Filtros
                </h5>
                <div x-data="multipleTable" class="flex-1 "> <!-- Da acesso aos dados da tabela -->
                    <form x-on:submit="submitForm($event)" id="formFilter" class="space-y-4">
                        <div>
                            <label for="name">Nome</label>
                            <input id="name" name="name" type="text" placeholder="Ed. Fiorentin" class="form-input" />
                        </div>
                        <div>
                            <label for="profession">Profession</label>
                            <input id="profession" type="text" placeholder="Web Developer" class="form-input" />
                        </div>
                        <div>
                            <label for="country">Country</label>
                            <select id="country" class="form-select text-white-dark">
                                <option>All Countries</option>
                                <option selected="">United States</option>
                                <option>India</option>
                                <option>Japan</option>
                                <option>China</option>
                                <option>Brazil</option>
                                <option>Norway</option>
                                <option>Canada</option>
                            </select>
                        </div>
                        <div>
                            <label for="address">Address</label>
                            <input id="address" type="text" placeholder="New York" class="form-input" />
                        </div>
                        <div>
                            <label for="profession">Profession</label>
                            <input id="profession" type="text" placeholder="Web Developer" class="form-input" />
                        </div>
                        <div>
                            <label for="profession">Profession</label>
                            <input id="profession" type="text" placeholder="Web Developer" class="form-input" />
                        </div>
    
                        <div class="flex gap-2 mt-4">
                            <div class="">
                                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-secondary" x-on:click="limpaFiltros()">Limpar
                                    Filtros</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="w-2/3 ">
            <div x-data="multipleTable" class="panel h-full mt-0">
                <!-- Listagem -->
                <div class="flex justify-between items-center ">
                    <h5 class="font-semibold text-lg dark:text-white-light">
                        Pretendentes
                    </h5>
                    <div>                    
                        <button id="searchButton" class="btn btn-primary" @click="toggle;" >Novo</button>                    
                    </div>
                </div>
    
                <table id="myTable2" class="whitespace-nowrap"></table>
    
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

    <!-- Modal Status do Pretendente -->
    <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open2 && '!block'">
        <div class="flex items-start justify-center min-h-screen px-4"  @click.self="open2 = false">
            <div x-show="open2" x-transition x-transition.duration.300
                class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    <h5 class="font-bold text-lg">Status do Pretendente</h5>
                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle2">
                        <?php echo file_get_contents('application/icons/close.svg'); ?>
                    </button>
                </div>
                <div class="p-5">
                    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                    
                        <!-- Dados vindos do ajax -->
                        <div id="resultStatusScrumBoard"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/simple-datatables.js"></script>
<script>
    const arrData = <?php echo json_encode($tableResult); ?>;
    console.log("🚀 ~ arrData:", arrData);

    document.addEventListener("alpine:init", () => {
        Alpine.data("multipleTable", () => ({
            datatable2: null,
            isAddEventModal: false,
            idDelete: null,
            nomeDelete: null,

            init() {
                this.updateTableData(arrData);
            },

            updateTableData(data) {
                if (this.datatable2) {
                    this.datatable2.destroy();
                }

                this.datatable2 = new simpleDatatables.DataTable('#myTable2', {
                    data: {
                        headings: ['Name', 'Status', 'Company', 'Start Date', 'Email', 'Phone No.', 'Action'],
                        data: data
                    },
                    searchable: false,
                    perPage: 10,
                    perPageSelect: [10, 20, 30, 50, 100],
                    columns: [
                        {
                            select: 0,
                            render: (data, cell, row) => {
                                const id = row.cells[6].data
                                return `<div class="flex items-center w-max">
                                            <img class="w-9 h-9 rounded-full ltr:mr-2 rtl:ml-2 object-cover" src="<?php echo BASE_THEME_URL; ?>/assets/images/profile-${row.dataIndex + 1}.jpeg" />
                                            <a href="#" onClick="nextPage('?module=pretendente&acao=edita_pretendente', '${id}');" class="hover:text-primary">${id} - ${data}</a>
                                        </div>`;
                            }
                        },
                        {
                            select: 1,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[6].data
                                return `<div @click="toggle2; getStatusScrumBoard('${id}');" x-tooltip="Alterar o status do pretendente" data-placement="top" class="w-4/5 min-w-[100px] h-2.5 bg-[#ebedf2] dark:bg-dark/40 rounded-full flex cursor-pointer"> <div class="bg-${this.randomColor()} h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:${data}%"></div> </div>`;
                            },
                        },
                        {
                            select: 3,
                            render: (data, cell, row) => {
                                return this.formatDate(data);
                            },
                        },
                        {
                            select: 6,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[6].data
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
                        console.log('Dados retornados do ajax: ', data)
                        this.updateTableData(data);
                    })
                    .catch(error => {
                        console.error('Erro ao enviar o formulário:', error);
                    });
            },

            getStatusScrumBoard(id){
                // Faz a requisição AJAX para o arquivo PHP
                fetch('application/pretendente/view/statusScrumBoard.php', {
                    method: 'POST',
                    body: id
                })
                    .then(response => response.json())
                    .then(data => {
                        // Atualiza os dados da tabela com os dados filtrados
                        console.log('Dados retornados do ajax: ', data)
                        document.getElementById('resultStatusScrumBoard').innerHTML = data;
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
                document.getElementById("formFilter").reset();
                this.updateTableData(arrData);
            },

            confirmDelete(id, nome) {
                console.log("🚀 ~ confirmDelete ~ nome:", nome)
                this.isAddEventModal = true;
                this.idDelete = id;
                this.nomeDelete = nome;
            },

            deleteItem() {
                console.log('delete: ', this.idDelete)
                nextPage('?module=pretendente&acao=deletadados_pretendente', this.idDelete)
            },

        }));
    });
</script>
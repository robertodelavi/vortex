<?php
    $sql = '
    SELECT 
        pv.prv_codigo,
        pv.prv_pretendente,

        p.prw_nome AS pretendente, 
        CONCAT(ti.tpi_descricao, " - ", b.bai_descricao, " - ", c.cid_descricao, "/", c.cid_uf) AS imovel, 
        DATE_FORMAT(pv.prv_dataini, "%d/%m/%Y") AS dataIni,           
        IF(pv.prv_horaini <> "", CONCAT(SUBSTRING(pv.prv_horaini, 1, 2), ":", SUBSTRING(pv.prv_horaini, 3, 2)), "--") AS horaIni,
        DATE_FORMAT(pv.prv_datafim, "%d/%m/%Y") AS dataFim,
        IF(pv.prv_horafim <> "", CONCAT(SUBSTRING(pv.prv_horafim, 1, 2), ":", SUBSTRING(pv.prv_horafim, 3, 2)), "--") AS horaFim,        
        u.usu_nome AS entreguePor
    FROM pretendentesvisitas AS pv
        LEFT JOIN pretendentes AS p ON (pv.prv_pretendente = p.prw_codigo)
        LEFT JOIN imoveis AS i ON (pv.prv_imovel = i.imo_codigo)
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)    
        LEFT JOIN cidades AS c ON (i.imo_cidade = c.cid_codigo)
        LEFT JOIN sisusuarios AS u ON (pv.prv_entreguepor = u.usu_codigo)
    ORDER BY pv.prv_dataini DESC, pv.prv_horaini DESC
    LIMIT 100';
    $result = $data->find('dynamic', $sql);

    $tableResult = [];
    foreach ($result as $row) {
        $arrRow = [];
        array_push($arrRow, trim($row['pretendente']));    
        array_push($arrRow, trim($row['imovel'] ? $row['imovel'] : '--'));
        array_push($arrRow, trim($row['entreguePor'] ? $row['entreguePor'] : '--'));        
        array_push($arrRow, trim($row['dataIni'] ? $row['dataIni'] : '--'));
        array_push($arrRow, trim($row['horaIni'] ? $row['horaIni'] : '--'));
        array_push($arrRow, trim($row['dataFim'] ? $row['dataFim'] : '--'));
        array_push($arrRow, trim($row['horaFim'] ? $row['horaFim'] : '--'));
        array_push($arrRow, $row['prv_pretendente'].'-'.$row['prv_codigo']);        
        array_push($tableResult, $arrRow);
    }
?>

<div x-data="multipleTable">
    <div x-data="modal">
        <!-- Tela com filtro e tabela de listagem -->
        <div class="flex h-screen gap-4">
            <!-- Filtros -->
            <div class="w-1/5">
                <div class="panel h-full">
                    <h5 class="mt-2 mb-5 font-semibold text-lg dark:text-white-light">
                        Filtros
                    </h5>
                    <?php include_once('application/pretendente/view/visita/list/formFilter.php'); ?>
                </div>
            </div>

            <!-- Listagem -->
            <div class="w-full overflow-x-auto">
                <div class="panel h-full mt-0">
                    <div class="flex justify-between items-center ">
                        <h5 class="font-semibold text-lg dark:text-white-light">
                            Visitas
                        </h5>
                        <div>                    
                            <button id="searchButton" class="btn btn-primary" @click="toggle;" >Novo</button>                    
                        </div>
                    </div>                        
                    <table id="myTable2" class="tabela whitespace-nowrap"></table>            
                </div>
            </div>
        </div>  

        <!-- Modal marcar visita no imóvel -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open2 && '!block'">
            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open2 = false">
                <div x-show="open2" x-transition x-transition.duration.300
                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Marcar visita</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle2">
                            <?php echo file_get_contents('application/icons/close.svg'); ?>
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]"> 
                            <form method="POST" action="?module=pretendente&acao=grava_visitas">
                                <!-- Parâmetros -->
                                <input type="hidden" name="prv_pretendente" id="prv_pretendente" /> <!-- Setado na função JS -->
                                <input type="hidden" name="prv_empresa" value="<?php echo $_SESSION['v_emp_codigo']; ?>" />

                                <?php require_once('application/pretendente/view/visita/view/formVisita.php'); ?>

                                <div class="flex justify-end items-center mt-8">
                                    <button type="button" class="btn btn-outline-dark" @click="toggle2">Cancelar</button>
                                    <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle2">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    </div>
</div>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/simple-datatables.js"></script>
<script>
    const arrData = <?php echo json_encode($tableResult); ?>;
    console.log("🚀 ~ arrData:", arrData)
    
    document.addEventListener("alpine:init", () => {
        Alpine.data("multipleTable", () => ({
            datatable2: null,
            isAddEventModal: false,
            idDelete: null,
            nomeDelete: null,
            currentData: arrData,
            
            init() {
                this.updateTableData(arrData);
            },

            updateTableData(data) {
                console.log("🚀 ~ updateTableData: ", data)
                
                if (this.datatable2) {
                    this.datatable2.destroy();
                }

                this.datatable2 = new simpleDatatables.DataTable('#myTable2', {
                    data: {
                        headings: ['Nome do Pretendente', 'Imóvel', 'Entregue por', 'Data Início', 'Hora Início', 'Data Fim', 'Hora Fim', 'Ações'],
                        data: data
                    },
                    searchable: false,
                    perPage: 30,
                    perPageSelect: [10, 20, 30, 50, 100],
                    columns: [
                        {
                            select: 0,
                            render: (data, cell, row) => {
                                const id = row.cells[7].data
                                console.log("🚀 ~ id:", id )

                                return `
                                <div class="flex items-center w-max">
                                    <a href="#" onClick="nextPage('?module=pretendente&acao=edita_visitas', '${id}');" class="hover:text-primary">${data}</a>
                                </div>`;
                            }
                        },
                        {
                            select: 7,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[7].data
                                const nome = row.cells[0].data
                                //? id: prv_pretentente-prv_codigo (mas o id será usado pra passar o pretendente pra uma nova visita, entao envia somente pretendente)
                                const idPretendente = id.split('-')[0]
                                
                                return `
                                <div class="flex gap-4 items-center" >
                                    <button 
                                        type="button" 
                                        class="hover:text-primary" x-tooltip="Marcar visita" data-theme="primary" 
                                        @click="() => setPretendente('${idPretendente}');" >
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 transition-all group-hover:fill-warning">
                                        <path d="M5 1.25C5.41421 1.25 5.75 1.58579 5.75 2V3.08515L7.32358 2.77043C9.11678 2.41179 10.9756 2.58245 12.6735 3.26161L12.8771 3.34307C14.2919 3.90898 15.849 4.01466 17.3273 3.64509C18.5579 3.33744 19.75 4.2682 19.75 5.53669V12.9037C19.75 13.8922 19.0773 14.7538 18.1183 14.9935L17.9039 15.0471C15.9814 15.5277 13.9563 15.3903 12.1164 14.6543C10.6886 14.0832 9.12562 13.9397 7.61776 14.2413L5.75 14.6149V22C5.75 22.4142 5.41421 22.75 5 22.75C4.58579 22.75 4.25 22.4142 4.25 22V2C4.25 1.58579 4.58579 1.25 5 1.25ZM5.75 13.0851L7.32358 12.7704C9.11678 12.4118 10.9756 12.5825 12.6735 13.2616C14.2206 13.8805 15.9235 13.996 17.5401 13.5919L17.7545 13.5383C18.0457 13.4655 18.25 13.2039 18.25 12.9037V5.53669C18.25 5.24405 17.975 5.02933 17.6911 5.10031C15.9069 5.54635 14.0276 5.4188 12.32 4.73578L12.1164 4.65433C10.6886 4.08323 9.12562 3.93973 7.61776 4.2413L5.75 4.61485V13.0851Z" fill="currentColor"/>
                                    </svg>

                                    </button>

                                    <a href="#" onClick="nextPage('?module=pretendente&acao=edita_visitas', '${id}');" class="hover:text-info">
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
                fetch('application/pretendente/view/visita/list/filter.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        // Atualiza os dados da tabela com os dados filtrados
                        console.log('Dados retornados do ajax: ', data)
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
                    console.log('==> ', key, value)
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
                nextPage('?module=pretendente&acao=deleta_visitas', this.idDelete)
            },

            setPretendente(id) {
                console.log("🚀 ~ setPretendente:", id)
                document.getElementById("prv_pretendente").value = id;
                this.toggle2(); // abre modal
            }

        }));
    });
</script>
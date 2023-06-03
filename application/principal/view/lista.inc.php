<?php
$sql = "SELECT * FROM clientes LIMIT 30";
$result = $data->find('dynamic', $sql);

$tableResult = [];
foreach($result as $row){
    $arrRow = [];
    array_push($arrRow, trim($row['cli_nome']));
    array_push($arrRow, trim($row['usu_codigo'] + 60));
    array_push($arrRow, trim($row['cli_nome']));
    array_push($arrRow, trim($row['cli_nome']));
    array_push($arrRow, trim($row['cli_nome']));
    array_push($arrRow, trim($row['cli_nome']));
    array_push($arrRow, trim($row['cli_nome']));
    //
    array_push($tableResult, $arrRow);
}

// var_dump($tableResult);
// echo '<br><br><br>';
// var_dump($filteredData);

?>

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
                        <label for="name">Full Name</label>
                        <input id="name" type="text" placeholder="Jimmy Turner" class="form-input" />
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

                    <div class="flex gap-2 mt-4" >
                        <div class="">
                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                        </div>
                        <div class="">
                            <button type="button" class="btn btn-secondary" x-on:click="limpaFiltros()" >Limpar Filtros</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
    </div>
    
    <!-- Listagem -->
    <div class="w-2/3 ">
        <div x-data="multipleTable" class="panel h-full mt-0">
            <h5 class="md:absolute md:top-[25px] md:mb-0 mb-5 font-semibold text-lg dark:text-white-light">Clientes</h5>
            <table id="myTable2" class="whitespace-nowrap"></table>            
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
            init() {
                this.updateTableData(arrData);
            },

            updateTableData(data) {
                if (this.datatable2) {
                    this.datatable2.destroy();
                }
                
                this.datatable2 = new simpleDatatables.DataTable('#myTable2', {
                    data: {
                        headings: ['Name', 'Progress', 'Company', 'Start Date', 'Email', 'Phone No.', 'Action'],
                        data: data
                    },
                    searchable: true,
                    perPage: 10,
                    perPageSelect: [10, 20, 30, 50, 100],
                    columns: [
                        {
                            select: 0,
                            render: (data, cell, row) => {
                                return `<div class="flex items-center w-max"><img class="w-9 h-9 rounded-full ltr:mr-2 rtl:ml-2 object-cover" src="<?php echo BASE_THEME_URL; ?>/assets/images/profile-${row.dataIndex + 1}.jpeg" /><a href="?module=principal&acao=visualiza_principal">${data}</a></div>`;
                            },
                            sort: "asc"
                        },
                        {
                            select: 1,
                            sortable: false,
                            render: (data, cell, row) => {
                                return `<div class="w-4/5 min-w-[100px] h-2.5 bg-[#ebedf2] dark:bg-dark/40 rounded-full flex"> <div class="bg-${this.randomColor()} h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:${data}%"></div> </div>`;
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
                                return `<div class="flex items-center">
                                            <button type="button" x-on:click="editar(${row.rowIndex})" >
                                                EDITAR
                                            </button>
                                            <button type="button" x-tooltip="Delete">
                                                EXCLUIR
                                            </button>
                                        </div>`;
                            },
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
                
                // Faz a requisição AJAX para o arquivo PHP
                fetch('application/principal/view/filter.php', {
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

            limpaFiltros(){
                document.getElementById("formFilter").reset();
                this.updateTableData(arrData);
            },

            editar(row) {
                console.log('Clicou! ', row);
            }
        }));
    });
</script>
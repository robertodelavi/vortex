<?php 
    $sql = '
    SELECT 
        i.imo_codigo, 
        p.pes_nome1 AS proprietario,

        i.imo_quartos,
        i.imo_suites,
        i.imo_banheiros,
        i.imo_garagem,

        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor
    FROM imoveis AS i 
        JOIN pessoas AS p ON (i.imo_proprietario = p.pes_codigo)
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
    LIMIT 60';
    $result = $data->find('dynamic', $sql);

    $tableResult = [];
    foreach ($result as $row) {
        $arrRow = [];
        array_push($arrRow, $row['imo_codigo']);    
        array_push($arrRow, trim($row['proprietario']));   
        array_push($arrRow, $row['imo_quartos']);
        array_push($arrRow, $row['imo_suites']);
        array_push($arrRow, $row['imo_banheiros']);         
        array_push($arrRow, $row['imo_garagem']);
        array_push($arrRow, 'R$ '.number_format($row['imv_valor'], 2, ',', '.'));
        array_push($arrRow, $row['prw_codigo']);
        //
        array_push($tableResult, $arrRow);
    }
?>

<div x-data="dataImovel"> 
    <div :class="{'flex-col gap-4' : isMobile, 'flex h-screen gap-4' : !isMobile}" class="gap-3 relative">
        <!-- Filtros (desktop/mobile) -->
        <div :class="{'w-1/5' : !isMobile}" >
            <div class="panel h-full">
                <div class="flex items-center justify-between">
                    <p class="font-semibold text-lg dark:text-white-light">Filtros</p>
                    <!-- mobile -->
                    <button class="block sm:hidden btn btn-sm btn-outline-primary" @click="toggleFilter">
                        <?php echo file_get_contents('application/icons/filter.svg'); ?>
                    </button>                                      
                </div>
                <div x-show="openFilter || !isMobile" x-transition x-transition.duration.300 class="overflow-hidden mt-4" >
                    <form x-on:submit="submitFormFilter($event)" id="formFilter" >
                        <?php include('application/venda/view/imovel/list/filter/formFilter.php'); ?>                                            
                    </form>
                </div>
            </div>
        </div>  

        <!-- Listagem -->
        <div class="w-full panel" >     
            <div class="flex justify-between items-center ">
                <h5 class="font-semibold text-lg dark:text-white-light">
                    Imóveis
                </h5>
                <div>                    
                    <button class="btn btn-primary" @click="toggleNew;" >Novo</button>                    
                </div>
            </div>  
            <table id="myTable" class="tabela whitespace-nowrap"></table>   
        </div>
    </div>

    
    
</div>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/simple-datatables.js"></script>
<script>
    const defaultData = <?php echo json_encode($tableResult); ?>;
    document.addEventListener("alpine:init", () => {
        Alpine.data("dataImovel", () => ({
            isMobile:  window.innerWidth <= 640, // Define a largura limite para considerar como celular
            openFilter: false,
            datatable: null,
            openDelete: false,
            currentData: defaultData ?? [],

            // Tabela
            init(){
                this.updateTable(this.currentData);
            },

            updateTable(data){
                console.log("🚀 ~ updateTable: ", data)
                
                if (this.datatable) {
                    this.datatable.destroy();
                }

                this.datatable = new simpleDatatables.DataTable('#myTable', {
                    data: {
                        headings: ['ID', 'Proprietário', 'D', 'S', 'B', 'VG', 'Valor', 'Ações'],
                        data: data
                    },
                    searchable: false,
                    perPage: 50,
                    perPageSelect: [10, 20, 30, 50, 100],
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
                    columns: [
                        {
                            select: 0,
                            render: (data, cell, row) => {
                                const id = row.cells[0].data
                                return `<div class="flex items-center w-max">
                                            <a href="#" onClick="nextPage('?module=venda&acao=edita_imovel', '${id}');" class="hover:text-primary">${data}</a>
                                        </div>`;
                            }
                        },
                        {
                            select: 1,
                            render: (data, cell, row) => {
                                const id = row.cells[0].data
                                return `<div class="flex items-center w-max">
                                            <a href="#" onClick="nextPage('?module=venda&acao=edita_imovel', '${id}');" class="hover:text-primary">${data}</a>
                                        </div>`;
                            }
                        },
                        {
                            select: 7,
                            sortable: false,
                            render: (data, cell, row) => {
                                const id = row.cells[0].data
                                const nome = row.cells[1].data
                                
                                return `
                                <div class="flex gap-4 items-center" >
                                    <a href="#" onClick="nextPage('?module=venda&acao=edita_imovel', '${id}');" x-tooltip="Editar imóvel" data-theme="primary" class="hover:text-info">
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

                                    <button type="button" class="hover:text-danger" x-tooltip="Deletar imóvel" data-theme="danger" @click="() => confirmDelete('${data}', '${nome}')">
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
                    ]
                });

            },

            // Filtros
            toggleFilter() {
                this.openFilter = !this.openFilter;
            },
            submitFormFilter(event) {
                event.preventDefault();
                console.log('submit');
            },
            limpaFiltros() {
                document.getElementById('formFilter').reset();
            },

            // Deleta imóvel
            confirmDelete(id, nome) {
                this.openDelete = true;                
            },
           
        }));
    });
</script>
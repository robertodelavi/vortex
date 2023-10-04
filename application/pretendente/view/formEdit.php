<?php
$sql = '
SELECT p.prw_codigo, p.prw_nome, p.prw_telefones
FROM pretendentes AS p 
WHERE p.prw_codigo = ' . $_POST['param_0'];
$result = $data->find('dynamic', $sql);

// Verifica se tem perfis de busca
$sql = '
SELECT COUNT(*) AS qtd
FROM pretendentesperfil
WHERE ppf_pretendente = ' . $_POST['param_0'];
$resultPerfilBusca = $data->find('dynamic', $sql);

//? TOASTS
$currentTab = 'pretendente';
if(isset($_GET['tab'])){
    switch($_GET['tab']){
        case 1:
            echo '
            <script>
                setTimeout(() => {
                    toast("Dados do pretendente atualizados com sucesso!", "success", 3000);
                }, 300);
            </script>';
            $currentTab = 'pretendente';
        break;
        case 2:
            echo '
            <script>
                setTimeout(() => {
                    toast("Perfil de busca atualizado com sucesso!", "success", 3000);
                }, 300);
            </script>';
            $currentTab = 'perfis';
        break;
        case 3:
            echo '
            <script>
                setTimeout(() => {
                    toast("Histórico de atendimento atualizado com sucesso!", "success", 3000);
                }, 300);
            </script>';
            $currentTab = 'historico-atendimentos';
        break;
        case 4:
            echo '
            <script>
                setTimeout(() => {
                    toast("Visita cadastrada com sucesso!", "success", 3000);
                }, 300);
            </script>';
            $currentTab = 'imoveis';
        break;
        case 5:
            echo '
            <script>
                setTimeout(() => {
                    toast("Visita atualizada com sucesso!", "success", 3000);
                }, 300);
            </script>';
            $currentTab = 'visita';
        break;
    }
}

?>

<link rel='stylesheet' type='text/css' media='screen' href='<?php echo BASE_THEME_URL; ?>/assets/css/fancybox.css'>
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/fancybox.umd.js"></script>

<div class="overflow-y-auto" x-data="lightbox">
    <div x-data="modal" >
        <div >
            <div class="pt-0">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p>Pretendente</p>
                        <h5 class="font-semibold text-lg dark:text-white-light "><?php echo $result[0]['prw_nome']; ?></h5>
                        
                    </div>

                    <div>
                        <button type="button" onclick="nextPage('?module=pretendente&acao=lista_pretendente', '');" class="btn btn btn-outline-dark">
                            <?php echo file_get_contents('application/icons/voltar.svg'); ?>
                            <span class="hidden sm:block">Voltar</span>
                        </button>   
                    </div>
                </div>
            
                <!-- ABAS -->
                <div x-data="{tab: '<?php echo $currentTab; ?>'}">
                    <ul
                        class="sm:flex font-semibold border-b border-[#ebedf2] dark:border-[#191e3a] mb-5 whitespace-nowrap overflow-y-auto">
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                                :class="{'!border-primary text-primary' : tab == 'pretendente'}" @click="tab='pretendente'">
            
                                <?php echo file_get_contents('application/icons/pessoa2.svg'); ?>
                                <span class="hidden sm:block">Dados Gerais</span>
                            </a>
                        </li>
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                                :class="{'!border-primary text-primary' : tab == 'perfis'}" @click="tab='perfis'">
            
                                <?php echo file_get_contents('application/icons/perfis.svg'); ?>
                                <span class="hidden sm:block">Perfis de Busca</span>
                            </a>
                        </li>
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                                :class="{'!border-primary text-primary' : tab == 'historico-atendimentos'}"
                                @click="tab='historico-atendimentos'">
            
                                <?php echo file_get_contents('application/icons/historico.svg'); ?>
                                <span class="hidden sm:block">Histórico de Atendimentos</span>
                            </a>
                        </li>
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                                :class="{'!border-primary text-primary' : tab == 'imoveis'}" @click="setVisualizationMode(); tab='imoveis'"
                                onClick="">
                                <?php echo file_get_contents('application/icons/imoveis.svg'); ?>
                                <span class="hidden sm:block">Imóveis</span>
                            </a>
                        </li>
                        <li class="inline-block">
                            <a href="javascript:;"
                                class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                                :class="{'!border-primary text-primary' : tab == 'visita'}" @click="tab='visita'" >
                                <?php echo file_get_contents('application/icons/flag.svg'); ?>
                                <span class="hidden sm:block">Visita</span>
                            </a>
                        </li>
                    </ul>
            
                    <!-- DADOS DO PRETENDENTE -->
                    <template x-if="tab === 'pretendente'">
                        <form method="POST" action="?module=pretendente&acao=updatedados_pretendente" class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
                            <div class="flex justify-between mb-4">
                                <div>
                                    <h5 class="text-lg font-semibold">Dados Gerais</h5>
                                </div>    
                                <div>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>            
                            </div>   
                            
                            <input type="hidden" name="prw_codigo" value="<?php echo $_POST['param_0']; ?>" />
                            
                            <?php include_once('application/pretendente/view/dadosPretendente/formDadosPretendente.php'); ?>
                        </form>
                    </div>
                    </template>
            
                    <!-- PERFIS DE BUSCA -->        
                    <template x-if="tab === 'perfis'"> 
                        <?php include_once('application/pretendente/view/perfilBusca/lista.php'); ?>
                    </template>
            
                    <!-- HISTÓRICO DE ATENDIMENTOS -->
                    <template x-if="tab === 'historico-atendimentos'">
                        <?php include_once('application/pretendente/view/historicoAtendimentos/lista.php'); ?>
                    </template>
            
                    <!-- IMÓVEIS -->
                    <template x-if="tab === 'imoveis'"> 
                        
                        <!-- Se tem perfil de busca, mostra os imóveis sugeridos -->
                        <?php 
                        if($resultPerfilBusca[0]['qtd'] > 0){                             
                        ?>                              
                            <form x-on:submit="submitForm($event)" id="formFilterId" >
                                <div :class="{'flex-col' : isMobile, 'flex' : !isMobile}" class="gap-3 relative">                
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
                                                <?php include('application/pretendente/view/imoveis/formFilter.php'); ?>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full " >     
                                        <!-- Imóveis vindo do ajax -->
                                        <div class="relative" id="resulAjaxImoveis"></div>   
                                        <table id="tableImoveis" class="tabela whitespace-nowrap"></table>
                                    </div>
                                    <!-- Botão com modo de exibição (tabela/grid/list) -->
                                    <div class="hidden sm:block absolute right-0 top-0">
                                        <div class="flex gap-1 ">
                                            <button type="button" x-tooltip="Visualização em Tabela" data-theme="primary" class="btn" :class="{'btn-primary' : modeView == 'table', 'btn-outline-primary' : modeView != 'table'}" @click="setModeView('table')">
                                                <?php echo file_get_contents('application/icons/table.svg'); ?>
                                            </button>
                                            <button type="button" x-tooltip="Visualização em Grade" data-theme="primary" class="btn" :class="{'btn-primary' : modeView == 'grid', 'btn-outline-primary' : modeView != 'grid'}" @click="setModeView('grid')">
                                                <?php echo file_get_contents('application/icons/grid.svg'); ?>
                                            </button>
                                            <button type="button" x-tooltip="Visualização em Lista" data-theme="primary" class="btn" :class="{'btn-primary': modeView == 'list', 'btn-outline-primary' : modeView != 'list'}" @click="setModeView('list')">
                                                <?php echo file_get_contents('application/icons/list.svg'); ?>
                                            </button>
                                        </div>
                                    </div>                                    
                                </div>                             
                            </form>                        
                        <?php 
                        }
                        // Se não tem perfil de busca, mostra mensagem de que não tem perfil de busca
                        if($resultPerfilBusca[0]['qtd'] == 0){ ?>
                            <div class="flex items-start min-h-screen mt-4">
                                <div class="">                                                                  
                                    <span class="ltr:pr-2 rtl:pl-2 flex items-center gap-2 mb-4 ">
                                        <?php echo file_get_contents('application/icons/warning.svg'); ?>
                                        Não há perfil de busca cadastrado para este pretendente.
                                    </span>
                                    <a href="javascript:;" class="text-primary hover:text-primary-dark/70" @click="tab='perfis'">
                                        <button type="button" class="btn btn-primary">
                                            Cadastrar perfil de busca
                                        </button>                                        
                                    </a>                                
                                </div>
                                
                            </div>
                        <?php 
                        }
                        ?>
                    </template>

                    <!-- VISITA -->        
                    <template x-if="tab === 'visita'"> 
                        <?php include_once('application/pretendente/view/visita/lista.php'); ?>
                    </template>
                </div>
            </div>
        </div>

        <!-- Modal visualizar imóvel -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="open && '!block'">
            <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
                <div x-show="open" x-transition x-transition.duration.300
                    class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-5xl my-10">
                    <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                        <h5 class="font-bold text-lg">Imóvel</h5>
                        <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                            <?php echo file_get_contents('application/icons/close.svg'); ?>
                        </button>
                    </div>
                    <div class="p-5">
                        <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]"> 
                            <!-- Imóveis vindo do ajax -->
                            <div id="resultAjaxGetImovel"></div>      
                        </div>
                    </div>
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
                            <div id="resulAjaxFormVisita"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BASE_THEME_URL; ?>/assets/js/simple-datatables.js"></script>
<script>
    //* GLOBAL: mode view (grid ou list)
    let modeView = '<?php echo $_GET['mode'] != '' ? $_GET['mode'] : 'table'; ?>';
    
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

    const getImovel = (id) => {
        var data = {
            id: id
        };

        fetch('application/pretendente/view/imoveis/getImovel.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            // Seta resultado do ajax na div
            document.getElementById('resultAjaxGetImovel').innerHTML = data;
        })
    }
    
    //* Perfil de busca
    const openModalEditPerfil = (ppf_pretendente, ppf_codigo) => {        
        if (ppf_pretendente) {
            fetch('application/pretendente/view/perfilBusca/formPerfilBusca.php', {
                method: 'POST',
                body: JSON.stringify({ 
                    action: (ppf_pretendente > 0 && ppf_codigo > 0 ? '?module=pretendente&acao=update_pretendente' : '?module=pretendente&acao=grava_pretendente'), 
                    ppf_pretendente: ppf_pretendente, 
                    ppf_codigo: ppf_codigo 
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                // Seta resultado do ajax na div
                document.getElementById('resulAjaxPerfilBusca').innerHTML = data;
            });
        }
    }

    //* Histórico de atendimentos
    const openModalEditHistoricoAtendimento = (prh_pretendente, prh_codigo) => {
        if(prh_pretendente){
            const data = { 
                action: (prh_pretendente > 0 && prh_codigo > 0 ? '?module=pretendente&acao=updatehistorico_pretendente' : '?module=pretendente&acao=gravahistorico_pretendente'), 
                prh_pretendente: parseInt(prh_pretendente), 
                prh_codigo: parseInt(prh_codigo) 
            }
            console.log("🚀 ~ openModalEditHistoricoAtendimento ~ data:", data)
            fetch('application/pretendente/view/historicoAtendimentos/formHistoricoAtendimento.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                // Seta resultado do ajax na div
                document.getElementById('resulAjaxHistoricoAtendimento').innerHTML = data;
            });
        }        
    }

    //* Visita 
    const openModalFormVisita = (prv_codigo, imo_codigo) => {
        if(imo_codigo){
            const data = { 
                action: prv_codigo ? '?module=pretendente&acao=updatevisita_pretendente' : '?module=pretendente&acao=gravavisita_pretendente', 
                prv_codigo: prv_codigo,
                imo_codigo: imo_codigo,
                prv_pretendente: '<?php echo $_POST['param_0']; ?>',
                prv_empresa: '<?php echo $_SESSION['v_emp_codigo']; ?>'
            }
            fetch('application/pretendente/view/visita/formVisita.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                // Seta resultado do ajax na div
                document.getElementById('resulAjaxFormVisita').innerHTML = data;
            });
        }        
    }

    //* Delete Perfil de busca
    let globalPpfPretendente = null
    let globalPpfCodigo = null
    const setDeleteId = (ppf_pretendente, ppf_codigo) => {
        globalPpfPretendente = ppf_pretendente
        globalPpfCodigo = ppf_codigo
    }
    const deletePerfilBusca = () => {
        nextPageArray('?module=pretendente&acao=deleta_pretendente', [globalPpfPretendente, globalPpfCodigo])
    }   

    //* LightBox da visualização do imóvel
    document.addEventListener("alpine:init", () => {
        Alpine.data("lightbox", () => ({
            allcontrols: 1,
            items: [],
            openFilter: false,
            openShare: false,
            openShareImovel: false,
            indexShare: null,
            modeView: modeView,
            sortDirection: null,
            tableFilters: null,
            visibleShare: {
                mode: null,
                id: null // id do imóvel
            },
            // table imoveis
            tableImoveis: null,
            currentTableImoveis: [],
            isMobile: window.innerWidth <= 640, // Define a largura limite para considerar como celular

            init() {
                this.getImoveis(this.tableFilters, this.modeView, null)
            },

            // detectar atualização da tabela, ou quando ordena ou filtra
            setVisualizationMode() {
                const mode = this.isMobile ? 'grid' : 'table';
                this.modeView = mode
                this.toggleVisibleShare(null, null) // fecha bloco compartilhar
                this.getImoveis(this.tableFilters, mode, null);
            },

            toggleShareImovel(){
                this.openShareImovel = !this.openShareImovel
            },

            //? NEW
            toggleVisibleShare(mode, id) {
                this.openShare = !this.openShare
                this.visibleShare.mode = mode;
                this.visibleShare.id = id;
                console.log('toggleVisibleShare: ', this.openShare, this.visibleShare)
            },

            getColumnBdName(columnNumber){
                let column = null
                switch(columnNumber){
                    case 1:
                        column = 'i.imo_codigo'
                    break;
                    case 2:
                        column = 'i.imo_tipoimovel'
                    break;
                    case 3:
                        column = 'b.bai_descricao'
                    break;
                    case 4:
                        column = 'i.imo_banheiros'
                    break;
                    case 5:
                        column = 'i.imo_quartos'
                    break;
                    case 6:
                        column = 'i.imo_suites'
                    break;
                    case 7:
                        column = 'i.imo_garagem'
                    break;
                    case 8:
                        column = 'i.imo_areaconstruida'
                    break;
                    case 9:
                        column = 'iv.imv_valor'
                    break;
                }
                return column
            },

            sortTableImoveis(column, direction) {
                column = this.getColumnBdName(column)
                direction = this.sortDirection == 'asc' ? 'desc' : 'asc'
                this.sortDirection = direction
                console.log("🚀 ~ sortTableImoveis: ", column, direction)                
                this.getImoveis(this.tableFilters, this.modeView, { column: column, direction: direction })
            },

            updateTableImoveis(data) {
                console.log("🚀 ~ updateTable ~ data:", data)
                if (this.tableImoveis) {
                    this.tableImoveis.destroy();
                }

                this.toggleVisibleShare(null, null) // fecha bloco compartilhar                
                
                this.tableImoveis = new simpleDatatables.DataTable("#tableImoveis", {
                    data: {
                        headings: [
                            'Foto',
                            'Código',
                            'Tipo',
                            'Bairro',
                            'B',
                            'D',
                            'S',
                            'VG',
                            'Área construída',
                            'Valor',
                            'Ações'
                        ],
                        data: data
                    },
                    searchable: false,
                    perPage: 20,
                    firstLast: true,
                    firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                    
                    layout: {
                        top: "{search}",
                        bottom: "{info}{pager}",
                    },
                    
                    // locale pt-br
                    labels: {
                        placeholder: "Pesquisar...",
                        perPage: "{select}",
                        noRows: "Nenhum registro encontrado",
                        info: "Mostrando {start} até {end} de {rows} registros",
                        infoEmpty: "Mostrando 0 até 0 de 0 registros",
                        infoFiltered: "(Filtrados de {total} registros)",
                        search: "Pesquisar:",
                        filter: "Filtrar:",
                        first: "Primeiro",
                        last: "Último",
                        previous: "Anterior",
                        next: "Próximo",
                    },
                });

                // Armazena uma referência ao contexto do Vue
                const self = this;

                //? Detecta click em cada coluna da tabela pra mandar a coluna pra uma função poder ordenar
                this.tableImoveis.on('datatable.sort', function (column, direction) {
                    self.sortTableImoveis(column, direction)                    
                });
            },

            verifyFilters(objFilters){
                // varre objeto e se todos os valores forem "", retorna null
                let filters = null
                if(objFilters){
                    console.log('entrou 1')
                    for(let [key, value] of Object.entries(objFilters)){
                        console.log('entrou 2: ', value)
                        if(value != ""){
                            console.log('entrou 3')
                            filters = objFilters
                        }
                    }
                }
                console.log("🚀 ~ verifyFilters:", filters)
                return filters
            },
           
            //* Atualiza imoveis sugeridos pro pretendente
            getImoveis(filters = null, mode = 'table', sort = null){
                console.log("🚀 ~ antes filters:", filters)
                var data = {
                    pretendente: <?php echo $_POST['param_0']; ?>,
                    mode: mode,
                    filters: this.verifyFilters(filters),
                    sortColumn: sort?.column,
                    sortDirection: sort?.direction
                };
                this.tableFilters = filters
                console.log("🚀 ~ getImoveis: ", data)
                
                // ? Loading
                setTimeout(() => {                    
                    document.getElementById('resulAjaxImoveis').innerHTML = '<div class="flex justify-center items-start min-h-screen mt-4"><div class="flex flex-col items-center"><span class="animate-spin border-4 border-primary border-l-transparent rounded-full w-12 h-12 mb-5"></span><p class="text-white-dark">Buscando imóveis pro seu perfil...</p></div></div>'                
                }, 30);

                fetch('application/pretendente/view/imoveis/getImoveis.php', {
                    method: 'POST',
                    body: JSON.stringify(data) // Converte o objeto em uma string JSON
                }).then(response => response.json()).then(data => {
                    if(mode == 'table'){ //? É tabela, resultado vem em json e monta a tabela aqui com Alpine.js
                        document.getElementById('resulAjaxImoveis').innerHTML = '<p class="font-semibold text-lg dark:text-white-light mt-3 mb-0">Imóveis</p>';      
                        document.getElementById('tableImoveis').style.display = 'block';                                              
                        //? Atualiza tabela de dados com o resultado vindo do ajax
                        this.updateTableImoveis(data)                                            
                    }else{              //? Não é tabela, resultado vem montado via ajax               
                        document.getElementById('resulAjaxImoveis').innerHTML = data;
                        document.getElementById('tableImoveis').style.display = 'none';
                        this.updateTableImoveis(null)                        
                    }
                })
            },

            //* Favoritar
            setFavorite(action, id){
                var data = {
                    action: action,
                    id: id,
                    pretendente: <?php echo $_POST['param_0']; ?>
                };
                if(data){
                    fetch('application/pretendente/view/imoveis/setFavorite.php', {
                        method: 'POST',
                        body: JSON.stringify(data) // Converte o objeto em uma string JSON
                    }).then(response => response.json()).then(data => {
                        setTimeout(() => {
                            this.getImoveis(this.tableFilters, modeView, null)
                        }, 300);
            
                        action ? toast('Imóvel favoritado com sucesso!', 'warning', 3000) : toast('Imóvel desfavoritado com sucesso!', '', 3000)
                    }).catch(error => {
                        console.error('Erro ao enviar dados:', error);
                    });
                }        
            },

            copyLink(id){
                this.toggleVisibleShare(null, null)

                let url = this.getUrlImovel(id)                
                var data = {
                    id: id,
                    emp_codigo: '<?php echo $_SESSION['v_emp_codigo']; ?>'
                };
                fetch('application/pretendente/view/imoveis/getImovelThumb.php', {
                    method: 'POST',
                    body: JSON.stringify(data) // Converte o objeto em uma string JSON
                }).then(response => response.json()).then(data => {
                    url += `?emp=${encodeURIComponent(data.emp)}&id=${encodeURIComponent(id)}&titulo=${encodeURIComponent(data.titulo)}&desc=${encodeURIComponent(data.desc)}&img=${data.img}`;
                    
                    navigator.clipboard.writeText(url)
                    this.openShare = false
                    toast('Link copiado!', 'success', 3000)
                })
            },

            shareWhatsapp(id, whatsapp){
                this.toggleVisibleShare(null, null)

                let url = this.getUrlImovel(id)
                var data = {
                    id: id,
                    emp_codigo: '<?php echo $_SESSION['v_emp_codigo']; ?>'
                };
                fetch('application/pretendente/view/imoveis/getImovelThumb.php', {
                    method: 'POST',
                    body: JSON.stringify(data) // Converte o objeto em uma string JSON
                }).then(response => response.json()).then(data => {
                    url = encodeURIComponent(`${url}?emp=${data.emp}&id=${id}&titulo=${encodeURIComponent(data.titulo)}&desc=${encodeURIComponent(data.desc)}&img=${encodeURIComponent(data.img)}`);
                    
                    window.open(`https://api.whatsapp.com/send?phone=55${whatsapp}&text=${url}`, '_blank')
                    this.openShare = false
                })
            },

            getUrlImovel(id){
                const emp_codigo = '<?php echo $_SESSION['v_emp_codigo']; ?>';
                return `https://vegax.com.br/vortex/imovel/detalhes`;                
            },

            toggleFilter() {
                this.openFilter = !this.openFilter;
            },

            setModeView(mode) {
                console.log("🚀 ~ setModeView ~ mode:", mode)
                modeView = mode
                this.modeView = mode
                this.getImoveis(this.tableFilters, mode, null)            
            },

            getImovelPhotos(id){
                if(id && id > 0){
                    fetch('application/pretendente/view/imoveis/getImovelPhotos.php', {
                        method: 'POST',
                        body: JSON.stringify({ id: id }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(response => response.json()).then(data => {
                        this.items = data
                    });
                }
            },

            getItems() {
                return this.items
            },

            bindFancybox() {
                if (this.allcontrols == 1) {
                    Fancybox.bind('[data-fancybox="gallery"]', {
                        Carousel: {
                            Navigation: {
                                prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 5l-7 7 7 7"/><path d="M4 12h16"/></svg>',
                                nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>',
                            },
                        },
                    });
                } else if (this.allcontrols == 2) {
                    Fancybox.bind('[data-fancybox="gallery"]', {
                        Carousel: {
                            Navigation: {
                                prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 5l-7 7 7 7"/><path d="M4 12h16"/></svg>',
                                nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>',
                            },
                        },
                        Thumbs: false,
                        Toolbar: false,
                        closeButton: "top",
                    });
                }
            },

            //* Filtros da barra lateral
            submitForm(event) {
                console.log('NO FORMMM')
                event.preventDefault();
                const formData = new FormData(event.target);
                const filters = {};
                for (let [key, value] of formData.entries()) {
                    console.log("🚀 ~ submitForm ~ key, value", key, value)
                    filters[key] = value;
                }                
                console.log("🚀 ~ submit filters:", filters)
                this.tableFilters = filters                
                this.getImoveis(filters, this.modeView, null)
            },

            limpaFiltros() {
                document.querySelectorAll('select').forEach((select) => {
                    select.selectedIndex = 0;
                })
                document.getElementById('formFilterId').reset();   
                console.log('limpaFiltros')
                this.tableFilters = null             
                this.getImoveis(null, this.modeView, null)
            }            
        }));
    }); 

</script>
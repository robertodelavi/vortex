<?php
$sql = '
SELECT p.prw_codigo, p.prw_nome
FROM pretendentes AS p 
WHERE p.prw_codigo = ' . $_POST['param_0'];
$result = $data->find('dynamic', $sql);

// Verifica se tem perfis de busca
$sql = '
SELECT COUNT(*) AS qtd
FROM pretendentesperfil
WHERE ppf_pretendente = ' . $_POST['param_0'];
$resultPerfilBusca = $data->find('dynamic', $sql);

// TOASTS
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
    }
}

?>

<link rel='stylesheet' type='text/css' media='screen' href='<?php echo BASE_THEME_URL; ?>/assets/css/fancybox.css'>
<script src="<?php echo BASE_THEME_URL; ?>/assets/js/fancybox.umd.js"></script>

<div x-data="lightbox">
    <div x-data="modal" >
        <div class="pt-0">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p>Pretendente</p>
                    <h5 class="font-semibold text-lg dark:text-white-light "><?php echo $result[0]['prw_nome']; ?></h5>
                </div>

                <div>
                    <button type="button" onclick="nextPage('?module=pretendente&acao=lista_pretendente', '');" class="btn btn btn-outline-dark">
                        <?php echo file_get_contents('application/icons/voltar.svg'); ?>
                        Voltar
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
                            Dados do Pretendente
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'perfis'}" @click="tab='perfis'">
        
                            <?php echo file_get_contents('application/icons/perfis.svg'); ?>
                            Perfis de Busca
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'historico-atendimentos'}"
                            @click="tab='historico-atendimentos'">
        
                            <?php echo file_get_contents('application/icons/historico.svg'); ?>
                            Histórico de Atendimentos
                        </a>
                    </li>
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'imoveis'}" @click="tab='imoveis'"
                            onClick="getImoveis()">
                            <?php echo file_get_contents('application/icons/imoveis.svg'); ?>
                            Imóveis
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
                        <div class="flex h-screen gap-3">                
                            <div class="w-1/5">
                                <!-- Bloco dos filtros -->
                                <div class="panel h-full">
                                    <h5 class="mt-2 mb-5 font-semibold text-lg dark:text-white-light">
                                        Filtros
                                    </h5>
                                    <?php require_once('application/pretendente/view/imoveis/formFilter.php'); ?>
                                </div>
                            </div>
                            <div class="w-full">
                                <!-- Imóveis vindo do ajax -->
                                <div id="resulAjaxImoveis"></div>    
                            </div>
                        </div>     
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
                            <form method="POST" action="?module=pretendente&acao=gravavisita_pretendente">
                                <!-- Parâmetros -->
                                <input type="hidden" name="prv_pretendente" value="<?php echo $_POST['param_0']; ?>" />
                                <input type="hidden" name="prv_imovel" id="prv_imovel" value="0" /> <!-- Seta id do imóvel na função JS setVisit  -->
                                <input type="hidden" name="prv_empresa" value="<?php echo $_SESSION['v_emp_codigo']; ?>" />

                                <!-- Mensagem -->
                                <div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
                                    <span class="ltr:pr-2 rtl:pl-2">Marcar uma visita para este imóvel.</span>
                                </div>

                                <div class="mt-5" >
                                    <div class="flex flex-col sm:flex-row">
                                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="nome">Acompanhante do pretendente</label>
                                                <input name="prv_acompanhantepretendente" type="text" class="form-input" />
                                            </div>

                                            <div>
                                                <label for="formaContato">Acompanhante da empresa</label>
                                                <select name="prv_acompanhante" class="form-select">
                                                    <option>-- Selecione --</option>
                                                    <?php 
                                                        $sql = '
                                                        SELECT * 
                                                        FROM sisusuarios
                                                        WHERE usu_ativado = "s"
                                                        ORDER BY usu_nome ASC';
                                                        $profissionais = $data->find('dynamic', $sql);
                                                        // Percorre os profissionais
                                                        foreach ($profissionais as $key => $value) {
                                                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="nome">Início da visita</label>
                                                <div class="flex gap-4 ">
                                                    <input name="prv_dataini" type="date" class="form-input" value="<?php echo date('Y-m-d'); ?>" />
                                                    <input name="prv_horaini" type="time" class="form-input" /> 
                                                </div>
                                            </div>

                                            <div>
                                                <label for="formaContato">Chave entregue por</label>
                                                <select name="prv_entreguepor" class="form-select">
                                                    <option>-- Selecione --</option>
                                                    <?php 
                                                        foreach ($profissionais as $key => $value) {
                                                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="nome">Fim da visita (entrega da chave)</label>
                                                <div class="flex gap-4 ">
                                                    <input name="prv_datafim" type="date" class="form-input" value="<?php echo date('Y-m-d'); ?>" />
                                                    <input name="prv_horafim" type="time" class="form-input" /> 
                                                </div>
                                            </div>

                                            <div>
                                                <label for="formaContato">Chave devolvida por</label>
                                                <select name="prv_devolvidopor" class="form-select">
                                                    <option>-- Selecione --</option>
                                                    <?php 
                                                        foreach ($profissionais as $key => $value) {
                                                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-1 mt-5">
                                        <div>
                                            <label for="nome">Observação</label>
                                            <textarea name="prv_obs" class="form-input" rows="3"></textarea>                    
                                        </div>
                                    </div>
                                </div>

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
    </div>
</div>

<script>
    //* IMOVEIS    
    //* Atualiza imoveis sugeridos pro pretendente
    const getImoveis = (filters = null) => {
        var data = {
            pretendente: <?php echo $_POST['param_0']; ?>,
            filters: filters
        };
        console.log("🚀 ~ getImoveis ~ data:", data)

        //? Loading
        setTimeout(() => {
            document.getElementById('resulAjaxImoveis').innerHTML = '<div class="flex justify-center items-start min-h-screen mt-4"><div class="flex flex-col items-center"><span class="animate-spin border-4 border-primary border-l-transparent rounded-full w-12 h-12 mb-5"></span><p class="text-white-dark">Buscando imóveis pro seu perfil...</p></div></div>'
        }, 30);

        fetch('application/pretendente/view/imoveis/getImoveis.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            // Seta resultado do ajax na div
            console.log('🚀 ~ getImoveis ~ data', data)
            document.getElementById('resulAjaxImoveis').innerHTML = data;
        })
    }
    getImoveis()

    const getImovel = (id) => {
        console.log('getImovel')
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
    
    //* Seta id do imóvel pra visita 
    const setVisit = (id) => {
        document.getElementById('prv_imovel').value = id
    }

    //* Favoritar
    const setFavorite = (action, id) => {
        var data = {
            action: action,
            id: id,
            pretendente: <?php echo $_POST['param_0']; ?>
        };
        if(data){
            console.log("🚀 ~ setFavorite ~ data:", data)
            fetch('application/pretendente/view/imoveis/setFavorite.php', {
                method: 'POST',
                body: JSON.stringify(data) // Converte o objeto em uma string JSON
            }).then(response => response.json()).then(data => {
                console.log('Dados retornados do ajax: ', data)
    
                setTimeout(() => {
                    getImoveis() // Atualiza listagem dos imóveis
                }, 300);
    
                action ? toast('Imóvel favoritado com sucesso!', 'warning', 3000) : toast('Imóvel desfavoritado com sucesso!', '', 3000)
            }).catch(error => {
                console.error('Erro ao enviar dados:', error);
            });
        }
        
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
            fetch('application/pretendente/view/historicoAtendimentos/formHistoricoAtendimento.php', {
                method: 'POST',
                body: JSON.stringify({ 
                    action: (prh_pretendente > 0 && prh_codigo > 0 ? '?module=pretendente&acao=updatehistorico_pretendente' : '?module=pretendente&acao=gravahistorico_pretendente'), 
                    prh_pretendente: prh_pretendente, 
                    prh_codigo: prh_codigo 
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                // Seta resultado do ajax na div
                document.getElementById('resulAjaxHistoricoAtendimento').innerHTML = data;
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

            getImovelPhotos(id){
                if(id && id > 0){
                    // faz fetch com arquivo php que retorna as fotos do imóvel e seta no array items
                    fetch('application/pretendente/view/imoveis/getImovelPhotos.php', {
                        method: 'POST',
                        body: JSON.stringify({ id: id }),
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }).then(response => response.json()).then(data => {
                        console.log('🚀 ~ getImovelPhotos ~ data', data)
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
                event.preventDefault();

                const formData = new FormData(event.target);
                const filters = {};
                for (let [key, value] of formData.entries()) {
                    filters[key] = value;
                    console.log('===> ', key, value);
                }                
                
                getImoveis(filters)
            },

            limpaFiltros() {
                document.getElementById("formFilter").reset();
                getImoveis()
            },
        }));
    }); 

</script>
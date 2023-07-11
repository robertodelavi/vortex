<?php
// Perfis de busca
$sql = '
SELECT * 
FROM pretendentesperfil AS pp
    LEFT JOIN tipoimovel AS ti ON (pp.ppf_tipoimovel = ti.tpi_codigo)
WHERE ppf_pretendente = ' . $_POST['param_0'];
$perfis = $data->find('dynamic', $sql);

// var_dump($perfis);

// TOASTS
if(isset($_GET['tab'])){
    switch($_GET['tab']){
        case 1:
            echo '
            <script>
                setTimeout(() => {
                    toast("Dados do pretendente atualizados com sucesso!", "success", 3000);
                }, 300);
            </script>';
        break;
        case 2:
            echo '
            <script>
                setTimeout(() => {
                    toast("Perfil de busca atualizado com sucesso!", "success", 3000);
                }, 300);
            </script>';
        break;
    }
}

?>

<div x-data="modal" >
    <div class="pt-0">
        <div class="flex items-center justify-between mb-5">
            <h5 class="font-semibold text-lg dark:text-white-light">Detalhes do Cliente</h5>
        </div>
    
        <!-- ABAS -->
        <div x-data="{tab: <?php echo isset($_GET['tab']) && $_GET['tab'] == 2 ? '\'perfis\'' : '\'pretendente\'' ?>}">
            <ul
                class="sm:flex font-semibold border-b border-[#ebedf2] dark:border-[#191e3a] mb-5 whitespace-nowrap overflow-y-auto">
                <li class="inline-block">
                    <a href="javascript:;"
                        class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                        :class="{'!border-primary text-primary' : tab == 'pretendente'}" @click="tab='pretendente'">
    
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5">
                            <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                            <ellipse opacity="0.5" cx="12" cy="17" rx="7" ry="4" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                        Dados do Pretendente
                    </a>
                </li>
                <li class="inline-block">
                    <a href="javascript:;"
                        class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                        :class="{'!border-primary text-primary' : tab == 'perfis'}" @click="tab='perfis'">
    
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5">
                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                            <path d="M12 6V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M15 9.5C15 8.11929 13.6569 7 12 7C10.3431 7 9 8.11929 9 9.5C9 10.8807 10.3431 12 12 12C13.6569 12 15 13.1193 15 14.5C15 15.8807 13.6569 17 12 17C10.3431 17 9 15.8807 9 14.5"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Perfis de Busca
                    </a>
                </li>
                <li class="inline-block">
                    <a href="javascript:;"
                        class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                        :class="{'!border-primary text-primary' : tab == 'historico-atendimentos'}"
                        @click="tab='historico-atendimentos'">
    
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5">
                            <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                            <ellipse opacity="0.5" cx="12" cy="17" rx="7" ry="4" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                        Histórico de Atendimentos
                    </a>
                </li>
                <li class="inline-block">
                    <a href="javascript:;"
                        class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                        :class="{'!border-primary text-primary' : tab == 'imoveis'}" @click="tab='imoveis'"
                        onClick="getImoveis()">
                        <?php echo file_get_contents('application/icons/imovel.svg'); ?>
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
                <!-- Imóveis vindo do ajax -->
                <div id="resulAjaxImoveis"></div>
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
</div>

<script>
    //* IMOVEIS    
    //* Atualiza imoveis sugeridos pro pretendente
    const getImoveis = () => {
        var data = {
            pretendente: <?php echo $_POST['param_0']; ?>
        };

        fetch('application/pretendente/view/imoveis/getImoveis.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            // Seta resultado do ajax na div
            document.getElementById('resulAjaxImoveis').innerHTML = data;
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

    //* Favoritar
    const setFavorite = (action, id) => {
        var data = {
            action: action,
            id: id,
            pretendente: <?php echo $_POST['param_0']; ?>
        };

        fetch('application/pretendente/view/imoveis/setFavorite.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            console.log('Dados retornados do ajax: ', data)
            getImoveis(); // Atualiza listagem dos imóveis
            action ? toast('Imóvel favoritado com sucesso!', 'warning', 3000) : toast('Imóvel desfavoritado com sucesso!', '', 3000)
        }).catch(error => {
            console.error('Erro ao enviar dados:', error);
        });
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

</script>
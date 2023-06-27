<?php
// Perfis de busca
$sql = '
    SELECT * 
    FROM pretendentesperfil AS pp
        LEFT JOIN tipoimovel AS ti ON (pp.ppf_tipoimovel = ti.tpi_codigo)
    WHERE ppf_pretendente = ' . $_POST['param_0'];
$perfis = $data->find('dynamic', $sql);

// var_dump($perfis);

?>

<div class="pt-0">
    <div class="flex items-center justify-between mb-5">
        <h5 class="font-semibold text-lg dark:text-white-light">Detalhes do Cliente</h5>
    </div>

    <!-- ABAS -->
    <div x-data="{tab: 'pretendente'}">
        <ul
            class="sm:flex font-semibold border-b border-[#ebedf2] dark:border-[#191e3a] mb-5 whitespace-nowrap overflow-y-auto">
            <li class="inline-block">
                <a href="javascript:;"
                    class="flex gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                    :class="{'!border-primary text-primary' : tab == 'pretendente'}" @click="tab='pretendente'">

                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5">
                        <path opacity="0.5"
                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                            stroke="currentColor" stroke-width="1.5" />
                        <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
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

                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5">
                        <path
                            d="M16.1007 13.359L16.5562 12.9062C17.1858 12.2801 18.1672 12.1515 18.9728 12.5894L20.8833 13.628C22.1102 14.2949 22.3806 15.9295 21.4217 16.883L20.0011 18.2954C19.6399 18.6546 19.1917 18.9171 18.6763 18.9651M4.00289 5.74561C3.96765 5.12559 4.25823 4.56668 4.69185 4.13552L6.26145 2.57483C7.13596 1.70529 8.61028 1.83992 9.37326 2.85908L10.6342 4.54348C11.2507 5.36691 11.1841 6.49484 10.4775 7.19738L10.1907 7.48257"
                            stroke="currentColor" stroke-width="1.5" />
                        <path opacity="0.5"
                            d="M18.6763 18.9651C17.0469 19.117 13.0622 18.9492 8.8154 14.7266C4.81076 10.7447 4.09308 7.33182 4.00293 5.74561"
                            stroke="currentColor" stroke-width="1.5" />
                        <path opacity="0.5"
                            d="M16.1007 13.3589C16.1007 13.3589 15.0181 14.4353 12.0631 11.4971C9.10807 8.55886 10.1907 7.48242 10.1907 7.48242"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Imóveis
                </a>
            </li>
        </ul>

        <!-- DADOS DO PRETENDENTE -->
        <template x-if="tab === 'pretendente'">
            <?php include_once('application/pretendente/view/abas/dadosPretendente/lista.php'); ?>
        </template>

        <!-- PERFIS DE BUSCA -->
        <template x-if="tab === 'perfis'">
            <?php include_once('application/pretendente/view/abas/perfilBusca/lista.php'); ?>
        </template>

        <!-- HISTÓRICO DE ATENDIMENTOS -->
        <template x-if="tab === 'historico-atendimentos'">
            <?php include_once('application/pretendente/view/abas/historicoAtendimentos/lista.php'); ?>
        </template>

        <!-- IMÓVEIS -->
        <template x-if="tab === 'imoveis'">
            <!-- Imóveis vindo do ajax -->
            <div id="resulAjaxImoveis"></div>
        </template>
    </div>
</div>


<script>

    //* IMOVEIS    
    //* Atualiza imoveis sugeridos pro pretendente
    function getImoveis() {
        console.log("🚀 ~ getImoveis")

        var data = {
            pretendente: <?php echo $_POST['param_0']; ?>
        };

        fetch('application/pretendente/view/ajax/getImoveis.php', {
            method: 'POST',
            body: JSON.stringify(data) // Converte o objeto em uma string JSON
        }).then(response => response.json()).then(data => {
            // Seta resultado do ajax na div
            document.getElementById('resulAjaxImoveis').innerHTML = data;
        })
    }

    //* Favoritar
    function setFavorite(action, id) {
        console.log("🚀 ~ setFavorite ~ setFavorite:", action, id)
        var data = {
            action: action,
            id: id,
            pretendente: <?php echo $_POST['param_0']; ?>
        };

        fetch('application/pretendente/view/ajax/setFavorite.php', {
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

    function openModalEditPerfil(ppf_pretendente, ppf_codigo) {
        if (ppf_pretendente && ppf_codigo) {
            console.log('funçao do modal...', ppf_pretendente, ppf_codigo)

            fetch('application/pretendente/view/ajax/getDataPerfilBusca.php', {
                method: 'POST',
                body: JSON.stringify({ ppf_pretendente: ppf_pretendente, ppf_codigo: ppf_codigo }),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                // Seta resultado do ajax na div
                document.getElementById('resulAjaxPerfilBusca').innerHTML = data;
            });
        }
    }

    function toast(title, color, time) {
        const toast = window.Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: time,
            showCloseButton: true,
            showConfirmButton: false,

            customClass: {
                popup: `color-${color}`
            },
        });
        toast.fire({
            title: title,
        });
    }

</script>
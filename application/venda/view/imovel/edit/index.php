<?php 
    $sql = '
    SELECT 
        i.imo_codigo, 
        p.pes_nome1 AS proprietario,
        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor,
        iv.imv_financiado
    FROM imoveis AS i 
        JOIN pessoas AS p ON (i.imo_proprietario = p.pes_codigo)
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
    WHERE i.imo_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);

    $currentTab = 'geral';
    if(isset($_GET['tab'])){
        switch($_GET['tab']){
            case 1:
                $currentTab = 'geral';
            break;
            case 2:
                $currentTab = 'agenciamento';
            break;
            case 3:
                $currentTab = 'valores';
            break;
            case 4:
                $currentTab = 'observacoes';
            break;
            case 5:
                $currentTab = 'fotos';
            break;
            case 6:
                $currentTab = 'visitas';
            break;
            case 7:
                $currentTab = 'ocorrencias';
            break;
            case 8:
                $currentTab = 'anexos';
            break;
        }
    }
?>

<div class="overflow-y-auto" x-data="dataEdit">
    <div>
        <div class="pt-0">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p>Imóvel</p>
                    <h5 class="font-semibold text-lg dark:text-white-light "><?php echo $result[0]['imo_codigo'].' - '.$result[0]['proprietario']; ?></h5>                    
                </div>

                <div>
                    <button type="button" onclick="nextPage('?module=venda&acao=lista_imovel', '');" class="btn btn btn-outline-dark">
                        <?php echo file_get_contents('application/icons/voltar.svg'); ?>
                        <span class="hidden sm:block">Voltar</span>
                    </button>   
                </div>
            </div>
        
            <!-- ABAS -->
            <div x-data="{tab: '<?php echo $currentTab; ?>'}">
                <ul class="sm:flex font-semibold border-b border-[#ebedf2] dark:border-[#191e3a] mb-5 whitespace-nowrap overflow-y-auto">
                    <!-- Geral -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'geral'}" @click="tab='geral'">        
                            <?php echo file_get_contents('application/icons/imoveis.svg'); ?>
                            <span class="hidden sm:block">Geral</span>
                        </a>
                    </li>
                    <!-- Agenciamento -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'agenciamento'}" @click="tab='agenciamento'">        
                            <?php echo file_get_contents('application/icons/agenciamento.svg'); ?>
                            <span class="hidden sm:block">Agenciamento</span>
                        </a>
                    </li>
                    <!-- Valores -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'valores'}" @click="tab='valores'">        
                            <?php echo file_get_contents('application/icons/valores.svg'); ?>
                            <span class="hidden sm:block">Valores</span>
                        </a>
                    </li>
                    <!-- Observações -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'observacoes'}" @click="tab='observacoes'">        
                            <?php echo file_get_contents('application/icons/observacoes.svg'); ?>
                            <span class="hidden sm:block">Observações</span>
                        </a>
                    </li>
                    <!-- Fotos -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'fotos'}" @click="tab='fotos'">        
                            <?php echo file_get_contents('application/icons/fotos.svg'); ?>
                            <span class="hidden sm:block">Fotos</span>
                        </a>
                    </li>
                    <!-- Visitas -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'visitas'}" @click="tab='visitas'">        
                            <?php echo file_get_contents('application/icons/flag.svg'); ?>
                            <span class="hidden sm:block">Visitas</span>
                        </a>
                    </li>
                    <!-- Ocorrências -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'ocorrencias'}" @click="tab='ocorrencias'">        
                            <?php echo file_get_contents('application/icons/ocorrencia.svg'); ?>
                            <span class="hidden sm:block">Ocorrências</span>
                        </a>
                    </li>
                    <!-- Anexos -->
                    <li class="inline-block">
                        <a href="javascript:;"
                            class="flex items-center gap-2 p-4 border-b border-transparent hover:border-primary hover:text-primary"
                            :class="{'!border-primary text-primary' : tab == 'anexos'}" @click="tab='anexos'">        
                            <?php echo file_get_contents('application/icons/anexo.svg'); ?>
                            <span class="hidden sm:block">Anexos</span>
                        </a>
                    </li>                    
                </ul>

                <!-- Geral -->
                <template x-if="tab === 'geral'">
                    <?php include_once('application/venda/view/imovel/edit/geral/index.php'); ?>
                </template>
                <!-- Agenciamento -->
                <template x-if="tab === 'agenciamento'">
                    <?php include_once('application/venda/view/imovel/edit/agenciamento/index.php'); ?>
                </template>
                <!-- Valores -->
                <template x-if="tab === 'valores'">
                    <?php include_once('application/venda/view/imovel/edit/valores/index.php'); ?>
                </template>
                <!-- Observações -->
                <template x-if="tab === 'observacoes'">
                    <p>Aba observações...</p>
                </template>
                <!-- Fotos -->
                <template x-if="tab === 'fotos'">
                    <p>Aba fotos...</p>
                </template>
                <!-- Visitas -->
                <template x-if="tab === 'visitas'">
                    <p>Aba visitas...</p>
                </template>
                <!-- Ocorrências -->
                <template x-if="tab === 'ocorrencias'">
                    <p>Aba ocorrências...</p>
                </template>
                <!-- Anexos -->
                <template x-if="tab === 'anexos'">
                    <p>Aba anexos...</p>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("dataEdit", () => ({
            editFinanciamento: <?php echo $result[0]['imv_financiado'] == 's' ? 'true' : 'false'; ?>,

            setFinanciamento(){
                this.editFinanciamento = !this.editFinanciamento;            
            }
        }));
    });
</script>
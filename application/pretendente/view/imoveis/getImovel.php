<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['id']) && $value['id'] > 0) {

        $sql = '
        SELECT 
            i.imo_codigo, 
            ti.tpi_descricao,
            i.imo_rua, 
            b.bai_descricao, 
            i.imo_areaconstruida, 
            i.imo_quartos, 
            i.imo_banheiros, 
            i.imo_garagem,

            i.imo_areaterreno,
            i.imo_areaconstruida,
            i.imo_areaprivativa,
            i.imo_areautil,
            i.imo_areacomum,
            i.imo_areagaragem,
            tc.tcn_descricao AS tipoconstrucao,
            u.uti_descricao AS utilizacao,
            i.imo_edificio,
            i.imo_pontoreferencia,
            i.imo_posicao,
            i.imo_elevadores,
            tp.tpp_descricao AS tipoPiso,
            i.imo_salaestar,
            i.imo_salatv,
            i.imo_lareira,
            i.imo_cozinha,      
            i.imo_areadeservico,
            i.imo_dependenciaempregada,
            i.imo_gascentral,
            i.imo_playground,
            i.imo_lavabo,
            i.imo_churrasqueira,
            i.imo_salaofestas,
            i.imo_sacada,
            i.imo_pocoartesiano,
            i.imo_portaoeletronico,
            i.imo_condominiofechado,
            i.imo_arealazer,
            i.imo_piscina,
            i.imo_terraco,    
            i.imo_detalhes,  

            ((iv.imv_valor*m.moe_valor)/100) AS imv_valor
        FROM imoveis AS i
            INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
            LEFT JOIN tipoconstrucao AS tc ON (i.imo_tipoconstrucao = tc.tcn_codigo)
            LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
            LEFT JOIN utilizacao AS u ON (i.imo_utilizacao = u.uti_codigo)
            LEFT JOIN tipopiso AS tp ON (i.imo_tipopiso = tp.tpp_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE i.imo_codigo = ' . $value['id'];
        $result = $data->find('dynamic', $sql);

        if ($result && count($result) > 0) {
            $html = '
            <div class="sm:flex gap-4">

                <div class="sm:w-1/2 mr-2">
                    <!-- LightBox da capa -->
                    <div class="rounded-md overflow-hidden relative w-full border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary hover:transition-colors duration-300" style="height: 300px; width: 100%;">
                        <template x-for="(item, i) in getItems" :key="i">
                            <template x-if="i == 0">
                                <a href="javascript:;" x-tooltip="Ampliar imagem" >
                                    <img :src="item.src" alt="image-gallery" data-fancybox="gallery" class="rounded-md w-full h-full object-cover" :data-caption="item.title" />
                                </a>
                            </template>
                        </template>    
                    </div>         

                    <!-- LightBox da galeria -->
                    <div class="grid grid-cols-2 md:grid-cols-4 mt-4 gap-4 text-center" x-init="bindFancybox()">
                        <template x-for="(item, i) in getItems" :key="i">
                            <template x-if="i > 0">
                                <a href="javascript:;" x-tooltip="Ampliar imagem" >
                                    <img :src="item.src" alt="image-gallery" data-fancybox="gallery" class="rounded-md w-full h-full object-cover border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary hover:transition-colors duration-300" :data-caption="item.title" style="height: 100px; width: 100%;" />
                                </a>
                            </template>
                        </template>    
                    </div>
                </div>

                <div class="sm:w-1/2 my-2 sm:mt-0">
                    <!-- Título e valor -->
                    <div class="sm:flex justify-between py-4 sm:py-0 ">
                        <div>
                            <p class="text-xs sm:text-right">
                                #' . $result[0]['imo_codigo'] . '
                            </p>
                            <p class="text-xl font-bold text-primary">' . $result[0]['tpi_descricao'] . '</p>
                            <p>' . $result[0]['bai_descricao'] . '</p>
                            
                        </div>
                        <div>
                            <p class="text-xs sm:text-right">
                                Valor de venda
                            </p>
                            <p class="text-xl font-bold text-success">
                                R$ '.number_format(($result[0]['imv_valor']/100), 2, ',', '.').'
                            </p>                                                        
                            <!-- COMPARTILHAR -->
                            <div class="mt-2">
                                <div @click="() => toggleShareImovel()" class="bg-white dark:bg-dark rounded p-2 flex">
                                    <button type="button" class="text-secondary group" data-imovel-id="6" x-tooltip="Compartilhar este imóvel" data-theme="secondary" @click="() => openModalFormVisita(null, '.$imovel['imo_codigo'].')">
                                        <div class="flex items-center text-center gap-2">
                                            '.file_get_contents('../../../icons/compartilhar.svg').'<p class="text-sm"> Compartilhar</p>
                                        </div>
                                    </button>
                                </div>
                                <!-- SELECIONAR MODO DE COMPARTILHAMENTO -->
                                <div x-show="openShareImovel" x-transition x-transition.duration.300 class="absolute mt-1 cursor-pointer">
                                    <div class="bg-white dark:bg-dark rounded p-2 flex flex-col gap-3">
                                        <div class="flex gap-1 items-center" x-tooltip="Copiar link do imóvel" data-theme="primary" @click="() => copyLink('.$result[0]['imo_codigo'].');" >
                                            <div class="text-primary">
                                                ' . file_get_contents('../../../icons/copiar.svg') . '
                                            </div>
                                            <p class="text-sm">Copiar Link</p>                                                
                                        </div>
                                        <div class="flex gap-1 items-center" x-tooltip="Compartilhar no whatsapp do pretendente" data-theme="success" @click="() => shareWhatsapp('.$result[0]['imo_codigo'].', \''.$pretendente[0]['prw_telefones'].'\');" >
                                            <div class="text-success">
                                                ' . file_get_contents('../../../icons/whatsapp.svg') . '
                                            </div>
                                            <p class="text-sm">WhatsApp</p>                                                
                                        </div>
                                    </div>

                                </div>                       
                            </div>
                        </div>
                    </div>';
                    
                    // Características (grid)
                    include('formCaracteristicas.php');

                    // Detalhes 
                    if($result[0]['imo_detalhes']){
                        $html .= '
                        <div class="py-4">
                            <p>Informações Adicionais</p>
                            <p class="text-sm">'.utf8_encode($result[0]['imo_detalhes']).'</p>
                        </div>';
                    }                    
                $html .= '
                </div>
            </div>';
        }else{
            $html .= '<p>O imóvel não foi encontrado!</p>';
        }                    

        // Retorna resposta
        echo json_encode($html);
        exit;
    }
}
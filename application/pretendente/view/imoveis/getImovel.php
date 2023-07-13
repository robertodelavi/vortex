<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['id']) && $value['id'] > 0) {

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao, i.imo_areaconstruida, i.imo_quartos, i.imo_banheiros, i.imo_garagem
        FROM imoveis AS i
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE i.imo_codigo = ' . $value['id'];
        $result = $data->find('dynamic', $sql);

        if ($result && count($result) > 0) {
            $html = '
            <div class="flex">
                <div class="w-1/2 mr-2">

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

                <div class="w-1/2 ml-2">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-md font-bold mb-2">
                                ' . $result[0]['tpi_descricao'] . '
                            </p>
                            <p class="mb-2">
                                ' . $result[0]['bai_descricao'] . '
                            </p>
                        </div>
                        <div>
                            <p class="text-lg font-bold text-success">
                                R$ 500.000,00
                            </p>
                            <p class="text-xs mb-2">
                                Código: ' . $result[0]['imo_codigo'] . '
                            </p>
                        </div>
                    </div>
                    
                    <!-- Principais características -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5 text-center">
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/area.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_areaconstruida'] ? number_format(($result[0]['imo_areaconstruida'] / 100), 0, ',', '.') : '0').' m²
                                </p>
                                <p class="text-xs mt-0" >Área total</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/area2.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_areaprivativa'] ? number_format(($result[0]['imo_areaprivativa'] / 100), 0, ',', '.') : '0').' m²
                                </p>
                                <p class="text-xs mt-0" >Área construída</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_quartos'] ? $result[0]['imo_quartos'] : '0').'
                                </p>
                                <p class="text-xs mt-0" >Quartos</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_suites'] ? $result[0]['imo_suites'] : '0').'
                                </p>
                                <p class="text-xs mt-0" >Suítes</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/banheiro.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_banheiros'] ? $result[0]['imo_banheiros'] : '0').'
                                </p>
                                <p class="text-xs mt-0" >Banheiros</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/vagagaragem.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_garagem'] ? $result[0]['imo_garagem'] : '0').'
                                </p>
                                <p class="text-xs mt-0" >Vagas</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-center mt-5">
                            <div class="mb-1">
                                ' . file_get_contents('../../../../application/icons/cozinha.svg') . '       
                            </div>
                            <div>
                                <p class="text-primary font-bold text-md mb-0" >
                                    '.($result[0]['imo_cozinha'] ? $result[0]['imo_cozinha'] : '0').'
                                </p>
                                <p class="text-xs mt-0" >Cozinhas</p>
                            </div>
                        </div>

                        
                                  
                    </div>

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
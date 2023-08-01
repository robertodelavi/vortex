<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['pretendente']) && $value['pretendente'] > 0) {

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao, i.imo_areaconstruida, i.imo_quartos, i.imo_banheiros, i.imo_garagem, ft.imf_arquivo
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s")
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = ' . $value['pretendente'] . ' AND p.pwi_favorito = 1
        GROUP BY i.imo_codigo';
        $resultFavoritos = $data->find('dynamic', $sql);

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao, i.imo_areaconstruida, i.imo_quartos, i.imo_banheiros, i.imo_garagem, ft.imf_arquivo
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s")
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = ' . $value['pretendente'] . ' AND p.pwi_favorito = 0
        GROUP BY i.imo_codigo';
        $resultImoveis = $data->find('dynamic', $sql);
        
        //* FAVORITOS
        $html = '
        <div>
            <h5 class="font-bold text-3xl text-warning my-6">Favoritos</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
                if ($resultFavoritos && count($resultFavoritos) > 0) {
                    foreach ($resultFavoritos as $i => $imovel) {
                        $foto = $imovel['imf_arquivo'] ? 'application/images/clientes/1/imoveis/'.$imovel['imf_arquivo'] : 'application/images/no-image-transparent.png';
                        $html .= '
                        <div @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');" id="favoritos-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                            <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                                                
                                
                                <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                    <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url('.$foto.');"></div>
                                    
                                    <!-- FAVORITAR -->
                                    <div class="absolute top-2 right-2 bg-white dark:bg-dark rounded p-2 flex">
                                        <button type="button" class="text-warning group" x-tooltip="Desfavoritar Imóvel" @click="() => setFavorite(false, ' . $imovel['imo_codigo'] . ')">
                                            ' . file_get_contents('../../../icons/starContained.svg') . '
                                        </button>
                                    </div>
                                </div>         
                            </div>

                            <div class="flex justify-between">
                                <div>
                                    <p class="text-md font-bold">
                                        ' . $imovel['tpi_descricao'] . '
                                    </p>
                                    <p class="">
                                        ' . $imovel['bai_descricao'] . '
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-success">
                                        R$ 500.000,00
                                    </p>
                                    <p class="text-xs">
                                        Código: ' . $imovel['imo_codigo'] . '
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between mt-5">
                                <div class="flex flex-col items-center">                                    
                                    ' . file_get_contents('../../../../application/icons/area.svg') . '                        
                                    <p class="mt-2 text-xs">' . ($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida'] / 100), 0, ',', '.') : '0') . 'm²</p>
                                </div>
                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '                        
                                    <p class="mt-2 text-xs">' . ($imovel['imo_quartos'] ? $imovel['imo_quartos'] : '0') . ' Quartos</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/banheiro.svg') . '
                                    <p class="mt-2 text-xs">' . ($imovel['imo_banheiros'] ? $imovel['imo_banheiros'] : '0') . ' Banheiros</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/vagagaragem.svg') . '                          
                                    <p class="mt-2 text-xs">' . ($imovel['imo_garagem'] ? $imovel['imo_garagem'] : '0') . ' Vagas</p>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    $html .= '<p>Nenhum imóvel favoritado!</p>';
                }
                $html .= ' 
            </div>
        </div>';

        //* IMÓVEIS SUGERIDOS
        $html .= '
        <div class="mt-3">
            <h5 class="font-bold text-3xl my-6">Imóveis</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
                if ($resultImoveis && count($resultImoveis) > 0) {
                    foreach ($resultImoveis as $i => $imovel) {
                        $foto = $imovel['imf_arquivo'] ? 'application/images/clientes/1/imoveis/'.$imovel['imf_arquivo'] : 'application/images/no-image-transparent.png';
                        $html .= '
                        <div @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');"" id="imoveis-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                            <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">  
                                <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                    <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url('.$foto.');"></div>
                                    
                                    <!-- FAVORITAR -->
                                    <div class="absolute top-2 right-2 bg-white dark:bg-dark rounded p-2 flex">
                                        <button type="button" class="text-warning group" data-imovel-id="6" x-tooltip="Favoritar Imóvel" data-theme="warning" @click="() => setFavorite(true, ' . $imovel['imo_codigo'] . ')">
                                            ' . file_get_contents('../../../icons/star.svg') . '
                                        </button>
                                    </div>

                                </div>    
                            </div>
                            
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-md font-bold">
                                        ' . $imovel['tpi_descricao'] . '
                                    </p>
                                    <p class="">
                                        ' . $imovel['bai_descricao'] . '
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-success">
                                        R$ 500.000,00
                                    </p>
                                    <p class="text-xs">
                                        Código: ' . $imovel['imo_codigo'] . '
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between mt-5">
                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/area.svg') . '                                                       
                                    <p class="mt-2 text-xs">' . ($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida'] / 100), 0, ',', '.') : '0') . 'm²</p>
                                </div>
                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '                                                       
                                    <p class="mt-2 text-xs">' . ($imovel['imo_quartos'] ? $imovel['imo_quartos'] : '0') . ' Quartos</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/banheiro.svg') . '                                                                                
                                    <p class="mt-2 text-xs">' . ($imovel['imo_banheiros'] ? $imovel['imo_banheiros'] : '0') . ' Banheiros</p>
                                </div>

                                <div class="flex flex-col items-center">
                                    ' . file_get_contents('../../../../application/icons/vagagaragem.svg') . '                          
                                    <p class="mt-2 text-xs">' . ($imovel['imo_garagem'] ? $imovel['imo_garagem'] : '0') . ' Vagas</p>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    $html .= '<p>Nenhum imóvel sugerido!</p>';
                }
                $html .= '
            </div>
        </div>';

        // Retorna resposta
        echo json_encode($html);
        exit;
    }
}
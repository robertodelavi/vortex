<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['pretendente']) && $value['pretendente'] > 0) {

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = ' . $value['pretendente'] . ' AND p.pwi_favorito = 1';
        $resultFavoritos = $data->find('dynamic', $sql);

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = ' . $value['pretendente'] . ' AND p.pwi_favorito = 0';
        $resultImoveis = $data->find('dynamic', $sql);

        //* FAVORITOS
        $html = '
        <div>
            <h5 class="font-semibold text-lg mb-4">Favoritos</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
                if ($resultFavoritos && count($resultFavoritos) > 0) {
                    foreach ($resultFavoritos as $i => $imovel) {
                        $html .= '
                            <div id="favoritos-container" class="cursor-pointer border-2 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                                <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                                                
                                    
                                    <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                        <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/abas/imoveis/img/foto-3.jpg);"></div>
                                        
                                        <!-- FAVORITAR -->
                                        <div class="absolute top-2 right-2 bg-white dark:bg-dark rounded p-2 flex">
                                            <button type="button" class="text-warning group" x-tooltip="Desfavoritar Imóvel" @click="() => setFavorite(false, ' . $imovel['imo_codigo'] . ')">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 fill-warning group-hover:fill-warning"  }">
                                                    <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" stroke="currentColor" stroke-width="1.5"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>                        
                                    
                                </div>
                                <h5 class="text-xl mb-5">' . $imovel['tpi_descricao'] . ' - '.$imovel['imo_rua'].' - '.$imovel['bai_descricao'].'</h5>
                                <div class="flex">
                                    <div class="flex-1">
                                        <p>' . $imovel['descricao'] . '</p>
                                    </div>
                                </div>
                            </div>';
                    }
                }else{
                    $html .= '<p>Nenhum imóvel favoritado!</p>';
                }
            $html .= ' 
            </div>
        </div>';

        //* IMÓVEIS SUGERIDOS
        $html .= '
        <div class="mt-3">
            <h5 class="font-semibold text-lg my-6">Imóveis</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
            if ($resultImoveis && count($resultImoveis) > 0) {
                foreach ($resultImoveis as $i => $imovel) {
                    $html .= '
                        <div id="imoveis-container" class="cursor-pointer border-2 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                            <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">  
                                <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                    <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/abas/imoveis/img/foto-3.jpg);"></div>
                                    
                                    <!-- FAVORITAR -->
                                    <div class="absolute top-2 right-2 bg-white dark:bg-dark rounded p-2 flex">
                                        <button type="button" class="text-warning group" data-imovel-id="6" x-tooltip="Favoritar Imóvel" data-theme="warning"  @click="() => setFavorite(true, ' . $imovel['imo_codigo'] . ')">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 group-hover:fill-warning"  }">
                                                <path d="M9.15316 5.40838C10.4198 3.13613 11.0531 2 12 2C12.9469 2 13.5802 3.13612 14.8468 5.40837L15.1745 5.99623C15.5345 6.64193 15.7144 6.96479 15.9951 7.17781C16.2757 7.39083 16.6251 7.4699 17.3241 7.62805L17.9605 7.77203C20.4201 8.32856 21.65 8.60682 21.9426 9.54773C22.2352 10.4886 21.3968 11.4691 19.7199 13.4299L19.2861 13.9372C18.8096 14.4944 18.5713 14.773 18.4641 15.1177C18.357 15.4624 18.393 15.8341 18.465 16.5776L18.5306 17.2544C18.7841 19.8706 18.9109 21.1787 18.1449 21.7602C17.3788 22.3417 16.2273 21.8115 13.9243 20.7512L13.3285 20.4768C12.6741 20.1755 12.3469 20.0248 12 20.0248C11.6531 20.0248 11.3259 20.1755 10.6715 20.4768L10.0757 20.7512C7.77268 21.8115 6.62118 22.3417 5.85515 21.7602C5.08912 21.1787 5.21588 19.8706 5.4694 17.2544L5.53498 16.5776C5.60703 15.8341 5.64305 15.4624 5.53586 15.1177C5.42868 14.773 5.19043 14.4944 4.71392 13.9372L4.2801 13.4299C2.60325 11.4691 1.76482 10.4886 2.05742 9.54773C2.35002 8.60682 3.57986 8.32856 6.03954 7.77203L6.67589 7.62805C7.37485 7.4699 7.72433 7.39083 8.00494 7.17781C8.28555 6.96479 8.46553 6.64194 8.82547 5.99623L9.15316 5.40838Z" stroke="currentColor" stroke-width="1.5"></path>
                                            </svg>
                                        </button>
                                    </div>
        
                                </div>    
                            </div>
                            <p class="text-md mb-5">' . $imovel['tpi_descricao'] . ' - '.$imovel['imo_rua'].' - '.$imovel['bai_descricao'].'</p>
                            <div class="flex">
                                <div class="flex-1">
                                    <p>' . $imovel['descricao'] . '</p>
                                </div>
                            </div>
                        </div>';
                }
            }else{
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
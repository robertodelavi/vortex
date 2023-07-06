<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['pretendente']) && $value['pretendente'] > 0) {

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao, i.imo_areaconstruida, i.imo_quartos, i.imo_banheiros, i.imo_garagem
        FROM pretendentesimoveis AS p 
            LEFT JOIN imoveis AS i ON (p.pwi_imovel = i.imo_codigo)
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE p.pwi_pretendente = ' . $value['pretendente'] . ' AND p.pwi_favorito = 1';
        $resultFavoritos = $data->find('dynamic', $sql);

        $sql = '
        SELECT i.imo_codigo, ti.tpi_descricao, i.imo_rua, b.bai_descricao, i.imo_areaconstruida, i.imo_quartos, i.imo_banheiros, i.imo_garagem
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
                        <div id="favoritos-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                            <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                                                
                                
                                <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                    <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-3.jpg);"></div>
                                    
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
                                        '.$imovel['tpi_descricao'].'
                                    </p>
                                    <p class="">
                                        '.$imovel['bai_descricao'].'
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-success">
                                        R$ 500.000,00
                                    </p>
                                    <p class="text-xs">
                                        Código: '.$imovel['imo_codigo'].'
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between mt-5">
                                <div class="text-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9H11C10.0572 9 9.58579 9 9.29289 9.29289C9 9.58579 9 10.0572 9 11V18.5C9 19.9045 9 20.6067 8.66294 21.1111C8.51702 21.3295 8.32952 21.517 8.11114 21.6629C7.60669 22 6.90446 22 5.5 22C4.09554 22 3.39331 22 2.88886 21.6629C2.67048 21.517 2.48298 21.3295 2.33706 21.1111C2 20.6067 2 19.9045 2 18.5V6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2H18.5C19.9045 2 20.6067 2 21.1111 2.33706C21.3295 2.48298 21.517 2.67048 21.6629 2.88886C22 3.39331 22 4.09554 22 5.5C22 6.90446 22 7.60669 21.6629 8.11114C21.517 8.32952 21.3295 8.51702 21.1111 8.66294C20.6067 9 19.9045 9 18.5 9H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M12 2L12 4M18 2L18 4M9 2L9 5M15 2L15 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 12H4M2 18H4M2 15L5 15M2 9L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida']/100), 0, ',', '.') : '0').'m²</p>
                                </div>
                                <div class="">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 20V18.5M5 20V18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 15C2 14.0681 2 13.6022 2.15224 13.2346C2.35523 12.7446 2.74458 12.3552 3.23463 12.1522C3.60218 12 4.06812 12 5 12H19C19.9319 12 20.3978 12 20.7654 12.1522C21.2554 12.3552 21.6448 12.7446 21.8478 13.2346C22 13.6022 22 14.0681 22 15C22 15.9319 22 16.3978 21.8478 16.7654C21.6448 17.2554 21.2554 17.6448 20.7654 17.8478C20.3978 18 19.9319 18 19 18H5C4.06812 18 3.60218 18 3.23463 17.8478C2.74458 17.6448 2.35523 17.2554 2.15224 16.7654C2 16.3978 2 15.9319 2 15Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M21 12C21 8.22876 21 6.34315 19.8284 5.17157C18.6569 4 16.7712 4 13 4H11C7.22876 4 5.34315 4 4.17157 5.17157C3 6.34315 3 8.22876 3 12" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M18.5 12V10.5C18.5 8.61438 18.5 7.67157 17.9142 7.08579C17.3284 6.5 16.3856 6.5 14.5 6.5H9.5C7.61438 6.5 6.67157 6.5 6.08579 7.08579C5.5 7.67157 5.5 8.61438 5.5 10.5V12" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M12 7V12" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_quartos'] ? $imovel['imo_quartos'] : '0').' Dormitórios</p>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 20.5C12.6493 20.5 13.364 20.4831 14.0982 20.4555C14.3558 20.4458 14.4845 20.441 14.7053 20.4186C17.983 20.0867 20.7773 17.1854 20.9859 13.8977C21 13.6762 21 13.4784 21 13.0827C21 13.0059 21 12.9675 20.9979 12.9351C20.9653 12.4339 20.5661 12.0347 20.0649 12.0021C20.0325 12 19.9941 12 19.9173 12M4.08268 12C4.00591 12 3.96752 12 3.93511 12.0021C3.43395 12.0347 3.0347 12.4339 3.00211 12.9351C3 12.9675 3 13.0059 3 13.0827C3 13.4784 3 13.6762 3.01406 13.8977C3.19458 16.742 5.31032 19.2971 8 20.1495" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6 20L5 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M18 20L19 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 12H14M22 12H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2.25 13C2.25 13.4142 2.58579 13.75 3 13.75C3.41421 13.75 3.75 13.4142 3.75 13H2.25ZM7.59973 3.49934L8.29609 3.22079L8.29609 3.22079L7.59973 3.49934ZM7.97885 4.44713L8.30713 5.12147L7.97885 4.44713ZM6.36212 6.19232L7.05701 6.47451L6.36212 6.19232ZM10.577 4.37783L10.2824 5.06753L10.577 4.37783ZM6.34559 8.74156L5.6478 9.01651C5.72221 9.20535 5.86997 9.35596 6.05735 9.43396C6.24473 9.51197 6.45572 9.51069 6.64215 9.43044L6.34559 8.74156ZM12.3063 6.17548L12.6029 6.86436C12.975 6.70417 13.1526 6.27744 13.0041 5.90053L12.3063 6.17548ZM3.75 13V4.38516H2.25V13H3.75ZM5.38516 2.75C6.05379 2.75 6.65506 3.15708 6.90338 3.77788L8.29609 3.22079C7.81998 2.0305 6.66715 1.25 5.38516 1.25V2.75ZM3.75 4.38516C3.75 3.48209 4.48209 2.75 5.38516 2.75V1.25C3.65366 1.25 2.25 2.65366 2.25 4.38516H3.75ZM6.90338 3.77788L7.2825 4.72568L8.67521 4.16859L8.29609 3.22079L6.90338 3.77788ZM7.04337 8.46661C6.80167 7.85321 6.78638 7.14092 7.05701 6.47451L5.66723 5.91014C5.24692 6.94515 5.26959 8.05665 5.6478 9.01651L7.04337 8.46661ZM12.0098 5.4866L6.04903 8.05268L6.64215 9.43044L12.6029 6.86436L12.0098 5.4866ZM10.2824 5.06753C10.9039 5.33307 11.367 5.83741 11.6086 6.45043L13.0041 5.90053C12.6258 4.94029 11.887 4.12189 10.8717 3.68813L10.2824 5.06753ZM7.05701 6.47451C7.31118 5.8486 7.76827 5.3838 8.30713 5.12147L7.65058 3.77279C6.78337 4.19496 6.06253 4.93671 5.66723 5.91014L7.05701 6.47451ZM8.30713 5.12147C8.91452 4.82579 9.62506 4.78672 10.2824 5.06753L10.8717 3.68813C9.79386 3.22768 8.62874 3.29661 7.65058 3.77279L8.30713 5.12147Z" fill="currentColor"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_banheiros'] ? $imovel['imo_banheiros'] : '0').' Banheiros</p>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502M21 22.0001V16M7.25345 6.2192L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 18.5H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6 22V19M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6.11424 13.0573 6.02228 13.7602 6.00434 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M10 9H10.5M14 9H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 15.5H10.5M15 15.5H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_garagem'] ? $imovel['imo_garagem'] : '0').' Vagas</p>
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
            <h5 class="font-semibold text-lg my-6">Imóveis</h5>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">';
                if ($resultImoveis && count($resultImoveis) > 0) {
                    foreach ($resultImoveis as $i => $imovel) {
                        $html .= '
                        <div id="imoveis-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                            <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">  
                                <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                                    <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-3.jpg);"></div>
                                    
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
                                        '.$imovel['tpi_descricao'].'
                                    </p>
                                    <p class="">
                                        '.$imovel['bai_descricao'].'
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-success">
                                        R$ 500.000,00
                                    </p>
                                    <p class="text-xs">
                                        Código: '.$imovel['imo_codigo'].'
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-between mt-5">
                                <div class="text-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 9H11C10.0572 9 9.58579 9 9.29289 9.29289C9 9.58579 9 10.0572 9 11V18.5C9 19.9045 9 20.6067 8.66294 21.1111C8.51702 21.3295 8.32952 21.517 8.11114 21.6629C7.60669 22 6.90446 22 5.5 22C4.09554 22 3.39331 22 2.88886 21.6629C2.67048 21.517 2.48298 21.3295 2.33706 21.1111C2 20.6067 2 19.9045 2 18.5V6C2 4.11438 2 3.17157 2.58579 2.58579C3.17157 2 4.11438 2 6 2H18.5C19.9045 2 20.6067 2 21.1111 2.33706C21.3295 2.48298 21.517 2.67048 21.6629 2.88886C22 3.39331 22 4.09554 22 5.5C22 6.90446 22 7.60669 21.6629 8.11114C21.517 8.32952 21.3295 8.51702 21.1111 8.66294C20.6067 9 19.9045 9 18.5 9H16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M12 2L12 4M18 2L18 4M9 2L9 5M15 2L15 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 12H4M2 18H4M2 15L5 15M2 9L5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida']/100), 0, ',', '.') : '0').'m²</p>
                                </div>
                                <div class="">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 20V18.5M5 20V18.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 15C2 14.0681 2 13.6022 2.15224 13.2346C2.35523 12.7446 2.74458 12.3552 3.23463 12.1522C3.60218 12 4.06812 12 5 12H19C19.9319 12 20.3978 12 20.7654 12.1522C21.2554 12.3552 21.6448 12.7446 21.8478 13.2346C22 13.6022 22 14.0681 22 15C22 15.9319 22 16.3978 21.8478 16.7654C21.6448 17.2554 21.2554 17.6448 20.7654 17.8478C20.3978 18 19.9319 18 19 18H5C4.06812 18 3.60218 18 3.23463 17.8478C2.74458 17.6448 2.35523 17.2554 2.15224 16.7654C2 16.3978 2 15.9319 2 15Z" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M21 12C21 8.22876 21 6.34315 19.8284 5.17157C18.6569 4 16.7712 4 13 4H11C7.22876 4 5.34315 4 4.17157 5.17157C3 6.34315 3 8.22876 3 12" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M18.5 12V10.5C18.5 8.61438 18.5 7.67157 17.9142 7.08579C17.3284 6.5 16.3856 6.5 14.5 6.5H9.5C7.61438 6.5 6.67157 6.5 6.08579 7.08579C5.5 7.67157 5.5 8.61438 5.5 10.5V12" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M12 7V12" stroke="currentColor" stroke-width="1.5"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_quartos'] ? $imovel['imo_quartos'] : '0').' Dormitórios</p>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 20.5C12.6493 20.5 13.364 20.4831 14.0982 20.4555C14.3558 20.4458 14.4845 20.441 14.7053 20.4186C17.983 20.0867 20.7773 17.1854 20.9859 13.8977C21 13.6762 21 13.4784 21 13.0827C21 13.0059 21 12.9675 20.9979 12.9351C20.9653 12.4339 20.5661 12.0347 20.0649 12.0021C20.0325 12 19.9941 12 19.9173 12M4.08268 12C4.00591 12 3.96752 12 3.93511 12.0021C3.43395 12.0347 3.0347 12.4339 3.00211 12.9351C3 12.9675 3 13.0059 3 13.0827C3 13.4784 3 13.6762 3.01406 13.8977C3.19458 16.742 5.31032 19.2971 8 20.1495" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6 20L5 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M18 20L19 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2 12H14M22 12H18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M2.25 13C2.25 13.4142 2.58579 13.75 3 13.75C3.41421 13.75 3.75 13.4142 3.75 13H2.25ZM7.59973 3.49934L8.29609 3.22079L8.29609 3.22079L7.59973 3.49934ZM7.97885 4.44713L8.30713 5.12147L7.97885 4.44713ZM6.36212 6.19232L7.05701 6.47451L6.36212 6.19232ZM10.577 4.37783L10.2824 5.06753L10.577 4.37783ZM6.34559 8.74156L5.6478 9.01651C5.72221 9.20535 5.86997 9.35596 6.05735 9.43396C6.24473 9.51197 6.45572 9.51069 6.64215 9.43044L6.34559 8.74156ZM12.3063 6.17548L12.6029 6.86436C12.975 6.70417 13.1526 6.27744 13.0041 5.90053L12.3063 6.17548ZM3.75 13V4.38516H2.25V13H3.75ZM5.38516 2.75C6.05379 2.75 6.65506 3.15708 6.90338 3.77788L8.29609 3.22079C7.81998 2.0305 6.66715 1.25 5.38516 1.25V2.75ZM3.75 4.38516C3.75 3.48209 4.48209 2.75 5.38516 2.75V1.25C3.65366 1.25 2.25 2.65366 2.25 4.38516H3.75ZM6.90338 3.77788L7.2825 4.72568L8.67521 4.16859L8.29609 3.22079L6.90338 3.77788ZM7.04337 8.46661C6.80167 7.85321 6.78638 7.14092 7.05701 6.47451L5.66723 5.91014C5.24692 6.94515 5.26959 8.05665 5.6478 9.01651L7.04337 8.46661ZM12.0098 5.4866L6.04903 8.05268L6.64215 9.43044L12.6029 6.86436L12.0098 5.4866ZM10.2824 5.06753C10.9039 5.33307 11.367 5.83741 11.6086 6.45043L13.0041 5.90053C12.6258 4.94029 11.887 4.12189 10.8717 3.68813L10.2824 5.06753ZM7.05701 6.47451C7.31118 5.8486 7.76827 5.3838 8.30713 5.12147L7.65058 3.77279C6.78337 4.19496 6.06253 4.93671 5.66723 5.91014L7.05701 6.47451ZM8.30713 5.12147C8.91452 4.82579 9.62506 4.78672 10.2824 5.06753L10.8717 3.68813C9.79386 3.22768 8.62874 3.29661 7.65058 3.77279L8.30713 5.12147Z" fill="currentColor"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_banheiros'] ? $imovel['imo_banheiros'] : '0').' Banheiros</p>
                                </div>

                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 22L2 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502M21 22.0001V16M7.25345 6.2192L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 18.5H15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M6 22V19M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6.11424 13.0573 6.02228 13.7602 6.00434 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M10 9H10.5M14 9H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M9 15.5H10.5M15 15.5H12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>                                
                                    <p class="mt-2">'.($imovel['imo_garagem'] ? $imovel['imo_garagem'] : '0').' Vagas</p>
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
<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['pretendente']) && $value['pretendente'] > 0) {
        
        //* Filtro da lateral da listagem dos imóveis 
        $sideFilters = $value['filters'];        
        $filters = getFilters($value['pretendente'], $data); //? Extrai os filtros relevantes do perfil (que possuem valor)
        $sql = createScriptImoveis($value, $filters, $sideFilters); //? Cria e configura o script (sql) para buscar os imóveis
        // echo json_encode($sql); exit;
        $resultImoveis = $data->find('dynamic', $sql);

        $sql = '
        SELECT p.prw_telefones
        FROM pretendentes AS p 
        WHERE p.prw_codigo = ' . $value['pretendente'];
        $pretendente = $data->find('dynamic', $sql);

        $BASE_URL_IMAGENS = $_SESSION['BASE_URL_IMAGENS'];

        //* IMÓVEIS
        $html = '<p class="font-semibold text-lg dark:text-white-light my-3">Imóveis</p>';
        $html .= $value['mode'] == 'table' ? mountTable($resultImoveis, $BASE_URL_IMAGENS) : ($value['mode'] == 'grid' ? mountGrid($resultImoveis, $BASE_URL_IMAGENS) : mountList($resultImoveis, $BASE_URL_IMAGENS));                    

        //? Retorna resposta
        echo json_encode($html);
        exit;
    }
}

//* MONTA TABELA
function mountTable($result, $BASE_URL_IMAGENS){
    if($result && count($result) > 0){
        $html = '
        <div class="cursor-pointer border border-[#ebedf2] dark:border-[#191e3a] rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
            <table id="table-imoveis">
                <thead>
                    <tr>
                        <th class="text-center">Foto</th>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Bairro</th>
                        <th>B</th>
                        <th>D</th>
                        <th>S</th>
                        <th>VG</th>
                        <th>Área construída</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>';   
                    foreach ($result as $i => $imovel) {
                        $foto = $imovel['imf_arquivo'] ? $BASE_URL_IMAGENS.$imovel['imf_imovel'].'-'.$imovel['imf_arquivo'] : 'application/images/no-image-transparent.png';
                        $html .= '
                        <tr class="dark:hover:bg-[#191e3a] hover:bg-[#ebedf2]">
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">
                                <div class="border border-[#ebedf2] dark:border-[#191e3a] rounded-full overflow-hidden h-10 w-10"  >
                                    <div class="bg-cover bg-center h-full" style="background-image: url('.$foto.');" ></div>
                                </div>
                            </td>
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['imo_codigo'].'</td>
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['tpi_descricao'].'</td>
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['bai_descricao'].'</td>
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['imo_banheiros'].'</td>                            
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['imo_quartos'].'</td>                            
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['imo_suites'].'</td>                            
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.$imovel['imo_garagem'].'</td>                            
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">'.($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida'] / 100), 0, ',', '.') : '0').'m²</td>                            
                            <td @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');" class="text-success">R$ '.number_format(($imovel['imv_valor']/100), 2, ',', '.').'</td>  
                            <!-- Ações -->
                            <td>
                                <div class="flex items-center gap-2">     
                                    <div>
                                        <button @click="() => toggleShare('.$i.')" type="button" x-tooltip="Compartilhar este imóvel" data-theme="secondary" class="text-secondary relative" >
                                            ' . file_get_contents('../../../icons/compartilhar.svg') . '
                                        </button> 
                                        <div x-show="openShare && indexShare == '.$i.'" x-transition x-transition.duration.300 class="absolute mt-1 z-50">
                                            <div class="bg-white dark:bg-dark rounded p-2 flex flex-col gap-3">
                                                <div class="flex gap-1 items-center" x-tooltip="Copiar link do imóvel" data-theme="primary" @click="() => copyLink('.$imovel['imo_codigo'].');" >
                                                    <div class="text-primary">
                                                        ' . file_get_contents('../../../icons/copiar.svg') . '
                                                    </div>
                                                    <p class="text-sm">Copiar Link</p>                                                
                                                </div>
                                                <div class="flex gap-1 items-center" x-tooltip="Compartilhar no whatsapp do pretendente" data-theme="success" @click="() => shareWhatsapp('.$imovel['imo_codigo'].', \''.$pretendente[0]['prw_telefones'].'\');" >
                                                    <div class="text-success">
                                                        ' . file_get_contents('../../../icons/whatsapp.svg') . '
                                                    </div>
                                                    <p class="text-sm">WhatsApp</p>                                                
                                                </div>
                                            </div>
                                        </div>                                     
                                    </div>
                                    <div @click="toggle2;" >
                                        <button type="button" x-tooltip="Marcar visita" data-theme="primary" class="text-primary" @click="() => openModalFormVisita(null, '.$imovel['imo_codigo'].')" >
                                            ' . file_get_contents('../../../icons/flag.svg') . '
                                        </button>
                                    </div>';

                                    if($imovel['favorito'] == 1){
                                        $html .= '
                                        <button type="button" x-tooltip="Desfavoritar imóvel" @click="() => setFavorite(false, ' . $imovel['imo_codigo'] . ')" >
                                            ' . file_get_contents('../../../icons/starContained.svg') . '
                                        </button>';
                                    }else{
                                        $html .= '
                                        <button type="button" x-tooltip="Favoritar imóvel" data-theme="warning" @click="() => setFavorite(true, ' . $imovel['imo_codigo'] . ')" >
                                            ' . file_get_contents('../../../icons/star.svg') . '
                                        </button>';
                                    }
                                $html .= '
                                </div>
                            </td>                          
                        </tr>';
                    }                    
                $html .= '
                </tbody>
            </table>
        </div>';
    }else{
        $html = '<p class="text-md">Nenhum imóvel encontrado</p>';
    }

    return $html;
}

//* MONTA GRID
function mountGrid($result, $BASE_URL_IMAGENS){
    if($result && count($result) > 0){
        $html = '                                    
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">';                    
            foreach ($result as $i => $imovel) {
                $foto = $imovel['imf_arquivo'] ? $BASE_URL_IMAGENS.$imovel['imf_imovel'].'-'.$imovel['imf_arquivo'] : 'application/images/no-image-transparent.png';
                $html .= '
                <div id="favoritos-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                    <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                                                
                        
                        <div class="rounded-md overflow-hidden relative" style="height: 300px;">
                            <div @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');" class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url('.$foto.');"></div>

                            <!-- AÇÕES -->
                            <div class="absolute top-2 right-2 w-full flex justify-end gap-1">                                    
                                <!-- COMPARTILHAR -->
                                <div>
                                    <div @click="() => toggleShare('.$i.')" class="bg-white dark:bg-dark rounded p-2 flex relative">
                                        <button type="button" class="text-secondary group" data-imovel-id="6" x-tooltip="Compartilhar este imóvel" data-theme="secondary" >
                                            ' . file_get_contents('../../../icons/compartilhar.svg') . '
                                        </button>
                                    </div>
                                    <!-- SELECIONAR MODO DE COMPARTILHAMENTO -->
                                    <div x-show="openShare && sectionShare == \'favoritos\' && indexShare == '.$i.'" x-transition x-transition.duration.300 class="absolute mt-1">
                                        <div class="bg-white dark:bg-dark rounded p-2 flex flex-col gap-3">
                                            <div class="flex gap-1 items-center" x-tooltip="Copiar link do imóvel" data-theme="primary" @click="() => copyLink('.$imovel['imo_codigo'].');" >
                                                <div class="text-primary">
                                                    ' . file_get_contents('../../../icons/copiar.svg') . '
                                                </div>
                                                <p class="text-sm">Copiar Link</p>                                                
                                            </div>
                                            <div class="flex gap-1 items-center" x-tooltip="Compartilhar no whatsapp do pretendente" data-theme="success" @click="() => shareWhatsapp('.$imovel['imo_codigo'].', \''.$pretendente[0]['prw_telefones'].'\');" >
                                                <div class="text-success">
                                                    ' . file_get_contents('../../../icons/whatsapp.svg') . '
                                                </div>
                                                <p class="text-sm">WhatsApp</p>                                                
                                            </div>
                                        </div>
                                    </div>                       
                                </div>

                                <!-- MARCAR VISITA -->
                                <div @click="toggle2;" class="bg-white dark:bg-dark rounded p-2 flex">
                                    <button type="button" class="text-primary group" data-imovel-id="6" x-tooltip="Marcar visita" data-theme="primary" @click="() => openModalFormVisita(null, '.$imovel['imo_codigo'].')">
                                        ' . file_get_contents('../../../icons/flag.svg') . '
                                    </button>
                                </div>
                                
                                <!-- FAVORITAR -->
                                <div class="bg-white dark:bg-dark rounded p-2 flex">';
                                    if($imovel['favorito'] == 1){
                                        $html .= '
                                        <button type="button" class="text-warning group" x-tooltip="Desfavoritar Imóvel" @click="() => setFavorite(false, ' . $imovel['imo_codigo'] . ')">
                                            ' . file_get_contents('../../../icons/starContained.svg') . '
                                        </button>';
                                    }else{
                                        $html .= '
                                        <button type="button" class="text-warning group" x-tooltip="Favoritar imóvel" data-theme="warning" @click="() => setFavorite(true, ' . $imovel['imo_codigo'] . ')">
                                            ' . file_get_contents('../../../icons/star.svg') . '
                                        </button>';
                                    }                                
                                $html .= '
                                </div>                                    
                            </div>
                        </div>         
                    </div>

                    <div @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">
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
                                    R$ '.number_format(($imovel['imv_valor']/100), 2, ',', '.').'
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
                    </div>                        
                </div>';
            }                    
        $html .= ' 
        </div>';
    }else{
        $html = '<p class="text-md">Nenhum imóvel encontrado</p>';
    }

    return $html;
}

//* MONTA LISTA
function mountList($result, $BASE_URL_IMAGENS){
    if($result && count($result) > 0){
        $html = '                                    
        <div class="flex flex-col gap-4 mb-4">';                    
            foreach ($result as $i => $imovel) {
                $foto = $imovel['imf_arquivo'] ? $BASE_URL_IMAGENS.$imovel['imf_imovel'].'-'.$imovel['imf_arquivo'] : 'application/images/no-image-transparent.png';
                $html .= '
                <div id="favoritos-container" class="cursor-pointer border-4 border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                    <div class="flex gap-4">
                        <!-- FOTO (esquerda) --> 
                        <div class="w-1/3 rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                                                
                            <div class="rounded-md overflow-hidden relative" style="height: 150px;">
                                <div @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');" class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url('.$foto.');"></div>
    
                                <!-- AÇÕES -->
                                <div class="absolute top-2 right-2 w-full flex justify-end gap-1">                                    
                                    <!-- COMPARTILHAR -->
                                    <div>
                                        <div @click="() => toggleShare('.$i.')" class="bg-white dark:bg-dark rounded p-2 flex relative">
                                            <button type="button" class="text-secondary group" data-imovel-id="6" x-tooltip="Compartilhar este imóvel" data-theme="secondary" @click="() => openModalFormVisita(null, '.$imovel['imo_codigo'].')">
                                                ' . file_get_contents('../../../icons/compartilhar.svg') . '
                                            </button>
                                        </div>
                                        <!-- SELECIONAR MODO DE COMPARTILHAMENTO -->
                                        <div x-show="openShare && indexShare == '.$i.'" x-transition x-transition.duration.300 class="absolute mt-1">
                                            <div class="bg-white dark:bg-dark rounded p-2 flex flex-col gap-3">
                                                <div class="flex gap-1 items-center" x-tooltip="Copiar link do imóvel" data-theme="primary" @click="() => copyLink('.$imovel['imo_codigo'].');" >
                                                    <div class="text-primary">
                                                        ' . file_get_contents('../../../icons/copiar.svg') . '
                                                    </div>
                                                    <p class="text-sm">Copiar Link</p>                                                
                                                </div>
                                                <div class="flex gap-1 items-center" x-tooltip="Compartilhar no whatsapp do pretendente" data-theme="success" @click="() => shareWhatsapp('.$imovel['imo_codigo'].', \''.$pretendente[0]['prw_telefones'].'\');" >
                                                    <div class="text-success">
                                                        ' . file_get_contents('../../../icons/whatsapp.svg') . '
                                                    </div>
                                                    <p class="text-sm">WhatsApp</p>                                                
                                                </div>
                                            </div>
    
                                        </div>                       
                                    </div>
    
                                    <!-- MARCAR VISITA -->
                                    <div @click="toggle2;" class="bg-white dark:bg-dark rounded p-2 flex">
                                        <button type="button" class="text-primary group" data-imovel-id="6" x-tooltip="Marcar visita" data-theme="primary" @click="() => openModalFormVisita(null, '.$imovel['imo_codigo'].')">
                                            ' . file_get_contents('../../../icons/flag.svg') . '
                                        </button>
                                    </div>
                                    
                                    <!-- FAVORITAR -->
                                    <div class="bg-white dark:bg-dark rounded p-2 flex">';
                                        if($imovel['favorito'] == 1){
                                            $html .= '
                                            <button type="button" class="text-warning group" x-tooltip="Desfavoritar Imóvel" @click="() => setFavorite(false, ' . $imovel['imo_codigo'] . ')">
                                                ' . file_get_contents('../../../icons/starContained.svg') . '
                                            </button>';
                                        }else{
                                            $html .= '
                                            <button type="button" class="text-warning group" x-tooltip="Favoritar imóvel" data-theme="warning" @click="() => setFavorite(true, ' . $imovel['imo_codigo'] . ')">
                                                ' . file_get_contents('../../../icons/star.svg') . '
                                            </button>';
                                        }                                
                                    $html .= '
                                    </div>                                    
                                </div>
                            </div>                      
                        </div> 
    
                        <!-- Conteúdo (direita) -->
                        <div class="w-full p-5">
                            <div class="flex flex-col gap-10" @click="toggle; getImovel('.$imovel['imo_codigo'].'); getImovelPhotos('.$imovel['imo_codigo'].');">
                                <div class="flex justify-between items-center ">
                                    <div>
                                        <p class="text-lg font-bold">
                                            ' . $imovel['imo_codigo'] . ' - ' . $imovel['tpi_descricao'] . ' - ' . $imovel['bai_descricao'] . '
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-success">
                                            R$ '.number_format(($imovel['imv_valor']/100), 2, ',', '.').'
                                        </p>
                                    </div>
                                </div>
    
                                <div class="flex justify-between">
                                    <div class="flex flex-col items-center">                                    
                                        ' . file_get_contents('../../../../application/icons/area.svg') . '                        
                                        <p class="mt-2 text-xs">' . ($imovel['imo_areaconstruida'] ? number_format(($imovel['imo_areaconstruida'] / 100), 0, ',', '.') : '0') . 'm²</p>
                                    </div>
                                    
                                    <div class="flex flex-col items-center">
                                        ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '                        
                                        <p class="mt-2 text-xs">' . ($imovel['imo_quartos'] ? $imovel['imo_quartos'] : '0') . ' Quartos</p>
                                    </div>';
                                        
                                    if($imovel['imo_suites'] > 0){
                                        $html .= '
                                        <div class="flex flex-col items-center">
                                            ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '                        
                                            <p class="mt-2 text-xs">Sendo '.$imovel['imo_suites'].' '.($imovel['imo_suites'] > 1 ? 'suítes' : 'suíte').'</p>
                                        </div>';
                                    }
                                        
                                    $html .= '
                                    <div class="flex flex-col items-center">
                                        ' . file_get_contents('../../../../application/icons/banheiro.svg') . '
                                        <p class="mt-2 text-xs">' . ($imovel['imo_banheiros'] ? $imovel['imo_banheiros'] : '0') . ' Banheiros</p>
                                    </div>
    
                                    <div class="flex flex-col items-center">
                                        ' . file_get_contents('../../../../application/icons/vagagaragem.svg') . '                          
                                        <p class="mt-2 text-xs">' . ($imovel['imo_garagem'] ? $imovel['imo_garagem'] : '0') . ' Vagas</p>
                                    </div>
                                </div>
                            </div>                       
                        </div>
                    </div>    
                </div>';
            }                    
        $html .= ' 
        </div>';
    }else{
        $html = '<p class="text-md">Nenhum imóvel encontrado</p>';
    }
    return $html;
}

//? Função que cria e configura o script (sql) para buscar os imóveis
function createScriptImoveis($value, $filters, $sideFilters){
    $sql = '
    SELECT 
        i.imo_codigo, 
        ti.tpi_descricao, 
        i.imo_rua, 
        b.bai_descricao, 
        i.imo_areaconstruida, 
        i.imo_quartos, 
        i.imo_suites,
        i.imo_banheiros, 
        i.imo_garagem, 
        ((iv.imv_valor*m.moe_valor)/100) AS imv_valor,
        ft.imf_imovel,
        ft.imf_arquivo,
        (SELECT MAX(pwi_favorito) 
        FROM pretendentesimoveis 
        WHERE pwi_imovel = i.imo_codigo AND pwi_pretendente = '.$value['pretendente'].' AND pwi_favorito = 1) AS favorito
    FROM imoveis AS i 
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo AND iv.imv_web = "s")
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)
        LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s" AND ft.imf_web = "s")
        LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
        LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
    WHERE (i.imo_codigo IN (SELECT pwi_imovel FROM pretendentesimoveis WHERE pwi_pretendente = '.$value['pretendente'].' AND pwi_favorito = 1)) OR ('; // Imóveis favoritos

    //? Filtros da barra lateral     
    if($sideFilters){ 
        //? Código
        if($sideFilters['codigo']) $sql .= ' i.imo_codigo = "'.$sideFilters['codigo'].'" AND ';
        //? Faixa de valor 
        if($sideFilters['valorIni'] && $sideFilters['valorFin']) {
            $sql .= ' (((iv.imv_valor*m.moe_valor)/100)/100) BETWEEN "'.moneyToFloat($sideFilters['valorIni']).'" AND "'.moneyToFloat($sideFilters['valorFin']).'" AND ';
        }
        //? Bairro 
        if($sideFilters['bairro'] != '') $sql .= ' b.bai_descricao LIKE "%'.$sideFilters['bairro'].'%" AND ';
        //? Dormitórios (between)
        if($sideFilters['dormitoriosIni'] && $sideFilters['dormitoriosFin']) {
            $sql .= ' i.imo_quartos BETWEEN "'.$sideFilters['dormitoriosIni'].'" AND "'.$sideFilters['dormitoriosFin'].'" AND ';
        }
        //? Suítes (between)
        if($sideFilters['suitesIni'] && $sideFilters['suitesFin']) {
            $sql .= ' i.imo_suites BETWEEN "'.$sideFilters['suitesIni'].'" AND "'.$sideFilters['suitesFin'].'" AND ';
        }
        //? Garagem 
        if($sideFilters['garagem'] != '') $sql .= ' i.imo_garagem = "'.$sideFilters['garagem'].'" AND ';
        //? Tipo de imóvel 
        if($sideFilters['tipoImovel'] != '') $sql .= ' i.imo_tipoimovel = "'.$sideFilters['tipoImovel'].'" AND ';

        $sql = substr($sql, 0, -4);
        $sql .= ') ';
    }else{
        $filters = json_decode($filters);
        // $sql .= ' AND ( ';
        foreach($filters as $keyPerfil => $valuePerfil){ // cada perfil
            $sql .= ' (';
            foreach($valuePerfil as $keyCampo => $valueCampo){ // cada campo do perfil
                //? Com intervalo de valores
                if($valueCampo->intervalo && $valueCampo->inicio != '' && $valueCampo->fim != ''){
                    if($keyCampo == 'ppf_valor'){ //? Valor faz join com tabela imovelvenda
                        $sql .= '(((iv.'.convertField($keyCampo).'*m.moe_valor)/100)/100) BETWEEN "'.$valueCampo->inicio.'" AND "'.$valueCampo->fim.'" AND ';
                    }else{
                        $sql .= 'i.'.convertField($keyCampo) .' BETWEEN "'.$valueCampo->inicio.'" AND "'.$valueCampo->fim.'" AND ';
                    }
                }else 
                //? Com valores únicos
                if(!$valueCampo->intervalo && $valueCampo->valor != ''){
                    $sql .= 'i.'.convertField($keyCampo) .' = "'.$valueCampo->valor.'" AND ';
                }
            }
            $sql = substr($sql, 0, -4);
            $sql .= ') OR ';
        }
        $sql = substr($sql, 0, -4);
        $sql .= ' ) ';
    }

    $sql .= ' 
    GROUP BY i.imo_codigo
    ORDER BY 
        (SELECT MAX(pwi_favorito) FROM pretendentesimoveis WHERE pwi_imovel = i.imo_codigo AND pwi_pretendente = '.$value['pretendente'].') DESC,
        i.imo_codigo DESC
    LIMIT 100';

    return $sql;
}

//? Converte nome da coluna da tabela pretendentesperfil pra nome da coluna da tabela imoveis
function convertField($field){
    switch($field){
        case 'ppf_tipoimovel':
            return 'imo_tipoimovel';
        break;
        case 'ppf_utilizacao':
            return 'imo_utilizacao';
        break;
        case 'ppf_quartos':
            return 'imo_quartos';
        break;
        case 'ppf_suites':
            return 'imo_suites';
        break;
        case 'ppf_garagem':
            return 'imo_garagem';
        break;
        case 'ppf_valor':
            return 'imv_valor'; //* tabela imovelvenda
        break;
        case 'ppf_areaterreno':
            return 'imo_areaterreno';
        break;
        case 'ppf_areaconstruida':
            return 'imo_areaconstruida';
        break;
        case 'ppf_empreendimento':
            return 'imo_empreendimento';
        break;
    }
}

//? Extrai os filtros relevantes do perfil (que possuem valor)
function getFilters($prw_codigo, $data){
    if(!$prw_codigo){
        return false;
    }

    // Busca perfis
    $sql = 'SELECT * FROM pretendentesperfil WHERE ppf_pretendente = '.$prw_codigo;
    $result = $data->find('dynamic', $sql);    

    // Busca filtros 
    $filtros = array();
    foreach($result as $key => $value){ // cada perfil  
        $perfil = array();
        foreach($value as $k => $v){
            if($v != '' && $v != 0 && $k != 'ppf_nome' && $k != 'ppf_pretendente' && $k != 'ppf_codigo' && $k != 'ppf_permuta'){            
                switch($k){
                    //? Campos com intervalo de valores
                    case 'ppf_quartosini':
                        $perfil['ppf_quartos']['inicio'] = $v;
                        $perfil['ppf_quartos']['intervalo'] = true;                        
                    break;
                    case 'ppf_quartosfim':
                        $perfil['ppf_quartos']['fim'] = $v;
                        $perfil['ppf_quartos']['intervalo'] = true;
                    break;
                    case 'ppf_suitesini':
                        $perfil['ppf_suites']['inicio'] = $v;
                        $perfil['ppf_suites']['intervalo'] = true;
                    break;
                    case 'ppf_suitesfim':
                        $perfil['ppf_suites']['fim'] = $v;
                        $perfil['ppf_suites']['intervalo'] = true;
                    break;
                    case 'ppf_valorini':
                        $perfil['ppf_valor']['inicio'] = $v;
                        $perfil['ppf_valor']['intervalo'] = true;
                    break;
                    case 'ppf_valorfim':
                        $perfil['ppf_valor']['fim'] = $v;
                        $perfil['ppf_valor']['intervalo'] = true;
                    break;
                    case 'ppf_areaterrenoini':
                        $perfil['ppf_areaterreno']['inicio'] = $v;
                        $perfil['ppf_areaterreno']['intervalo'] = true;
                    break;
                    case 'ppf_areaterrenofim':
                        $perfil['ppf_areaterreno']['fim'] = $v;
                        $perfil['ppf_areaterreno']['intervalo'] = true;
                    break;
                    case 'ppf_areaconstruidaini':
                        $perfil['ppf_areaconstruida']['inicio'] = $v;
                        $perfil['ppf_areaconstruida']['intervalo'] = true;
                    break;
                    case 'ppf_areaconstruidafim':
                        $perfil['ppf_areaconstruida']['fim'] = $v;  
                        $perfil['ppf_areaconstruida']['intervalo'] = true;
                    break;
                    //? Campos com valores únicos
                    default:
                        $perfil[$k]['valor'] = $v;                              
                        $perfil[$k]['intervalo'] = false;
                    break;
                }              
            }
        }
        $filtros[] = $perfil;
    }
    return json_encode($filtros);        
}
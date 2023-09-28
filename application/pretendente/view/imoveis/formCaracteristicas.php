<?php 
    $html .= '
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-5 text-center">';
        if($result[0]['imo_areaterreno']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areaterreno'] / 100), 0, ',', '.').' m² Área terreno</p>
                </div>
            </div>';
        }

        if($result[0]['imo_areaconstruida']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areaconstruida'] / 100), 0, ',', '.').' m² Área construída</p>
                </div>
            </div>';
        }

        if($result[0]['imo_areaprivativa']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areaprivativa'] / 100), 0, ',', '.').' m² Área privativa</p>
                </div>
            </div>';
        }

        if($result[0]['imo_areautil']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areautil'] / 100), 0, ',', '.').' m² Área útil</p>
                </div>
            </div>';                            
        }
        
        if($result[0]['imo_areacomum']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areacomum'] / 100), 0, ',', '.').' m² Área comum</p>
                </div>
            </div>';                            
        }
        
        if($result[0]['imo_areagaragem']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoRegua.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.number_format(($result[0]['imo_areagaragem'] / 100), 0, ',', '.').' m² Área garagem</p>
                </div>
            </div>';                            
        }

        if($result[0]['imo_garagem']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/vagagaragem.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.$result[0]['imo_garagem'].' Garagem</p>
                </div>
            </div>';
        }
        
        if($result[0]['imo_quartos']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.$result[0]['imo_quartos'].' Quarto(s)</p>
                </div>
            </div>';
        }

        if($result[0]['imo_suites']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/dormitorio.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.$result[0]['imo_suites'].' Suíte(s)</p>
                </div>
            </div>';
        }

        if($result[0]['imo_banheiros']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/banheiro.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.$result[0]['imo_banheiros'].' Banheiro(s)</p>
                </div>
            </div>';
        }        
        
        if($result[0]['tipoconstrucao']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoTpConstrucao.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['tipoconstrucao'].'</p>
                </div>
            </div>';
        }        

        if($result[0]['imo_cozinha']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/cozinha.svg') . '       
                </div>
                <div>                    
                    <p class="text-xs mt-0" >'.$result[0]['imo_cozinha'].' Cozinhas</p>
                </div>
            </div>';
        }
    
    $html .= '
    </div>';

    return $html;
?>
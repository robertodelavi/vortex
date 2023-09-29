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
                    <p class="text-xs mt-0" >Área terreno<br/>'.number_format(($result[0]['imo_areaterreno'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Área construída<br/>'.number_format(($result[0]['imo_areaconstruida'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Área privativa<br/>'.number_format(($result[0]['imo_areaprivativa'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Área útil<br/>'.number_format(($result[0]['imo_areautil'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Área comum<br/>'.number_format(($result[0]['imo_areacomum'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Área garagem<br/>'.number_format(($result[0]['imo_areagaragem'] / 100), 0, ',', '.').' m²</p>
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
                    <p class="text-xs mt-0" >Garagem<br/>'.$result[0]['imo_garagem'].' vaga(s)</p>
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
                    <p class="text-xs mt-0" >Sendo '.$result[0]['imo_suites'].' suíte(s)</p>
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

        if($result[0]['utilizacao']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoProximidade.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['utilizacao'].'</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_edificio']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPredio.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['imo_edificio'].'</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_pontoreferencia']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoProximidade.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['imo_pontoreferencia'].'</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_posicao']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPosicaoSolar.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['imo_posicao'].'</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_elevadores']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoElevador.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['imo_elevadores'].' elevador(es)</p>
                </div>
            </div>';
        }     
        
        if($result[0]['tipoPiso']){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoOutros.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >'.$result[0]['tipoPiso'].'</p>
                </div>
            </div>';
        }     
       
        if($result[0]['imo_salaestar'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoSala.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Sala de Estar</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_salatv'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoTV.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Sala de TV</p>
                </div>
            </div>';
        }     
        
        if($result[0]['imo_lareira'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoChurrasqueira.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Lareira</p>
                </div>
            </div>';
        }     

        if($result[0]['imo_cozinha'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoCozinha.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Cozinha</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_areadeservico'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoLavanderia.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Lavanderia</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_dependenciaempregada'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoQuarto.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Dependência de Empregada</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_gascentral'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoGasCentral.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Gás Central</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_playground'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPlayground.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Playground</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_lavabo'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoLavabo.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Lavabo</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_churrasqueira'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoChurrasqueira.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Churrasqueira</p>
                </div>
            </div>';
        }   
       
        if($result[0]['imo_salaofestas'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoFesta.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Salão de Festas</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_sacada'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoSacada.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Sacada</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_pocoartesiano'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPoco.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Poço Artesiano</p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_portaoeletronico'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPortaoElevacao.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Portão Eletrônico</p></p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_condominiofechado'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoCasa.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Condomínio Fechado</p></p>
                </div>
            </div>';
        }   
       
        if($result[0]['imo_arealazer'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoLazer.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Área de Lazer</p></p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_piscina'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoPiscina.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Piscina</p></p>
                </div>
            </div>';
        }   
        
        if($result[0]['imo_terraco'] == 's'){
            $html .= '
            <div class="flex flex-col items-center">
                <div class="mb-1">
                    ' . file_get_contents('../../../../application/icons/icoOutros.svg') . '       
                </div>
                <div>
                    <p class="text-xs mt-0" >Terraço</p></p>
                </div>
            </div>';
        }   
    
    $html .= '
    </div>';

    return $html;
?>
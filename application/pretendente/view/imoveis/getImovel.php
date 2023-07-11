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
                    <div class="rounded-md overflow-hidden relative w-full" style="height: 300px; width: 100%;">
                        <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-2.jpg);"></div>                        
                    </div>         

                    <div class="grid grid-cols-2 md:grid-cols-4 mt-4 gap-4 text-center" >
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
                        <div class="rounded-md overflow-hidden relative w-full" style="height: 80px; width: 100%;">
                            <div class="bg-cover bg-center h-full transform hover:scale-110 transition duration-500 ease-in-out " style="background-image: url(application/pretendente/view/imoveis/img/foto-4.jpg);"></div>                        
                        </div>         
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
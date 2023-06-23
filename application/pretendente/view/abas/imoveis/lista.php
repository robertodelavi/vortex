<?php

$imoveis = [
    array(
        'id' => 1,
        'nome' => 'Casa 1',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-6.jpg',
    ),
    array(
        'id' => 2,
        'nome' => 'Casa 2',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-2.jpg',
    ),
    array(
        'id' => 3,
        'nome' => 'Casa 3',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-3.jpg',
    ),
    array(
        'id' => 4,
        'nome' => 'Casa 4',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-4.jpg',
    ),
    array(
        'id' => 5,
        'nome' => 'Casa 5',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-5.jpg',
    ),
    array(
        'id' => 6,
        'nome' => 'Casa 6',
        'descricao' => 'Casa com 3 quartos, 2 banheiros, 1 vaga de garagem',
        'imagem' => 'application/pretendente/view/abas/imoveis/img/foto-1.jpg',
    )
];
?>

<div class="switch">
    <!-- FAVORITOS -->
    <div>
        <h5 class="font-semibold text-lg mb-4">Favoritos</h5>
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">         -->
        <div class="grid grid-cols-4 gap-4">
            <?php
            foreach ($imoveis as $i => $imovel) {
                echo '

                <div class="cursor-pointer border border-[#ebedf2] dark:border-[#191e3a] dark:hover:border-primary hover:border-primary rounded-md hover:transition-colors duration-300 bg-white dark:bg-[#0e1726] p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),_0px_12px_24px_-4px_rgba(145,158,171,0.12)]">
                    <div class="rounded-md overflow-hidden mb-5 shadow-[0_6px_10px_0_rgba(0,0,0,0.14),_0_1px_18px_0_rgba(0,0,0,0.12),_0_3px_5px_-1px_rgba(0,0,0,0.20)]">                        
                        <div class="rounded-md overflow-hidden" style="height: 300px;">
                            <div class="bg-cover bg-center h-full" style="background-image: url('.$imovel['imagem'].');"></div>
                        </div>
                    </div>
                    <h5 class="text-xl mb-5">' . $imovel['nome'] . '</h5>
                    <div class="flex">
                        <div class="flex-1">
                            <p>' . $imovel['descricao'] . '</p>
                        </div>
                    </div>
                </div>
';
            }
            ?>
        </div>
    </div>

    <!-- IMÓVEIS -->
    <div class="mt-3">
        <h5 class="font-semibold text-lg my-6">Imóveis</h5>
    </div>
</div>
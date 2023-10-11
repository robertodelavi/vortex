<?php include 'application/home/imoveisNovos/getData.php'; ?>

<div class="text-lg font-bold">
    Imóveis novos para seus pretendentes
    <?php if($result && count($result) > 0){ echo '<span class="badge bg-success/20 text-success rounded-full hover:top-0">'.count($result).' registros encontrados</span>'; } ?>
</div>
<p class="mb-8 text-xs">Contém os imóveis novos que atendem aos critérios dos seus pretendentes</p>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Pretendente</th>
                <th>Imóvel</th>
                <th>Valor</th>
                <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">Imóvel cadastrado</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if($result && count($result) > 0){
                    foreach ($result as $key => $value) { 
                        echo '
                        <tr>
                            <td class="font-semibold cursor-pointer hover:text-primary" onClick="nextPage(\'?module=pretendente&acao=edita_pretendente\', '.$value['prw_codigo'].');" >                                
                                '.$value['pretendente'].'                                
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="flex items-center gap-2"> 
                                    <div class="border border-[#ebedf2] dark:border-[#191e3a] rounded-full overflow-hidden h-10 w-10">
                                        <div class="bg-cover bg-center h-full" style="background-image: url('.$value['foto'].');" ></div>
                                    </div>
                                    <div>'.$value['imovel'].'</div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap text-success">'.$value['valor'].'</td>
                            <td class="text-center">
                                <span class="badge bg-primary whitespace-nowrap">há '.($value['diasCadastro'] == 1 ? $value['diasCadastro'].' dia' : $value['diasCadastro'].' dias').'</span>
                            </td>
                        </tr>';
                    }
                }else{
                    echo '
                    <tr>
                        <td colspan="4" class="text-center">Nenhum resultado encontrado!</td>
                    </tr>'; 
                }
            ?>
        </tbody>
    </table>
</div>
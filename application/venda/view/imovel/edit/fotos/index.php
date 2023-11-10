<?php 
    $sql = '
    SELECT 
        iv.*,
        (((iv.imv_valor*m.moe_valor)/100)/100) AS imv_valor
    FROM imoveis AS i 
        INNER JOIN imovelvenda AS iv ON (i.imo_codigo = iv.imv_codigo)
        LEFT JOIN moedas AS m ON (iv.imv_moeda = m.moe_codigo)        
    WHERE i.imo_codigo = '.$_POST['param_0'];
    // $result = $data->find('dynamic', $sql);
?>

<form method="POST" action="?module=venda&acao=update_fotos_imovel" >
    <div class="flex flex-col gap-3"  >
        <div class="panel">
            <input type="hidden" name="imv_codigo" value="<?php echo $_POST['param_0']; ?>" />
    
            <!-- Cabeçalho -->
            <div class="flex justify-between mb-4">
                <div>
                    <h5 class="text-lg font-semibold">Observações</h5>
                </div>    
                <div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>            
            </div>       
            
            <!-- Dados -->        
            <div class="flex flex-col gap-3">

                <!-- Área pra inserir fotos -->
                <div class="flex-1">
                <input type="file" 
                    class="filepond"
                    name="filepond" 
                    multiple >            
                </div>

            </div>        
        </div>
    </div>    
</form>
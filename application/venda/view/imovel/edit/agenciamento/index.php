<?php 
    $sql = '
    SELECT 
        i.*,
        DATE_FORMAT(i.imo_datacad, "%d/%m/%Y") AS imo_datacad,
        DATE_FORMAT(i.imo_dataatual, "%d/%m/%Y") AS imo_dataatual
    FROM imoveis AS i 
    WHERE i.imo_codigo = '.$_POST['param_0'];
    $result = $data->find('dynamic', $sql);
?>

<div class="panel">
    <form method="POST" action="?module=venda&acao=update_agenciamento_imovel" >
        <input type="hidden" name="imo_codigo" value="<?php echo $_POST['param_0']; ?>" />

        <!-- Cabeçalho -->
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="text-lg font-semibold">Agenciamento</h5>
            </div>    
            <div>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>            
        </div>   
        
        <!-- Dados -->
        <div class="flex flex-col sm:flex-row" >
            <div class="flex-1 grid sm:grid-cols-2 md:grid-cols-4 gap-5">
                <!-- Nome -->
                <div>
                    <label>Nome (?)</label>
                    <input type="text" placeholder="" class="form-input" value="<?php echo $result[0]['motivo']; ?>" />
                </div>
            </div>
        </div>
    </form>
</div>
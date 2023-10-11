<?php 
    //? TOASTS
    if(isset($_GET['status'])){
        switch($_GET['status']){
            case 1:
                echo '
                <script>
                    setTimeout(() => {
                        toast("Dados da visita atualizados com sucesso!", "success", 3000);
                    }, 300);
                </script>';
            break;
        }
    }
?>

<div class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
    <form method="POST" action="?module=pretendente&acao=update_visitas">
        <div class="flex justify-between mb-4">
            <div>
                <h5 class="text-lg font-semibold">Visita</h5>
            </div>    
            <div class="flex gap-4">
                <button type="button" onclick="nextPage('?module=pretendente&acao=lista_visitas', '');" class="btn btn btn-outline-dark">
                    <?php echo file_get_contents('application/icons/voltar.svg'); ?>
                    Voltar
                </button>   
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>            
        </div>   

        <?php include_once('application/pretendente/view/visita/view/formVisita.php'); ?>
    </form>
</div>
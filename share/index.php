<?php 
    // Header default
    session_start();
    require_once('../library/DataManipulation.php');
    require_once('../library/MySql.php');
    $data = new DataManipulation();
    $conn = new MySql();

    

    //* Autenticação
	// $conn->connOpen('localhost','vortex__autenticacao','root', '');
    $conn->connOpen('brs36.brs.com.br','vegacscom_vortex','vegacscom_vortex', 'vortex@54741');

    $sql = '
    SELECT * 
    FROM encurtadorlink 
    WHERE enc_linkcurto = "'.$_GET['id'].'" AND enc_status = 1';
    $resultLink = $conn->executeQuery($sql);

    if ($conn->countLines($resultLink) > 0){
        for ($i=0; $i< $conn->countLines($resultLink); $i++){
            $imagem = $conn->result($resultLink, $i, 'enc_imagem');
            $titulo = $conn->result($resultLink, $i, 'enc_titulo');
            $descricao = $conn->result($resultLink, $i, 'enc_descricao');
            $link = $conn->result($resultLink, $i, 'enc_linklongo');

            // Criar HTML com meta para visualização de imagem, titulo e descrição na miniatura
            echo '
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">    
                <meta property="og:image" content="https://blog.blablacar.com.br/wp-content/uploads/2017/01/jeri%201.jpg">
                <meta property="og:title" content="<?=$titulo?>">
                <meta property="og:description" content="<?=$descricao?>">
                <meta name="description" content="<?=$descricao?>">
            </head>
            <body>
                <!-- Conteúdo da página (opcional) -->
            </body>
            </html>';

            if($link != ''){
                // Redireciona para o link
                header('Location: https://vegax.com.br/vortex'.$link);                
            }            
        }
    } else {
        header('Location: https://vegax.com.br/vortex');
    }
?>


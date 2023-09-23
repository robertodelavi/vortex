<?php
    // Desativa a exibição de erros
    ini_set('display_errors', 0);

    // Define o nível de relatório de erros para ignorar os warnings
    error_reporting(E_ALL & ~E_WARNING);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vórtex Sistemas - Detalhes do imóvel</title>
        <link rel="icon" type="image/x-icon" href="../../application/images/favicon.ico">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

        <meta property="og:image" content="<?php echo $_GET['img']?>">
        <!-- Substitua "URL_DA_IMAGEM_AQUI" pela URL da imagem que deseja exibir como miniatura -->

        <!-- Outras meta tags Open Graph -->
        <meta property="og:title" content="<?php echo $_GET['titulo']?>">
        <meta property="og:description" content="<?php echo $_GET['desc']?>">
        <!-- Adicione outras meta tags Open Graph conforme necessário -->

        <script>
            var url = 'https://vegax.com.br/vortex/api/imoveis/detalhes/?emp='+<?php echo $_GET['emp']?>+'&id='+<?php echo $_GET['id']?>;

            jQuery(function($){
                const formatter = new Intl.NumberFormat('pt-br', {
                    style: 'currency',
                    currency: 'BRL',
                    // These options are needed to round to whole numbers if that's what you want.
                    //minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
                    //maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
                    //como usar formatter.format(data.valorEstimadoProximoConcurso)
                });
                
                $.getJSON(url, {
                    format: 'json'
                })
                .done(function(data) {
                    var linhaCarac = 0;
                    var contItens = 0;
                    var item = [];
                    var dispositivo = '';

                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        // O usuário está navegando a partir de um dispositivo móvel
                        dispositivo = 'celular';
                        tamanhoColuna = 'flex flex-col items-center w-1/3';
                    } else {
                        // O usuário está navegando a partir de um desktop ou outro dispositivo
                        dispositivo = 'desktop';
                        tamanhoColuna = 'flex flex-col items-center w-1/4';
                    }

                    if(data.data[0]['areaTerreno'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área terreno<br />'+(data.data[0]['areaTerreno']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['area'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área construida<br />'+(data.data[0]['areaConstruida']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaPrivativa'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área privativa<br />'+(data.data[0]['areaPrivativa']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaUtil'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área útil<br />'+(data.data[0]['areaUtil']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaComum'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área comum<br />'+(data.data[0]['areaComum']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaGaragem'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs text-center">Área garagem<br />'+(data.data[0]['areaGaragem']/100)+' m²</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['garagem'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoGaragem.svg'); ?><p class="mt-2 text-xs text-center">Garagem<br />'+data.data[0]['garagem']+' Vaga(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['quartos'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['quartos']+' Quarto(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['suites'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs text-center">Sendo '+data.data[0]['suites']+' Suites(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['banheiros'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoBanheiro.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['banheiros']+' Banheiros(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['tipoConstrucao'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoTpConstrucao.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['tipoConstrucao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['utilizacao'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoProximidade.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['utilizacao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['edificio'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPredio.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['edificio']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['pontoReferencia'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoProximidade.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['pontoReferencia']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['posicao'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPosicaoSolar.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['posicao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['elevadores'] > 0){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoElevador.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['elevadores']+' elevador(es)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['tipoPiso'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoOutros.svg'); ?><p class="mt-2 text-xs text-center">'+data.data[0]['tipoPiso']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaEstar'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoSala.svg'); ?><p class="mt-2 text-xs text-center">Sala de Estar</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaTv'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoTV.svg'); ?><p class="mt-2 text-xs text-center">Sala de TV</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['lareira'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoChurrasqueira.svg'); ?><p class="mt-2 text-xs text-center">Lareira</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['cozinha'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoCozinha.svg'); ?><p class="mt-2 text-xs">Cozinha</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaDeServico'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoLavanderia.svg'); ?><p class="mt-2 text-xs">Área de Serviço</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['dependenciaEmpregada'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs text-center">Dependência de Empregada</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['gasCentral'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs text-center">Gás Central</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['playground'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPlayground.svg'); ?><p class="mt-2 text-xs text-center">Playground</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['lavabo'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoLavabo.svg'); ?><p class="mt-2 text-xs text-center">Lavabo</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['churrasqueira'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoChurrasqueira.svg'); ?><p class="mt-2 text-xs text-center">Churrasqueira</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaoFestas'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoFesta.svg'); ?><p class="mt-2 text-xs text-center">Salão Festa</p></div>');
                        contItens++;
                    } 

                    if(data.data[0]['sacada'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoSacada.svg'); ?><p class="mt-2 text-xs text-center">Sacada</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['pocoArtesiano'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPoco.svg'); ?><p class="mt-2 text-xs text-center">Poço Artesiano</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['portaoEletronico'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPortaoElevacao.svg'); ?><p class="mt-2 text-xs text-center">Portão Eletrônico</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['condominioFechado'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoCasa.svg'); ?><p class="mt-2 text-xs text-center">Condominio Fechado</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaLazer'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoLazer.svg'); ?><p class="mt-2 text-xs text-center">Área Lazer</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['piscina'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPiscina.svg'); ?><p class="mt-2 text-xs text-center">Piscina</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['terraco'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoOutros.svg'); ?><p class="mt-2 text-xs text-center">Terraco</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['codigo'] != ''){
                        document.getElementById('titulo').innerHTML = '<span class="badge bg-primary" style="margin: 5px;"> #'+data.data[0]['codigo']+'</span>';
                    }

                    if(data.data[0]['detalhes'] != ''){
                        document.getElementById('descricaoImovel').innerHTML += '<p mt-5><b>Mais informações:</b> '+data.data[0]['detalhes']+'</p>';
                    }

                    if(data.data[0]['rua'] != ''){
                        document.getElementById('localizacao').innerHTML += '<p style="margin-right: 5px"><?php echo file_get_contents('../../application/icons/icoPin.svg'); ?></p><p>'+data.data[0]['rua'].toUpperCase()+' '+data.data[0]['numero'].toUpperCase()+' '+data.data[0]['complemento'].toUpperCase()+',<br /> BAIRRO '+data.data[0]['bairro'].toUpperCase()+', '+data.data[0]['cidade'].toUpperCase()+'/'+data.data[0]['uf'].toUpperCase()+'</p>';
                    }
                    

                    if(data.data[0]['tipo'] != ''){
                        document.getElementById('tagsImoveis').innerHTML += '<span class="badge bg-success" style="margin: 5px;">'+data.data[0]['tipo'].toUpperCase()+'</span>';
                    }

                    if(data.data[0]['bairro'] != ''){
                        document.getElementById('tagsImoveis').innerHTML += '<span class="badge bg-info" style="margin: 5px;">'+data.data[0]['bairro'].toUpperCase()+'</span>';
                    }

                    if(dispositivo == 'celular'){
                        if(data.data[0]['fotos']['capa']['url'] != ''){
                            document.getElementById('fotoCapa').innerHTML = "<img src='"+data.data[0]['fotos']['capa']['url']+"' class='object-cover' />";
                        }
                    }else{
                        if(data.data[0]['fotos']['capa']['url'] != ''){
                            document.getElementById('fotoCapa').innerHTML = "<div style='width: 100%; height: 90vh; background-size: cover; background-position: center; background-image: url("+data.data[0]['fotos']['capa']['url']+");'></div>";
                        }
                    }

                    if(data.data[0]['valor'] != ''){
                        var precovenda = 'R$ <strong>'+data.data[0]['valor']+'</strong>';
                    }else{
                        var precovenda = 'Sob consulta';
                    }

                    //Monta a parte das caracteristicas
                    document.getElementById('caracteristica').innerHTML = '<div class="flex justify-between mt-5" id="caracLinha0"></div>';
                    var aux;
                    for (var i=0; i < contItens; i++) {
                        document.getElementById('caracLinha'+linhaCarac).innerHTML += item[i];
                        aux = i+1;

                        if(dispositivo == 'celular'){
                            if(aux%2 == 0){
                                linhaCarac++;
                                document.getElementById('caracteristica').innerHTML += '<div class="flex justify-between mt-5" id="caracLinha'+linhaCarac+'"></div>';
                            }
                        }else{
                            if(aux%4 == 0){
                                linhaCarac++;
                                document.getElementById('caracteristica').innerHTML += '<div class="flex justify-between mt-5" id="caracLinha'+linhaCarac+'"></div>';
                            }
                        }                        
                    }
                    

                    //Valida quantos espaços preciso colocar a mais quando tem menos itens na ultima linha
                    if(dispositivo == 'celular'){
                        switch(aux%2){
                            case 1:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;
                        }
                    }else{
                        switch(aux%4){
                            case 1:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;
                            case 2:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';    
                                break;  
                            case 3:    
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;              
                        }
                    }

                    // Crie um elemento meta para cada propriedade que você deseja definir
                    var metaUrl = document.createElement('meta');
                    metaUrl.setAttribute('property', 'og:url');
                    metaUrl.setAttribute('content', window.location.href);

                    var metaTitle = document.createElement('meta');
                    metaTitle.setAttribute('property', 'og:title');
                    metaTitle.setAttribute('content', data.data[0]['codigo']+' - '+data.data[0]['tipo']+' - '+data.data[0]['bairro']);

                    var metaImage = document.createElement('meta');
                    metaImage.setAttribute('property', 'og:image');
                    metaImage.setAttribute('content', data.data[0]['fotos']['capa']['url']);

                    var metaDescription = document.createElement('meta');
                    metaDescription.setAttribute('property', 'og:description');
                    metaDescription.setAttribute('content', data.data[0]['fotos']['capa']['descricao']);

                    var metaTwitterDescription = document.createElement('meta');
                    metaTwitterDescription.setAttribute('property', 'twitter:description');
                    metaTwitterDescription.setAttribute('content', data.data[0]['fotos']['capa']['descricao']);

                    var metaTwitterTitle = document.createElement('meta');
                    metaTwitterTitle.setAttribute('property', 'twitter:title');
                    metaTwitterTitle.setAttribute('content', data.data[0]['codigo']+' - '+data.data[0]['tipo']+' - '+data.data[0]['bairro']);

                    var metaTwitterImage = document.createElement('meta');
                    metaTwitterImage.setAttribute('property', 'twitter:image');
                    metaTwitterImage.setAttribute('content', data.data[0]['fotos']['capa']['url']);

                    // Acesse o elemento head do seu documento HTML
                    var head = document.head || document.getElementsByTagName('head')[0];

                    // Adicione as meta tags criadas ao elemento head
                    head.appendChild(metaUrl);
                    head.appendChild(metaTitle);
                    head.appendChild(metaImage);
                    head.appendChild(metaDescription);

                    head.appendChild(metaTwitterDescription);
                    head.appendChild(metaTwitterTitle);
                    head.appendChild(metaTwitterImage);
                    

                    document.getElementById('detValor').innerHTML = precovenda;

                    // DADOS DA EMPRESA ------------------------------------------------------------------------------------------------------        
                    if(data.data[0]['empresa']['logomarca'] !== undefined && data.data[0]['empresa']['logomarca'] != ''){
                        document.getElementById('logoCliente').innerHTML = '<img src="'+data.data[0]['empresa']['logomarca']+'" style="width: 10rem;" class="rounded-md" />';
                    }else{
                        document.getElementById('logoCliente').innerHTML = '<img src="../../application/images/logo-vortex-branca.png" style="width: 10rem;" />';
                    }

                    if(data.data[0]['empresa']['nome'] != ''){
                        document.getElementById('infoEmpresa').innerHTML = '<p class="dark:text-white-light"><b>'+data.data[0]['empresa']['nome']+'</b></p>';
                    }else{
                        document.getElementById('infoEmpresa').innerHTML = '<p class="dark:text-white-light"><b>Vortex Sistemas</b></p>';
                    }     

                    if(data.data[0]['empresa']['cnpj'] != ''){
                        document.getElementById('infoEmpresa').innerHTML += '<p class="dark:text-white-light"><b>CNPJ:</b> '+data.data[0]['empresa']['cnpj']+'</p>';
                    }else{
                        document.getElementById('infoEmpresa').innerHTML += '<p class="dark:text-white-light"><b>Vortex Sistemas</b></p>';
                    }   

                    if(data.data[0]['empresa']['creci'] != ''){
                        document.getElementById('infoEmpresa').innerHTML += '<p class="dark:text-white-light mb-3"><b>CRECI:</b> '+data.data[0]['empresa']['creci']+'</p>';
                    } 

                    if(data.data[0]['empresa']['telefone']['comercial'] != ''){
                        document.getElementById('infoEmpresa').innerHTML += '<p class="flex"><?php echo file_get_contents('../../application/icons/icoTelefone.svg'); ?>  &nbsp;'+data.data[0]['empresa']['telefone']['comercial']+'</p>';
                    }        

                    if(data.data[0]['empresa']['email'] != ''){
                        document.getElementById('infoEmpresa').innerHTML += '<p class="flex"><?php echo file_get_contents('../../application/icons/icoEmail.svg'); ?>  &nbsp;'+data.data[0]['empresa']['email']+'</p>';
                    }       

                    if(data.data[0]['empresa']['endereco'] != ''){
                        document.getElementById('infoEmpresa').innerHTML += '<p class="flex"><?php echo file_get_contents('../../application/icons/icoPin.svg'); ?>  &nbsp;'+data.data[0]['empresa']['endereco']+'</p>';
                    }    

                    
                    for (var j = 0; j < data.data[0]['fotos']['galeria'].length; j++) {
                      document.getElementById('galeriaFotos').innerHTML += '<a href="javascript:;"><img alt="image-gallery" data-fancybox="gallery" class="rounded-md w-full h-full object-cover" src="'+data.data[0]['fotos']['galeria'][j]['url']+'" data-caption="'+data.data[0]['fotos']['galeria'][j]['descricao']+'"></a>';
                    }                    
                    
                    //------------------------------------------------------------------------------------------------------ 
                });
            });
        </script>

        <!-- SEO -->
        <meta name="twitter:card" content="summary" />

        <meta name="description" content="Este é uma página para visualização dos imóvel cadastrados no sistema Vórtex.">
        <meta name="author" content="Vórtex Sistemas">
        <meta name="keywords" content="Imóveis, imobiliaria, vendas, locação"/>

        <link rel="alternate" href="" hreflang="pt-br" />
        <meta name="robots" content="index, follow">
        <meta name="theme-color" content="#0e1726">

        <meta property="business:contact_data:country_name" content="PAÍS" />
        <meta property="business:contact_data:website" content="URL" />
        <meta property="business:contact_data:region" content="SC" />
        <meta property="business:contact_data:email" content="EMAIL" />
        <meta property="business:contact_data:phone_number" content="TEL" />

        <meta name="geo.placename" content="LOCALIZAÇÃO" />
        <meta name="geo.region" content="BR" />
        <meta name="description" content="DESCRIÇÃO" />
        <link rel="canonical" href="URL" />

        <meta property="og:type" content="website" />
        <meta property="og:locale" content="pt_BR" />
        <meta name="format-detection" content="telephone=no">
        <!-- SEO -->
    </head>
    <body x-data="main" class="antialiased relative font-nunito text-sm font-normal overflow-x-hidden overflow-y-auto horizontal dark full ltr">
        <?php include '../../library/vristo/header-main.php'; ?>

        <link rel='stylesheet' type='text/css' media='screen' href='../../library/vristo/assets/css/fancybox.css'>
        <script src="../../library/vristo/assets/js/fancybox.umd.js"></script>
        <div>
            <div>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 pb-5 auto-cols-auto auto-rows-auto">
                    <div class="panel flex items-center">
                        <div class="flex h-screen items-center">
                            <div id="logoCliente"></div>
                            <div id="infoEmpresa" style="margin-left: 10px;"></div>
                        </div>
                    </div>

                    <div class="panel">
                        <div>
                            <div id="titulo" class="mb-8"></div>
                            <div class="grid lg:grid-cols-1 grid-cols-1 gap-6">
                                <div>                    
                                    <div class="">À venda por</div>
                                    <h2 class="font-bold text-4xl dark:text-white-light" id="detValor"></h2>
                                </div>

                                <div class="flex items-end">
                                    <div class="w-1/2">
                                        <button type="button" class="btn btn-outline-primary w-full">Fale conosco</button>
                                    </div>
                                    <div class="w-1/2 ml-2">
                                        <button type="button" class="btn btn-outline-success w-full">Compartilhe</button>
                                    </div>
                                    <!--
                                    <p>Compartilhe este imóvel</p>
                                    <div class="flex mt-3" style="font-size: 1.8em;">
                                        <a href="https://wa.me/?text=https://www.alternativachapeco.com.br/detalhes-imovel/?id_imovel=5666" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>&nbsp;&nbsp;&nbsp;
                                        
                                        <a href="https://t.me/share/url?url=https://www.alternativachapeco.com.br/detalhes-imovel/?id_imovel=5666" target="_blank" rel="noopener">
                                            <i class="fab fa-telegram-plane"></i>
                                        </a>&nbsp;&nbsp;&nbsp;

                                        <a href="mailto:?subject=Detalhes imóvel&body=https://www.alternativachapeco.com.br/detalhes-imovel/?id_imovel=5666" rel="noopener">
                                            <i class="far fa-envelope"></i>
                                        </a>&nbsp;&nbsp;&nbsp;

                                        <a href="http://www.linkedin.com/shareArticle?mini=true&url=https://www.alternativachapeco.com.br/detalhes-imovel/?id_imovel=5666" target="_blank" rel="noopener">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </div>    -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 pb-5 auto-cols-auto auto-rows-auto">
                    <div class="panel">
                        <div>
                            <div id="tagsImoveis" class="absolute mt-3 ml-2"></div>
                            <div id="fotoCapa"></div>
                        </div>
                    </div>
                    <div class="gap-6 pb-5">
                        <!-- CARACTERISTICAS -->
                        <div class="panel mb-5">
                            <div id="caracteristica"></div>
                        </div>
                        <div class="panel">
                            <div id="localizacao" class="flex mt-4 mb-5 items-center"></div>
                            <div id="descricaoImovel"></div>
                        </div>
                    </div>
                </div>    
                <div x-data="lightbox" class="mb-5" >
                    <!-- Lightbox -->
                    <div class="panel">
                        <div class="mb-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3" x-init="bindFancybox()" id="galeriaFotos"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include '../../library/vristo/footer-main.php'; ?>
        <script type="text/javascript">
            document.addEventListener("alpine:init", () => {
                Alpine.data("lightbox", () => ({
                    allcontrols: 1,
                    items: [],
                    bindFancybox() {                
                        Fancybox.bind('[data-fancybox="gallery"]', {
                            Carousel: {
                                Navigation: {
                                    prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 5l-7 7 7 7"/><path d="M4 12h16"/></svg>',
                                    nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>',
                                },
                            },
                            Thumbs: false,
                            Toolbar: false,
                            closeButton: "top",
                        });
                    }
                }));
            });
        </script>    
    </body>
</html>
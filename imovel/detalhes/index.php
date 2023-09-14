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

        <script>
            var url = 'https://vegax.com.br/vortex/api/imoveis/detalhes/?emp='+<?php echo $_GET['emp']?>+'&id='+<?php echo $_GET['id']?>;

            var galeria = []; // Agora galeria é um array
            fetch(url).then(response => {
                // Verifica se a resposta da solicitação está OK (código 200)
                if (!response.ok) {
                  throw new Error('Erro na solicitação');
                }
            
                // Parseia a resposta JSON
                return response.json();
            })
            
            .then(data => {
                console.log('Resposta JSON:', data); // Verifique o conteúdo da resposta JSON
                galeria.push({
                    src: data.data[0]['fotos']['capa']['url']
                  });
                for (var j = 0; j < data.data[0]['fotos']['galeria'].length; j++) {
                  galeria.push({
                    src: data.data[0]['fotos']['galeria'][j]['url']
                  });
                }
                console.log('Variável galeria:', galeria); // Verifique o conteúdo da variável galeria
            })
            .catch(error => {
                console.error('Erro:', error);
            });

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
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoGaragem.svg'); ?><p class="mt-2 text-xs">Garagem<br />'+data.data[0]['garagem']+' Vaga(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['quartos'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['quartos']+' Quarto(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['suites'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs">Sendo '+data.data[0]['suites']+' Suites(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['banheiros'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoBanheiro.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['banheiros']+' Banheiros(s)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['tipoConstrucao'] != '0'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoTpConstrucao.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['tipoConstrucao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['utilizacao'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoProximidade.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['utilizacao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['edificio'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPredio.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['edificio']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['pontoReferencia'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoProximidade.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['pontoReferencia']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['posicao'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPosicaoSolar.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['posicao']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['elevadores'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoElevador.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['elevadores']+' elevador(es)</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['tipoPiso'] != ''){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoOutros.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['tipoPiso']+'</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaEstar'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoSala.svg'); ?><p class="mt-2 text-xs">Sala de Estar</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaTv'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoTV.svg'); ?><p class="mt-2 text-xs">Sala de TV</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['lareira'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoChurrasqueira.svg'); ?><p class="mt-2 text-xs">Lareira</p></div>');
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
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs">Dependência de Empregada</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['gasCentral'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs">Gás Central</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['playground'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPlayground.svg'); ?><p class="mt-2 text-xs">Playground</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['lavabo'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoLavabo.svg'); ?><p class="mt-2 text-xs">Lavabo</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['churrasqueira'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoChurrasqueira.svg'); ?><p class="mt-2 text-xs">Churrasqueira</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['salaoFestas'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoFesta.svg'); ?><p class="mt-2 text-xs">Salão Festa</p></div>');
                        contItens++;
                    } 

                    if(data.data[0]['sacada'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoSacada.svg'); ?><p class="mt-2 text-xs">Sacada</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['pocoArtesiano'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPoco.svg'); ?><p class="mt-2 text-xs">Poço Artesiano</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['portaoEletronico'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPortaoElevacao.svg'); ?><p class="mt-2 text-xs">Portão Eletrônico</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['condominioFechado'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoCasa.svg'); ?><p class="mt-2 text-xs">Condominio Fechado</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['areaLazer'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoLazer.svg'); ?><p class="mt-2 text-xs">Área Lazer</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['piscina'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoPiscina.svg'); ?><p class="mt-2 text-xs">Piscina</p></div>');
                        contItens++;
                    }

                    if(data.data[0]['terraco'] != 'n'){
                        item.push('<div class="'+tamanhoColuna+'"><?php echo file_get_contents('../../application/icons/icoOutros.svg'); ?><p class="mt-2 text-xs">Terraco</p></div>');
                        contItens++;
                    }
                    
                    if(data.data[0]['codigo'] != ''){
                        document.getElementById('titulo').innerHTML = '<span class="badge badge-outline-primary" style="margin: 5px;"> CÓDIGO: '+data.data[0]['codigo']+'</span>';
                    }

                    if(data.data[0]['tipo'] != ''){
                        document.getElementById('titulo').innerHTML += '<span class="badge badge-outline-success" style="margin: 5px;">'+data.data[0]['tipo'].toUpperCase()+'</span>';
                    }

                    if(data.data[0]['bairro'] != ''){
                        document.getElementById('titulo').innerHTML += '<span class="badge badge-outline-info" style="margin: 5px;">'+data.data[0]['bairro'].toUpperCase()+'</span>';
                    }

                    if(data.data[0]['rua'] != ''){
                        document.getElementById('localizacao').innerHTML += '<p><?php echo file_get_contents('../../application/icons/icoPin.svg'); ?></p><p>'+data.data[0]['rua']+' '+data.data[0]['numero']+' '+data.data[0]['complemento']+', bairro '+data.data[0]['bairro']+', '+data.data[0]['cidade']+'/'+data.data[0]['uf']+'</p>';
                    }


                    if(data.data[0]['valor'] != ''){
                        var precovenda = 'R$<strong>'+data.data[0]['valor']+'</strong>';
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
                            if(aux%3 == 0){
                                linhaCarac++;
                                document.getElementById('caracteristica').innerHTML += '<div class="flex justify-between mt-5" id="caracLinha'+linhaCarac+'"></div>';
                            }
                        }else{
                            if(aux%6 == 0){
                                linhaCarac++;
                                document.getElementById('caracteristica').innerHTML += '<div class="flex justify-between mt-5" id="caracLinha'+linhaCarac+'"></div>';
                            }
                        }                        
                    }
                    

                    //Valida quantos espaços preciso colocar a mais quando tem menos itens na ultima linha
                    if(dispositivo == 'celular'){
                        switch(aux%3){
                            case 1:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;
                            case 2:    
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'"></div>';
                                break;  
                        }
                    }else{
                        switch(aux%6){
                            case 1:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;
                            case 2:
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';    
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;  
                            case 3:    
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;      
                            case 4:    
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                document.getElementById('caracLinha'+linhaCarac).innerHTML += '<div class="'+tamanhoColuna+'">&nbsp;</div>';
                                break;      
                            case 5:    
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

                    // Acesse o elemento head do seu documento HTML
                    var head = document.head || document.getElementsByTagName('head')[0];

                    // Adicione as meta tags criadas ao elemento head
                    head.appendChild(metaUrl);
                    head.appendChild(metaTitle);
                    head.appendChild(metaImage);
                    head.appendChild(metaDescription);

                    document.getElementById('detValor').innerHTML = precovenda;

                    // DADOS DA EMPRESA ------------------------------------------------------------------------------------------------------        
                    if(data.data[0]['empresa']['logomarca'] !== undefined && data.data[0]['empresa']['logomarca'] != ''){
                        document.getElementById('logo').innerHTML = '<img src="'+data.data[0]['empresa']['logomarca']+'" class="object-cover" />';
                    }else{
                        document.getElementById('logo').innerHTML = '<img src="../../application/images/logo-vortex-branca.png" class="object-cover" />';
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
                    //------------------------------------------------------------------------------------------------------ 

                    
                    
                });
            });
        </script>

        <!-- SEO -->
        <meta name="description" content="Este é uma página para visualização dos imóvel cadastrados no sistema Vórtex.">
        <meta name="author" content="Vórtex Sistemas">
        <meta name="keywords" content="Imóveis, imobiliaria, vendas, locação"/>

        <link rel="alternate" href="" hreflang="pt-br" />
        <meta name="robots" content="index, follow">
        <meta name="theme-color" content="#0e1726">

        <meta property="business:contact_data:country_name" content="PAÍS" />
        <meta property="business:contact_data:website" content="URL" />
        <meta property="business:contact_data:region" content="SP" />
        <meta property="business:contact_data:email" content="EMAIL" />
        <meta property="business:contact_data:phone_number" content="TEL" />


        <meta name="twitter:card" content="summary" />
        <meta name="twitter:description" content="DESCRIÇÃO"/>
        <meta name="twitter:title" content="TITULO" />
        <meta name="twitter:image" content="URL IMAGEM" />


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
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 pb-5">
                    <!-- VALORES -->
                    <div class="panel flex items-center">
                        <div id="logo" class="w-1/3" ></div>
                        <div id="infoEmpresa" class="w-2/3 ml-3"></div>
                    </div>

                    <!-- VALORES -->
                    <div class="panel">
                        <div id="logo"></div>
                        <div id="titulo" class="grid lg:grid-cols-3 grid-cols-1 mb-3"></div>                
                        <div class="grid lg:grid-cols-2 grid-cols-1">
                            <div>                    
                                <p>À venda por</p>
                                <h2 class="font-semibold text-3xl dark:text-white-light mb-5" id="detValor"></h2>
                            </div>

                            <div class="mb-5">
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
                                </div>    
                            </div>
                        </div>
                        <div>    <!-- large -->
                            <button type="button" class="btn btn-primary btn-lg">Fale conosco</button>
                        </div>
                    </div>
                </div>
                <div class="grid lg:grid-cols-1 grid-cols-1 gap-6 pb-5">
                    <!-- CARACTERISTICAS -->
                    <div class="panel">
                        <div class="mb-10 text-center">
                            <h5 class="font-semibold text-lg dark:text-white-light">Detalhes do Imóvel</h5>
                        </div>
                        <div id="caracteristica"></div>
                        <div id="localizacao" class="flex mb-3 mt-4 items-center justify-center"></div>
                    </div>
                </div>
                <div x-data="lightbox">
                    <!-- Lightbox -->
                    <div class="panel">
                        <div class="mb-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3" x-init="bindFancybox()">
                                <template x-for="(item, i) in getItems" :key="i">
                                    <a href="javascript:;" :class="{'md:row-span-2 md:col-span-2' : i == 3}">
                                        <img :src="item.src" alt="image-gallery" data-fancybox="gallery" class="rounded-md w-full h-full object-cover" :data-caption="item.title" />
                                    </a>
                                </template>
                            </div>
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

                    getItems() {
                        console.log(galeria);
                        return this.items = galeria;
                    },

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
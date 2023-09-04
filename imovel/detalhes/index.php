<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

<script>
    jQuery(function($){
        var url = 'https://vegax.com.br/vortex/api/imoveis/detalhes/?emp='+<?php echo $_GET['emp']?>+'&id='+<?php echo $_GET['id']?>;

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
            console.log(data.data[0]);
            var linhaCarac = 0;
            var contItens = 0;
            var item = [];

            if(data.data[0]['area'] != '0'){
                item.push('<div class="flex flex-col items-center"><?php echo file_get_contents('../../application/icons/icoRegua.svg'); ?><p class="mt-2 text-xs">'+(data.data[0]['area']/100)+' m²</p></div>');
                contItens++;
            }

            if(data.data[0]['quartos'] != '0'){
                item.push('<div class="flex flex-col items-center"><?php echo file_get_contents('../../application/icons/icoQuarto.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['quartos']+' Quarto(s)</p></div>');
                contItens++;
            }

            if(data.data[0]['banheiros'] != '0'){
                item.push('<div class="flex flex-col items-center"><?php echo file_get_contents('../../application/icons/icoBanheiro.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['banheiros']+' Banheiros(s)</p></div>');
                contItens++;
            }

            if(data.data[0]['garagem'] != '0'){
                item.push('<div class="flex flex-col items-center"><?php echo file_get_contents('../../application/icons/icoGaragem.svg'); ?><p class="mt-2 text-xs">'+data.data[0]['garagem']+' Vaga(s)</p></div>');
                contItens++;
            }


            if(data.data[0]['tipo'] != ''){
                document.getElementById('titulo').innerHTML = '<div class="flex flex-col items-center p-1"><span class="badge badge-outline-success">'+data.data[0]['tipo']+'</span></div>';
            }

            if(data.data[0]['bairro'] != ''){
                document.getElementById('titulo').innerHTML += '<div class="flex flex-col items-center p-1"><span class="badge badge-outline-info">'+data.data[0]['bairro']+'</span></div>';
            }

            if(data.data[0]['cidade'] != ''){
                document.getElementById('titulo').innerHTML += '<div class="flex flex-col items-center p-1"><span class="badge badge-outline-primary">'+data.data[0]['cidade']+'/'+data.data[0]['uf']+'</span></div>';
            }


            if(data.data[0]['rua'] != ''){
                document.getElementById('localizacao').innerHTML += '<div class="flex flex-col items-center p-1"><p><span class="dark:text-white-light"><b>Localização:</b></span> '+data.data[0]['rua']+', bairro '+data.data[0]['bairro']+', '+data.data[0]['cidade']+'/'+data.data[0]['uf']+'</span></div>';
            }

            if(data.data[0]['codigo'] != ''){
                document.getElementById('codImovel').innerHTML = 'Código: '+data.data[0]['codigo'];
            }

            if(data.data[0]['valor'] > 0){
                var precovenda = formatter.format(data.data[0]['valor']);
            }else{
                var precovenda = 'Sob consulta';
            }

            //Monta a parte das caracteristicas
            document.getElementById('caracteristica').innerHTML = '<div class="flex justify-between mt-5" id="caracLinha0"></div>';
            var aux;
            for (var i=0; i < contItens; i++) {
                document.getElementById('caracLinha'+linhaCarac).innerHTML += item[i];
                aux = i+1;
                if(aux%4 == 0){
                    linhaCarac++;
                    document.getElementById('caracteristica').innerHTML += '<div class="flex justify-between mt-5" id="caracLinha'+linhaCarac+'"></div>';
                }
            }
            
            document.getElementById('detValor').innerHTML = '<strong>'+precovenda+'</strong>';
        });
    });
    
    document.addEventListener("alpine:init", () => {
        Alpine.data("lightbox", () => ({
            allcontrols: 1,
            items: [],

            getItems() {
                return this.items = [{
                        src: ('../../library/vristo/assets/images/lightbox1.jpg')
                    },
                    {
                        src: ('../../library/vristo/assets/images/lightbox2.jpeg')
                    },
                    {
                        src: ('../../library/vristo/assets/images/lightbox3.jpeg')
                    },
                    {
                        src: ('../../library/vristo/assets/images/lightbox4.jpeg')
                    },
                    {
                        src: ('../../library/vristo/assets/images/lightbox5.jpeg')
                    },
                    {
                        src: ('../../library/vristo/assets/images/lightbox6.jpeg')
                    },
                ];
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

<?php include '../../library/vristo/header-main.php'; ?>

<link rel='stylesheet' type='text/css' media='screen' href='../../library/vristo/assets/css/fancybox.css'>
<script src="../../library/vristo/assets/js/fancybox.umd.js"></script>
<div>
    <div>
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 pb-5">
            <!-- VALORES -->
            <div class="panel">
                <div id="titulo" class="flex mb-3"></div>                
                <div class="flex justify-between">
                    <div>                    
                        <p>À venda por</p>
                        <h2 class="font-semibold text-3xl dark:text-white-light mb-5" id="detValor"></h2>
                    </div>

                    <div>
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

            <!-- CARACTERISTICAS -->
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Características:</h5>
                    <div class="flex flex-col items-center p-1"><span class="badge badge-outline-primary" id="codImovel"></span></div>
                </div>
                <div id="caracteristica"></div>
                <div id="localizacao" class="flex mb-3 mt-4 "></div>
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


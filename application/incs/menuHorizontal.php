<?php  
    
    $menuAvo = [];
    $menuPai = [];
    $menuNeto = [];
    foreach($_SESSION['menu'] as $key => $row){
        if(!$row['men_pai']){
            $menuAvo[] = $row;
        }
        if($row['men_pai'] && !$row['men_url']){
            $menuPai[] = $row;
        }
        if($row['men_pai'] && $row['men_url']){
            $menuNeto[] = $row;
        }
    }
    
    $sql = '
    SELECT pro.pro_codigo, pro.pro_nome
    FROM sispermissoes AS per 
        JOIN sisprogramas AS pro ON per.per_programa = pro.pro_codigo
    WHERE per_usuario = '.$_SESSION['v_usu_codigo'].' AND per_empresa = 1';
    $result = $data->find('dynamic', $sql);

    function hasPermission($result, $programa){
        foreach ($result as $key => $value) {
            if($value['pro_nome'] == $programa) return true;
        }
        return false;
    }
    
    function hasSubmenuPermission($result, $arrProgramas){
        foreach ($result as $key => $value) {
            foreach ($arrProgramas as $keyPrograma => $valuePrograma) {
                if($value['pro_nome'] == $valuePrograma) return true;
            }
        }
        return false;
    }   
?>

<ul class="horizontal-menu hidden py-1.5 font-semibold px-6 lg:space-x-1.5 xl:space-x-8 rtl:space-x-reverse bg-white border-t border-[#ebedf2] dark:border-[#191e3a] dark:bg-[#0e1726] text-black dark:text-white-dark">
    <?php 
        // Varre itens do menu (avô)
        foreach($menuAvo as $keyAvo => $rowAvo){
            echo '
            <li class="menu nav-item relative">
                <a href="javascript:;" class="nav-link">
                    <div class="flex items-center">
                        '.file_get_contents($rowAvo['men_icone']).'
                        <span class="px-1">'.$rowAvo['men_nome'].'</span>
                    </div>
                    <div class="right_arrow">
                        <svg class="w-4 h-4 rotate-90" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
                <ul class="sub-menu">';
               
                
                // Varre itens do menu (avô)
                foreach($menuNeto as $keyNeto => $rowNeto){
                    if($rowNeto['men_pai'] == $rowAvo['men_codigo']){
                        if(hasPermission($result, $rowNeto['pro_nome'])){
                            echo '<li><a href="'.$rowNeto['men_url'].'">'.$rowNeto['men_nome'].'</a></li>';
                        }
                    }
                }

                foreach($menuPai as $keyPai => $rowPai){
                // Com submenus 
                // if(hasSubmenuPermission($result, array('sisEmpresas','sis2','sis3', 'sis4'))){
                //     echo '
                //     <li class="relative">
                //         <a href="javascript:;">Locação
                //             <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                //                 <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                //                     <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                //                 </svg>
                //             </div>
                //         </a>
                //         <ul class="rounded absolute top-0 ltr:left-[95%] rtl:right-[95%] min-w-[180px] bg-white z-[10] text-dark dark:text-white-dark dark:bg-[#1b2e4b] shadow p-0 py-2 hidden">';
                //             if(hasPermission($result, 'sisEmpresas')){
                //                 echo '<li><a href="?module=aviso&acao=lista_aviso">Categorias da Locação</a></li>';
                //             }
                //             if(hasPermission($result, 'sisEmpresas')){
                //                 echo '<li><a href="?module=aviso&acao=lista_aviso">Indicadores de Reajuste</a></li>';
                //             }
                //             if(hasPermission($result, 'sisEmpresas')){
                //                 echo '<li><a href="?module=aviso&acao=lista_aviso">Motivos de Saída</a></li>';
                //             }
                //             if(hasPermission($result, 'sisEmpresas')){
                //                 echo '<li><a href="?module=aviso&acao=lista_aviso">Tabela I.R.R.F.</a></li>';
                //             }
                //         echo '
                //         </ul>
                //     </li>';
                // }
                }
                                    
            echo
                '</ul>
            </li>';
        }
    ?>

    <!-- SISTEMA -->
    <li class="menu nav-item relative">
        <a href="javascript:;" class="nav-link">
            <div class="flex items-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor" />
                    <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor" />
                </svg>
                <span class="px-1">Sistema</span>
            </div>
            <div class="right_arrow">
                <svg class="w-4 h-4 rotate-90" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </a>
        <ul class="sub-menu">
            <?php 
                if(hasPermission($result, 'Sistema')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Avisos</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Empresas</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Usuários</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Permissões de Acesso</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Perfil de Usuários</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Agenda de Atividades</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Mês de Referência da Locação</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Abertura de Caixa</a></li>';
                }
            ?>                  
        </ul>
    </li>

    <!-- CADASTROS -->
    <li class="menu nav-item relative">
        <a href="javascript:;" class="nav-link">
            <div class="flex items-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g opacity="0.5">
                        <path d="M14 2.75C15.9068 2.75 17.2615 2.75159 18.2892 2.88976C19.2952 3.02503 19.8749 3.27869 20.2981 3.7019C20.7213 4.12511 20.975 4.70476 21.1102 5.71085C21.2484 6.73851 21.25 8.09318 21.25 10C21.25 10.4142 21.5858 10.75 22 10.75C22.4142 10.75 22.75 10.4142 22.75 10V9.94359C22.75 8.10583 22.75 6.65019 22.5969 5.51098C22.4392 4.33856 22.1071 3.38961 21.3588 2.64124C20.6104 1.89288 19.6614 1.56076 18.489 1.40314C17.3498 1.24997 15.8942 1.24998 14.0564 1.25H14C13.5858 1.25 13.25 1.58579 13.25 2C13.25 2.41421 13.5858 2.75 14 2.75Z" fill="currentColor" />
                        <path d="M9.94358 1.25H10C10.4142 1.25 10.75 1.58579 10.75 2C10.75 2.41421 10.4142 2.75 10 2.75C8.09318 2.75 6.73851 2.75159 5.71085 2.88976C4.70476 3.02503 4.12511 3.27869 3.7019 3.7019C3.27869 4.12511 3.02503 4.70476 2.88976 5.71085C2.75159 6.73851 2.75 8.09318 2.75 10C2.75 10.4142 2.41421 10.75 2 10.75C1.58579 10.75 1.25 10.4142 1.25 10V9.94358C1.24998 8.10583 1.24997 6.65019 1.40314 5.51098C1.56076 4.33856 1.89288 3.38961 2.64124 2.64124C3.38961 1.89288 4.33856 1.56076 5.51098 1.40314C6.65019 1.24997 8.10583 1.24998 9.94358 1.25Z" fill="currentColor" />
                        <path d="M22 13.25C22.4142 13.25 22.75 13.5858 22.75 14V14.0564C22.75 15.8942 22.75 17.3498 22.5969 18.489C22.4392 19.6614 22.1071 20.6104 21.3588 21.3588C20.6104 22.1071 19.6614 22.4392 18.489 22.5969C17.3498 22.75 15.8942 22.75 14.0564 22.75H14C13.5858 22.75 13.25 22.4142 13.25 22C13.25 21.5858 13.5858 21.25 14 21.25C15.9068 21.25 17.2615 21.2484 18.2892 21.1102C19.2952 20.975 19.8749 20.7213 20.2981 20.2981C20.7213 19.8749 20.975 19.2952 21.1102 18.2892C21.2484 17.2615 21.25 15.9068 21.25 14C21.25 13.5858 21.5858 13.25 22 13.25Z" fill="currentColor" />
                        <path d="M2.75 14C2.75 13.5858 2.41421 13.25 2 13.25C1.58579 13.25 1.25 13.5858 1.25 14V14.0564C1.24998 15.8942 1.24997 17.3498 1.40314 18.489C1.56076 19.6614 1.89288 20.6104 2.64124 21.3588C3.38961 22.1071 4.33856 22.4392 5.51098 22.5969C6.65019 22.75 8.10583 22.75 9.94359 22.75H10C10.4142 22.75 10.75 22.4142 10.75 22C10.75 21.5858 10.4142 21.25 10 21.25C8.09318 21.25 6.73851 21.2484 5.71085 21.1102C4.70476 20.975 4.12511 20.7213 3.7019 20.2981C3.27869 19.8749 3.02503 19.2952 2.88976 18.2892C2.75159 17.2615 2.75 15.9068 2.75 14Z" fill="currentColor" />
                    </g>
                    <path d="M5.52721 5.52721C5 6.05442 5 6.90294 5 8.6C5 9.73137 5 10.2971 5.35147 10.6485C5.70294 11 6.26863 11 7.4 11H8.6C9.73137 11 10.2971 11 10.6485 10.6485C11 10.2971 11 9.73137 11 8.6V7.4C11 6.26863 11 5.70294 10.6485 5.35147C10.2971 5 9.73137 5 8.6 5C6.90294 5 6.05442 5 5.52721 5.52721Z" fill="currentColor" />
                    <path d="M5.52721 18.4728C5 17.9456 5 17.0971 5 15.4C5 14.2686 5 13.7029 5.35147 13.3515C5.70294 13 6.26863 13 7.4 13H8.6C9.73137 13 10.2971 13 10.6485 13.3515C11 13.7029 11 14.2686 11 15.4V16.6C11 17.7314 11 18.2971 10.6485 18.6485C10.2971 19 9.73138 19 8.60002 19C6.90298 19 6.05441 19 5.52721 18.4728Z" fill="currentColor" />
                    <path d="M13 7.4C13 6.26863 13 5.70294 13.3515 5.35147C13.7029 5 14.2686 5 15.4 5C17.0971 5 17.9456 5 18.4728 5.52721C19 6.05442 19 6.90294 19 8.6C19 9.73137 19 10.2971 18.6485 10.6485C18.2971 11 17.7314 11 16.6 11H15.4C14.2686 11 13.7029 11 13.3515 10.6485C13 10.2971 13 9.73137 13 8.6V7.4Z" fill="currentColor" />
                    <path d="M13.3515 18.6485C13 18.2971 13 17.7314 13 16.6V15.4C13 14.2686 13 13.7029 13.3515 13.3515C13.7029 13 14.2686 13 15.4 13H16.6C17.7314 13 18.2971 13 18.6485 13.3515C19 13.7029 19 14.2686 19 15.4C19 17.097 19 17.9456 18.4728 18.4728C17.9456 19 17.0971 19 15.4 19C14.2687 19 13.7029 19 13.3515 18.6485Z" fill="currentColor" />
                </svg>
                <span class="px-1">Cadastros</span>
            </div>
            <div class="right_arrow">
                <svg class="w-4 h-4 rotate-90" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </a>
        <ul class="sub-menu">
            <?php 
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Pessoas</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Profissões</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Cidades</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Países</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Bairros</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Corretores</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Empreendimentos</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Condomínios</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Tipos de Piso</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Tipos de Forro</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Origem Atendimento</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Motivo Conclusão Atendimento</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Tipos de Imóvel</a></li>';
                }
                if(hasPermission($result, 'sisEmpresas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Feriados do Ano</a></li>';
                }

                // Com submenus 
                if(hasSubmenuPermission($result, array('sisEmpresas','sis2','sis3', 'sis4'))){
                    echo '
                    <li class="relative">
                        <a href="javascript:;">Locação
                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </a>
                        <ul class="rounded absolute top-0 ltr:left-[95%] rtl:right-[95%] min-w-[180px] bg-white z-[10] text-dark dark:text-white-dark dark:bg-[#1b2e4b] shadow p-0 py-2 hidden">';
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Categorias da Locação</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Indicadores de Reajuste</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Motivos de Saída</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Tabela I.R.R.F.</a></li>';
                            }
                        echo '
                        </ul>
                    </li>';
                }

                // Com submenus 
                if(hasSubmenuPermission($result, array('sisEmpresas','sis2','sis3', 'sis4', 'sis5'))){
                    echo '
                    <li class="relative">
                        <a href="javascript:;">Financeiro
                            <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </a>
                        <ul class="rounded absolute top-0 ltr:left-[95%] rtl:right-[95%] min-w-[180px] bg-white z-[10] text-dark dark:text-white-dark dark:bg-[#1b2e4b] shadow p-0 py-2 hidden">';
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Bancos</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Contas</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Plano de Contas</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Categorias do Financeiro</a></li>';
                            }
                            if(hasPermission($result, 'sisEmpresas')){
                                echo '<li><a href="?module=aviso&acao=lista_aviso">Moedas</a></li>';
                            }
                        echo '
                        </ul>
                    </li>';
                }
            ?>   
        </ul>
    </li>

    <!-- ATENDIMENTO (CRM) -->
    <li class="menu nav-item relative">
        <a href="javascript:;" class="nav-link">
            <div class="flex items-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M3 10C3 6.22876 3 4.34315 4.17157 3.17157C5.34315 2 7.22876 2 11 2H13C16.7712 2 18.6569 2 19.8284 3.17157C21 4.34315 21 6.22876 21 10V14C21 17.7712 21 19.6569 19.8284 20.8284C18.6569 22 16.7712 22 13 22H11C7.22876 22 5.34315 22 4.17157 20.8284C3 19.6569 3 17.7712 3 14V10Z" fill="currentColor" />
                    <path d="M16.5189 16.5013C16.6939 16.3648 16.8526 16.2061 17.1701 15.8886L21.1275 11.9312C21.2231 11.8356 21.1793 11.6708 21.0515 11.6264C20.5844 11.4644 19.9767 11.1601 19.4083 10.5917C18.8399 10.0233 18.5356 9.41561 18.3736 8.94849C18.3292 8.82066 18.1644 8.77687 18.0688 8.87254L14.1114 12.8299C13.7939 13.1474 13.6352 13.3061 13.4987 13.4811C13.3377 13.6876 13.1996 13.9109 13.087 14.1473C12.9915 14.3476 12.9205 14.5606 12.7786 14.9865L12.5951 15.5368L12.3034 16.4118L12.0299 17.2323C11.9601 17.4419 12.0146 17.6729 12.1708 17.8292C12.3271 17.9854 12.5581 18.0399 12.7677 17.9701L13.5882 17.6966L14.4632 17.4049L15.0135 17.2214L15.0136 17.2214C15.4394 17.0795 15.6524 17.0085 15.8527 16.913C16.0891 16.8004 16.3124 16.6623 16.5189 16.5013Z" fill="currentColor" />
                    <path d="M22.3665 10.6922C23.2112 9.84754 23.2112 8.47812 22.3665 7.63348C21.5219 6.78884 20.1525 6.78884 19.3078 7.63348L19.1806 7.76071C19.0578 7.88348 19.0022 8.05496 19.0329 8.22586C19.0522 8.33336 19.0879 8.49053 19.153 8.67807C19.2831 9.05314 19.5288 9.54549 19.9917 10.0083C20.4545 10.4712 20.9469 10.7169 21.3219 10.847C21.5095 10.9121 21.6666 10.9478 21.7741 10.9671C21.945 10.9978 22.1165 10.9422 22.2393 10.8194L22.3665 10.6922Z" fill="currentColor" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.25 9C7.25 8.58579 7.58579 8.25 8 8.25H14.5C14.9142 8.25 15.25 8.58579 15.25 9C15.25 9.41421 14.9142 9.75 14.5 9.75H8C7.58579 9.75 7.25 9.41421 7.25 9ZM7.25 13C7.25 12.5858 7.58579 12.25 8 12.25H11C11.4142 12.25 11.75 12.5858 11.75 13C11.75 13.4142 11.4142 13.75 11 13.75H8C7.58579 13.75 7.25 13.4142 7.25 13ZM7.25 17C7.25 16.5858 7.58579 16.25 8 16.25H9.5C9.91421 16.25 10.25 16.5858 10.25 17C10.25 17.4142 9.91421 17.75 9.5 17.75H8C7.58579 17.75 7.25 17.4142 7.25 17Z" fill="currentColor" />
                </svg>
                <span class="px-1">Atendimento (CRM)</span>
            </div>
            <div class="right_arrow">
                <svg class="w-4 h-4 rotate-90" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </a>
        <ul class="sub-menu">
            <?php 
                if(hasPermission($result, 'relVendasPretendentes')){
                    echo '<li><a href="?module=pretendente&acao=lista_pretendente">Pretendentes</a></li>';
                }
                if(hasPermission($result, 'relAgenda')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Agenda</a></li>';
                }
                if(hasPermission($result, 'venVisitas')){
                    echo '<li><a href="?module=aviso&acao=lista_aviso">Visitas</a></li>';
                }
            ?>                  
        </ul>
    </li>
</ul>
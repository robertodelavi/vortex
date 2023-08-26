<?php  
    require_once('validaMenu.php');
?>

<div :class="{'dark text-white-dark' : $store.app.semidark}">
    <nav x-data="sidebar" class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="bg-white dark:bg-[#0e1726] h-full">
            <div class="flex justify-between items-center px-4 py-3">
                <a href="<?php echo BASE_THEME_URL; ?>/" class="main-logo flex items-center shrink-0">
                    <img class="w-8 ml-[5px] flex-none" src="<?php echo BASE_THEME_URL; ?>/assets/images/logo.svg" alt="image" />
                    <span class="text-2xl ltr:ml-1.5 rtl:mr-1.5  font-semibold  align-middle lg:inline dark:text-white-light">VÓRTEX</span>
                </a>
                <a href="javascript:;" class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180" @click="$store.app.toggleSidebar()">
                    <svg class="w-5 h-5 m-auto" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>

            <ul class="perfect-scrollbar relative font-semibold space-y-0.5 h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden  p-4 py-0" x-data="{ activeDropdown: null }">
             <?php 
                // Varre itens do menu (avô)
                foreach($menuAvo as $keyAvo => $rowAvo){            
                    if(hasMenuPermission($result, $rowAvo['men_modulo'], $menuPai, $menuNeto)){
                        echo '
                        <h2 class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">
                            '.file_get_contents($rowAvo['men_icone']).' &nbsp;
                            <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>'.$rowAvo['men_nome'].'</span>
                        </h2>';
                    }

                    // Varre itens do menu (avô)
                    foreach($menuPai as $keyPai => $rowPai){
                        if($rowPai['men_pai'] == $rowAvo['men_codigo']){
                            if(hasPermission($result, $rowPai['pro_nome'])){
                                echo '
                                    <li class="menu nav-item">
                                        <a href="'.$rowPai['men_url'].'" class="nav-link group">
                                            <div class="flex items-center">
                                                <span class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">'.$rowPai['men_nome'].'</span>
                                            </div>
                                        </a>
                                    </li>';
                            }
                        }
                    }
                    $contPai = 0;
                    foreach($menuPai as $keyPai => $rowPai){
                        $contPai++;
                        //Valida para ver se o pai é filho do avó
                        if($rowPai['men_pai'] == $rowAvo['men_codigo']){
                            //busco todo os itens do submenu para posteriormente saber se o usuario tem acesso ou não e montar o pai.
                            foreach($menuNeto as $keyNeto => $rowNeto){
                                if($rowNeto['men_pai'] == $rowPai['men_codigo']){
                                    $arrayProg[] = $rowNeto['pro_nome'];
                                }
                            }

                            if(hasSubmenuPermission($result, $arrayProg)){
                                echo '
                                <li class="menu nav-item">
                                    <button type="button" class="nav-link group" :class="{\'active\' : activeDropdown === \''.$rowPai['men_nome'].$contPai.'\'}" @click="activeDropdown === \''.$rowPai['men_nome'].$contPai.'\' ? activeDropdown = null : activeDropdown = \''.$rowPai['men_nome'].$contPai.'\'">
                                        <div class="flex items-center">
                                            <span class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">'.$rowPai['men_nome'].'</span>
                                        </div>
                                        <div class="rtl:rotate-180" :class="{\'!rotate-90\' : activeDropdown === \''.$rowPai['men_nome'].$contPai.'\'}">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </button>
                                    <ul x-cloak x-show="activeDropdown === \''.$rowPai['men_nome'].$contPai.'\'" x-collapse class="sub-menu text-gray-500">';
                                        // Varre itens do menu (pai)
                                        foreach($menuNeto as $keyNeto => $rowNeto){
                                            if($rowNeto['men_pai'] == $rowPai['men_codigo']){
                                                if(hasPermission($result, $rowNeto['pro_nome'])){
                                                    echo '<li><a href="'.$rowNeto['men_url'].'">'.$rowNeto['men_nome'].'</a></li>';
                                                }
                                            }
                                        }
                                echo '        
                                    </ul>
                                </li>';
                            }
                            unset($arrayProg);
                        }
                    }
                }
            ?>

                
            </ul>
        </div>
    </nav>
</div>
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("sidebar", () => ({
            init() {
                const selector = document.querySelector('.sidebar ul a[href="' + window.location.pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.click();
                            });
                        }
                    }
                }
            },
        }));
    });
</script>

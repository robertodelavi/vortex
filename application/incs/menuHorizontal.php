<?php  
    $menuAvo = [];
    $menuPai = [];
    $menuNeto = [];
    $menuBisneto = [];

    foreach($_SESSION['menu'] as $key => $row){
        if($row['men_nivel'] == 0){
            $menuAvo[] = $row;
        }
        if($row['men_nivel'] == 1){
            $menuPai[] = $row;
        }
        if($row['men_nivel'] == 2){
            $menuNeto[] = $row;
        }
        if($row['men_nivel'] == 3){
            $menuBisneto[] = $row;
        }

    }
    
    $sql = '
    SELECT pro.pro_codigo, pro.pro_nome
    FROM sispermissoes AS per 
        JOIN sisprogramas AS pro ON per.per_programa = pro.pro_codigo
    WHERE per_usuario = '.$_SESSION['v_usu_codigo'].' AND per_empresa = 1';
    $result = $data->find('dynamic', $sql);

    function hasPermission($result, $programa){
        if($result && count($result) > 0){
            foreach ($result as $key => $value) {
                if($value['pro_nome'] == $programa) return true;
            }
        }
        return false;
    }
    
    function hasSubmenuPermission($result, $arrProgramas){
        if($result && count($result) > 0){
            foreach ($result as $key => $value) {
                if($arrProgramas && count($arrProgramas) > 0){
                    foreach ($arrProgramas as $keyPrograma => $valuePrograma) {
                        if($value['pro_nome'] == $valuePrograma) return true;
                    }
                }
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
                    '.file_get_contents('application/icons/setaBaixo.svg').'
                    </div>
                </a>
                <ul class="sub-menu">';
                    // Varre itens do menu (avô)
                    foreach($menuPai as $keyPai => $rowPai){
                        if($rowPai['men_pai'] == $rowAvo['men_codigo']){
                            if(hasPermission($result, $rowPai['pro_nome'])){
                                echo '<li><a href="'.$rowPai['men_url'].'">'.$rowPai['men_nome'].'</a></li>';
                            }
                        }
                    }

                    foreach($menuPai as $keyPai => $rowPai){
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
                                <li class="relative">
                                    <a href="javascript:;">'.$rowPai['men_nome'].'
                                        <div class="ltr:ml-auto rtl:mr-auto rtl:rotate-180">
                                        '.file_get_contents('application/icons/setaDireita.svg').'
                                        </div>
                                    </a>
                                    <ul class="rounded absolute top-0 ltr:left-[95%] rtl:right-[95%] min-w-[180px] bg-white z-[10] text-dark dark:text-white-dark dark:bg-[#1b2e4b] shadow p-0 py-2 hidden">';
                                    
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
                echo
                '</ul>
            </li>';
        }
    ?>
</ul>
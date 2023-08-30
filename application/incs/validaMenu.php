<?php  
    $menuAvo     = [];
    $menuPai     = [];
    $menuNeto    = [];
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

    function hasMenuPermission($result, $modulo, $mpai, $mneto){
        if($result && count($result) > 0){
            foreach($mpai as $kPai => $rPai){
                if($rPai['men_modulo'] == $modulo){
                    foreach ($result as $key => $value) {
                        if($value['pro_nome'] == $rPai['pro_nome']) {
                            return 1;
                        }
                    }
                }

                foreach($mneto as $kNeto => $rNeto){
                    if($rNeto['men_pai'] == $rPai['men_codigo'] && $rNeto['men_modulo'] == $modulo){
                        foreach ($result as $key => $value) {
                            if($value['pro_nome'] == $rNeto['pro_nome']){
                               return 1;
                            } 
                        }
                    }
                }
            }
        }
        return 0;
    }

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
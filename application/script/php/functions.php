<?php 

    function moneyToFloat($str){
        // Remover "R$ " e converter de real pra float 
        return floatval(str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $str))));        
    }

    function floatToMoney($float){
        // Converter de float pra real
        return 'R$ '.number_format($float, 2, ',', '.');
    }

?>
<?php include 'application/home/statusAtendimento/getData.php'; ?>    

<div class="font-bold text-lg mb-5">
    Status Atendimentos
    <?php if($result && count($result) > 0){ echo '<span class="badge bg-success/20 text-success rounded-full hover:top-0">Total de '.number_format($totalPretendentes, 0, ',', '.').' pretendentes</span>'; } ?>
</div>    
<div class="space-y-9">
    <?php 
        if($result && count($result) > 0) {
            foreach ($result as $key => $value) {
                $percentual = ((int)$value['total'] * 100)/(int)$totalPretendentes;
                
                $total = number_format($value['total'], 0, ',', '.');
                
                // Cada status
                echo '
                <div class="flex items-center">
                    <div class="w-9 h-9 ltr:mr-3 rtl:ml-3">
                        <div class="rounded-full w-9 h-9 grid place-content-center" style="background-color: '.$value['psa_cor'].'; color: #FFF;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.74157 18.5545C4.94119 20 7.17389 20 11.6393 20H12.3605C16.8259 20 19.0586 20 20.2582 18.5545M3.74157 18.5545C2.54194 17.1091 2.9534 14.9146 3.77633 10.5257C4.36155 7.40452 4.65416 5.84393 5.76506 4.92196M3.74157 18.5545C3.74156 18.5545 3.74157 18.5545 3.74157 18.5545ZM20.2582 18.5545C21.4578 17.1091 21.0464 14.9146 20.2235 10.5257C19.6382 7.40452 19.3456 5.84393 18.2347 4.92196M20.2582 18.5545C20.2582 18.5545 20.2582 18.5545 20.2582 18.5545ZM18.2347 4.92196C17.1238 4 15.5361 4 12.3605 4H11.6393C8.46374 4 6.87596 4 5.76506 4.92196M18.2347 4.92196C18.2347 4.92196 18.2347 4.92196 18.2347 4.92196ZM5.76506 4.92196C5.76506 4.92196 5.76506 4.92196 5.76506 4.92196Z" stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5" d="M9.1709 8C9.58273 9.16519 10.694 10 12.0002 10C13.3064 10 14.4177 9.16519 14.8295 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="flex font-semibold text-white-dark mb-2">
                            <h6>'.$value['psa_descricao'].' ('.($total == 1 ? $total.' pretendente' : $total.' pretendentes').')</h6>
                            <p class="ltr:ml-auto rtl:mr-auto">'.number_format($percentual, 2, ',', '.').'%</p>
                        </div>
                        <div class="rounded-full h-2 bg-dark-light dark:bg-[#1b2e4b] shadow">
                            <div class="w-12/12 h-full rounded-full" style="background: linear-gradient(90deg, '.$value['psa_cor'].' '.$percentual.'%, transparent '.$percentual.'%);"
                            ></div>
                        </div>
                    </div>
                </div>';
            }
        }else{
            echo '<p>Nenhum status cadastrado!</p>';
        }
    ?>
</div>
<?php 
    //? pretendente-visita
    list($prv_pretendente, $prv_codigo) = explode('-', $_POST['param_0']);
        
    $result = [];
    if(isset($prv_pretendente) && $prv_pretendente > 0 && isset($prv_codigo) && $prv_codigo > 0){ //? Edição
        $sql = '
        SELECT * 
        FROM pretendentesvisitas AS pv 
            LEFT JOIN pretendentes AS p ON (pv.prv_pretendente = p.prw_codigo)
        WHERE pv.prv_pretendente = '.$prv_pretendente.' AND pv.prv_codigo = '.$prv_codigo;
        $result = $data->find('dynamic', $sql);
    }

    //? Novo (recebe pretendente)
    if(isset($prv_pretendente) && $prv_pretendente > 0){
        $sql = '
        SELECT * 
        FROM pretendentes AS p
        WHERE p.prw_codigo = '.$prv_pretendente;
        $pretendente = $data->find('dynamic', $sql);
    }
    
    $sql = '
    SELECT * 
    FROM sisusuarios
    WHERE usu_ativado = "s"
    ORDER BY usu_nome ASC';
    $profissionais = $data->find('dynamic', $sql);

    //? Parâmetros (prv_codigo tem somente na edição)
    echo '<input type="hidden" name="prv_pretendente" value="'.$prv_pretendente.'" />';
    if(isset($prv_codigo) && $prv_codigo > 0){
        echo '<input type="hidden" name="prv_codigo" value="'.$prv_codigo.'" />';
    }
?>

<!-- Mensagem -->
<div class="flex items-center p-3.5 rounded text-info bg-info-light dark:bg-info-dark-light">
    <span class="ltr:pr-2 rtl:pl-2">Pretendente:</span>
    <span id="pretendenteNome"></span>
    <?php echo $result[0]['prw_nome']; ?>
</div>

<div class="mt-5" >
    <div class="flex flex-col sm:flex-row">
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <input type="hidden" name="prv_empresa" value="<?php echo $_SESSION['v_emp_codigo']; ?>" />

            <div>
                <label>Imóvel</label>
                <select name="prv_imovel" id="select-imovel" >
                    <option value="">-- Selecione --</option>
                </select>
            </div>

            <div>
                <label for="nome">Acompanhante do pretendente</label>
                <input name="prv_acompanhantepretendente" type="text" class="form-input" value="<?php echo $result[0]['prv_acompanhantepretendente']; ?>" />                 
            </div>

            <div>
                <label for="formaContato">Acompanhante da empresa</label>
                <select name="prv_acompanhante" class="form-select">
                    <option>-- Selecione --</option>
                    <?php 
                        foreach ($profissionais as $key => $value) {
                            $selected = $result[0]['prv_acompanhante'] == $value['usu_codigo'] ? 'selected' : '';
                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="nome">Início da visita</label>
                <?php 
                    //? Converte varchar pra data yyyy-mm-dd
                    $formatedDataIni = $result[0]['prv_dataini'] ? substr($result[0]['prv_dataini'], 0, 4) . '-' . substr($result[0]['prv_dataini'], 4, 2) . '-' . substr($result[0]['prv_dataini'], 6, 2) : '';         
                    $dataIni = $formatedDataIni ? $formatedDataIni : date('Y-m-d');
                    //? Converte varchar pra hora hh:mm
                    $formatedHoraIni = $result[0]['prv_horaini'] ? substr($result[0]['prv_horaini'], 0, 2) . ':' . substr($result[0]['prv_horaini'], 2, 2) : '';
                    $horaIni = $formatedHoraIni ? $formatedHoraIni : '';
                ?>
                <div class="flex gap-4 ">
                    <input name="prv_dataini" type="date" class="form-input" value="<?php echo $dataIni; ?>" />
                    <input name="prv_horaini" type="time" class="form-input" value="<?php echo $horaIni; ?>" /> 
                </div>
            </div>

            <div>
                <label for="formaContato">Chave entregue por</label>
                <select name="prv_entreguepor" class="form-select">
                    <option>-- Selecione --</option>
                    <?php 
                        $selected = $result[0]['prv_entreguepor'] == $value['usu_codigo'] ? 'selected' : '';
                        foreach ($profissionais as $key => $value) {
                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div>
                <label for="nome">Fim da visita (entrega da chave)</label>
                <?php 
                    //? Converte varchar pra data yyyy-mm-dd
                    $formatedDataFim = $result[0]['prv_datafim'] ? substr($result[0]['prv_datafim'], 0, 4) . '-' . substr($result[0]['prv_datafim'], 4, 2) . '-' . substr($result[0]['prv_datafim'], 6, 2) : '';
                    $dataFim = $formatedDataFim ? $formatedDataFim : date('Y-m-d');
                    //? Converte varchar pra hora hh:mm
                    $formatedHoraFim = $result[0]['prv_horafim'] ? substr($result[0]['prv_horafim'], 0, 2) . ':' . substr($result[0]['prv_horafim'], 2, 2) : '';
                    $horaFim = $formatedHoraFim ? $formatedHoraFim : '';
                ?>
                <div class="flex gap-4 ">
                    <input name="prv_datafim" type="date" class="form-input" value="<?php echo $dataFim; ?>" />
                    <input name="prv_horafim" type="time" class="form-input" value="<?php echo $horaFim; ?>" /> 
                </div>
            </div>

            <div>
                <label for="formaContato">Chave devolvida por</label>
                <select name="prv_devolvidopor" class="form-select">
                    <option>-- Selecione --</option>
                    <?php 
                        $selected = $result[0]['prv_devolvidopor'] == $value['usu_codigo'] ? 'selected' : '';
                        foreach ($profissionais as $key => $value) {
                            echo '<option value="' . $value['usu_codigo'] . '" '.$selected.' >' . $value['usu_nome'] . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>

    <div class="flex-1 mt-5">
        <div>
            <label for="nome">Observação</label>
            <textarea name="prv_obs" class="form-input" rows="3"><?php echo $result[0]['prv_obs']; ?></textarea>                    
        </div>
    </div>
</div>
    

<script>
    document.addEventListener("DOMContentLoaded", function(e) {
        var options = {
            searchable: true,
        };
        NiceSelect.bind(document.getElementById("select-imovel"), options);
        // Mantenha uma referência ao elemento select original
        var selectImovel = document.getElementById("select-imovel");
                        
        // Adicione um ouvinte de eventos para o evento de digitação no input do niceSelect
        document.querySelector(".nice-select-search").addEventListener("input", function() {
            const filtro = this.value.toLowerCase();
            
            fetch('application/pretendente/view/visita/ajax/filterImovel.php', {
                method: 'POST',
                body: JSON.stringify(filtro) // Converte o objeto em uma string JSON
            }).then(response => response.json()).then(data => {
                console.log("🚀 ~ resposta ajax:", data)

                // atualizar options do select
                selectImovel.innerHTML = '<option value="">-- Selecione --</option>';
                data.forEach(function(item) {
                    selectImovel.innerHTML += '<option value="' + item.value + '">' + item.text + '</option>';
                });

                // Cria novo select
                NiceSelect.bind(document.getElementById("select-imovel"), options);
                
            }).catch(error => console.error(error));
        });
    });

    // document.addEventListener("DOMContentLoaded", function(e) {
    //     // seachable 
    //     var options = {
    //         searchable: true,
    //     };
    //     NiceSelect.bind(document.getElementById("select-imovel"), options);
    //     var selectImovel = document.getElementById("select-imovel");
    //     // copia options do select
    //     var optionsImovel = selectImovel.innerHTML;

    //     console.log('cria..')

    //     // Adicione um ouvinte de eventos para o evento de digitação no input do niceSelect
    //     document.querySelector(".nice-select-search").addEventListener("input", function() {
    //         console.log('atualiza...')
    //         // Obtenha o valor do filtro digitado
    //         const filtro = this.value.toLowerCase();
            
    //         // Faça uma solicitação AJAX para buscar opções com base no filtro
    //         // Substitua a URL pela URL do seu arquivo AJAX
    //         // A resposta deve ser um array de objetos com as opções (por exemplo, [{ value: "3", text: "Condomínio" }])
    //         // Certifique-se de que a resposta seja tratada como JSON no seu arquivo AJAX.
    //         fetch('application/pretendente/view/visita/ajax/filterImovel.php', {
    //             method: 'POST',
    //             body: JSON.stringify(filtro) // Converte o objeto em uma string JSON
    //         }).then(response => response.json()).then(data => {
    //             console.log("🚀 ~ resposta ajax:", data)

    //             // apagar select com id select-imovel
    //             selectImovel.innerHTML = '';

    //             // Atualizar options do select 
    //             selectImovel.innerHTML = '<option value="">-- Selecione --</option>';
    //             data.forEach(function(item) {
    //                 selectImovel.innerHTML += '<option value="' + item.value + '">' + item.text + '</option>';
    //             });

    //             // Cria novo select
    //             NiceSelect.bind(document.getElementById("select-imovel"), options);

                
                

                
    //         }).catch(error => console.error(error));
    //     });
    // });
</script>
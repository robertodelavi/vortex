<?php 
    $sql = 'SELECT 
                u.usu_codigo,
                u.usu_nome,
                p.upe_descricao
            FROM 
                usuario AS u
                LEFT JOIN usuario_permissao AS p ON (u.upe_codigo = p.upe_codigo)
            ORDER BY u.usu_nome ASC';
    $usuario = $data->find('dynamic', $sql);
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9 col-xs-8">
        <h2>Relatórios</h2>
        <ol class="breadcrumb">
            <li>Cotações realizadas</li>
            <li class="active"><strong>Filtro</strong></li>            
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Definição dos filtros</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>

        <div class="ibox-content">
            <form role="form" action="application/relatorio/view/cotacao/relatorio.php" target="_blank" id="MyForm" method="post" enctype="multipart/form-data" name="MyForm">
                <div class="row form-group">
                    <div class="col-sm-2">
                        <label class="control-label" for="data_ini">Data Inicial:</label>
                        <input name="data_ini" type="text" class="form-control blockenter" id="data_ini" required />
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="data_fin">Data Final:</label>
                        <input name="data_fin" type="text" class="form-control blockenter" id="data_fin" required />
                    </div>

                    <div class="col-sm-8" >
                        <label class="control-label" for="usuario">Usuário:</label>
                        <select name="usuario" class="form-control selectpicker show-tick" id="usuario" >
                            <option value="">TODAS USUÁRIOS</option>
                            <?php 
                                for($i=0; $i< count($usuario); $i++){ 
                                    echo '<option value="'.$usuario[$i]['usu_codigo'].'"> '.$usuario[$i]['usu_nome'].' ['.$usuario[$i]['upe_descricao'].']</option>';  
                                }
                            ?>
                        </select>
                    </div>
                </div> 

                <div class="form-group" style="margin-top:20px;" >
                    <button class="btn btn-primary" type="submit"><i class="fa fa-print" aria-hidden="true"></i>  Imprimir relatório</button>                    
        		</div>
        	</form>	
        </div>
    </div>  

<script>	
    function enviar(){       
        document.forms['MyForm'].submit();
    }     

    $("#data_ini").mask("99/99/9999");
    $('#data_ini').datepicker({    
        format: "dd/mm/yyyy",
        autoclose: true,
        orientation: "bottom left",
        startView: 0,    
        todayHighlight: true,
        language: "pt-BR"
    });

    $("#data_fin").mask("99/99/9999");
    $('#data_fin').datepicker({    
        format: "dd/mm/yyyy",
        autoclose: true,
        orientation: "bottom left",
        startView: 0,    
        todayHighlight: true,
        language: "pt-BR"
    });
</script>

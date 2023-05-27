<?php 
    $sql = "SELECT * FROM usuario_permissao ORDER BY upe_descricao ASC";
    $permissao = $data->find('dynamic', $sql);

    $sql = "SELECT est_uf FROM cidade GROUP BY est_uf ORDER BY est_uf ASC";
    $estados = $data->find('dynamic', $sql);
?>

<!-- some CSS styling changes and overrides -->
<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: left;
    }
    .kv-avatar .file-input {
        display: table-cell;
        /*max-width: 220px;*/
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9 col-xs-8">
        <h2>Usuários</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#">Usuário</a>
            </li>
            <li class="active">
                <strong>Novo</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-3 col-xs-4" style="text-align:right;">
        <br /><br />
        <button class="btn btn-primary" onclick="$('#MyForm').valid() ? enviar():'';" type="button"><i class="fa fa-check"></i><span class="hidden-xs hidden-sm"> Salvar</span></button>
        <button class="btn btn-default" onclick="voltar();" type="button"><i class="fa fa-times"></i><span class="hidden-xs hidden-sm"> Cancelar</span></button>
    </div>
</div>

<div id="result_login"></div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulário de Cadastro</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form role="form" action="?module=usuario&acao=grava_usuario" id="MyForm" method="post" enctype="multipart/form-data" name="MyForm">
                <div class="row form-group">
                	<div class="col-sm-8" >           
        		        <label class="control-label" for="usu_nome">Nome:</label>
        	    	    <input name="usu_nome" type="text" class="form-control" id="usu_nome" style="text-transform:uppercase;" required/>
                    </div>

                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_login">Login:</label>
                        <input name="usu_login" type="text" class="form-control" id="usu_login" style="text-transform:lowercase;" required onblur="verif_login();" />
                    </div>                

                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_senha">Senha:</label>
                        <input name="usu_senha" type="password" class="form-control" id="usu_senha" required />
                    </div> 
                </div>  
                
                <div class="row form-group" > 
                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_email">E-mail:</label>
                        <input name="usu_email" type="text" class="form-control" id="usu_email" style="text-transform:lowercase;" required />
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="usu_telefone">Telefone:</label>
                        <input name="usu_telefone" type="text" class="form-control blockenter" id="usu_telefone" style="text-transform:uppercase;"  />
                    </div> 
                    <div class="col-sm-4" >           
                        <label class="control-label" for="upe_codigo">Função/Cargo</label>
                        <select name="upe_codigo" class="form-control selectpicker show-tick" id="upe_codigo" onchange="mostra_representante();" required >                   
                            <option value="">SELECIONE...</option>
                            <?php
                                for($i=0; $i<count($permissao); $i++){
                                    echo '<option value="'.$permissao[$i]['upe_codigo'].'">'.$permissao[$i]['upe_descricao'].'</option>';    
                                }
                            ?>
                        </select>                
                    </div> 
        		</div>

                <div class="row form-group" id="representante">
                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_estado_atuacao">Estado atuação:</label>
                        <select name="usu_estado_atuacao" class="form-control selectpicker show-tick" id="usu_estado_atuacao" >
                            <option value="">SELECIONE</option>
                        <?php
                            for($i=0; $i<count($estados); $i++){
                                echo '<option value="'.$estados[$i]['est_uf'].'">'.$estados[$i]['est_uf'].'</option>';
                            }
                        ?>
                        </select>                
                    </div> 
                    <div class="col-sm-10" >
                        <label class="control-label" for="usu_area_atuacao">Área de Atuação:</label>
                        <input name="usu_area_atuacao" id="usu_area_atuacao" type="text" style="text-transform: uppercase;" class="form-control" value="<?php echo $usuario[0]['usu_area_atuacao']?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_meta_prospeccao">Meta Prospecção (mês):</label>
                        <input name="usu_meta_prospeccao" id="usu_meta_prospeccao" type="text" class="form-control" />
                    </div>

                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_meta_cotacao">Meta Cotação (mês):</label>
                        <input name="usu_meta_cotacao" type="text" class="form-control" id="usu_login" />
                    </div>
                </div>

                <div class="row form-group" > 
                    <div class="col-sm-12" >           
                        <label class="control-label" for="usu_dado_bancario">Dados Bancários:</label>
                        <textarea name="usu_dado_bancario" rows="5" class="form-control" id="usu_dado_bancario" style="text-transform:uppercase;"></textarea>
                    </div>
                </div>

                <div class="row" >
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <input type="hidden" name="imagemCortada" id="imagemCortada">
                        
                            <div class="row">
                                <!-- edit -->
                                <div class="col-md-4" >                            
                                    <div class="image-crop" id="image_edits" style="display: block;" >                                
                                        <img src="application/images/sem_img_profile.svg" style="width:100%;">
                                    </div>
                                </div>
                                <div class="col-md-4" id="btn_edits" style="display: block;" >
                                    <div class="btn-group">
                                        <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                            <input type="file" accept="image/*" name="file" id="inputImage" class="hide">
                                            Escolher imagem
                                        </label>                      
                                        <div style="clear: both;" ></div>
                                        <div>    
                                          <font style="color: #a3a3a3;">* Escolha uma imagem </font><br/>
                                          <span style="color: #a3a3a3;">* Selecione a área de corte </span><br/>
                                          <span style="color: #a3a3a3;">* Clique em Salvar </span>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row -->    
                        </div>
                    </div>
                </div>

                <input name="usu_situacao" type="hidden" value="1" /> 
                
                <!-- Para nao dar erro de nao existir a id ainda -->
                <input type="hidden" id="val_existe" value="0" />
        		
        	</form>	

            <div class="form-group" style="margin-top:20px;" >
                <button class="btn btn-primary" onclick="$('#MyForm').valid() ? enviar():'';" type="button"><i class="fa fa-check"></i><span class="hidden-xs hidden-sm"> Salvar</span></button>
                <button class="btn btn-default" onclick="voltar();" type="button"><i class="fa fa-times"></i>  Cancelar</button>
            </div>
        </div>
    </div>       	 
<script>	
    function mostra_representante(){
        if($("#upe_codigo").val() == 2){
            document.getElementById('representante').style.display = 'block';
        }else{
            document.getElementById('representante').style.display = 'none';
        }
    }

    var $image;

    function setimg(){
        document.getElementById('imagemCortada').value = $image.cropper("getDataURL");
        //document.forms['MyForm'].submit();  
    }

    function enviar(){
    	setimg();
        verif_login();
        if(document.getElementById('val_existe').value == '1'){
            bootbox.alert("Este login já está cadastrado em nosso sistema, favor verificar!", function(){}); 
        }else{
            document.forms['MyForm'].submit();  
        }
    }

    $(document).ready(function(){
        $image = $(".image-crop > img")
        $($image).cropper({
            aspectRatio: 1.0,
            preview: ".img-preview",
            done: function(data) {                    
                // Output the result data for cropping image.
            }
        });

        var $inputImage = $("#inputImage");
        if (window.FileReader) {
            $inputImage.change(function() {
                var fileReader = new FileReader(),
                    files = this.files,
                    file;

                if (!files.length) {
                    return;
                }

                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $inputImage.val("");
                        $image.cropper("reset", true).cropper("replace", this.result);
                    };
                } else {
                    showMessage("Por favor, escolha uma imagem.");
                }
            });
        } else {
            $inputImage.addClass("hide");
        }

        $("#download").click(function() {
            window.open($image.cropper("getDataURL"));
            //alert($image.cropper("getDataURL"));
        });

        $("#zoomIn").click(function() {
            $image.cropper("zoom", 0.1);
        });

        $("#zoomOut").click(function() {
            $image.cropper("zoom", -0.1);
        });
    });
    
    
    function voltar(){
        window.location.href = '?module=usuario&acao=lista_usuario';
    } 
	
     $(document).ready(function(){
       /*
        $(".sel_estab").select2({
            placeholder: "Selecione a clinica deste usuario",
            allowClear: true
        });
        */

        $("#MyForm").validate({
            rules: {
                usu_nome: {
                    required: true,
                    minlength: 5
                },
                usu_login: {
                    required: true,
                    maxlength: 20,
                   minlength: 4
                },
                usu_senha: {
                    required: true,
                    maxlength: 20,
                    minlength: 6
                },
                usu_email: {
                    required: true,
                    email: true
                },
                per_codigo: {
                    required: true
                }
            }
        });

        $("#MyForm").submit(function(event) {
        	setimg();
            verif_login();    
            if(document.getElementById('val_existe').value == '0'){
                document.forms['MyForm'].submit();
            }else{
                event.preventDefault(); //para o submit
                bootbox.alert("Este login já está cadastrado em nosso sistema, favor verificar!", function(){}); 
            }
        });
        
        $("#usu_telefone").mask("(99) 9999-9999?9");

    });

    function verif_login(login){
        login = document.getElementById('usu_login').value;                
        //
        url = "application/script/ajax/verificaFormulario.php?formulario=usuario&login="+login;
        div = "result_login"; // div que receberá o resultado
        ajax(url, div);   
    }
</script>

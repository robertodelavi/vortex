<?php 
    $sql = "SELECT * FROM usuario_permissao ORDER BY upe_descricao ASC";
    $permissao = $data->find('dynamic', $sql);

    $sql = "SELECT * FROM usuario AS u WHERE u.usu_codigo = ".$_POST['param_0'];
    $usuario = $data->find('dynamic', $sql);			

    if($_SESSION['wf_userPermissao'] == 1){
        $inativar = '';    
    }else{
        $inativar = 'disabled';
    }

    if(!$usuario[0]['usu_foto']){
        $foto = 'application/images/sem_img_profile.svg';
    }else{
        $foto = $usuario[0]['usu_foto'];
    }    
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9 col-xs-8">
        <?php if($usuario[0]['usu_permissao']==1){ ?>
            <h2>Usuários</h2>
            <ol class="breadcrumb">
                <li><a href="?module=usuario&acao=lista_usuario">Usuário</a></li>
                <li class="active"><strong>Detalhes</strong></li>
            </ol>

        <?php }else{ ?>
            
            <h2>Meus dados</h2>
            <ol class="breadcrumb">
                <li><a href="?module=usuario&acao=lista_usuario">Usuário</a></li>
                <li class="active"><strong>Detalhes</strong></li>
            </ol>
        <?php } ?>
    </div>

    <div class="col-lg-3 col-xs-4" style="text-align:right;">
        <br /><br />
        <button class="btn btn-primary" onclick="$('#MyForm').valid() ? enviar():'';" type="submit"><i class="fa fa-check"></i><span class="hidden-xs hidden-sm"> Salvar</span></button>
        <button class="btn btn-default" onclick="voltar();" type="button"><i class="fa fa-times"></i><span class="hidden-xs hidden-sm"> Cancelar</span></button>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Detalhes do Usuário</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <form role="form" action="?module=usuario&acao=update_usuario" id="MyForm" method="post" enctype="multipart/form-data" name="MyForm">
                <input type="hidden" name="usu_codigo" id="usu_codigo" value="<?php echo $usuario[0]['usu_codigo']; ?>">
                <div class="row form-group">
                	<div class="col-sm-8" >           
        		        <label class="control-label" for="usu_nome">Nome:</label>
        	    	    <input name="usu_nome" id="usu_nome" type="text" class="form-control" value="<?php echo $usuario[0]['usu_nome']?>" />
                    </div>

                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_login">Login:</label>
                        <input name="usu_login" type="text" class="form-control" id="usu_login" value="<?php echo $usuario[0]['usu_login']?>" <?php echo $inativar; ?> readonly/>
                    </div>                

                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_senha">Senha:</label>
                        <input name="usu_senha" type="password" class="form-control" id="usu_senha" value="<?php echo $usuario[0]['usu_senha']?>" />
                    </div> 
                </div>  
                
                <div class="row form-group" > 
                    <div class="col-sm-8" >           
                        <label class="control-label" for="usu_email">E-mail:</label>
                        <input name="usu_email" type="text" class="form-control" id="usu_email" style="text-transform:lowercase;" value="<?php echo $usuario[0]['usu_email']?>" />
                    </div>
                    <div class="col-sm-4" >           
                        <label class="control-label" for="upe_codigo">Função/Cargo:</label>
                        <select name="upe_codigo" class="form-control selectpicker show-tick" id="upe_codigo" <?php echo $inativar; ?> required >
                        <?php
                            for($i=0; $i<count($permissao); $i++){
                                if($permissao[$i]['upe_codigo'] == $usuario[0]['upe_codigo']){
                                    echo '<option value="'.$permissao[$i]['upe_codigo'].'" selected>'.$permissao[$i]['upe_descricao'].'</option>';
                                }else{
                                    echo '<option value="'.$permissao[$i]['upe_codigo'].'">'.$permissao[$i]['upe_descricao'].'</option>';    
                                }
                            }
                        ?>
                        </select>                
                    </div> 
        		</div>

                <div class="row form-group">
                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_meta_prospeccao">Meta Prospecção (mês):</label>
                        <input name="usu_meta_prospeccao" id="usu_meta_prospeccao" type="text" class="form-control" value="<?php echo $usuario[0]['usu_meta_prospeccao']?>" <?php echo $inativar; ?> />
                    </div>

                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_meta_cotacao">Meta Cotação (mês):</label>
                        <input name="usu_meta_cotacao" type="text" class="form-control" id="usu_login" value="<?php echo $usuario[0]['usu_meta_cotacao']?>" <?php echo $inativar; ?> />
                    </div>
                </div>    

                <div class="row form-group" > 
                    <div class="col-sm-12" >           
                        <label class="control-label" for="usu_dado_bancario">Dados Bancários:</label>
                        <textarea name="usu_dado_bancario" rows="5" class="form-control" id="usu_dado_bancario" style="text-transform:uppercase;"><?php echo $usuario[0]['usu_dado_bancario']?></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <input type="hidden" name="imagemAnterior" value="<?php echo $usuario[0]['usu_foto']; ?>">
                            <input type="hidden" name="imagemCortada" id="imagemCortada" disabled />
                        
                            <div class="row form-group" style="padding-left: 12px;" >
                              <!-- view -->
                                <div class="col-md-4" >
                                    <div id="image_view" style="display: block;" >                                
                                        <img src="<?php echo $foto; ?>" width="100%;">
                                    </div>
                                </div>
                                <div class="col-md-2" id="btn_view" style="display: block;" >
                                    <div class="btn-group">
                                        <a href="#div_imagem" onclick="editar_imagem();" >
                                          <div class="btn btn-primary">                                    
                                              Editar imagem
                                          </div>                      
                                        </a>
                                        <div style="clear: both;" ></div>                                
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group" id="div_imagem" style="padding-left: 12px;">
                                <!-- edit -->
                                <div class="col-md-4" >                            
                                    <div class="image-crop" id="image_edits" style="display: none;" >                                
                                        <img src="<?php echo $foto; ?>" style="width:100%;">
                                    </div>
                                </div>
                                <div class="col-md-4" id="btn_edits" style="display: none;" >
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
        	</form>	

            <div class="form-group" style="margin-top:20px;" >
                <button class="btn btn-primary" onclick="$('#MyForm').valid() ? enviar():'';" type="submit"><i class="fa fa-check"></i><span class="hidden-xs hidden-sm"> Salvar</span></button>
                <button class="btn btn-default" onclick="voltar();" type="button"><i class="fa fa-times"></i>  Cancelar</button>
            </div>
        </div>
    </div>            	 

<script>
    var $image;

    function editar_imagem(){
        document.getElementById('image_edits').style.display = 'block';
        document.getElementById('image_view').style.display  = 'none';
        //
        document.getElementById('btn_edits').style.display   = 'block';
        document.getElementById('btn_view').style.display    = 'none';

        document.getElementById('imagemCortada').removeAttribute("disabled");

    }

    function setimg(){
        document.getElementById('imagemCortada').value = $image.cropper("getDataURL");
        //document.forms['MyForm'].submit();  
    }

    function enviar(){
        setimg();
        document.forms['MyForm'].submit();  
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
            document.forms['MyForm'].submit();
        });
    });
    
    function voltar(){
        window.location.href = '?module=usuario&acao=lista_usuario';
    }
</script>
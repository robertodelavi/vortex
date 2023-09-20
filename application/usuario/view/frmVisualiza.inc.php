<?php 
    $sql = "SELECT * FROM usuario_permissao ORDER BY upe_descricao ASC";
    $permissao = $data->find('dynamic', $sql);

    $sql = "SELECT * FROM usuario AS u JOIN usuario_permissao AS p ON (p.upe_codigo = u.upe_codigo) WHERE u.usu_codigo = ".$_POST['param_0'];
    $usuario = $data->find('dynamic', $sql);

    $sql = "SELECT est_uf FROM cidade GROUP BY est_uf ORDER BY est_uf ASC";
    $estados = $data->find('dynamic', $sql);

    $sql = "SELECT * FROM usuario_areaatuacao WHERE usu_codigo = ".$_POST['param_0'];
    $atuacao = $data->find('dynamic', $sql);

    if($_SESSION['v_usu_nivel'] > 1){
        if($usuario[0]['upe_codigo'] == 1){
            $inativar = '';    
        }else{
            $inativar = 'readonly';
        }
    }
    
    if(!$usuario[0]['usu_foto']){
        $foto = 'application/images/sem_img_profile.svg';
    }else{
        $foto = $usuario[0]['usu_foto'];
    }    
?>

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: "slideDown",
        timeOut: 5000
    };
    <?php
        switch ($_GET[ms]){
            case 1:
                echo 'toastr.success("Usuário cadastro com sucesso!", "Incluido!");';
                break;

            case 2:
                echo 'toastr.success("Usuário atualizado com sucesso", "Atualizado!");';
                break;

            case 3:
                echo 'toastr.success("Usuário excluido com sucesso", "Exluido!");';
                break;

            case 4:
                echo 'toastr.info("Usuário foi inativado", "Inativado!");';
                break;

            case 5:
                echo 'toastr.success("Usuário foi reativado", "Reativado!");';
                break;          

            case 6:
                echo 'toastr.success("Área de atuação foi cadastrada com sucesso", "Área de Atuação!");';
                break;

            case 7:
                echo 'toastr.success("Área de atuação foi deletada com sucesso", "Área de Atuação!");';
                break;    
        }
    ?>
</script>

<body onload="mostra_representante(<?php echo $usuario[0]['upe_codigo']?>);">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9 col-xs-8">
        <?php if($usuario[0]['usu_permissao']==1){ ?>
            <h2>Usuários</h2>
            <ol class="breadcrumb">
                <li><a href="#">Usuário</a></li>
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
                        <input name="usu_login" type="text" class="form-control" id="usu_login" value="<?php echo $usuario[0]['usu_login']?>" <?php echo $inativar; ?> />
                    </div>                

                    <div class="col-sm-2" >           
                        <label class="control-label" for="usu_senha">Senha:</label>
                        <input name="usu_senha" type="password" class="form-control" id="usu_senha" value="<?php echo $usuario[0]['usu_senha']?>" />
                    </div> 
                </div>  
                
                <div class="row form-group" > 
                    <div class="col-sm-6" >           
                        <label class="control-label" for="usu_email">E-mail:</label>
                        <input name="usu_email" type="text" class="form-control" id="usu_email" style="text-transform:lowercase;" value="<?php echo $usuario[0]['usu_email']?>" />
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label" for="usu_telefone">Telefone:</label>
                        <input name="usu_telefone" type="text" class="form-control blockenter" id="usu_telefone" style="text-transform:uppercase;" value="<?php echo $usuario[0]['usu_telefone']?>" />
                    </div>                    
                    <div class="col-sm-4" >           
                        <label class="control-label" for="upe_codigo">Função/Cargo:</label>
                        <select name="upe_codigo" class="form-control" id="upe_codigo" <?php echo $inativar; ?> onchange="mostra_representante();" required >
                        <?php
                            if($_SESSION['v_usu_nivel'] > 1){ //CASO NÃO FOR ADM
                                echo '<option value="'.$usuario[0]['upe_codigo'].'" selected>'.$usuario[0]['upe_descricao'].'</option>';
                            }else{
                                for($i=0; $i<count($permissao); $i++){
                                    if($permissao[$i]['upe_codigo'] == $usuario[0]['upe_codigo']){
                                        echo '<option value="'.$permissao[$i]['upe_codigo'].'" selected>'.$permissao[$i]['upe_descricao'].'</option>';
                                    }else{
                                        echo '<option value="'.$permissao[$i]['upe_codigo'].'">'.$permissao[$i]['upe_descricao'].'</option>';    
                                    }
                                }
                            }
                        ?>
                        </select>                
                    </div> 
        		</div>

                <?php if($usuario[0]['upe_codigo'] < 9){ ?>
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
                <?php } ?>

                <div class="row form-group" id="representante">    
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            	<div class="row form-group" style="margin-bottom: 0px;">
	                                <div class="col-sm-9">
	                                    ÁREA DE ATUAÇÃO
	                                </div>
	                                <?php if($_SESSION['v_usu_nivel'] == 1){ ?>
	                                    <div class="col-sm-3" style="text-align: right;">
	                                        <a href="#" onClick='abreAreaatuacao("<?php echo $_POST['param_0']?>");' title="Adicionar área de atuação" style="text-decoration:none;"> <button class="btn btn-default btn-xs" style="margin: 0" type="button"><i class="fa fa-plus"></i>  Adicionar área de atuação</button> </a>
	                                    </div>
	                                <?php } ?>    
	                            </div>

                            </div>
                            <div class="panel-body" >
				                <div class="table-responsive" style="overflow-x: initial;">
				         			<br class="hidden-md hidden-lg" />
					                <table class="table table-striped table-bordered table-hover dataTables-example">
					                    <thead>
						                    <tr>
						                        <th>ESTADO</th>
								            	<th>ÁREA DE ATUAÇÃO</th>
								            	<?php if($_SESSION['v_usu_nivel'] == 1){ echo '<th>Opção</th>'; } ?>
						                    </tr>
					                    </thead>
					    
					    				<tbody>
								        <?php
											for($i=0; $i< count($atuacao); $i++){
												echo '
												<tr>
													<td ><a href="#" title="Visualizar usuário" onClick="nextPage(\'?module=usuario&acao=visualiza_usu_atuacao\', '.$atuacao[$i]['uaa_codigo'].');" style="text-decoration:none;">'.$atuacao[$i]['uaa_estado'].'</a></td>
													<td >'.$atuacao[$i]['uaa_area_atuacao'].'</td>';
													if($_SESSION['v_usu_nivel'] == 1){
														echo '
														<td> 
														   <a href="#" onClick=\'deletar('.$atuacao[$i]['uaa_codigo'].', '.$atuacao[$i]['usu_codigo'].');\' title="Excluir Área de atuação" style="text-decoration:none;">
																	<i class="fa fa-trash"></i>
																</a>
														</td>';
													}
												echo '	
												</tr>';
											}
										?>        	
								        </tbody>
									</table>
								</div>
							</div>
						</div>
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

<div class="modal inmodal" id="modalAreaatuacao" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">                    
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" onclick="fechaAreaatuacao()"><span aria-hidden="true" >&times;</span><span class="sr-only">Close</span></button>                              
                <h4 class="modal-title">Adicionar Área de Atuação</h4>                    
            </div>
            <div class="modal-body">
                <form role="form" action="?module=usuario&acao=gravaarea_usuario" id="FormAreaatuacao" method="post" enctype="multipart/form-data" name="FormAreaatuacao">
                    <input type="hidden" name="usu_codigo" id="usu_codigo_area" />
                    <div class="row form-group">
                        <div class="col-sm-2">
                            <select name="uaa_estado" class="form-control" required>
                                <?php 
                                    for($j=0; $j< count($estados); $j++){
                                        echo '<option value="'.$estados[$j]['est_uf'].'">'.$estados[$j]['est_uf'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-10">
                            <input name="uaa_area_atuacao" type="text" class="form-control blockenter" style="text-transform: uppercase;" required />
                        </div>
                    </div>


                    <div class="form-group" style="margin-top:20px;" >
                        <button class="btn btn-primary" onclick="$('#FormAreaatuacao').valid() ? enviarFoto():'';" type="submit"><i class="fa fa-check"></i><span class="hidden-xs hidden-sm"> Salvar</span></button>
                        <button class="btn btn-default" onclick="fechaAreaatuacao();" type="button"><i class="fa fa-times"></i>  Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>            
</div>

<script>
    function abreAreaatuacao(usu_codigo){
        document.getElementById('modalAreaatuacao').style.display = 'block';
        document.getElementById('usu_codigo_area').value = usu_codigo;
    }

    function fechaAreaatuacao(){
        document.getElementById('modalAreaatuacao').style.display = 'none';
        return false;
    }

    function enviarAreaatuacao(){
        document.forms['FormAreaatuacao'].submit();  
    }

    function deletar(id, id2){
        var url = "?module=usuario&acao=deletaarea_usuario";

        swal({
            title: "Você tem certeza?   ",
            text: "Deseja realmente deletar esta Área de atuação?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: false,
            closeOnCancel: false 
        }).then(function() {     //CONFIRM      
            nextPage(url, id+','+id2);
        }, function(dismiss) {
          // dismiss can be 'cancel', 'overlay', 'close', 'timer'
          if (dismiss === 'cancel') {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: "slideDown",
                    timeOut: 5000
                };
                toastr.info("Nenhum dado foi afetado!", "Cancelado");
          }
        })
    }

    function mostra_representante(id){
        if(!id){
           id = $("#upe_codigo").val();
        }
        if((id == 1)||(id == 2)||(id == 3)||(id == 6)||(id == 7)){
            document.getElementById('representante').style.display = 'block';
        }else{
            document.getElementById('representante').style.display = 'none';
        }
    }


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
                   minlength: 3
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

        $("#usu_telefone").mask("(99) 9999-9999?9");
    });
    
    function voltar(){
        window.location.href = '?module=usuario&acao=lista_usuario';
    }
</script>
<?php
	$sql = "SELECT 
				u.usu_codigo,
				u.usu_nome,
				u.usu_login,
				u.usu_email,
				u.usu_situacao,
				u.usu_foto,
				p.upe_codigo,
				p.upe_descricao
			FROM 
				usuario AS u
				LEFT JOIN usuario_permissao AS p ON (u.upe_codigo = p.upe_codigo)
			WHERE 
				u.usu_situacao = 1 
			ORDER BY usu_nome ASC";
	$res_ati = $data->find('dynamic', $sql);

	$sql = "SELECT 
				u.usu_codigo,
				u.usu_nome,
				u.usu_login,
				u.usu_email,
				u.usu_situacao,
				u.usu_foto,
				p.upe_codigo,
				p.upe_descricao
			FROM 
				usuario AS u
				LEFT JOIN usuario_permissao AS p ON (u.upe_codigo = p.upe_codigo)
			WHERE 
				u.usu_situacao = 0
			ORDER BY usu_nome ASC";
	$res_ina = $data->find('dynamic', $sql);
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
		}
	?>
</script>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9 col-xs-9">
        <h2>Usuários</h2>
        <ol class="breadcrumb">
            <li>
                <a href="?module=principal&acao=visao_geral">Início</a>
            </li>
            <li class="active">
                <strong>Usuário</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-3 col-xs-3" style="text-align:right;">
    	<br /><br />
		<a href="?module=usuario&acao=novo_usuario" class="btn btn-primary" style="height: 34px;">
			<span class="glyphicon glyphicon-plus-sign"></span> <span class="hidden-xs hidden-sm">Novo</span>
		</a>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-thumbs-o-up"></i>Ativos (<?php echo count($res_ati); ?>)</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-thumbs-o-down"></i>Inativos (<?php echo count($res_ina); ?>)</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow-x: initial;">
			         			<br class="hidden-md hidden-lg" />
				                <table class="table table-striped table-bordered table-hover dataTables-example">
				                    <thead>
					                    <tr>
					                        <th>...</th>
							            	<th>Nome</th>
							            	<th>Login</th>
							            	<th>E-mail</th>            	       
							            	<th>Permissão</th>            	       
							            	<th>Opção</th>
					                    </tr>
				                    </thead>
				    
				    				<tbody>
							        <?php
										for($i=0; $i< count($res_ati); $i++){
											if($res_ati[$i]['usu_foto']){
												$foto = $res_ati[$i]['usu_foto'];
											}else{
												$foto = 'application/images/sem_img_profile.svg';
											}

											echo '
											<tr>
												<td ><img src="'.$foto.'" style="width:25px; height:25px; border-radius:50%;" /></td>
												<td ><a href="#" title="Visualizar usuário" onClick="nextPage(\'?module=usuario&acao=visualiza_usuario\', '.$res_ati[$i]['usu_codigo'].');" style="text-decoration:none;">'.$res_ati[$i]['usu_nome'].'</a></td>
												<td >'.$res_ati[$i]['usu_login'].'</td>
												<td >'.$res_ati[$i]['usu_email'].'</td>
												<td >'.$res_ati[$i]['upe_descricao'].'</td>
												<td>';
													
													if($res_ati[$i]['usu_situacao']==1){
														echo '
														<a href="#" onClick=\'inativar("'.$res_ati[$i]['usu_codigo'].'", "'.$res_ati[$i]['usu_nome'].'");\' title="Inativar Usuário" style="text-decoration:none;">
															<i class="fa fa-thumbs-o-down"></i>
														</a>';
													}else{
														echo '
														<a href="#" onClick=\'ativar("'.$res_ati[$i]['usu_codigo'].'", "'.$res_ati[$i]['usu_nome'].'");\' title="Ativar Usuário" style="text-decoration:none;">
															<i class="fa fa-thumbs-up"></i>
														</a>';
													}
												echo '
												</td>
											</tr>';
										}
									?>        	
							        </tbody>
								</table>
							</div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="table-responsive" style="overflow-x: initial;">
			         			<br class="hidden-md hidden-lg" />
				                <table class="table table-striped table-bordered table-hover dataTables-example">
				                    <thead>
					                    <tr>
					                        <th>...</th>
							            	<th>Nome</th>
							            	<th>Login</th>
							            	<th>E-mail</th>            	       
							            	<th>Permissão</th>            	       
							            	<th>Opção</th>
					                    </tr>
				                    </thead>
				    
				    				<tbody>
							        <?php
										for($i=0; $i< count($res_ina); $i++){
											if($res_ina[$i]['usu_foto']){
												$foto = $res_ina[$i]['usu_foto'];
											}else{
												$foto = 'application/images/sem_img_profile.svg';
											}

											echo '
											<tr>
												<td ><img src="'.$foto.'" style="width:25px; height:25px; border-radius:50%;" /></td>
												<td ><a title="Visualizar usuário" href="#" onClick="nextPage(\'?module=usuario&acao=visualiza_usuario\', '.$res_ina[$i]['usu_codigo'].');" style="text-decoration:none;">'.$res_ina[$i]['usu_nome'].'</a></td>
												<td >'.$res_ina[$i]['usu_login'].'</td>
												<td >'.$res_ina[$i]['usu_email'].'</td>
												<td >'.$res_ina[$i]['upe_descricao'].'</td>
												<td>';
													
													if($res_ina[$i]['usu_situacao']==1){
														echo '
														<a href="#" onClick=\'inativar("'.$res_ina[$i]['usu_codigo'].'", "'.$res_ina[$i]['usu_nome'].'");\' title="Inativar Usuário" style="text-decoration:none;">
															<i class="fa fa-thumbs-o-down"></i>
														</a>';
													}else{
														echo '
														<a href="#" onClick=\'ativar("'.$res_ina[$i]['usu_codigo'].'", "'.$res_ina[$i]['usu_nome'].'");\' title="Ativar Usuário" style="text-decoration:none;">
															<i class="fa fa-thumbs-up"></i>
														</a>';
													}
												echo '
												</td>
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
        </div>
    </div>
	<br />

<script>
    $(document).ready(function() {
        $('.dataTables-example').DataTable({
        	"lengthMenu": [[50,150,200,-1], [50,150,200, "Todos"]]
        });
    });

	function inativar(id, nome){
		var url = "?module=usuario&acao=inativar_usuario";

		swal({
            title: "Você tem certeza?	",
            text: "Deseja realmente inativar este Usuário?<br /><b>"+nome+"</b>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: false,
            closeOnCancel: false 
        }).then(function() {	 //CONFIRM      
            nextPage(url, id);
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

	function ativar(id, nome){
		var url = "?module=usuario&acao=ativar_usuario";

		swal({
            title: "Você tem certeza?	",
            text: "Deseja realmente ativar este Usuário?<br /><b>"+nome+"</b>",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim",
            cancelButtonText: "Não",
            closeOnConfirm: false,
            closeOnCancel: false 
        }).then(function() {	 //CONFIRM      
            nextPage(url, id);
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
</script>
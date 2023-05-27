<?php
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 	
	$data = new DataManipulation();
	//	
	switch($_GET['formulario']){
		// ARTIGOS ESPORTIVOS
		case 'artigoesportivo':
			//
			if($_GET['artigoesportivo'] != 'undefined'){
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND art_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//
				$sql = "SELECT art_nome
						FROM sge_artigo_esportivo
						WHERE art_nome = '".$_GET['desc']."' ".$update;
				$result = $data->find('dynamic', $sql);
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este artigo esportivo já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// aluno
		case 'aluno':
			//
			if($_GET['aluno'] != 'undefined'){
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND alu_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//
				$_GET['dt_nasc'] = implode("-", array_reverse(explode("/", $_GET['dt_nasc'])));
				//
				$sql = "SELECT alu_nome
						FROM sge_aluno
						WHERE alu_nome     = '".$_GET['nome_alu']."' AND 
							  alu_dt_nasc  = '".$_GET['dt_nasc']."'  AND 
							  alu_mae_nome = '".$_GET['nome_mae']."' ".$update;
				$result = $data->find('dynamic', $sql);					
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este aluno já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// CAMPO
		case 'curso':
			//
			if($_GET['curso'] != 'undefined'){			
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND cur_codigo <> '.$_GET['pk'];
				else
					$update = '';	
				//
				$sql = "SELECT cur_descricao
						FROM sge_curso
						WHERE cur_descricao = '".$_GET['desc']."' ".$update;
				$result = $data->find('dynamic', $sql);				
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este curso já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// ESCOLA
		case 'escola':
			//
			if($_GET['escola'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND esc_codigo <> '.$_GET['pk'];
				else
					$update = '';		
				//
				$sql = "SELECT esc_nome
						FROM sge_escola
						WHERE esc_nome = '".$_GET['desc']."' ".$update;
				$result = $data->find('dynamic', $sql);				
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Esta escola já está cadastrada no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// NIVEL
		case 'nivel':
			//
			if($_GET['nivel'] != 'undefined'){	
				if($_GET['desc']){	
					$sql = "SELECT cni_descricao
							FROM sge_curso_nivel
							WHERE cni_descricao = '".$_GET['desc']."' AND 
								  cur_codigo = ".$_GET['pk'];
					$result = $data->find('dynamic', $sql);				
				}
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este nível já está cadastrada neste curso, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// PARÂMETRO
		case 'parametro':
			//
			if($_GET['parametro'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND prm_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//						
				$sql = "SELECT prm_desc
						FROM sge_parametro
						WHERE prm_desc = '".$_GET['desc']."' ".$update;
				$result = $data->find('dynamic', $sql);				
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este parâmetro já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// PROFESSOR
		case 'professor':						
			if($_GET['professor'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND prf_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//						
				$_GET['dt_nasc'] = implode("-", array_reverse(explode("/", $_GET['dt_nasc'])));
				//
				$sql = "SELECT prf_nome
						FROM sge_professor
						WHERE prf_nome = '".$_GET['desc']."' AND 
							  prf_dt_nasc = '".$_GET['dt_nasc']."' ".$update;
				$result = $data->find('dynamic', $sql);				
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este professor já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// TURMA
		case 'turma':						
			if($_GET['turma'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND tur_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//														
				$sql = "SELECT tur_nome
						FROM sge_turma
						WHERE tur_nome = '".$_GET['desc']."' ".$update;
				$result = $data->find('dynamic', $sql);				
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Esta turma já está cadastrada no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// USUÁRIO
		case 'usuario':						
			if($_GET['usuario'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				if($_GET['pk'])
					$update = ' AND usu_codigo <> '.$_GET['pk'];
				else
					$update = '';
				//														
				$sql = "SELECT usu_nome
						FROM usuario
						WHERE usu_login = '".$_GET['login']."' ".$update;
				$result = $data->find('dynamic', $sql);		
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Este login já está cadastrado no sistema, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;

		// DIARIO ON-LINE
		case 'diario':	
			if($_GET['dia'] != 'undefined'){		
				// Quando for edição, verifica se é o mesmo código
				$update = '';
				if($_GET['turma']){
					$update .= ' AND tur_codigo = '.$_GET['turma'];
				}
				if($_GET['id']){
					$update .= ' AND dia_codigo <> '.$_GET['id'];
				}
					
				//						
				$_GET['dia'] = implode("-", array_reverse(explode("/", $_GET['dia'])));
				//
				$sql = "SELECT dia_codigo
						FROM sge_diario
						WHERE dia_data = '".$_GET['dia']."' ".$update;
				$result = $data->find('dynamic', $sql);
			}
			//	
			if(count($result) > 0){ // Cadastro já existente
				echo '
					<input type="hidden" id="val_existe" value="1" required />
					<div class="alert alert-danger" style="margin:0; margin-top:10px;">Já existe diario para esta data e turma, favor verificar!</div>';
			}else{
				echo '<input type="hidden" id="val_existe" value="0" required />';
			}
			break;	
	}	
?>
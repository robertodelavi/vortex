<?php
	require_once 'library/php-image-magician/php_image_magician.php';
	switch($_GET['acao']){
		case 'grava_usuario':
			//$array['usa_nome']    = mb_convert_case($_POST['usa_nome'], MB_CASE_TITLE, "UTF-8")
			$array['usu_nome']  = addslashes(mb_strtoupper($_POST['usu_nome'],'UTF-8'));
			$array['usu_login']	= addslashes(mb_strtolower($_POST['usu_login'],'UTF-8'));
			$array['usu_senha']	= addslashes($_POST['usu_senha']);
			$array['usu_email']	= addslashes(mb_strtolower($_POST['usu_email'],'UTF-8'));
			$array['upe_codigo']= $_POST['upe_codigo'];
			$array['usu_dado_bancario']	  = addslashes(mb_strtolower($_POST['usu_dado_bancario'],'UTF-8'));
			$array['usu_meta_prospeccao'] = addslashes(mb_strtolower($_POST['usu_meta_prospeccao'],'UTF-8'));
			$array['usu_meta_cotacao']	  = addslashes(mb_strtolower($_POST['usu_meta_cotacao'],'UTF-8'));
			
			// Inclui a imagem enviada no formulario
			if($_POST['imagemCortada']){
				$image = $utils->blobToImage($_POST['imagemCortada'], 'arquivos/usuarios/');
				/*$img_orig = $image;

				// *** Open JPG image
			  	$magicianObj = new imageLib($image);

			  	// *** Resize to best fit then crop
			  	$magicianObj -> setTransparency(false);
			  	$magicianObj -> resizeImage(500, 500, 'crop');

			  	// *** Save resized image as a JPG
			 	$magicianObj -> saveImage($image, 75);

			 	$image = substr($image, 0, (strlen($image)-4));
			  	$image = $image.'.jpg';*/

				$aux['usu_foto'] = $image;
				//unlink($img_orig);
			}

			unset($_POST['imagemCortada']);
			
			$data->tabela = 'usuario';
			$data->add($array);			
			
			echo '<script>window.location = "?module=usuario&acao=lista_usuario&ms=1";</script>';
		break;

		case 'update_usuario':
			$array['usu_codigo'] 	= $_POST['usu_codigo'];	
			$array['usu_nome']  	= addslashes(mb_strtoupper($_POST['usu_nome'],'UTF-8'));
			$array['usu_login']		= addslashes(mb_strtolower($_POST['usu_login'],'UTF-8'));
			$array['usu_senha']		= addslashes(mb_strtoupper($_POST['usu_senha'],'UTF-8'));
			$array['usu_email']		= addslashes(mb_strtolower($_POST['usu_email'],'UTF-8'));
			$array['upe_codigo']	= $_POST['upe_codigo'];
			$array['usu_dado_bancario']	  = addslashes(mb_strtolower($_POST['usu_dado_bancario'],'UTF-8'));
			$array['usu_meta_prospeccao'] = addslashes(mb_strtolower($_POST['usu_meta_prospeccao'],'UTF-8'));
			$array['usu_meta_cotacao']	  = addslashes(mb_strtolower($_POST['usu_meta_cotacao'],'UTF-8'));
			

			// Inclui a imagem enviada no formulario
			if($_POST['imagemCortada']){
				$image = $utils->blobToImage($_POST['imagemCortada'], 'arquivos/usuarios/');
				//$img_orig = $image;
				// *** Open JPG image
			  	/*$magicianObj = new imageLib($image);

			  	// *** Resize to best fit then crop
			  	$magicianObj -> setTransparency(false);
			  	$magicianObj -> resizeImage(500, 500, 'crop');

			  	// *** Save resized image as a JPG
			 	$magicianObj -> saveImage($image, 75);
				echo '-->'.$imgage.'<br />';
			 	$image = substr($image, 0, (strlen($image)-4));
			  	$image = $image.'.jpg';*/

				$array['usu_foto'] = $image;
				//unlink($img_orig);
			}

			if($_POST['imagemAnterior'] != '' && $_POST['imagemCortada']){
				unlink($_POST['imagemAnterior']);
			}

			unset($_POST['imagemCortada']);
			unset($_POST['imagemAnterior']);

			$data->tabela = 'usuario';
			$data->update($array);
			echo '<body onload="nextPage(\'?module=usuario&acao=visualiza_usuario&ms=1\', \''.$_POST['usu_codigo'].'\' )"></body>';
		break;
		
		case 'inativar_usuario':
			$sql = 'UPDATE usuario SET usu_situacao = 0 WHERE usu_codigo = '.$_POST['param_0'];
    		$data->executaSQL($sql);
			echo '<script>window.location = "?module=usuario&acao=lista_usuario&ms=4";</script>';	
		break;

		case 'ativar_usuario':
			$sql = 'UPDATE usuario SET usu_situacao = 1 WHERE usu_codigo = '.$_POST['param_0'];
    		$data->executaSQL($sql);
			echo '<script>window.location = "?module=usuario&acao=lista_usuario&ms=5";</script>';	
		break;
	}	
?>
<?php	
	ob_start();
	require_once('../../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../../library/DataManipulation.php'); 
	require_once("../../../../library/mpdf/mpdf.php"); 
	//
	$mpdf = new mPDF('c','A4',10,10,6,6,6);
	$data = new DataManipulation();
	//
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
	$data_extenso = strftime('%d de %B de %Y', strtotime(date('Y-m-d')));

	$aux['data_ini'] = implode("-", array_reverse(explode("/", $_POST['data_ini'])));
	$aux['data_fin'] = implode("-", array_reverse(explode("/", $_POST['data_fin'])));

	if($_POST['usuario']){
		$where = ' WHERE u.usu_codigo = '.$_POST['usuario'];
	}else{
		$where = '';
	}

	$sql = 'SELECT 
                u.usu_codigo,
                u.usu_nome,
                p.upe_descricao
            FROM 
                usuario AS u
                LEFT JOIN usuario_permissao AS p ON (u.upe_codigo = p.upe_codigo)
            '.$where.'    
            ORDER BY u.usu_nome ASC';
	$usuario = $data->find('dynamic', $sql);

	$html = 
	'
	<div style="font-family: Arial;" >
		<div style="text-align: center;">
			<img src="../../../images/logo_danca_reduzido.png" style="width: 100px; "/>
		</div>
		<div style="text-align: center;">
			<h3>ACESSOS AO SISTEMA: '.$_POST['data_ini'].' À '.$_POST['data_fin'].'</h3>
		</div>';		

		for($i=0; $i< count($usuario); $i++){	
			$sql = 'SELECT *
		            FROM 
		                usuario_acesso
		            WHERE 
		            	usu_codigo = '.$usuario[$i]['usu_codigo'].' AND
		            	uac_time BETWEEN "'.$aux['data_ini'].'" AND "'.$aux['data_fin'].'"
		            ORDER BY uac_time ASC';
			$acesso = $data->find('dynamic', $sql);

			$html .= '<h5>'.$usuario[$i]['usu_nome'].' ('.count($acesso).')</h5>';
			if($_POST['tipo'] == 0){ //DETALHADO
				$html .= '<table style="font-size:12px; width:100%; margin-bottom:5px; margin-top:5px; border-collapse: collapse;">';
				for ($j=0; $j < count($acesso); $j++) { 
					if($j%2 == 0)
						$cor_linha = "#e6e6e6;";
					else
						$cor_linha = "#ffffffff;";
					$aux2 = explode(' ',$acesso[$j]['uac_time']);
					$aux1 = implode("/", array_reverse(explode("-", $aux2[0])));
					$dt_acesso = $aux1.' '.$aux2[1];
					$html .= '
					<tr style="background-color:'.$cor_linha.' " >						
						<td>
							'.$dt_acesso.'
						</td>					
					</tr>';
				}	
				$html .= '</table>';
			}
		}
	$html .= '</div>';
	//
	ob_clean();
	$mpdf->ignore_invalid_utf8 = true;
	$mpdf->WriteHTML($html);	
	// Rodapé	
	$mpdf->SetFooter(array(
		'L' => array('content' => 'Página {PAGENO}',),
		'C' => array('content' => 'Azambuja',),
		'R' => array('content' => date("d/m/Y"),),
		'Line' => 1
	), 'O');
	$mpdf->Output();
	exit;
?>

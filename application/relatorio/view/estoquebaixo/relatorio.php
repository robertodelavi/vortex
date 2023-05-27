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

	$html = 
	'
	<div style="font-family: Arial;" >
		<div style="text-align: center;">
			<h3>RELATÓRIO ESTOQUE BAIXO</h3>
			<hr />
		</div>';
		
		// Busca os alunos desta escola
		$sql = "SELECT *
				FROM
					produto_estoque AS p
					JOIN categoria_produto_estoque AS ce ON (p.cpe_codigo = ce.cpe_codigo)
				WHERE
					p.pre_situacao = 1 AND
					p.pre_qtd <= p.pre_qtd_min
				ORDER BY p.pre_descricao ASC";
		$produtos = $data->find('dynamic', $sql);
		
		if(count($produtos) > 0){
			$html .= '
			<table style="font-size:16px; width:100%; margin-bottom:5px; margin-top:5px; border-collapse: collapse; font-size: 12px;">
				<tr >								
					<td>
						<b>PRODUTO</b>
					</td>
					<td>
						<b>MODELO</b>
					</td>			
					<td >
						<b>MARCA</b>
					</td>
					<td >
						<b>CATEGORIA</b>
					</td>
					<td >
						<b>QTD. EST.</b>
					</td>
				</tr>';
				// LISTA OS alunoS DA escola CORRENTE
				for($i=0; $i< count($produtos); $i++){	
					if($i%2 == 0)
						$cor_linha = "#e6e6e6;";
					else
						$cor_linha = "#ffffffff;";								
					
					$html .= 
					'<tr style="background-color:'.$cor_linha.' " >						
						<<td>
							'.$produtos[$i]['pre_descricao'].'
						</td>
						<td>
							'.$produtos[$i]['pre_modelo'].'
						</td>			
						<td >
							'.$produtos[$i]['pre_marca'].'
						</td>
						<td >
							'.$produtos[$i]['cpe_descricao'].'
						</td>
						<td >
							'.$produtos[$i]['pre_qtd'].'
						</td>
					</tr>';
				}	
			$html .= '</table>';		
		}
		
		$html .= '
		<br /><br />		
	</div>';
	//
	$mpdf->ignore_invalid_utf8 = true;
	ob_clean();//Limpa o buffer de saída
	$mpdf->WriteHTML($html);	
	// Rodapé	
	$mpdf->SetFooter(array(
							'L' => array(
									'content' => 'Página {PAGENO}', 
							),
							
							'C' => array(
									'content' => 'SGE',
							),
							'R' => array(
									'content' => date("d/m/Y"),
							),
							'Line' => 1
						
					), 'O');
	$mpdf->Output();
	exit;
?>

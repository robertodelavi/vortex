<?php	
	require_once('../../../library/MySql.php'); // Conecta ao BD
	require_once('../../../library/DataManipulation.php'); 
	//
	$data = new DataManipulation();
	//	
	if($_GET['uf'] != ''){
		$sql = "SELECT *
				FROM usuario_areaatuacao AS ua
					LEFT JOIN usuario AS u ON (ua.usu_codigo = u.usu_codigo)
				WHERE ua.uaa_estado = '".$_GET['uf']."'
				ORDER BY u.usu_nome ASC";
		$result = $data->find('dynamic', $sql);

		switch ($_GET['uf']) {
			case 'AC':
				$estado = 'ACRE';
				break;
			case 'AL':
				$estado = 'ALAGOAS';
				break;
			case 'AP':
				$estado = 'AMAPÁ';
				break;
			case 'AM':
				$estado = 'AMAZONAS';
				break;
			case 'BA':
				$estado = 'BAHIA';
				break;
			case 'CE':
				$estado = 'CEARÁ';
				break;
			case 'DF':
				$estado = 'DISTRITO FEDERAL';
				break;
			case 'ES':
				$estado = 'ESPIRITO SANTO';
				break;		
			case 'GO':
				$estado = 'GOIÁS';
				break;
			case 'MA':
				$estado = 'MARANHÃO';
				break;
			case 'MT':
				$estado = 'MATO GROSSO';
				break;
			case 'MS':
				$estado = 'MATO GROSSO DO SUL';
				break;
			case 'MG':
				$estado = 'MINAS GERAIS';
				break;	
			case 'PA':
				$estado = 'PARÁ';
				break;
			case 'PB':
				$estado = 'PARAÍBA';
				break;
			case 'PR':
				$estado = 'PARANÁ';
				break;
			case 'PE':
				$estado = 'PERNAMBUCO';
				break;
			case 'PI':
				$estado = 'PIAUÍ';
				break;	
			case 'RJ':
				$estado = 'RIO DE JANEIRO';
				break;
			case 'RN':
				$estado = 'RIO GRANDE DO NORTE';
				break;	
			case 'RS':
				$estado = 'RIO GRANDE DO SUL';
				break;
			case 'RO':
				$estado = 'RONDÔNIA';
				break;		
			case 'RR':
				$estado = 'RORAIMA';
				break;
			case 'SC':
				$estado = 'SANTA CATARINA';
				break;	
			case 'SP':
				$estado = 'SÃO PAULO';
				break;	
			case 'SE':
				$estado = 'SERGIPE';
				break;
			case 'TO':
				$estado = 'TOCANTINS';
				break;	
		}
		
		//
		if(count($result) > 0){
			echo '
			<div class="row form-group" style="text-align: center;">
				<div class="col-md-12">
					<h3 style="color:#19aa8d;"> -- '.$estado.' -- </h3>
				</div>
			</div>

			<div class="row form-group" style="margin:0;">
				<div class="col-md-4">
					<b>Nome</b>
				</div>
				<div class="col-md-4">
					<b>Telefone</b>
				</div>
				<div class="col-md-4">
					<b>Área de Atuação</b>
				</div>
			</div><hr style="margin:0; margin-bottom:10px;" />';

			for ($i=0; $i < count($result); $i++) { 
				echo '
				<div class="row form-group">
					<div class="col-md-4">
						'.$result[$i]['usu_nome'].'
					</div>
					<div class="col-md-4">
						'.$result[$i]['usu_telefone'].'
					</div>
					<div class="col-md-4">
						'.$result[$i]['uaa_area_atuacao'].'
					</div>
				</div>';
			}
		}else{
			echo '
			<div class="row form-group" >
				<div class="col-md-12" style="text-align:center;">
					<h3 style="color:#19aa8d;"> -- '.$estado.' -- </h3>
					<h3 style="margin:0;">Não tem representantes neste estado.</h3>
				</div>
			</div>';
		}
	}	
?>
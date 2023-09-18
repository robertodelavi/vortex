<?php
// Header default
session_start();
require_once('../../../../library/DataManipulation.php');
require_once('../../../script/php/functions.php');
$data = new DataManipulation();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $value = json_decode(file_get_contents('php://input'), true);
    if (isset($value['id']) && $value['id'] > 0 && isset($value['emp_codigo']) && $value['emp_codigo'] > 0) {

        $result = [];
        $sql = '
        SELECT 
            i.imo_codigo, 
            ti.tpi_descricao, 
            b.bai_descricao, 
            i.imo_detalhes,
            ft.imf_arquivo
        FROM imoveis AS i
            LEFT JOIN imovelfoto AS ft ON (i.imo_codigo = ft.imf_imovel AND ft.imf_principal = "s")
            LEFT JOIN tipoimovel AS ti ON (i.imo_tipoimovel = ti.tpi_codigo)
            LEFT JOIN bairros AS b ON (i.imo_bairro = b.bai_codigo)
        WHERE i.imo_codigo = ' . $value['id'];
        $result = $data->find('dynamic', $sql);

        $res = [];
        foreach ($result as $key => $resValue) {
            $res[$key]['emp'] = $value['emp_codigo'];
            $res[$key]['id'] = $value['id'];
            $res[$key]['titulo'] = $value['id'].' - '.mb_strtoupper($resValue['tpi_descricao']).' - '.mb_strtoupper($resValue['bai_descricao']);
            $res[$key]['desc'] = utf8_encode($resValue['imo_detalhes']);
            $res[$key]['img'] = $resValue['imf_arquivo'] ? $_SESSION['BASE_URL_IMAGENS'] . $resValue['imf_arquivo'] : null;            
        }

        // Retorna resposta
        echo json_encode($res[0]);
        exit;
    }
}
<?php
require_once('../../../library/MySql.php'); // Conecta ao BD
require_once('../../../library/DataManipulation.php'); 
//
$data = new DataManipulation();
$sql = "SELECT imo_codigo, imo_edificio FROM imoveis WHERE imo_edificio <> '' LIMIT 3";
$result = $data->find('dynamic', $sql);

$filteredData = [];
foreach($result as $key => $row){

    if($key < 3){
        $arrRow = [];
        array_push($arrRow, trim($row['imo_edificio']));
        array_push($arrRow, trim($row['imo_codigo'] + 60));
        array_push($arrRow, trim($row['imo_edificio']));
        array_push($arrRow, trim($row['imo_edificio']));
        array_push($arrRow, trim($row['imo_edificio']));
        array_push($arrRow, trim($row['imo_edificio']));
        array_push($arrRow, $row['imo_codigo']);
        //
        array_push($filteredData, $arrRow);
    }
}

// Retorna os dados filtrados em formato JSON
header('Content-Type: application/json');

echo json_encode($filteredData);
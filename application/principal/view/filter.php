<?php
session_start();
require_once '../../../library/MySql.php';
$bd = new MySql();
$bd->connOpen($_SESSION['database']);
//

// Recupera os valores do formulário
$formData = $_POST;
$values = json_decode($formData['values'], true);

// Exemplo: exibindo o valor do campo 'name'
$name = $values['name'];

$sql = "SELECT imo_codigo, imo_edificio FROM imoveis WHERE imo_edificio LIKE '%".$name."%' ";
$result = $bd->executeQuery($sql, false);

$filteredData = [];
if ($bd->countLines($result) > 0){
    for ($i=0; $i< $bd->countLines($result); $i++){
        $arrRow = [];
        array_push($arrRow, trim($bd->result($result, $i, 'imo_edificio')));
        array_push($arrRow, trim($bd->result($result, $i, 'imo_codigo') + 60));
        array_push($arrRow, 'Tozzo');
        array_push($arrRow, '2023-01-08');
        array_push($arrRow, 'r@gmail.com');
        array_push($arrRow, '3352-4671');
        array_push($arrRow, $bd->result($result, $i, 'imo_codigo'));
        //
        array_push($filteredData, $arrRow);
    }
}

// Retorna os dados filtrados em formato JSON
header('Content-Type: application/json');

echo json_encode($filteredData);
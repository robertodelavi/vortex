<?php
session_start();
require_once '../../../library/MySql.php';
$bd = new MySql();
$bd->connOpen($_SESSION['database_host'], $_SESSION['database'], $_SESSION['database_user'], $_SESSION['database_pass']);
//

// Recupera os valores do formulário
$formData = $_POST;
$values = json_decode($formData['values'], true);

// Exemplo: exibindo o valor do campo 'name'
$name = $values['name'];

$sql = "SELECT prw_codigo, prw_nome FROM pretendentes WHERE prw_nome LIKE '%".$name."%' LIMIT 100 ";
$result = $bd->executeQuery($sql, false);


$filteredData = [];
if ($bd->countLines($result) > 0){
    for ($i=0; $i< $bd->countLines($result); $i++){
        $arrRow = [];
        array_push($arrRow, trim($bd->result($result, $i, 'prw_nome')));
        array_push($arrRow, '<div class="h-2.5 rounded-full rounded-bl-full text-center text-white text-xs" style="width:40%; background-color: red; "></div>');
        array_push($arrRow, 'Tozzo');
        array_push($arrRow, '2023-01-08');
        array_push($arrRow, 'r@gmail.com');
        array_push($arrRow, '3352-4671');
        array_push($arrRow, $bd->result($result, $i, 'prw_codigo'));
        //
        array_push($filteredData, $arrRow);
    }
}

// Retorna os dados filtrados em formato JSON
header('Content-Type: application/json');

echo json_encode($filteredData);
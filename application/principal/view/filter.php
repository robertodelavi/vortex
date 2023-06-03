<?php
require_once('../../../library/MySql.php'); // Conecta ao BD
require_once('../../../library/DataManipulation.php'); 
//
$data = new DataManipulation();
$sql = "SELECT * FROM clientes LIMIT 30";
$result = $data->find('dynamic', $sql);

$filteredData = [];
foreach($result as $key => $row){

    if($key < 3){
        $arrRow = [];
        array_push($arrRow, trim($row['cli_nome']));
        array_push($arrRow, trim($row['usu_codigo'] + 60));
        array_push($arrRow, trim($row['cli_nome']));
        array_push($arrRow, trim($row['cli_nome']));
        array_push($arrRow, trim($row['cli_nome']));
        array_push($arrRow, trim($row['cli_nome']));
        array_push($arrRow, trim($row['cli_nome']));
        //
        array_push($filteredData, $arrRow);
    }
}

// $filteredData = array(
//     array(
//         'id' => 1,
//         'name' => 'John Doe',
//         'date' => '2023-05-01',
//         'sale' => '$100',
//         'status' => 'Complete'
//     ),
//     array(
//         'id' => 2,
//         'name' => 'Jane Smith',
//         'date' => '2023-05-02',
//         'sale' => '$200',
//         'status' => 'Pending'
//     ),
// );

// $name = $_POST['name']; // Exemplo de campo de filtro
// Realiza o filtro dos dados da tabela com base nos parâmetros
// Aqui você deve implementar a lógica de filtragem adequada para os seus dados
// Suponha que os dados filtrados sejam armazenados em $filteredData

// Retorna os dados filtrados em formato JSON
header('Content-Type: application/json');

echo json_encode($filteredData);
<?php

// Header default
session_start();
require_once('../../../../../../library/DataManipulation.php');
require_once('../../../../../script/php/functions.php');
$data = new DataManipulation();

// Handle the file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['filepond'];

    $values = $_POST;

    
    //? Save $file at folder uploads 
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];
    $file_ext = $file['ext'];

    // save on uploads folder
    $file_destination = 'uploads/' . $file_name;
    move_uploaded_file($file_tmp, $file_destination);

    //? Save database
    $data->tabela = 'imovelfoto';
    $foto = array(
        'imf_imovel' => 1,
        'imf_arquivo' => $file_destination,
        'imf_descricao' => 'teste betha 1.0',
        'imf_principal' => 's',
        'imf_ficha' => 's',
        'imf_web' => 's'
    );
    $data->add($foto);     

    // Send a response (e.g., JSON) back to the client to indicate success or failure
    $response = [
        'status' => 'success', // You can customize this based on your logic
        'message' => 'File uploaded successfully!!!!!!!!!!!!!!!!!', // Add a message if needed
        'files' => var_dump($_FILES),
        'received' => $_POST['filepond'],
        'database' => var_dump($foto), 
        'values' => var_dump($values)
    ];

    echo json_encode($response);
} else {
    // Invalid request
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
}


// // Handle the file upload
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
//     $uploadedFile = $_FILES['file'];

//     // Process the file and save it to the FTP server and database
//     // Implement your FTP and database logic here

// } else {
//     // Invalid request
//     http_response_code(400);
//     echo json_encode(['error' => 'Invalid request']);
// }

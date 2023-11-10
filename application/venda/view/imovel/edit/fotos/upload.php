<?php


// Handle the file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['filepond'];

    // $file = array(5) {
//     ["name"]=>
//     string(52) "thumb_small_ferias-na-praia-o-que-fazer-das-f163.jpg"
//     ["type"]=>
//     string(10) "image/jpeg"
//     ["tmp_name"]=>
//     string(24) "C:\xampp\tmp\php28A8.tmp"
//     ["error"]=>
//     int(0)
//     ["size"]=>
//     int(8205)
//   }

    // save $file at folder uploads 
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_type = $file['type'];
    $file_ext = $file['ext'];

    // save on uploads folder
    $file_destination = 'uploads/' . $file_name;
    move_uploaded_file($file_tmp, $file_destination);



    

    


    // Send a response (e.g., JSON) back to the client to indicate success or failure
    $response = [
        // 'status' => 'success', // You can customize this based on your logic
        // 'message' => 'File uploaded successfully!!!!!!!!!!!!!!!!!', // Add a message if needed
        'files' => var_dump($_FILES),
        'received' => $_POST['filepond'],
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

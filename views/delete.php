<?php
require_once('../models/Movies_model.php');

$response = [
    "success" => false,
    "message" => "Invalid request"
];


 if ( !filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' ) {
     respond($response);
     exit;
 }

$id = filter_input(INPUT_POST, 'id');

if (!$id) {
    respond($response);
    exit;
}

$movies = new Movies_model();
$result = $movies->delete($id);

if ($result) {
    $response["success"] = $result;
    $response["message"] = "Deleted movie successfully";
}

respond($response);

function respond($response) {
    echo json_encode($response);
    header("Content-type:application/json");
} 

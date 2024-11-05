<?php

header("Access-control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    http_response_code(404);
    echo "Not found";
    return;
}


include "../../config/database.php";
include "../../models/book.php";

//instantiate database
$database = new Database();
$db = $database->getConnection();


//instantiate book object
$book = new Book($db);


// get URL param
if (isset($_GET['bookid'])) {
    $book->bookid = $_GET['bookid'];

    $result = $book->delete();

    if ($result > 0) {
        http_response_code(200);
        echo json_encode(array("message" => $result . " record deleted"));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "No records deleted"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to delete, bookid is required"));
}

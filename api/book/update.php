<?php

header("Access-control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
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

$data = json_decode(file_get_contents("php://input"));

if (
    empty($data->bookid) ||
    empty($data->title) ||
    empty($data->author) ||
    empty($data->year_published) ||
    empty($data->publisher) ||
    empty($data->description) ||
    empty($data->category)
) {
    // bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to update, data is incomplete"));
    return;
}


$book->bookid = $data->bookid;
$book->title = $data->title;
$book->author = $data->author;
$book->year_published = $data->year_published;
$book->publisher = $data->publisher;
$book->description = $data->description;
$book->category = $data->category;


if($book->update() > 0) {
    http_response_code(200);
    echo json_encode(array("message" => "1 record updated"));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "No records updated"));
}
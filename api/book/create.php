<?php

header("Access-control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
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
    empty($data->title) ||
    empty($data->author) ||
    empty($data->year_published) ||
    empty($data->publisher) ||
    empty($data->description) ||
    empty($data->category)
) {
    // bad request
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create, data is incomplete"));
    return;
}

$book->title = $data->title;
$book->author = $data->author;
$book->year_published = $data->year_published;
$book->publisher = $data->publisher;
$book->description = $data->description;
$book->category = $data->category;

//check if book exists
if ($book->exists()) {
    http_response_code(409);
    echo json_encode(array("message" => "Book already exists"));
    return;
}

// create book
$isCreated = $book->create($book);

if ($isCreated) {
    // 201 - created
    http_response_code(201);
    echo json_encode(array("message" => "1 record added"));
} else {
    http_response_code(500);
}

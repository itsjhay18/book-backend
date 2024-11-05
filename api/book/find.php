<?php

header("Access-control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
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

// check if bookid is given
if (isset($_GET['bookid'])) {
    $book->bookid = $_GET['bookid'];

    $result = $book->findOne();

    $data = $result->get_result();

    if ($data->num_rows > 0) {
        $row = $data->fetch_assoc();
        echo json_encode(array("data" => $row));
    } else {
        echo json_encode(array("message"=> "No records found"));
    }

} else {
    $result = $book->findAll();

    $book_arr = array();
    $book_arr["data"] = array();
    while ($row = $result->fetch_assoc()) {
        array_push($book_arr["data"], $row);
    }

    //set http status code to - 200 ok  
    http_response_code(200);
    echo json_encode($book_arr);
}

<?php
class Book
{

    private $conn;
    private $table_name = "books";

    //object properties
    public $bookid;
    public $title;
    public $author;
    public $year_published;
    public $publisher;
    public $description;
    public $category;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findAll()
    {
        $query = "SELECT * FROM $this->table_name";

        //execute query
        $stmt = $this->conn->query($query);

        return $stmt;
    }

    public function findOne()
    {
        $query = "SELECT * FROM $this->table_name WHERE bookid=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->bookid);

        if ($stmt->execute()) {
            return $stmt;
        }
        return false;
    }

    public function create()
    {
        $query = "INSERT INTO $this->table_name (title, author, year_published, publisher, description, category, date_added)
        VALUES(?,?,?,?,?,?, NOW())";

        //prepare and bind
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssssss",
            $this->title,
            $this->author,
            $this->year_published,
            $this->publisher,
            $this->description,
            $this->category
        );

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update()
    {
        $query = "UPDATE $this->table_name SET title=?, author=?, year_published=?, publisher=?, description=?, category=? 
        WHERE bookid=?";

        //prepare and bind
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssssssi",
            $this->title,
            $this->author,
            $this->year_published,
            $this->publisher,
            $this->description,
            $this->category,
            $this->bookid
        );

        if ($stmt->execute()) {
            return $stmt->affected_rows;
        }
        return false;
    }



    public function delete()
    {
        $query = "DELETE FROM $this->table_name WHERE bookid=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->bookid);

        if ($stmt->execute()) {
            return $stmt->affected_rows;
        }
        return false;
    }


    public function exists()
    {
        $query = "SELECT COUNT(*) FROM $this->table_name WHERE title=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->title);

        $count = 0;

        if ($stmt->execute()) {
            $stmt->bind_result($count);
            $stmt->fetch();
            return $count;
        }
        return false;
    }
}

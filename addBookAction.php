<?php
session_start();
include "connection.php";

$book_tracking_number = trim($_POST['book_tracking_number']);
$book_title = trim($_POST['book_title']);
$book_author = trim($_POST['book_author']);
$book_publisher = trim($_POST['book_publisher']);
$book_isbn = trim($_POST['book_isbn']);
$category_id = trim($_POST['category']);

if(empty($book_tracking_number) || empty($book_title) || empty($book_author) || empty($book_publisher) || empty($book_isbn)){
    $_SESSION["error"] = "Error: All fields are required to fill";
    header("Location: addBook.php");
    exit();
}

$query = "SELECT COUNT(*) FROM tblBook WHERE book_tracking_number = :book_tracking_number";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ':book_tracking_number', $book_tracking_number);
oci_execute($stmt);
$count = oci_fetch_array($stmt, OCI_RETURN_NULLS)[0];
oci_free_statement($stmt);

if ($count > 0){
    $_SESSION["error"] = "Error: Book with book ID '{$book_tracking_number}' already exists!";
    header("Location: addBook.php");
    exit();
}

//$stmt = oci_parse($conn, "INSERT INTO tblBook (book_tracking_number, book_title, book_author, book_publisher, book_isbn, category_id) VALUES (:book_tracking_number, :book_title, :book_author, :book_publisher, :book_isbn, :category_id)");

$query = "INSERT INTO tblBook (book_tracking_number, book_title, book_author, book_publisher, book_isbn, category_id) VALUES (:book_tracking_number, :book_title, :book_author, :book_publisher, :book_isbn, :category_id)";
$stmt = oci_parse($conn, $query);


oci_bind_by_name($stmt,":book_tracking_number", $book_tracking_number);
oci_bind_by_name($stmt,":book_title", $book_title);
oci_bind_by_name($stmt,":book_author", $book_author);
oci_bind_by_name($stmt,":book_publisher", $book_publisher);
oci_bind_by_name($stmt,":book_isbn", $book_isbn);
oci_bind_by_name($stmt,":category_id", $category_id);

$result = oci_execute($stmt);

if($result){
    echo "Book added successfully!";
    header("Location: books.php");
}else{
    $e = oci_error($stmt);
    $error_message = "Error: " . htmlentities($e['message'], ENT_QUOTES);
    echo "<script>alert('$error_message'); window.location='addBook.php';</script>";

    $_SESSION["error"] = $error_message;
    header("Location: addBook.php");

    /*$error_message = "Error: ";
    $e = oci_error($stmt);
    
    if(strpos($e['message'], 'ORA-14400') !== false){
        $error_message .= "The value of book_tracking_number fell outside the specified range for any of the partitions.";
    }else{
        $error_message .= htmlentities($e['message'], ENT_QUOTES);*/

   
    /*$_SESSION["error"] = $error_message;
    header("Location: addBook.php");*/
}

oci_free_statement($stmt);
oci_close($conn);
?>
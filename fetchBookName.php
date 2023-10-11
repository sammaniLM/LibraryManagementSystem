<?php

include "connection.php";

//Display Book name when Type Book Tracking ID
$book_tracking_number = $_POST['book_tracking_number'];
$sql = "SELECT book_title FROM tblBook WHERE book_tracking_number = :book_tracking_number";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':book_tracking_number', $book_tracking_number);
oci_execute($stmt);

if ($row = oci_fetch_assoc($stmt)) {
    $book_title = $row['BOOK_TITLE'];
} else {
    $book_title = "Book not found";
}
oci_close($conn);
echo $book_title;

?>

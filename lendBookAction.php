<?php

include "connection.php";
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $loan_tracking_num = $_POST["loan_tracking_num"];
    $member_tracking_num = $_POST["member_tracking_num"];
    $book_tracking_number = $_POST["book_tracking_number"];
    $loan_date = $_POST["loan_date"];
    $return_date_expected = $_POST["return_date_expected"];

    // Validate form data
    if (empty($loan_tracking_num) || empty($member_tracking_num) || empty($book_tracking_number) || empty($loan_date) || empty($return_date_expected)) {
        $_SESSION["error"]="All fields are required. Please fill in all the fields.";
        header("Location: lendBook.php");
        exit();
    } else {

        // Check for duplicate loan_tracking_num
        $stmt = oci_parse($conn, "SELECT COUNT(*) FROM tblBookLoans WHERE loan_tracking_num = :loan_tracking_num");
        oci_bind_by_name($stmt, ":loan_tracking_num", $loan_tracking_num);
        oci_execute($stmt);
        $row = oci_fetch_array($stmt, OCI_ASSOC);
        $count = $row["COUNT(*)"];
        if ($count > 0) {
            $_SESSION["error"]="Book Lending ID already exists. Please choose a different Book Lending ID.";
            header("Location: lendBook.php");
            exit();
        } else {
            // Check if member has already borrowed 2 books
            $stmt = oci_parse($conn, "SELECT COUNT(*) FROM tblBookLoans WHERE member_tracking_num = :member_tracking_num AND return_date IS NULL");
            oci_bind_by_name($stmt, ":member_tracking_num", $member_tracking_num);
            oci_execute($stmt);
            $row = oci_fetch_array($stmt, OCI_ASSOC);
            $count = $row["COUNT(*)"];
            if ($count >= 2) {
                $_SESSION["error"]="Member has already borrowed 2 books. Cannot borrow more books.";
                header("Location: lendBook.php");
                exit();
            } else {

                $stmt = oci_parse($conn, "SELECT loan_id FROM tblBookLoans WHERE book_tracking_number = :book_tracking_number AND return_date IS NULL");
                //oci_bind_by_name($stmt, ":member_tracking_num", $member_tracking_num);
                oci_bind_by_name($stmt, ":book_tracking_number", $book_tracking_number);
                oci_execute($stmt);
                $row = oci_fetch_assoc($stmt);

                if ($row){
                    //$_SESSION["error"]="Member has already borrowed the same book without returning.";
                    $_SESSION["error"]="This book haven't returned to the Library by the borrowed user!";
                    header("Location: lendBook.php");
                    exit();
                }else{
                    // Insert into tblBookLoans
                    $stmt = oci_parse($conn, "INSERT INTO tblBookLoans (loan_tracking_num, member_tracking_num, book_tracking_number, loan_date, return_date_expected) VALUES (:loan_tracking_num, :member_tracking_num, :book_tracking_number, TO_DATE(:loan_date, 'YYYY-MM-DD'), TO_DATE(:return_date_expected, 'YYYY-MM-DD'))");
                    oci_bind_by_name($stmt, ":loan_tracking_num", $loan_tracking_num);
                    oci_bind_by_name($stmt, ":member_tracking_num", $member_tracking_num);
                    oci_bind_by_name($stmt, ":book_tracking_number", $book_tracking_number);
                    oci_bind_by_name($stmt, ":loan_date", $loan_date);
                    oci_bind_by_name($stmt, ":return_date_expected", $return_date_expected);
                    oci_execute($stmt);

                    // Check for successful insertion
                    if (oci_num_rows($stmt) > 0) {
                        echo "<script>alert('Book loaned successfully.'); window.location.href = 'lendBookList.php';</script>"; // Redirect to homepage
                    } else {
                        echo "<script>alert('Failed to loan book. Please try again later.');</script>";
                    }
                }
            }
        }
    }
} else {
    echo "<script>alert('Invalid request.');</script>";
}
?>

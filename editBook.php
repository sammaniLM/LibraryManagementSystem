<?php

//session_start();
include "connection.php";

include "inc/checkLogin.php";
check_login();

$title = "Edit Book";
include "inc/header.php";
include "inc/sidebar.php";

if (isset($_GET['edit_id'])) {
    $book_id = $_GET['edit_id'];
} else {
    echo "Book ID not specified.";
    exit;
}

//$query = "SELECT * FROM tblBook WHERE book_id = $book_id";
$query = "SELECT /*+ index(tblbook pk_book_id) full(tblbook) use_nl(tblbookcategory) */ *
          FROM tblBook tblbook
          JOIN tblbookcategory tblcat ON tblbook.category_id = tblcat.category_id
          WHERE book_id = :book_id";
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt, ':book_id', $book_id);

if (!oci_execute($stmt)) {
    echo "Failed to retrieve book information.";
    exit;
}

$row = oci_fetch_array($stmt, OCI_ASSOC);
if (!$row) {
    echo "Book not found.";
    exit;
}

$book_tracking_number = $row['BOOK_TRACKING_NUMBER'] ?? '';
$book_title = $row['BOOK_TITLE'] ?? '';
$book_author = $row['BOOK_AUTHOR'] ?? '';
$book_publisher = $row['BOOK_PUBLISHER'] ?? '';
$book_isbn = $row['BOOK_ISBN'] ?? '';
$category_id = $row['CATEGORY_ID'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $book_id = $_POST['book_id'];
    $book_tracking_number = $_POST['book_tracking_number'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $book_publisher = $_POST['book_publisher'];
    $book_isbn = $_POST['book_isbn'];
    $category_id = $_POST['category_id'];

    if(empty($book_tracking_number) || empty($book_title) || empty($book_author) || empty($book_publisher) || empty($book_isbn) || empty($category_id)){
        echo "<script>alert('Please fill out all required fields.');</script>";
    }else{
        $query = "UPDATE tblbook 
              SET book_title = :book_title,
                  book_author = :book_author,
                  book_publisher = :book_publisher,
                  book_isbn = :book_isbn,
                  category_id = :category_id";

        if (!empty($book_tracking_number)){
            $query .= ", book_tracking_number = :book_tracking_number";
        }

        $query .= " WHERE book_tracking_number = :book_tracking_number";

        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ':book_title', $book_title);
        oci_bind_by_name($stmt, ':book_author', $book_author);
        oci_bind_by_name($stmt, ':book_publisher', $book_publisher);
        oci_bind_by_name($stmt, ':book_isbn', $book_isbn);
        oci_bind_by_name($stmt, ':category_id', $category_id);
        oci_bind_by_name($stmt, ':book_tracking_number', $book_tracking_number);
        oci_bind_by_name($stmt, ':book_id', $book_id);

        if (oci_execute($stmt)) {
            header("Location: books.php");
            exit;
        } else {
            echo "Failed to update user information.";
            exit;
        }

    }
}
?>

<div id="main" style="margin-left: 25%">
    <div class="head">
        <?php
        $pageTitle = "Edit Book";
        include "inc/nav.php";
        ?>

        <form action="" method="post">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
            <div class="mb-3">
                <label class="form-label text-white">Book Number</label>
                <input type="text" class="form-control" id="book_tracking_number" name="book_tracking_number" value="<?php echo $book_tracking_number ?>" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo $book_title ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Author</label>
                <input type="text" class="form-control" id="book_author" name="book_author" value="<?php echo $book_author ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Publisher</label>
                <input type="text" class="form-control" id="book_publisher" name="book_publisher" value="<?php echo $book_publisher ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-white">ISBN</label>
                <input type="text" class="form-control" id="book_isbn" name="book_isbn" value="<?php echo $book_isbn ?>">
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Book Category</label>
                <select class="form-select" name="category_id">
                    <?php
                        /*$query = "SELECT category_id, category_name FROM tblBookCategory";
                        $stmt = oci_parse($conn, $query);
                        oci_execute($stmt);

                    while ($category = oci_fetch_array($stmt, OCI_ASSOC)){
                        $selected = ($category['CATEGORY_ID'] == $category_id) ? 'selected' : '';
                        echo "<option value='" . $category['CATEGORY_ID'] . "' " . $selected . ">" . $category['CATEGORY_NAME'] . "</option>";
                    }*/
                    $query = "SELECT /*+ index(tblbookcategory pk_book_category_id) */ category_id, category_name FROM tblBookCategory";
                    $stmt = oci_parse($conn, $query);
                    oci_execute($stmt);

                    while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
                        $selected = '';
                        if ($row['CATEGORY_ID'] === $category_id) {
                            $selected = 'selected';
                        }
                        echo "<option value='" . $row['CATEGORY_ID'] . "' " . $selected . ">" . $row['CATEGORY_NAME'] . "</option>";
                    }

                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="books.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>
    </div>
</div>
<?php
include "inc/footer.php";
?>

<?php
include "connection.php";

include "inc/checkLogin.php";
check_login();

/*Delete a Book*/
if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM tblBook WHERE Book_id = :id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);

    if(oci_num_rows($stmt) > 0){
        $message = "Book Deleted Successfully!";
    }else{
        $message = "Deletion is Unsuccessful!";
    }
}

$title = "All Books";
include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "All Books";
        include "inc/nav.php";
        ?>
        <a href="addBook.php" class="btn btn-primary">Add New Book</a>
        <input type="text" id="search-box-book" placeholder="Search By Name" style="float: right; height: 40px; width: 300px; border-radius: 10px">

        <?php if(isset($message)):?>
            <?php if($message == "Book Deleted Successfully!"): ?>
                <div class="alert alert-success mt-3" role="alert">
                    <?php echo $message; ?>
                </div>

            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <table class="mt-4" style="width: 100%">
            <tr>
                <th scope="col">Book Number</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Publisher</th>
                <th scope="col">ISBN</th>
                <th scope="col">Book Category</th>
                <!--<th scope="col">Added Date</th>-->
                <th scope="col">Action</th>
            </tr>
            <tbody>
            <?php
                $search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';
                $query = "SELECT b.book_id, b.book_tracking_number, b.book_title, b.book_author, 
                b.book_publisher, b.book_isbn, c.category_name
                FROM tblBook b
                INNER JOIN tblBookCategory c ON b.category_id = c.category_id
                WHERE b.book_title LIKE '%" . $search_term . "%'
                ORDER BY b.book_tracking_number DESC";

                $stmt = oci_parse($conn, $query);
                oci_execute($stmt);

                while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                    echo "<tr>";
                    echo "<td>" . $row['BOOK_TRACKING_NUMBER'] . "</td>";
                    echo "<td>" . $row['BOOK_TITLE'] . "</td>";
                    echo "<td>" . $row['BOOK_AUTHOR'] . "</td>";
                    echo "<td>" . $row['BOOK_PUBLISHER'] . "</td>";
                    echo "<td>" . $row['BOOK_ISBN'] . "</td>";
                    echo "<td>" . $row['CATEGORY_NAME'] . "</td>";
                    //echo "<td>" . $row['CREATED_AT'] . "</td>";
                    echo "<td>
                        <a href='editBook.php?edit_id=".$row['BOOK_ID']."' title='Edit Book'><i class='fa-solid fa-pen-to-square fa-lg' style='color: #00ffff';></i></a>
                        <a href='?delete_id=".$row['BOOK_ID']."' title='Delete Book' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-solid fa-trash fa-xl' style='color: #ff0000';></i></a>
                </td>";
                    echo "</tr>";
                }

            ?>
            </tbody>
        </table>

    </div>
</div>
<?php
include "inc/footer.php";
?>

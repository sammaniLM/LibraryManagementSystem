<?php
//session_start();

include "inc/checkLogin.php";
check_login();

include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loan_id = $_POST['loan_id'];
    $return_date = $_POST['return_date'];

    $query = "SELECT loan_id, loan_tracking_num, book_title, member_name, loan_date, return_date_expected FROM tblBookLoans 
              INNER JOIN tblBook ON tblBookLoans.book_tracking_number = tblBook.book_tracking_number
              INNER JOIN tblMember ON tblBookLoans.member_tracking_num = tblMember.member_tracking_num
              WHERE loan_id = :loan_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':loan_id', $loan_id);
    oci_execute($stmt);
    $loan = oci_fetch_assoc($stmt);

    $loan_date = new DateTime($loan['LOAN_DATE']);
    $return_date = new DateTime($return_date);

    /*$query = "SELECT SYSDATE FROM DUAL";
    $stmt = oci_parse($conn, $query);
    oci_execute($stmt);
    $sysdate = oci_fetch_assoc($stmt)['SYSDATE'];*/
    $return_date_expected = new DateTime($loan['RETURN_DATE_EXPECTED']);

    if ($return_date < $loan_date) {
        echo "<script>alert('Return date cannot be earlier than loan date.'); window.location.href = 'lendBookList.php';</script>";
    }/*elseif ($sysdate > $loan['RETURN_DATE_EXPECTED']){
        echo "<script>alert('You have overdue books. Please pay your fines to proceed.'); window.location.href = 'fineList.php';</script>";
    }*/elseif ($return_date > $return_date_expected){
        echo "<script>alert('Return date is overdue. Please pay the fine before returning the book.'); window.location.href = 'fineList.php';</script>";
        exit;
    } else {
        $return_date_str = $return_date->format('d-M-y');
        $query = "UPDATE tblBookLoans SET return_date = :return_date WHERE loan_id = :loan_id";
        $stmt = oci_parse($conn, $query);
        oci_bind_by_name($stmt, ':return_date', $return_date_str);
        oci_bind_by_name($stmt, ':loan_id', $loan_id);

        if (oci_execute($stmt)) {
            oci_commit($conn);
            header('Location: lendBookList.php');
            exit;
        } else {
            $e = oci_error($stmt); // print the error from the failed query
            echo '<script>alert("Error updating return date: ' . $e['message'] . '");</script>';
        }
    }
} else {
    $loan_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : '';

    $query = "SELECT loan_id, loan_tracking_num, book_title, member_name, loan_date, return_date_expected FROM tblBookLoans 
              INNER JOIN tblBook ON tblBookLoans.book_tracking_number = tblBook.book_tracking_number
              INNER JOIN tblMember ON tblBookLoans.member_tracking_num = tblMember.member_tracking_num
              WHERE loan_id = :loan_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':loan_id', $loan_id);
    oci_execute($stmt);
    $loan = oci_fetch_assoc($stmt);

    $loan_date = new DateTime($loan['LOAN_DATE']);

    $title = "Return Book";
    include "inc/header.php";
    include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "Return Book";
        include "inc/nav.php";
        ?>
    </div>

    <form action="" method="post">
        <input type="hidden" name="loan_id" id="loan_id" value="<?php echo $loan_id ?? ''; ?>">
        <div class="mb-3">
            <label for="loan_tracking_num" class="text-white">Loan Tracking Number</label>
            <input type="text" class="form-control" id="loan_tracking_num" name="loan_tracking_num" value="<?php echo $loan['LOAN_TRACKING_NUM']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="book_title" class="text-white">Book Title</label>
            <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo $loan['BOOK_TITLE']; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="member_name" class="text-white">Member Name</label>
            <input type="text" class="form-control" id="member_name" name="member_name" value="<?php echo $loan['MEMBER_NAME'] ?? ''; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="member_name" class="text-white">Loan Date</label>
            <input type="text" class="form-control" id="loan_date" name="loan_date" value="<?php echo $loan['LOAN_DATE'] ?? ''; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="return_date_expected" class="text-white">Return Date Expected</label>
            <input type="text" class="form-control" id="return_date_expected" name="return_date_expected" value="<?php echo $loan['RETURN_DATE_EXPECTED'] ?? ''; ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="member_name" class="text-white">Return Date</label>
            <input type="date" class="form-control" id="return_date" name="return_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="lendBookList.php" class="btn btn-light mr-2" style="float: right">Back</a>
    </form>
</div>
<?php
}
include "inc/footer.php";
?>

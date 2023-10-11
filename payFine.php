<?php
//session_start();
include "connection.php";

include "inc/checkLogin.php";
check_login();

if(isset($_POST['payment_tracking_num'])){
    $payment_tracking_num = $_POST['payment_tracking_num'];
    $loan_tracking_num = $_POST['loan_tracking_num'];
    $member_name = $_POST['member_name'];
    $book_title = $_POST['book_title'];
    $loan_date = $_POST['loan_date'];
    $return_date_expected = $_POST['return_date_expected'];

    $diff = abs(strtotime($loan_date) - strtotime($return_date_expected));
    $days_overdue = floor($diff / (60*60*24));
    $fine_amount = $days_overdue * 10;

    /*$query = "INSERT INTO Fine_Payments (payment_tracking_num, loan_tracking_num, payment_date, payment_amount)
              VALUES ('$payment_tracking_num', '$loan_tracking_num', SYSDATE, '$fine_amount')";*/

    $query = "INSERT INTO Fine_Payments (payment_tracking_num, loan_tracking_num, payment_date, payment_amount)
                  VALUES ('$payment_tracking_num', '$loan_tracking_num', SYSDATE, '{$_POST['total_fine']}')";

    $stmt = oci_parse($conn, $query);
    $success = oci_execute($stmt);

    if($success){
        // Remove record from fineList.php by updating return_date
        $update_query = "UPDATE tblBookLoans SET return_date = SYSDATE WHERE loan_tracking_num = '$loan_tracking_num'";
        $update_stmt = oci_parse($conn, $update_query);
        oci_execute($update_stmt);

        echo "<script>alert('Fine Paid Successfully!');</script>";
        echo "<script>window.location.href='fineList.php';</script>";
    } else {
        echo "<script>alert('An error occurred while processing your request.');</script>";
    }

    oci_close($conn);

}

$title = "Fine Payments";
include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "Pay Fine";
        include "inc/nav.php";
        ?>

        <form action="" method="post">
            <div class="form-group mb-3">
                <label for="payment_tracking_num" class="text-white">Payment ID</label>
                <input type="text" class="form-control" name="payment_tracking_num" id="payment_tracking_num">
            </div>
            <div class="form-group mb-3">
                <label for="loan_tracking_num" class="text-white">Book Lending ID</label>
                <input type="text" class="form-control" name="loan_tracking_num" id="loan_tracking_num" value="<?php echo $_GET['edit_id']; ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="member_name" class="text-white">Member Name</label>
                <input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo isset($_GET['member_name']) ? $_GET['member_name'] : ''; ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="book_title" class="text-white">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo isset($_GET['book_title']) ? $_GET['book_title'] : ''; ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="loan_date" class="text-white">Loan Date</label>
                <input type="text" class="form-control" id="loan_date" name="loan_date" value="<?php echo isset($_GET['loan_date']) ? $_GET['loan_date'] : ''; ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="return_date_expected" class="text-white">Expected Return Date</label>
                <input type="text" class="form-control" id="return_date_expected" name="return_date_expected" value="<?php echo isset($_GET['return_date_expected']) ? $_GET['return_date_expected'] : ''; ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="total_fine" class="text-white">Total Fine</label>
                <?php
                $return_date_expected = $_GET['return_date_expected'];
                $diff = strtotime(date("Y-m-d")) - strtotime($return_date_expected);
                $days_overdue = floor($diff / (60 * 60 * 24));
                $fine_amount = $days_overdue * 10;
                echo "<input type='text' class='form-control' id='total_fine' name='total_fine' value='$fine_amount' readonly>";
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Pay Fine</button>
            <a href="fineList.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>
    </div>
</div>
</div>

<?php include "inc/footer.php"; ?>
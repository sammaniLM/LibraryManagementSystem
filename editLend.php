<?php
//session_start();
include "connection.php";

include "inc/checkLogin.php";
check_login();

$title = "Extend Book Return Date";
include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main" style="margin-left: 25%">
    <div class="head">
        <?php
        $pageTitle = "Extend Book Return Date";
        include "inc/nav.php";
        ?>

        <form action="" method="post" onsubmit="return validateForm()">

            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $loan_id = $_POST["loan_id"];
                $return_date_expected = $_POST["return_date_expected"];

                $new_return_date_expected = date('Y-m-d', strtotime($return_date_expected . ' + 7 days'));

                $query = "UPDATE tblBookLoans SET return_date_expected = TO_DATE(:new_return_date_expected, 'YYYY-MM-DD') WHERE loan_id = :loan_id";
                $stmt = oci_parse($conn, $query);
                oci_bind_by_name($stmt, ':new_return_date_expected', $new_return_date_expected);
                oci_bind_by_name($stmt, ':loan_id', $loan_id);
                oci_execute($stmt);

                $_SESSION["success"] = "Return date expected has been extended successfully.";
                header("Location: lendBookList.php");
                exit;
            } else {
            $loan_id = $_GET["edit_id"];

            $query = "SELECT loan_id, loan_tracking_num, book_title, member_name, loan_date, return_date_expected FROM tblBookLoans 
                      INNER JOIN tblBook ON tblBookLoans.book_tracking_number = tblBook.book_tracking_number
                      INNER JOIN tblMember ON tblBookLoans.member_tracking_num = tblMember.member_tracking_num
                      WHERE loan_id = :loan_id";
            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ':loan_id', $loan_id);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            ?>


            <input type="hidden" name="loan_id" value="<?php echo $row['LOAN_ID']; ?>">
            <div class="mb-3">
                <label for="loan_tracking_num" class="text-white">Loan Tracking Number</label>
                <input type="text" class="form-control" id="loan_tracking_num" name="loan_tracking_num" value="<?php echo $row['LOAN_TRACKING_NUM']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="book_title" class="text-white">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo $row['BOOK_TITLE']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="member_name" class="text-white">Member Name</label>
                <input type="text" class="form-control" id="member_name" name="member_name" value="<?php echo $row['MEMBER_NAME']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="member_name" class="text-white">Loan Date</label>
                <input type="text" class="form-control" id="loan_date" name="loan_date" value="<?php echo $row['LOAN_DATE']; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="return_date_expected" class="text-white">Return Date Expected</label>
                <input type="date" class="form-control" id="return_date_expected" name="return_date_expected" value="<?php echo $row['RETURN_DATE_EXPECTED']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Extend Return Date</button>
            <a href="lendBookList.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>

    </div>
</div>

<?php
}
include "inc/footer.php";
?>

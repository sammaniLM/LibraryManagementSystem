<?php

//session_start();
include "connection.php";

include "inc/checkLogin.php";
check_login();

$title = "Overdue Book List";
include "inc/header.php";
include "inc/sidebar.php";
?>

    <div id="main">
        <div class="head">
            <?php
            $pageTitle = "Overdue Book List";
            include "inc/nav.php";
            ?>

            <input type="text" id="search-fine" placeholder="Search By Lending ID" style="float: right; height: 40px; width: 300px; border-radius: 10px" />
            <table class="mt-4" style="width: 100%">
                <tr>
                    <th scope="col">Book Lending ID</th>
                    <th scope="col">Book Title</th>
                    <th scope="col">Member Name</th>
                    <th scope="col">Loan Date</th>
                    <th scope="col">Expected Return Date</th>
                    <th scope="col">Action</th>
                </tr>
                <tbody>

                <?php
                    $query = "SELECT bl.loan_id, bl.loan_tracking_num, m.member_name, b.book_title, bl.loan_date, bl.return_date_expected
                            FROM tblBookLoans bl
                            JOIN tblMember m ON bl.member_tracking_num = m.member_tracking_num
                            JOIN tblBook b ON bl.book_tracking_number = b.book_tracking_number
                            WHERE bl.return_date IS NULL
                            AND bl.return_date_expected < SYSDATE";

                    $stmt = oci_parse($conn, $query);
                    oci_execute($stmt);

                    while ($row = oci_fetch_assoc($stmt)){
                        echo "<tr>";
                        //echo "<td>" . $row['LOAN_ID'] . "</td>";
                        echo "<td>" . $row['LOAN_TRACKING_NUM'] . "</td>";
                        echo "<td>" . $row['BOOK_TITLE'] . "</td>";
                        echo "<td>" . $row['MEMBER_NAME'] . "</td>";
                        echo "<td>" . $row['LOAN_DATE'] . "</td>";
                        echo "<td>" . $row['RETURN_DATE_EXPECTED'] . "</td>";
                        echo "<td>
                        <a href='payFine.php?edit_id=" . $row['LOAN_TRACKING_NUM'] . "&member_name=" . $row['MEMBER_NAME'] . "&book_title=" . $row['BOOK_TITLE'] . "&loan_date=" . $row['LOAN_DATE'] . "&return_date_expected=" . $row['RETURN_DATE_EXPECTED'] . "' title='Pay Fine'><i class='fa-solid fa-money-bill-transfer fa-lg' style='color: #ff0000;'></i></a>
                        </td>";
                        echo "</tr>";
                    }
                    oci_close($conn);
                ?>
                </tbody>
            </table>

        </div>
    </div>
<?php
include "inc/footer.php";
?>
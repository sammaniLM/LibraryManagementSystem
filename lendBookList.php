<?php

include "connection.php";

include "inc/checkLogin.php";
check_login();

$title = "Lended Books";
include "inc/header.php";
include "inc/sidebar.php";
?>

    <div id="main">
        <div class="head">
            <?php
            $pageTitle = "Lend Books List";
            include "inc/nav.php";
            ?>
            <a href="lendBook.php" class="btn btn-primary">Lend Books</a>
            <input type="text" id="search-lend" placeholder="Search By Lending ID" style="float: right; height: 40px; width: 300px; border-radius: 10px" />
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

                $search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';

                $query = "SELECT loan_id, loan_tracking_num, book_title, member_name, loan_date, return_date_expected FROM tblBookLoans 
                  INNER JOIN tblBook ON tblBookLoans.book_tracking_number = tblBook.book_tracking_number
                  INNER JOIN tblMember ON tblBookLoans.member_tracking_num = tblMember.member_tracking_num
                  WHERE return_date IS NULL
                  ORDER BY loan_tracking_num DESC";
                $stmt = oci_parse($conn, $query);
                oci_execute($stmt);

                while ($row = oci_fetch_assoc($stmt)) {
                    echo "<tr>";
                    //echo "<td>" . $row['LOAN_ID'] . "</td>";
                    echo "<td>" . $row['LOAN_TRACKING_NUM'] . "</td>";
                    echo "<td>" . $row['BOOK_TITLE'] . "</td>";
                    echo "<td>" . $row['MEMBER_NAME'] . "</td>";
                    echo "<td>" . $row['LOAN_DATE'] . "</td>";
                    echo "<td>" . $row['RETURN_DATE_EXPECTED'] . "</td>";
                    echo "<td>
                        <a href='editLend.php?edit_id=" . $row['LOAN_ID'] . "' title='Extend Returning Date'><i class='fa-solid fa-pen-to-square fa-lg' style='color: #00ffff;'></i></a>
                        <a href='returnBook.php?edit_id=" . $row['LOAN_ID'] . "' title='Return Book'><i class='fa-solid fa-arrow-left fa-lg' style='color: #ff0000;'></i></a>
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
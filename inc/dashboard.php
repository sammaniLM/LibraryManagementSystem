<?php
include "connection.php";
/*Member Count*/
$sql = "SELECT COUNT(*) AS total_members FROM tblMember";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);
$totalMembers = $row['TOTAL_MEMBERS'];

$members = '<div class="col-div-3">
                <div class="box">
                    <p>'.$totalMembers.'<br /> <span>Members</span></p>
                    <i class="fa fa-users box-icon"></i>
                </div>
            </div>';

echo $members;

/*books*/

$sql = "SELECT COUNT(*) AS total_books FROM tblBook";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
$row = oci_fetch_assoc($stmt);
$totalBooks = $row['TOTAL_BOOKS'];

$books = '<div class="col-div-3">
                <div class="box">
                    <p>'.$totalBooks.'<br /> <span>Books</span></p>
                    <i class="fa fa-book box-icon"></i>
                </div>
            </div>';

echo $books;
?>


<?php
$sql = "SELECT COUNT(*) AS loanCount FROM LMS.TBLBOOKLOANS WHERE RETURN_DATE IS NULL";

$result = oci_parse($conn, $sql);
oci_execute($result);

$row = oci_fetch_assoc($result);
$loanCount = $row['LOANCOUNT'];

oci_close($conn);

?>
<div class="col-div-3">
    <div class="box">
        <p><?php echo $loanCount; ?><br /> <span>Lended Books</span></p>
        <i class="fa-solid fa-arrow-right box-icon"></i>
    </div>
</div>

<?php
$currentDate = date('Y-m-d');

$sql = "SELECT COUNT(*) AS overdueCount FROM LMS.TBLBOOKLOANS WHERE RETURN_DATE IS NULL AND RETURN_DATE_EXPECTED < TO_DATE(:currentDate, 'YYYY-MM-DD')";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':currentDate', $currentDate);

oci_execute($stid);

$row = oci_fetch_assoc($stid);
$overdueCount = $row['OVERDUECOUNT'];

oci_close($conn);
?>

<div class="col-div-3">
    <div class="box">
        <p><?php echo $overdueCount; ?><br /> <span>Overdue Books</span></p>
        <i class="fa-solid fa-money-check-dollar box-icon"></i>
    </div>
</div>
<div class="clearfix"></div>
<br /> <br />
<div class="col-div-8"></div>
<div class="box-8">
    <div class="content-box">
        <p>Latest Book Additions <span><a href="books.php" class="btn btn-primary">View All</a></span></p>
        <br />
        <?php
            $sql = "SELECT book_title, book_author, created_at
        FROM tblBook
        ORDER BY created_at DESC
        FETCH FIRST 5 ROWS ONLY";

        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        $html = '<table style="width: 100%">
            <tr>
                <th>Book Title</th>
                <th>Book Author</th>
                <th>Created At</th>
            </tr>';

        while ($row = oci_fetch_assoc($stmt)) {
            $html .= '<tr>
                <td>' . $row['BOOK_TITLE'] . '</td>
                <td>' . $row['BOOK_AUTHOR'] . '</td>
                <td>' . $row['CREATED_AT'] . '</td>
              </tr>';
        }
        oci_close($conn);
        $html .= '</table>';
        echo $html;
        ?>
    </div>
</div>
<div class="clearfix"></div>
<?php

include "connection.php";

include "inc/checkLogin.php";
check_login();

if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM tblMember WHERE member_id = :id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':id', $id);
    oci_execute($stmt);

    if(oci_num_rows($stmt) > 0){
        $message = "Member Deleted Successfully!";
    }else{
        $message = "Deletion is Unsuccessful!";
    }
}

$title = "All Members";
include "inc/header.php";
include "inc/sidebar.php";
?>

    <div id="main">
        <div class="head">
            <?php
            $pageTitle = "All Members";
            include "inc/nav.php";
            ?>
            <a href="addMember.php" class="btn btn-primary">Add Member</a>
            <input type="text" id="search-box" placeholder="Search By Member ID" style="float: right; height: 40px; width: 300px; border-radius: 10px" />

            <?php if(isset($message)):?>
                <?php if($message == "Member Deleted Successfully!"): ?>
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
                    <th scope="col">Member ID</th>
                    <th scope="col">Member Name</th>
                    <th scope="col">Faculty Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile Number</th>
                    <!--<th scope="col">Registered Date</th>-->
                    <th scope="col">Action</th>
                </tr>
                <tbody>

                <?php

                $search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';

                $query = "SELECT m.member_id, m.member_tracking_num, m.member_name, f.faculty_name,
                m.member_email, m.member_phone
                FROM tblMember m
                INNER JOIN tblFaculty f ON m.faculty_id = f.faculty_id
                WHERE m.member_name LIKE '%" . $search_term . "%'
                ORDER BY m.member_tracking_num DESC";
                $stmt = oci_parse($conn, $query);
                oci_execute($stmt);

                while ($row = oci_fetch_assoc($stmt)) {
                    echo "<tr>";
                    echo "<td>" . $row['MEMBER_TRACKING_NUM'] . "</td>";
                    echo "<td>" . $row['MEMBER_NAME'] . "</td>";
                    echo "<td>" . $row['FACULTY_NAME'] . "</td>";
                    echo "<td>" . $row['MEMBER_EMAIL'] . "</td>";
                    echo "<td>" . $row['MEMBER_PHONE'] . "</td>";
                    //echo "<td>" . $row['CREATED_AT'] . "</td>";
                    echo "<td>
                    <a href='editMember.php?edit_id=".$row['MEMBER_ID']."' title='Edit Member'><i class='fa-solid fa-pen-to-square fa-lg' style='color: #00ffff';></i></a>
                        <a href='?delete_id=".$row['MEMBER_ID']."' title='Delete Member' onclick='return confirm(\"Are you sure you want to delete this record?\");'><i class='fa-solid fa-trash fa-xl' style='color: #ff0000';></i></a>
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

<?php
//session_start();
include "connection.php";

include "inc/checkLogin.php";
check_login();

$title = "Edit Member";
include "inc/header.php";
include "inc/sidebar.php";

if (isset($_GET['edit_id'])) {
    $member_id = $_GET['edit_id'];
} else {
    echo "Member ID not specified.";
    exit;
}

/*$query = "SELECT * FROM tblMember WHERE member_id = $member_id";
$stmt = oci_parse($conn, $query);
if (!oci_execute($stmt)) {
    echo "Failed to retrieve member information.";
    exit;
}*/

$query = "SELECT /*+ index(tblmember pk_tblmember) */ *
          FROM tblMember tblmember
          WHERE member_id = :member_id";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ':member_id', $member_id);
if (!oci_execute($stmt)) {
    echo "Failed to retrieve member information.";
    exit;
}

$row = oci_fetch_array($stmt, OCI_ASSOC);
if (!$row) {
    echo "Member not found.";
    exit;
}

$member_tracking_num = $row['MEMBER_TRACKING_NUM'] ?? '';
$member_name = $row['MEMBER_NAME'] ?? '';
$faculty_id = $row['FACULTY_ID'] ?? '';
$member_email = $row['MEMBER_EMAIL'] ?? '';
$member_phone = $row['MEMBER_PHONE'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $member_tracking_num = $_POST['member_tracking_num'];
    $member_name = $_POST['member_name'];
    $faculty_id = $_POST['faculty_id'];
    $member_email = $_POST['member_email'];
    $member_phone = $_POST['member_phone'];

    if (empty($member_tracking_num) || empty($member_name) || empty($faculty_id) || empty($member_email) || empty($member_phone)) {
        echo "<script>alert('Please fill out all required fields.');</script>";
    } else {
        if (!filter_var($member_email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.');</script>";
        }elseif (!preg_match('/^[0-9]{10}$/', $member_phone)){
            echo "<script>alert('Invalid mobile number format! Please enter a 10-digit number.');</script>";
        } else {
                $query = "UPDATE tblMember 
                      SET member_name = '$member_name',
                          faculty_id = '$faculty_id',
                          member_email = '$member_email',
                          member_phone = '$member_phone'";

                if(!empty($member_tracking_num)){
                    $query .= ", member_tracking_num = '$member_tracking_num'";
                }
                $query .= " WHERE member_id = $member_id";

                $stmt = oci_parse($conn, $query);
                if (oci_execute($stmt)) {
                    header("Location: members.php");
                    exit;
                } else {
                    echo "Failed to update user information.";
                    exit;
                }
            }
    }
}

?>

<div class="main">
    <div class="head" style="margin-left: 25%">
        <?php
        $pageTitle = "Edit Member";
        include "inc/nav.php";
        ?>
        <form action="" method="post">
            <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">

            <div class="mb-3">
                <label class="form-label text-white">Membership Number</label>
                <input type="text" class="form-control" name="member_tracking_num" value="<?php echo $member_tracking_num; ?>" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Name</label>
                <input type="text" class="form-control" name="member_name" value="<?php echo $member_name; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Faculty</label>
                <select name="faculty_id" class="form-select">
                    <?php
                    $query = "SELECT faculty_id, faculty_name FROM tblFaculty";
                    $stmt = oci_parse($conn, $query);
                    oci_execute($stmt);

                    while ($faculty = oci_fetch_array($stmt, OCI_ASSOC)){
                        $selected = ($faculty['FACULTY_ID'] == $faculty_id) ? 'selected' : '';
                        echo "<option value='" . $faculty['FACULTY_ID'] . "' " . $selected . ">" . $faculty['FACULTY_NAME'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label text-white">Email</label>
                <input type="text" class="form-control" name="member_email" value="<?php echo $member_email; ?>">
            </div>

            <div class="mb-3 ml-5">
                <label class="form-label text-white">Mobile Number</label>
                <input type="text" class="form-control" name="member_phone" pattern="[0-9]{10}" value="<?php echo $member_phone; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="members.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>
    </div>
</div>

<?php
include "inc/footer.php";
?>

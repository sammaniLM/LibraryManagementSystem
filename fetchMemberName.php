<?php

include "connection.php";

// Fetch member name based on member tracking number
$member_tracking_number = $_POST['member_tracking_num'];
$sql = "SELECT member_name FROM tblMember WHERE member_tracking_num = :member_tracking_number";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':member_tracking_number', $member_tracking_number);
oci_execute($stmt);

if ($row = oci_fetch_assoc($stmt)) {
    $member_name = $row['MEMBER_NAME'];
} else {
    $member_name = "Member not found";
}
oci_close($conn);
echo $member_name;

?>

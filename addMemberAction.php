<?php
session_start();

include "connection.php";

$member_tracking_num = trim($_POST['student_membership_id']);
$member_name = trim($_POST['student_name']);
$faculty_id = $_POST['faculty'];
$member_email = trim($_POST['student_email']);
$member_phone = trim($_POST['student_phone']);

//Empty check
if(empty($member_tracking_num) || empty($member_name) || empty($member_email) || empty($member_phone)){
    $_SESSION["error"] = "All fields are required to fill";
    header("Location: addMember.php");
    exit();
}

//Email Format
if (!filter_var($member_email, FILTER_VALIDATE_EMAIL)){
    $_SESSION["error"] = "Invalid Email Format!";
    header("Location: addMember.php");
    exit();
}

//Mobile Number Character count
if (!preg_match('/^[0-9]{10}$/', $member_phone)){
    $_SESSION["error"] = "Error: Invalid mobile number format! Please enter a 10-digit number.";
    header("Location: addMember.php");
    exit;
}

/*Unique ID check*/
$query = "SELECT COUNT(*) FROM tblmember WHERE member_tracking_num = :member_tracking_num";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ':member_tracking_num', $member_tracking_num);
oci_execute($stmt);
$count = oci_fetch_array($stmt, OCI_RETURN_NULLS)[0];
oci_free_statement($stmt);

if ($count > 0){
    $_SESSION["error"] = "Error: Member with membership ID '{$member_tracking_num}' already exists!";
    header("Location: addMember.php");
    exit;
}

$stmt = oci_parse($conn, "INSERT INTO tblmember (member_tracking_num, member_name, faculty_id, member_email, member_phone) VALUES (:member_tracking_num, :member_name, :faculty_id, :member_email, :member_phone)");

oci_bind_by_name($stmt, ":member_tracking_num", $member_tracking_num);
oci_bind_by_name($stmt, ":member_name", $member_name);
oci_bind_by_name($stmt, ":faculty_id", $faculty_id);
oci_bind_by_name($stmt, ":member_email", $member_email);
oci_bind_by_name($stmt, ":member_phone", $member_phone);

$result = oci_execute($stmt);

if ($result) {
    echo "Member added successfully!";
    header("Location:members.php");
} else {
    $e = oci_error($stmt);
    $error_message = "Error: " . htmlentities($e['message'], ENT_QUOTES);
    echo "<script>alert('$error_message'); window.location='addMember.php';</script>";
}

oci_free_statement($stmt);
oci_close($conn);

?>
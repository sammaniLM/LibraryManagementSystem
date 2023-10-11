<?php
$host = 'localhost';
$port = '1521';
$sid = 'orcl';
$username = 'lms';
$password = 'new_password';

$conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))");

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
} /*else {
    echo "Connected to Oracle database successfully!";
}*/

oci_close($conn);
?>

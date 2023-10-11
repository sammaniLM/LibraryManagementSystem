<?php
session_start();

function check_login() {
    if (!isset($_SESSION['UserID'])) {
        header('Location: login.php');
        exit;
    }
}
?>
<?php
session_start();
include "connection.php";

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT Users.UserID, Users.Username, Users.Password, Roles.RoleName, Roles.RoleID 
              FROM Users 
              INNER JOIN UserRole ON Users.UserID = UserRole.UserID 
              INNER JOIN Roles ON UserRole.RoleID = Roles.RoleID 
              WHERE Username=:username";

    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":username", $username);

    if(oci_execute($stmt)) {
        $row = oci_fetch_array($stmt, OCI_ASSOC);

        if($row) {
            if($password == $row['PASSWORD']) {
                $_SESSION['UserID'] = $row['USERID'];
                $_SESSION['Username'] = $row['USERNAME'];
                $_SESSION['RoleName'] = $row['ROLENAME'];
                $_SESSION['RoleID'] = $row['ROLEID'];
                header('Location: ./');
                exit;
            } else {
                echo '<script>alert("Invalid username or password.");</script>';
            }
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    } else {
        $error = oci_error($stmt);
        echo "Error: " . $error['message'];
    }

    oci_free_statement($stmt);
    oci_close($conn);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/loginStyle.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.png">
    <title>Login | Library Management System</title>
</head>
<body>
<div class="box">
    <div class="container">
        <div class="top-header">
            <header>Login</header>
        </div>
        <form action="" method="post">
        <div class="input-field">
            <input type="text" class="input" placeholder="Username" name="username" id="username" required>
            <i class="fa-solid fa-user fa-lg" style="color: #ffffff;"></i>
        </div>
        <div class="input-field">
            <input type="password" class="input" placeholder="Password" name="password" id="password" required>
            <i class="fa-solid fa-lock fa-lg" style="color: #ffffff;"></i>
        </div>
        <div class="input-field">
            <input type="submit" class="submit" value="Login">
        </div>
        </form>
    </div>
</div>

<?php
    include "inc/footer.php";
?>
</body>
</html>


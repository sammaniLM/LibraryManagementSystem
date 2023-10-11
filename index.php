<?php
$title = "Dashboard";

include "inc/checkLogin.php";
check_login();

include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "Dashboard";
        include "inc/nav.php";
        include "inc/dashboard.php";
        ?>
    </div>
</div>
<?php
include "inc/footer.php";
?>
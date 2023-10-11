<div class="col-div-6">
    <span style="font-size: 30px; cursor: pointer; color: white" class="nav"><?php echo $pageTitle ?></span>
</div>
<div class="col-div-6">
    <div class="profile">
        <?php
        include "connection.php";

        // Check if the user is logged in and their UserID is in the session
        if (isset($_SESSION['UserID'])) {
            $userID = $_SESSION['UserID'];

            // Query to get user details and role
            $query = "SELECT Users.FirstName, Users.LastName, Roles.RoleName FROM Users
                      INNER JOIN UserRole ON Users.UserID = UserRole.UserID
                      INNER JOIN Roles ON UserRole.RoleID = Roles.RoleID
                      WHERE Users.UserID = :userID";

            $stmt = oci_parse($conn, $query);
            oci_bind_by_name($stmt, ":userID", $userID);

            if (oci_execute($stmt)) {
                $row = oci_fetch_array($stmt, OCI_ASSOC);

                if ($row) {
                    $fullName = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
                    $roleName = $row['ROLENAME'];

                    echo "<p>$fullName <span>$roleName</span></p>";
                }
            }

            oci_free_statement($stmt);
        }
        oci_close($conn);
        ?>
    </div>
</div>
<div class="clearfix"></div>
<br />

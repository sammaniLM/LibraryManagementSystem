<?php
//session_start();

include "inc/checkLogin.php";
check_login();

$title = "Add Members";
include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "Add New Member";
        include "inc/nav.php";
        ?>

        <form action="addMemberAction.php" method="post">
            <div class="mb-3">
                <label class="form-label text-white">Membership Number</label>
                <input type="text" class="form-control" id="student_membership_id" name="student_membership_id">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Faculty</label>
                <select class="form-select" name="faculty">
                    <option value="1">Faculty of Arts</option>
                    <option value="2">Faculty of Education</option>
                    <option value="3">Faculty of Graduate Studies</option>
                    <option value="4">Faculty of Indigenous Medicine</option>
                    <option value="5">Faculty of Law</option>
                    <option value="6">Faculty of Management and Finance</option>
                    <option value="7">Faculty of Medicine</option>
                    <option value="8">Faculty of Science</option>
                    <option value="9">Faculty of Technology</option>
                    <option value="10">Faculty of Nursing</option>
                    <option value="11">Faculty of Computing</option>
                    <option value="12">Faculty of Applied Sciences</option>
                    <option value="13">Faculty of Urban and Aquatic Bioresources</option>
                    <option value="14">Faculty of Engineering</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Email</label>
                <input type="text" class="form-control" id="student_email " name="student_email">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Mobile Number</label>
                <input type="text" class="form-control" id="student_phone " name="student_phone" pattern="[0-9]{10}">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="members.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>
    </div>
</div>

<?php
include "inc/footer.php";
?>


<?php
include "connection.php";
//session_start();

include "inc/checkLogin.php";
check_login();

$title = "Lending Books";
include "inc/header.php";
include "inc/sidebar.php";

?>

    <div id="main">
        <div class="head">
            <?php
            $pageTitle = "Lending Books";
            include "inc/nav.php";
            ?>

            <form action="lendBookAction.php" method="post">
                <div class="row">
                    <div class="mb-3">
                        <label class="form-label text-white">Book Lending ID</label>
                        <input type="text" class="form-control" id="loan_tracking_num" name="loan_tracking_num">
                        <?php if (isset($_SESSION["error"])){ ?>
                            <script>
                                alert("<?php echo $_SESSION["error"]; ?>");
                            </script>
                            <?php unset($_SESSION["error"]); ?>
                        <?php } ?>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="member_tracking_num" class="text-white">Membership Number</label>
                            <input type="text" class="form-control" id="member_tracking_num" name="member_tracking_num" onblur="fetchMemberName()">
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="book_tracking_number" class="text-white">Book Number</label>
                            <input type="text" class="form-control" id="book_tracking_number" name="book_tracking_number" onblur="fetchBookTitle()">
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="loan_date" class="text-white">Book Lending Date</label>
                            <input type="date" class="form-control" id="loan_date" name="loan_date">
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="member_name" class="text-white">Member Name</label>
                            <input type="text" class="form-control" id="member_name" name="member_name" readonly>
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="book_title" class="text-white">Book Title</label>
                            <input type="text" class="form-control" id="book_title" name="book_title" readonly>
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="return_date" class="text-white">Expected Return Date</label>
                            <input type="date" class="form-control" id="return_date_expected" name="return_date_expected" readonly>
                            <?php if (isset($_SESSION["error"])){ ?>
                                <script>
                                    alert("<?php echo $_SESSION["error"]; ?>");
                                </script>
                                <?php unset($_SESSION["error"]); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="lendBookList.php" class="btn btn-light mr-2" style="float: right">Back</a>
            </form>

        </div>
    </div>
<?php
include "inc/footer.php";
?>
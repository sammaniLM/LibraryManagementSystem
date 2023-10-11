<?php
//session_start();
$title = "Add Book";

include "inc/checkLogin.php";
check_login();
include "inc/header.php";
include "inc/sidebar.php";
?>

<div id="main">
    <div class="head">
        <?php
        $pageTitle = "Add New Book";
        include "inc/nav.php";
        ?>

        <form action="addBookAction.php" method="post">
            <div class="mb-3">
                <label class="form-label text-white">Book Number</label>
                <input type="text" class="form-control" id="book_tracking_number" name="book_tracking_number">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Author</label>
                <input type="text" class="form-control" id="book_author" name="book_author">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Publisher</label>
                <input type="text" class="form-control" id="book_publisher" name="book_publisher">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">ISBN</label>
                <input type="text" class="form-control" id="book_isbn" name="book_isbn">
                <?php if (isset($_SESSION["error"])){ ?>
                    <script>
                        alert("<?php echo $_SESSION["error"]; ?>");
                    </script>
                    <?php unset($_SESSION["error"]); ?>
                <?php } ?>
            </div>
            <div class="mb-3">
                <label class="form-label text-white">Book Category</label>
                <select class="form-select" name="category">
                    <option value="1">Fictions</option>
                    <option value="2">Mathematics</option>
                    <option value="3">Mechanical Engineering</option>
                    <option value="4">Environmental Science</option>
                    <option value="5">Architecture</option>
                    <option value="6">Biography</option>
                    <option value="7">Languages</option>
                    <option value="8">Educational</option>
                    <option value="9">Management</option>
                    <option value="10">History</option>
                    <option value="11">Motivational</option>
                    <option value="12">Law</option>
                    <option value="13">Computer Science</option>
                    <option value="14">Medical Science</option>
                    <option value="15">Accounting</option>
                    <option value="16">Statistics</option>
                    <option value="17">Religion</option>
                    <option value="18">Civil Engineering</option>
                    <option value="19">Physics</option>
                    <option value="20">Polymer Science</option>
                    <option value="21">Plant Biotechnology</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="books.php" class="btn btn-light mr-2" style="float: right">Back</a>
        </form>
    </div>
</div>
<?php
include "inc/footer.php";
?>


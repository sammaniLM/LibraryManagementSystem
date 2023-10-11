<!--<div id="mySidenv" class="sidenav">
    <p class="logo"><span>LMS-</span>Solution</p>
    <a href="./" class="icon-a"><i class="fa fa-dashboard icons"></i>&nbsp;&nbsp;Dashboard</a>
    <a href="members.php" class="icon-a"><i class="fa fa-users icons"></i>&nbsp;&nbsp;Members</a>
    <a href="books.php" class="icon-a"><i class="fa fa-book icons"></i>&nbsp;&nbsp;Books</a>
    <a href="lendBookList.php" class="icon-a"><i class="fa-solid fa-arrow-right-arrow-left icons"></i>&nbsp;&nbsp;Lending and Returning</a>
    <a href="fineList.php" class="icon-a"><i class="fa-solid fa-money-bill icons"></i>&nbsp;&nbsp;Fines</a>
    <a href="reports.php" class="icon-a"><i class="fa-solid fa-chart-simple icons"></i>&nbsp;&nbsp;Reports</a>
    <a href="logout.php" class="icon-a"><i class="fa-solid fa-power-off icons"></i>&nbsp;&nbsp;Logout</a>
</div>-->

<?php

echo '<div id="mySidenv" class="sidenav">';
echo '<p class="logo"><span>LMS-</span>Solution</p>';

echo '<a href="./" class="icon-a"><i class="fa fa-dashboard icons"></i>  Dashboard</a>';

if($_SESSION['RoleID'] == 1){
    echo '<a href="members.php" class="icon-a"><i class="fa fa-users icons"></i>&nbsp;&nbsp;Members</a>';
    echo '<a href="books.php" class="icon-a"><i class="fa fa-book icons"></i>&nbsp;&nbsp;Books</a>';
    echo '<a href="lendBookList.php" class="icon-a"><i class="fa-solid fa-arrow-right-arrow-left icons"></i>&nbsp;&nbsp;Lending and Returning</a>';
    echo '<a href="fineList.php" class="icon-a"><i class="fa-solid fa-money-bill icons"></i>&nbsp;&nbsp;Fines</a>';
    /*echo '<a href="reports.php" class="icon-a"><i class="fa-solid fa-chart-simple icons"></i>&nbsp;&nbsp;Reports</a>';*/
} else if($_SESSION['RoleID'] == 2){
    echo '<a href="members.php" class="icon-a"><i class="fa fa-users icons"></i>&nbsp;&nbsp;Members</a>';
    echo '<a href="books.php" class="icon-a"><i class="fa fa-book icons"></i>&nbsp;&nbsp;Books</a>';
    echo '<a href="lendBookList.php" class="icon-a"><i class="fa-solid fa-arrow-right-arrow-left icons"></i>&nbsp;&nbsp;Lending and Returning</a>';
    echo '<a href="fineList.php" class="icon-a"><i class="fa-solid fa-money-bill icons"></i>&nbsp;&nbsp;Fines</a>';
    /*echo '<a href="reports.php" class="icon-a"><i class="fa-solid fa-chart-simple icons"></i>&nbsp;&nbsp;Reports</a>';*/
} else if($_SESSION['RoleID'] == 3){
    echo '<a href="members.php" class="icon-a"><i class="fa fa-users icons"></i>&nbsp;&nbsp;Members</a>';
    echo '<a href="books.php" class="icon-a"><i class="fa fa-book icons"></i>&nbsp;&nbsp;Books</a>';
    echo '<a href="lendBookList.php" class="icon-a"><i class="fa-solid fa-arrow-right-arrow-left icons"></i>&nbsp;&nbsp;Lending and Returning</a>';
    echo '<a href="fineList.php" class="icon-a"><i class="fa-solid fa-money-bill icons"></i>&nbsp;&nbsp;Fines</a>';
}
echo '<a href="logout.php" class="icon-a"><i class="fa-solid fa-power-off icons"></i>  Logout</a>';
echo '</div>';
?>
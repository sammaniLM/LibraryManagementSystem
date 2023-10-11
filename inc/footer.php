<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/5241448f6b.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!--Sweet Alert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>

<!--Search Member-->
<script>
    $(document).ready(function(){
        $("#search-box").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $.ajax({
                type: "GET",
                url: "search_members.php",
                data: { search_term: value },
                success: function(data){
                    $("table tbody").html(data);
                }
            });
        });
    });
</script>

<!--Search Book-->
<script>
    $(document).ready(function(){
        $("#search-box-book").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

<!--Search Lending Record-->
<script>
    $(document).ready(function(){
        $("#search-lend").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $.ajax({
                type: "GET",
                url: "search_lendRecords.php",
                data: { search_term: value },
                success: function(data){
                    $("table tbody").html(data);
                }
            });
        });
    });
</script>

<!--Search Overdue Books-->
<script>
    $(document).ready(function(){
        $("#search-fine").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            $.ajax({
                type: "GET",
                url: "search_fineRecords.php",
                data: { search_term: value },
                success: function(data){
                    $("table tbody").html(data);
                }
            });
        });
    });
</script>

<!--Display Book Name when input Book tracking number-->
<script>
    function fetchBookTitle() {
        var bookTrackingNumber = document.getElementById('book_tracking_number').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetchBookName.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('book_title').value = xhr.responseText;
                } else {
                    console.error('Failed to fetch book title');
                }
            }
        };
        xhr.send('book_tracking_number=' + bookTrackingNumber);
    }
</script>

<!--Display Member name when input Member tracking number-->
<script>
    function fetchMemberName() {
        var memberTrackingNum = document.getElementById('member_tracking_num').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetchMemberName.php', true); // Update the URL to the PHP file that fetches member name
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('member_name').value = xhr.responseText;
                } else {
                    console.error('Failed to fetch member name');
                }
            }
        };
        xhr.send('member_tracking_num=' + memberTrackingNum);
    }
</script>

<!--Display expected return date-->
<script>
    var loanDateInput = document.getElementById('loan_date');
    var returnDateInput = document.getElementById('return_date_expected');

    loanDateInput.addEventListener('change', function() {
        var loanDate = new Date(loanDateInput.value);
        var expectedReturnDate = new Date(loanDate);
        expectedReturnDate.setDate(loanDate.getDate() + 14);
        var formattedExpectedReturnDate = expectedReturnDate.toISOString().slice(0, 10);
        returnDateInput.value = formattedExpectedReturnDate;
    });
</script>

<!--Check whether Extended Return date is prior than lending date-->
<script>
    function validateForm() {
        var returnDateExpected = document.getElementById("return_date_expected").value;
        var loanDate = document.getElementById("loan_date").value;

        if (new Date(returnDateExpected) <= new Date(loanDate)) {
            alert("New return date expected must be after loan date.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
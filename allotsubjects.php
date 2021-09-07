<?php
include('./views/includes/header.php');
include('./views/includes/nav.php');
include('./class/connection.php');
?>
<br>
<div align="center">
    <form action="allotmentFormvalidation.php" method="post" style="margin-top: 100px">
        <div style="margin-top: 5px">
            <select name="tobealloted" class="list-group-item" required>
                <?php
                $q = mysqli_query(
                    $con,
                    "SELECT * FROM subjects ORDER BY department,semester ASC"
                );
                $row_count = mysqli_num_rows($q);
                if ($row_count) {
                    $mystring = '
                     <option selected disabled>Select Subject</option>';
                    while ($row = mysqli_fetch_assoc($q)) {
                        if ($row['isAlloted'] == 1 || $row['course_type'] == "LAB")
                            continue;
                        $mystring .= '<option value="' . $row['subject_code'] . '">' . $row['subject_code'] . " " . $row['subject_name'] . '</option>';
                    }
                    echo $mystring;
                }
                ?>
            </select>
        </div>
        <div>
            <select name="toalloted" class="list-group-item" required>
                <?php
                $q = mysqli_query(
                    $con,
                    "SELECT * FROM teachers ORDER BY faculty_number ASC"
                );
                $row_count = mysqli_num_rows($q);
                if ($row_count) {
                    $mystring = '
                      <option selected disabled>Select Teacher</option>';
                    while ($row = mysqli_fetch_assoc($q)) {
                        $mystring .= '<option value="' . $row['faculty_number'] . '">' . $row['name'] . '</option>';
                    }
                    echo $mystring;
                }
                ?>
            </select>
        </div>
        <div style="margin-top: 10px">
            <button type="submit" class="btn btn-success btn-lg">Allot</button>
        </div>
    </form>
</div>
<script>
    function deleteHandlers() {
        var table = document.getElementById("allotedsubjectstable");
        var rows = table.getElementsByTagName("tr");
        for (i = 0; i < rows.length; i++) {
            var currentRow = table.rows[i];
            //var b = currentRow.getElementsByTagName("td")[0];
            var createDeleteHandler =
                function(row) {
                    return function() {
                        var cell = row.getElementsByTagName("td")[0];
                        var id = cell.innerHTML;
                        var x;
                        if (confirm("Are You Sure?") == true) {
                            window.location.href = "deleteallotment.php?name=" + id;
                        }
                    };
                };
            currentRow.cells[4].onclick = createDeleteHandler(currentRow);
        }
    }
</script>
<style>
    table {
        margin-top: 80px;
        margin-bottom: 50px;
        font-family: arial, sans-serif;
        border-collapse: collapse;
        margin-left: 80px;
        width: 90%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>
<table id=allotedsubjectstable>
    <caption><strong>THEORY COURSES ALLOTMENT</strong></caption>
    <tr>
        <th width="70">Semester</th>
        <th width="150">Subject Code</th>
        <th width=320>Subject Title</th>
        <th width=150>Branch</th>
        <th width="170">Faculty No</th>
        <th width="330">Teacher's Name</th>
        <th width="40">Action</th>
    </tr>
    <tbody id="table-data">
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Table Records
        function loadTable() {
            $.ajax({
                url: "./class/allotmentFunction.php",
                type: "POST",
                data: {
                    method: 'load_theory',
                },
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
        }
        loadTable();
        $(document).on("click", ".delete-btn", function() {
            if (confirm("Do you really want to delete this record ?")) {
                var subId = $(this).data("cid");
                var element = this;
                $.ajax({
                    url: "./class/allotmentFunction.php",
                    type: "POST",
                    data: {
                        method: 'remove_theory',
                        id: subId,
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            loadTable();
                            alert("Deleted successfully");
                        } else {
                            loadTable();
                            alert("Deletion failed");
                        }
                    }
                });
            }
        });
    });
</script>
<?php include('./views/includes/footer.php'); ?>
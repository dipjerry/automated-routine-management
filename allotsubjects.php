<?php
include('./views/includes/header.php');
include('./views/includes/nav.php');
include('./class/connection.php');
?>
<br>
<div align="center">
    <form action="allotmentFormvalidation.php" method="post" style="margin-top: 100px">
        <div style="margin-top: 5px">
            <select name="tobealloted" class="list-group-item">
                <?php
                $q = mysqli_query(
                    $con,
                    "SELECT * FROM subjects"
                );
                $row_count = mysqli_num_rows($q);
                if ($row_count) {
                    $mystring = '
                     <option selected disabled>Select Subject</option>';
                    while ($row = mysqli_fetch_assoc($q)) {
                        if ($row['isAlloted'] == 1 || $row['course_type'] == "LAB")
                            continue;
                        $mystring .= '<option value="' . $row['subject_code'] . '">' . $row['subject_name'] . '</option>';
                    }
                    echo $mystring;
                }
                ?>
            </select>
        </div>
        <div>
            <select name="toalloted" class="list-group-item">
                <?php
                $q = mysqli_query(
                    $con,
                    "SELECT * FROM teachers "
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
        <th width="150">Subject Code</th>
        <th width=420>Subject Title</th>
        <th width="170">Faculty No</th>
        <th width="330">Teacher's Name</th>
        <th width="40">Action</th>
    </tr>
    <tbody>
        <?php
        $q = mysqli_query(
            $con,
            "SELECT * FROM subjects "
        );
        while ($row = mysqli_fetch_assoc($q)) {
            if ($row['isAlloted'] == 0 || $row['course_type'] == 'LAB')
                continue;
            $teacher_id = $row['allotedto'];
            $t = mysqli_query(
                $con,
                "SELECT name FROM teachers WHERE faculty_number = '$teacher_id'"
            );
            $trow = mysqli_fetch_assoc($t);
            echo "<tr><td>{$row['subject_code']}</td>
                    <td>{$row['subject_name']}</td>
                    <td>{$row['allotedto']}</td>
                    <td>{$trow['name']}</td>
                   <td>
                    <button>Delete</button></td>
                    </tr>\n";
        }
        echo "<script>deleteHandlers();</script>";
        ?>
    </tbody>
</table>
<?php include('./views/includes/footer.php'); ?>
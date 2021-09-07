<?php
include('./views/includes/header.php');
include('./views/includes/nav.php');
include('./class/connection.php');
?>
<br>
<?php
if (isset($_POST['in_class'])) {
    $year = $_POST['course'];
    $class = $_POST['in_class'];
    $q = mysqli_query(
        $con,
        "UPDATE classrooms SET status = '$year' WHERE name = '$class'"
    );
}
?>
<form action="allotclasses.php" method="post" style="margin-top: 100px">
    <div align="center">
        <select name="course" class="list-group-item">
            <option selected disabled>Select Course</option>
            <option value="2">2nd Year</option>
            <option value="3">3rd Year</option>
        </select>
    </div>
    <div align="center" style="margin-top: 5px">
        <select name="in_class" class="list-group-item">
            <?php
            $q = mysqli_query(
                $con,
                "SELECT * FROM classrooms"
            );
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
             <option selected disabled>Select Classroom</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    if ($row['status'] != 0)
                        continue;
                    $mystring .= '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                }
                echo $mystring;
            }
            ?>
        </select>
    </div>
    <div align="center" style="margin-top: 10px;">
        <button type="submit" class="btn btn-success btn-lg">Allot</button>
    </div>
</form>
<div align="center">
    <style>
        table {
            margin-top: 70px;
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
    <table id=allotedclassroomstable>
        <caption><strong>CLASSROOMS ALLOTMENT</strong></caption>
        <tr>
            <th width="250">Classroom</th>
            <th width="400">Alloted To</th>
            <th width="60">Action</th>
        </tr>
        <tbody id="table-data">
            <!-- teachers information will be fetched here by asynchronous ajax request -->
        </tbody>
    </table>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Table Records
        function loadTable() {
            $.ajax({
                url: "./class/allotmentFunction.php",
                type: "POST",
                data: {
                    method: 'load_classroom',
                },
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
        }
        loadTable();
        $(document).on("click", ".delete-btn", function() {
            if (confirm("Do you really want to delete this record ?")) {
                var classId = $(this).data("cid");
                var element = this;
                $.ajax({
                    url: "./class/allotmentFunction.php",
                    type: "POST",
                    data: {
                        method: 'remove_classroom',
                        id: classId,
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            loadTable();
                            alert("Deleted sucessfully");
                        } else {
                            alert("Deleted sucessfully");
                            loadTable();
                        }
                    }
                });
            }
        });
    });
</script>
<?php include('./views/includes/footer.php'); ?>
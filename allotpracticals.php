<?php
include('./views/includes/header.php');
include('./class/connection.php');
?>

<div class="navbar navbar-inverse navbar-fixed-top " id="menu">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="navbar-collapse collapse move-me">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="addteachers.php">ADD TEACHERS</a></li>
                <li><a href="addsubjects.php">ADD SUBJECTS</a></li>
                <li><a href="addclassrooms.php">ADD CLASSROOMS</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">ALLOTMENT
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href=allotsubjects.php>THEORY COURSES</a>
                        </li>
                        <li>
                            <a href=allotpracticals.php>PRACTICAL COURSES</a>
                        </li>
                        <li>
                            <a href=allotclasses.php>CLASSROOMS</a>
                        </li>
                    </ul>
                </li>
                <li><a href="generatetimetable.php">GENERATE TIMETABLE</a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">LOGOUT</a></li>
            </ul>

        </div>
    </div>
</div>
<!--NAVBAR SECTION END-->
<br>
<form action="allotmentpracticalFormvalidation.php" method="post" style="margin-top: 100px">
    <div align="center">
        <select name="tobealloted" class="list-group-item">
            <?php

            $q = mysqli_query(
                $con,
                "SELECT * FROM subjects WHERE course_type = 'LAB'"
            );
            $row_count = mysqli_num_rows($q);
            if ($row_count) {
                $mystring = '
         <option selected disabled>Select Subject</option>';
                while ($row = mysqli_fetch_assoc($q)) {
                    if ($row['isAlloted'] == 1)
                        continue;
                    $mystring .= '<option value="' . $row['subject_code'] . '">' . $row['subject_name'] . '</option>';
                }

                echo $mystring;
            }
            ?>
        </select>
    </div>
    <div align="center" style="margin-top: 5px">
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
    <div align="center" style="margin-top: 5px">
        <select name="toalloted2" class="list-group-item">
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
    <div align="center" style="margin-top: 5px">
        <select name="toalloted3" class="list-group-item">
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

    </div>
    <div align="center" style="margin-top: 10px">
        <button type="submit" class="btn btn-success btn-lg">Allot</button>
    </div>
</form>
<?php
/**
 * Created by PhpStorm.
 * User: MSaqib
 * Date: 16-11-2016
 * Time: 14:13
 */
if (isset($_GET['name'])) {
    $id = $_GET['name'];
    $q = mysqli_query(
        $con,
        "UPDATE subjects  SET isAlloted = '0' , allotedto = '',allotedto2 = '',allotedto3 = '' WHERE subject_code = '$id' "
    );
}


?>
<script>
    function deleteHandlersForPractical() {
        var table = document.getElementById("allotedpracticalstable");
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
                            // window.location.href = "deletepracticalallotment.php?name=" + id;
                            window.location.href = "allotpracticals.php?name=" + id;
                        }

                    };
                };

            currentRow.cells[8].onclick = createDeleteHandler(currentRow);
        }
    }
</script>
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

<table id=allotedpracticalstable>
    <caption><strong>PRACTICAL COURSES ALLOTMENT</strong></caption>
    <tr>
        <th width="130">Subject Code</th>
        <th width=200>Subject Title</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
        <th width="120">Faculty No</th>
        <th width="300">Teacher's Name</th>
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
                    method: 'load_practical',
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
                alert("hello");
                $.ajax({
                    url: "./class/allotmentFunction.php",
                    type: "POST",
                    data: {
                        method: 'remove_practical',
                        id: subId,
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            $("#error-message").html("Can't Delete Record.").slideDown();
                            $("#success-message").slideUp();
                            $("#success-message").html("Can't Delete Record.").slideDown();
                            $("#error-message").slideUp();
                            loadTable();
                            alert("ok");
                        } else {
                            loadTable();
                            $("#error-message").html("Can't Delete Record.").slideDown();
                            $("#success-message").slideUp();
                        }
                    }
                });
            }
        });
    });
</script>
<?php include('./views/includes/footer.php'); ?>
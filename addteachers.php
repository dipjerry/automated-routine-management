<?php include('./views/includes/header.php');
include('./views/includes/nav.php');
include './class/connection.php';
?>
<br>
<div class="alert alert-warning alert-dismissible fade show" id="error-alert" style="display: none;">
    <strong>Warning!</strong>
    <span id="error-message"></span>
    <button type="button" class="close" id="error">
        &times;
    </button>
</div>
<div class="alert alert-success alert-dismissible fade show" id="success-alert" style="display: none;">
    <strong>Success!</strong>
    <span id="success-message"></span>
    <button type="button" class="close" id="success">
        &times;
    </button>
</div>
<div align="center" style="margin-top:80px">
    <form name="import" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" name="teacherexcel" id="teacherexcel" class="btn btn-info btn-lg" value="IMPORT EXCEL" />
    </form>
    <?php
    if (isset($_POST['teacherexcel'])) {
        if (empty($_FILES['file']['tmp_name'])) {
            echo '<script>alert("Select a file first! ");</script>';
        } else {
            $file = $_FILES['file']['tmp_name'];
            $row = 1;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $facno = $data[0];
                    $name = $data[1];
                    $alias = $data[2];
                    $designation = $data[3];
                    $contact = $data[4];
                    $email = $data[5];
                    if ($facno == "" || $facno == "Faculty No.") {
                        continue;
                    }
                    $q = mysqli_query(
                        $con,
                        "INSERT INTO teachers VALUES ('$facno','$name','$alias','$designation','$contact','$email')"
                    );
                    if ($q) {
                        $sql = "CREATE TABLE " . $facno . " (
                day VARCHAR(10) PRIMARY KEY, 
                period1 VARCHAR(30),
                period2 VARCHAR(30),
                period3 VARCHAR(30),
                period4 VARCHAR(30),
                period5 VARCHAR(30),
                period6 VARCHAR(30)
                )";
                        mysqli_query($con, $sql);
                        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
                        for ($i = 0; $i < 6; $i++) {
                            $day = $days[$i];
                            $sql = "INSERT into " . $facno . " VALUES('$day','','','','','','')";
                            mysqli_query($con, $sql);
                        }
                    }
                }
                fclose($handle);
            }
        }
    }
    ?>
</div>
<div align="center" style="margin-top:20px">
    <button id="teachermanual" class="btn btn-success btn-lg">ADD TEACHER</button>
</div>
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="margin-top: -60px">
        <div class="modal-header">
            <span class="close">&times</span>
            <h2 id="popupHead">Add Teacher</h2>
        </div>
        <div class="modal-body" id="EnterTeacher">
            <!--Admin Login Form-->
            <div style="display:none" id="addTeacherForm">
                <form action="addteacherFormValidation.php" method="POST">
                    <div class="form-group">
                        <label for="teachername">Teacher's Name</label>
                        <input type="text" class="form-control" id="teachername" name="TN" placeholder="Teacher's Name ...">
                    </div>
                    <div class="form-group">
                        <label for="TF">Faculty No</label>
                        <input type="text" class="form-control" id="facultyno" name="TF" placeholder="Faculty No ...">
                    </div>
                    <div class="form-group">
                        <label for="TF">Alias</label>
                        <input type="text" class="form-control" id="alias_name" name="AL" placeholder="Alias..">
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <select class="form-control" id="designation" name="TD">
                            <option selected disabled>Select</option>
                            <option value="Principal">Principal</option>
                            <option value="HOD">HOD</option>
                            <option value="Professor">Professor</option>
                            <option value="Junior Instructor">Instructor</option>
                            <option value="Junior Instructor">Junior Instructor</option>
                            <option value="Guest Faculty">Guest Faculty</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teachercontactnumber">Contact No.</label>
                        <input type="text" class="form-control" id="teachercontactnumber" name="TP" placeholder="+91 ...">
                    </div>
                    <div class="form-group">
                        <label for="teacheremailid">Email-ID</label>
                        <input type="text" class="form-control" id="teacheremailid" name="TE" placeholder="abc@xyz.com ...">
                    </div>
                    <div align="right">
                        <input type="submit" class="btn btn-default" name="ADD" value="ADD">
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
</div>
<script>
    var modal = document.getElementById('myModal');
    var addteacherBtn = document.getElementById("teachermanual");
    var heading = document.getElementById("popupHead");
    var facultyForm = document.getElementById("addTeacherForm");
    var span = document.getElementsByClassName("close")[0];
    addteacherBtn.onclick = function() {
        modal.style.display = "block";
        facultyForm.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
        facultyForm.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<div>
    <br>
    <style>
        table {
            margin-top: 10px;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            /* margin-left: 30px; */
            width: 80%;
            padding: 5%;
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
    <div class="table-responsive">
        <table id=teacherstable class="table table-hover">
            <caption><strong>Teacher's Information </strong></caption>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Faculty No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Alias</th>
                    <th scope="col">Designation</th>
                    <th scope="col">Contact No.</th>
                    <th scope="col">Email ID</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="table-data">
                <!-- teachers information will be fetched here by asynchronous ajax request -->
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Table Records
        function loadTable() {
            $.ajax({
                url: "./class/teacherFunctions.php",
                type: "POST",
                data: {
                    method: 'load',
                },
                success: function(data) {
                    $("#table-data").html(data);
                }
            });
        }
        loadTable();
        $(document).on("click", ".delete-btn", function() {
            if (confirm("Do you really want to delete this record ?")) {
                var teacherId = $(this).data("tid");
                var element = this;
                $.ajax({
                    url: "./class/teacherFunctions.php",
                    type: "POST",
                    data: {
                        method: 'remove',
                        id: teacherId,
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            loadTable();
                            alert("Deleted succesfully");
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
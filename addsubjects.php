<?php
include('./views/includes/header.php');
include('./views/includes/nav.php');
include('./class/connection.php');
?>
<br>
<div align="center" style="margin-top:60px">
    <form name="import" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" name="subjectexcel" id="subjectexcel" class="btn btn-info btn-lg" value="IMPORT EXCEL" />
    </form>
    <?php
    if (isset($_POST['subjectexcel'])) {
        if (empty($_FILES['file']['tmp_name'])) {
            echo '<script>alert("Select a file first! ");</script>';
        } else {
            $file = $_FILES['file']['tmp_name'];
            $row = 1;
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);
                    $code = $data[0];
                    $name = $data[1];
                    $type = $data[2];
                    $semester = $data[3];
                    $department = $data[4];
                    if ($code == "" || $code == "Subject Code") {
                        continue;
                    }
                    $q = mysqli_query(
                        $con,
                        "INSERT INTO subjects VALUES ('$code','$name','$type','$semester','$department',0,'','','')"
                    );
                }
                fclose($handle);
            }
        }
    }
    ?>
</div>
<div align="center" style="margin-top: 20px">
    <button id="subjectmanual" class="btn btn-success btn-lg">ADD SUBJECT</button>
</div>
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times</span>
            <h2 id="popupHead">Add Subject</h2>
        </div>
        <div class="modal-body" id="EnterSubject">
            <!--Admin Login Form-->
            <div style="display:none" id="addSubjectForm">
                <form action="addsubjectFormValidation.php" method="POST">
                    <div class="form-group">
                        <label for="subjectname">Subject Name</label>
                        <input type="text" class="form-control" id="subjectname" name="SN" placeholder="Subject's Name ...">
                    </div>
                    <div class="form-group">
                        <label for="subjectcode">Subject Code</label>
                        <input type="text" class="form-control" id="subjectcode" name="SC" placeholder="CO203 CO205...">
                    </div>
                    <div class="form-group">
                        <label for="subjecttype">Course Type</label>
                        <select class="form-control" id="subjecttype" name="ST">
                            <option selected disabled>Select</option>
                            <option value="THEORY">THEORY</option>
                            <option value="LAB">LAB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subjectsemester">Semester</label>
                        <select class="form-control" id="subjectsemester" name="SS">
                            <option selected disabled>Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subjectdepartment">Department</label>
                        <select class="form-control" id="subjectdepartment" name="SD">
                            <option selected disabled>Select</option>
                            <option value="Computer Engg.">Computer Engg.</option>
                            <option value="Printing Engg.">Printing Technology Engg.</option>
                            <option value="Electrical Engg.">Electrical Engg.</option>
                            <option value="common">Common</option>
                        </select>
                    </div>
                    <div align="right" class="form-group">
                        <!-- <input type="submit" class="btn btn-default" name="ADD" value="ADD"> -->
                        <input value="save" type="submit" name="submit" class="btn btn-primary btn-sm" id="save-button">
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
    var addsubjectBtn = document.getElementById("subjectmanual");
    var heading = document.getElementById("popupHead");
    var subjectForm = document.getElementById("addSubjectForm");
    var span = document.getElementsByClassName("close")[0];
    addsubjectBtn.onclick = function() {
        modal.style.display = "block";
        subjectForm.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
        subjectForm.style.display = "none";
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
            font-family: arial, sans-serif;
            border-collapse: collapse;
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
    <div class="table-responsive">
        <table id=subjectstable class="table table-hover">
            <caption><strong> Subject's Information</strong></caption>
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Title</th>
                    <th scope="col">Course Type</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Department</th>
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
                url: "./class/subjectFunctions.php",
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
                    url: "./class/subjectFunctions.php",
                    type: "POST",
                    data: {
                        method: 'remove',
                        id: teacherId,
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            $("#success-message").html("Can't Delete Record.").slideDown();
                            $("#error-message").slideUp();
                            loadTable();
                        } else {
                            loadTable();
                            $("#error-message").html("Can't Delete Record.").slideDown();
                            $("#success-message").slideUp();
                        }
                    }
                });
            }
        });
        // ajax function tu add
        $("#save-button").on("click", function(e) {
            e.preventDefault();
            var subjectname = $("#subjectname").val();
            var subjectcode = $("#subjectcode").val();
            var subjecttype = $("#subjecttype").val();
            var subjectsemester = $("#subjectsemester").val();
            var subjectdepartment = $("#subjectdepartment").val();
            if (subjectname == "" || subjectcode == "" || subjecttype == "" || subjectsemester == "" || subjectdepartment == "") {
                alert("All field are required");
            } else {
                $.ajax({
                    url: "./class/subjectFunctions.php",
                    type: "POST",
                    data: {
                        method: 'add',
                        sName: subjectname,
                        sCode: subjectcode,
                        sType: subjecttype,
                        sSem: subjectsemester,
                        sDept: subjectdepartment,
                    },
                    success: function(data) {
                        if (data == 1) {
                            modal.style.display = "none";
                            loadTable();
                            alert("ok");
                            $("#addForm").trigger("reset");
                            echo("Adding record failed");
                        } else {
                            echo("Adding record failed");
                        }
                    }
                });
            }
        });
    });
</script>
<?php
include('./views/includes/footer.php');
?>
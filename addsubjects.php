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
    // Get the modal
    var modal = document.getElementById('myModal');
    // Get the button that opens the modal
    var addsubjectBtn = document.getElementById("subjectmanual");
    var heading = document.getElementById("popupHead");
    var subjectForm = document.getElementById("addSubjectForm");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks the button, open the modal
    addsubjectBtn.onclick = function() {
        modal.style.display = "block";
        //heading.innerHTML = "Faculty Login";
        subjectForm.style.display = "block";
        //adminForm.style.display = "none";
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        //adminForm.style.display = "none";
        subjectForm.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
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
            margin-left: 50px;
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
    <table id=subjectstable style="margin-left: 90px">
        <caption><strong> Subject's Information</strong></caption>
        <tr>
            <th width="150">Code</th>
            <th width=300>Title</th>
            <th width=150>Course Type</th>
            <th width="150">Semester</th>
            <th width="350">Department</th>
            <th width="40">Action</th>
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
        // ajax function tu add
        $("#save-button").on("click", function(e) {
            e.preventDefault();
            var subjectname = $("#subjectname").val();
            var subjectcode = $("#subjectcode").val();
            var subjecttype = $("#subjecttype").val();
            var subjectsemester = $("#subjectsemester").val();
            var subjectdepartment = $("#subjectdepartment").val();
            if (subjectname == "" || subjectcode == "" || subjecttype == "" || subjectsemester == "" || subjectdepartment == "") {
                $("#error-message").html("All fields are required.").slideDown();
                $("#success-message").slideUp();
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
                            $("#success-message").html("Data Inserted Successfully.").slideDown();
                            $("#error-message").slideUp();
                        } else {
                            $("#error-message").html("Can't Save Record.").slideDown();
                            $("#success-message").slideUp();
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
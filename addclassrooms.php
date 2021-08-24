<?php
include('./views/includes/header.php');
include('./views/includes/nav.php');
?>
<br>
<div align="center" style="margin-top:10%">
    <button id="classroommanual" class="btn btn-success btn-lg">ADD CLASSROOM</button>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times</span>
            <h2 id="popupHead">Add Classroom</h2>
        </div>
        <div class="modal-body" id="EnterClassroom">
            <!--Admin Login Form-->
            <div style="display:none" id="addClassroomForm">
                <form action="addclassroomFormValidation.php" method="POST">
                    <div class="form-group">
                        <label for="classroomname">Name</label>
                        <input type="text" class="form-control" id="classroomname" name="CN" placeholder="ML 32, NL 33 ...">
                    </div>
                    <div align="right">
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
    var addclassroomBtn = document.getElementById("classroommanual");
    var heading = document.getElementById("popupHead");
    var classroomForm = document.getElementById("addClassroomForm");
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks the button, open the modal
    addclassroomBtn.onclick = function() {
        modal.style.display = "block";
        classroomForm.style.display = "block";
    }
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
        classroomForm.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<div align="center">
    <br>
    <style>
        table {
            margin-top: 10px;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 70%;
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

        <table id=classroomstable>
            <caption><strong>ADDED CLASSROOMS</strong></caption>
            <thead class="thead-dark">
                <tr>
                    <th width="100">Name</th>
                    <th width="60">Action</th>
                </tr>
            </thead>
            <tbody id="table-data">
                <!-- classroom information will be fetched here by asynchronous ajax request -->
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // // ajax function tu Load classroom Records
        function loadTable() {
            $.ajax({
                url: "./class/classroomFunction.php",
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
        // ajax function tu delete
        $(document).on("click", ".delete-btn", function() {
            if (confirm("Do you really want to delete this record ?")) {
                var classRoomId = $(this).data("cid");
                var element = this;
                $.ajax({
                    url: "./class/classroomFunction.php",
                    type: "POST",
                    data: {
                        method: 'remove',
                        id: classRoomId,
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
        // ajax function tu add
        $("#save-button").on("click", function(e) {
            e.preventDefault();
            var Name = $("#classroomname").val();
            if (Name == "") {
                $("#error-message").html("All fields are required.").slideDown();
                $("#success-message").slideUp();
            } else {
                $.ajax({
                    url: "./class/classroomFunction.php",
                    type: "POST",
                    data: {
                        method: 'add',
                        name: Name,
                    },
                    success: function(data) {
                        if (data == 1) {
                            loadTable();
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
<?php include('./views/includes/footer.php'); ?>
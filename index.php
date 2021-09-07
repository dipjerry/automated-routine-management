<?php
if (isset($_GET['generated']) && $_GET['generated'] == "false") {
    unset($_GET['generated']);
    echo '<script>alert("Timetable not generated yet!!");</script>';
}
require("./class/connection.php");
require("./class/loginFunction.php");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TimeTable Management System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/flexslider.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top " id="menu">
        <div class="container">
            <div align="center">
                <h3 align="center">TIME TABLE MANAGEMENT SYSTEM, COMPUTER SCIENCE ENGINEERING DEPARTMENT </h3>
                <h3 align="center">NALBARI POLYTECHNIC</h3>
                <h4 align="center">Nabari - 781334</h4>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <img src="assets/img/building.jpg" class="img-fluid" alt="Building" style="width:100% ; height:350px ; margin-top:9% ">
    </div>
    <script type="text/javascript">
        function genpdf() {
            var doc = new jsPDF();
            doc.addHTML(document.getElementById('TT'), function() {
                doc.save('timetable.pdf');
            });
            window.alert("Downloaded!");
        }
    </script>
    <div align="center" STYLE="margin-top: 30px">
        <button data-scroll-reveal="enter from the bottom after 0.2s" id="teacherLoginBtn" class="btn btn-info btn-lg">TEACHER LOGIN
        </button>
        <button data-scroll-reveal="enter from the bottom after 0.2s" id="adminLoginBtn" class="btn btn-success btn-lg">ADMIN LOGIN
        </button>
    </div>
    <br>
    <div align="center">
        <form data-scroll-reveal="enter from the bottom after 0.2s" action="studentvalidation.php" method="post" target="_blank">
            <select id="select_semester" name="select_semester" class="list-group-item">
                <option selected disabled>Select Semester</option>
                <option value="3">II Year ( Semester III )</option>
                <option value="4">II Year ( Semester IV )</option>
                <option value="5">III Year ( Semester V )</option>
                <option value="6">III Year ( Semester VI )</option>
            </select>
            <button type="submit" class="btn btn-info btn-lg" style="margin-top: 10px">View</button>
        </form>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times</span>
                <h2 id="popupHead">Modal Header</h2>
            </div>
            <div class="modal-body" id="LoginType">
                <!--Admin Login Form-->
                <div style="display:none" id="adminForm">
                    <form method="POST">
                        <div class="form-group">
                            <label for="adminname">Username</label>
                            <input type="text" class="form-control" id="adminname" name="UN" placeholder="Username ...">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="PASS" placeholder="Password ...">
                        </div>
                        <div align="right">
                            <button type="submit" class="w3-btn w3-blue" name="admin_login" id="btn-submit" value="SUBMIT">Log IN</button>
                            <!-- <input type="submit" class="btn btn-default" name="faculty_login" value="faculty_login"> -->
                        </div>
                    </form>
                </div>
            </div>
            <!--Faculty Login Form-->
            <div style="display:none" id="facultyForm">
                <form name="faculty" action="" id="faculty" method="post" style="overflow: hidden">
                    <div class="form-group">
                        <label for="facultyno">Faculty No.</label>
                        <input type="text" class="form-control" id="facultyno" name="FN" placeholder="Faculty No. ...">
                    </div>
                    <div align="right">
                        <button type="submit" class="btn btn-default" name="faculty_login">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var modal = document.getElementById('myModal');
        var teacherLoginBtn = document.getElementById("teacherLoginBtn");
        var adminLoginBtn = document.getElementById("adminLoginBtn");
        var heading = document.getElementById("popupHead");
        var facultyForm = document.getElementById("facultyForm");
        var adminForm = document.getElementById("adminForm");
        var span = document.getElementsByClassName("close")[0];
        adminLoginBtn.onclick = function() {
            modal.style.display = "block";
            heading.innerHTML = "Admin Login";
            adminForm.style.display = "block";
            facultyForm.style.display = "none";
        }
        teacherLoginBtn.onclick = function() {
            modal.style.display = "block";
            heading.innerHTML = "Faculty Login";
            facultyForm.style.display = "block";
            adminForm.style.display = "none";
        }
        span.onclick = function() {
            modal.style.display = "none";
            adminForm.style.display = "none";
            facultyForm.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <div class="container">
        <div class="row set-row-pad">
            <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1 " data-scroll-reveal="enter from the bottom after 0.4s">
                <h2><strong>Project done by</strong></h2>
                <hr />
                <div>
                    <h4>Kumarjit Jha [NAL/18/C0/026]</h4>
                    <h4>Abhijeet Kalita [NAL/18/C0/023]</h4>
                    <h4>Nayan kalpa Talukdar [NAL/18/C0/057]</h4>
                </div>
            </div>
        </div>
    </div>
    <?php include("./views/includes/footer.php") ?>
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
                <li><a href="addteachers.php">ADD TEACHERS </a></li>
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
                <li><a href="index.php">LOGOUT <i class="fa fa-sign-out"></i></a></li>
                <li><a id="reset">Reset Allotment</a></li>
            </ul>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on("click", "#reset", function() {
            if (confirm("Do you really want to reset the records ?")) {
                var element = this;
                $.ajax({
                    url: "./class/reset.php",
                    type: "POST",
                    data: {
                        method: 'reset'
                    },
                    success: function(data) {
                        if (data == 1) {
                            $(element).closest("tr").fadeOut();
                            $("#error-message").html("Can't Delete Record.").slideDown();
                            $("#success-message").slideUp();
                            $("#success-message").html("Can't Delete Record.").slideDown();
                            $("#error-message").slideUp();
                            alert("Reset succesfull");
                        } else {
                            alert("Reset failed");

                        }
                    }
                });
            }
        });
    });
</script>
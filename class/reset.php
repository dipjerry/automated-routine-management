<?php
require("./connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methods = $_POST['method'];
    if ($methods == "reset") {
        reset_app($con);
    }
}
function reset_app($conn)
{
    $success_counter = 0;
    $failure_counter = 0;
    $errors = array();
    $sql1 = "select * from teachers";
    $result = mysqli_query($conn, $sql1) or die("failed to load teacher");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sql2 = "DROP TABLE " . $row['faculty_number'];
            if (mysqli_query($conn, $sql2)) {
                $success_counter += 1;
            } else {
                $errors[$failure_counter] = "Error in deleting table " . $row['faculty_number'];
                $failure_counter += 1;
            }
        }
    }
    $sql3 = "DELETE FROM classrooms;";
    if (mysqli_query($conn, $sql3)) {
        $success_counter += 1;
    } else {
        $errors[$failure_counter] = "Error in deleting clearing class room";
        $failure_counter += 1;
    }
    $sql4 = "DELETE FROM teachers;";
    if (mysqli_query($conn, $sql4)) {
        $success_counter += 1;
    } else {
        $errors[$failure_counter] = "Error in clearing Teachers";
        $failure_counter += 1;
    }
    $sql5 = "DELETE FROM subjects;";
    if (mysqli_query($conn, $sql5)) {
        $success_counter += 1;
    } else {
        $errors[$failure_counter] = "Error in clearing subjects";
        $failure_counter += 1;
    }
    for ($i = 3; $i <= 6; $i++) {
        for ($j = 0; $j < 6; $j++) {
            $database_name = "semester" . $i;
            $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
            $sql6 = "UPDATE " . $database_name . " SET  
        period1= '-<br>-', period2='- <br>', period3='-<br>-', period4='-<br>-',  period5='-<br>-', period6= '-<br>-' WHERE day='" . $days[$j] . "'";
            echo ($days[$j]);
            if (!mysqli_query($conn, $sql6)) {
                echo ("error description" . mysqli_error($conn));
                $errors[$failure_counter] = "Error in updating $database_name";
                $failure_counter += 1;
            } else {
                $success_counter += 1;
            }
        }
        if ($failure_counter > 0) {
            $error_counter = count($errors);
            for ($i = 0; $i < $error_counter; $i++) {
                echo ("$i" . $errors[$i]);
            }
        }
        if ($failure_counter > 0) {
            echo 0;
        } else {
            echo 1;
        }
    }
}

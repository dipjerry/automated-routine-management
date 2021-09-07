<?php
require("./connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $methods = $_POST['method'];
    $tab = 'Teachers_list';
    if ($methods == "load") {
        load($con);
    } elseif ($methods == "remove") {
        remove($_POST['id'], $con);
    } elseif ($methods == "add") {
        add(
            $_POST['sName'],
            $_POST['sCode'],
            $_POST['sType'],
            $_POST['sSem'],
            $_POST['sDept'],
            $con
        );
    }
}
function load($conn)
{
    $sql = "SELECT * FROM subjects ORDER BY subject_code ASC ";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['subject_code']}</td>
            <td>{$row['subject_name']}</td>
            <td>{$row['course_type']}</td>
            <td>{$row['semester']}</td>
            <td>{$row['department']}</td>
            <td>
                <button Class='delete-btn btn btn-sm btn-danger' data-tid='{$row["subject_code"]}'>Delete</button>
            </td>
            </tr>\n";
        }
        mysqli_close($conn);
        // echo $output;
    } else {
        echo "<h2>No Record Found.</h2>";
    }
}
function remove($subject_id, $conn)
{
    $sql = "DELETE FROM `subjects` WHERE subject_code = '$subject_id'";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
function add($name, $code, $course, $sem, $dept, $conn)
{
    $sql = "INSERT INTO subjects VALUES ('$code','$name','$course','$sem','$dept',0,'','','')";
    if (mysqli_query($conn, $sql)) {
        echo 1;
    } else {
        echo 0;
    }
}
